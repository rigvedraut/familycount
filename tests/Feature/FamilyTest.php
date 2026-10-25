<?php

namespace Tests\Feature;

use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FamilyTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    protected function validFamilyPayload(array $overrides = []): array
    {
        $state = State::first();
        $city = $state->cities()->first();

        $payload = [
            'name' => 'Amit',
            'surname' => 'Patel',
            'birthdate' => now()->subYears(25)->toDateString(),
            'mobile_no' => '9876543210',
            'address' => '12 Park Street',
            'state_id' => $state->id,
            'city_id' => $city->id,
            'pincode' => '400001',
            'marital_status' => 'married',
            'wedding_date' => now()->subYears(2)->toDateString(),
            'hobbies' => ['Reading', 'Travel'],
            'members' => [
                [
                    'name' => 'Riya',
                    'birthdate' => now()->subYears(30)->toDateString(),
                    'marital_status' => 'unmarried',
                    'education' => 'B.Com',
                ],
            ],
        ];

        return array_replace_recursive($payload, $overrides);
    }

    public function test_valid_head_with_hobbies_and_members_is_saved(): void
    {
        Storage::fake('public');

        $payload = $this->validFamilyPayload();
        $payload['photo'] = UploadedFile::fake()->image('head.jpg', 600, 600)->size(100);
        $payload['members'][0]['photo'] = UploadedFile::fake()->image('member.jpg', 600, 600)->size(100);

        $response = $this->post('/families', $payload);

        $response->assertRedirect('/families');
        $this->assertDatabaseHas('family_heads', [
            'name' => 'Amit',
            'mobile_no' => '9876543210',
        ]);
        $this->assertDatabaseHas('family_hobbies', ['hobby' => 'Reading']);
        $this->assertDatabaseHas('family_members', ['name' => 'Riya']);
        Storage::disk('public')->assertExists('family-photos/' . $payload['photo']->hashName());
        Storage::disk('public')->assertExists('family-photos/' . $payload['members'][0]['photo']->hashName());
    }

    public function test_head_aged_20_years_364_days_is_rejected(): void
    {
        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'birthdate' => now()->subYears(21)->subDay()->toDateString(),
        ]));

        $response->assertSessionHasErrors(['birthdate']);
    }

    public function test_head_aged_21_years_and_1_day_is_accepted(): void
    {
        Storage::fake('public');

        $payload = $this->validFamilyPayload([
            'birthdate' => now()->subYears(21)->addDay()->toDateString(),
        ]);
        $payload['photo'] = UploadedFile::fake()->image('head.jpg', 600, 600)->size(100);

        $response = $this->post('/families', $payload);

        $response->assertRedirect('/families');
    }

    public function test_married_without_wedding_date_is_rejected_and_unmarried_with_wedding_date_is_ignored(): void
    {
        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'marital_status' => 'married',
            'wedding_date' => null,
        ]));
        $response->assertSessionHasErrors(['wedding_date']);

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'marital_status' => 'unmarried',
            'wedding_date' => now()->subYears(2)->toDateString(),
        ]));
        $response->assertSessionHasErrors(['wedding_date']);
    }

    public function test_duplicate_invalid_mobile_and_invalid_pincode_are_rejected(): void
    {
        $this->post('/families', $this->validFamilyPayload([
            'mobile_no' => '9876543210',
        ]));

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'mobile_no' => '9876543210',
        ]));
        $response->assertSessionHasErrors(['mobile_no']);

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'mobile_no' => '1234567890',
        ]));
        $response->assertSessionHasErrors(['mobile_no']);

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'pincode' => '12345',
        ]));
        $response->assertSessionHasErrors(['pincode']);
    }

    public function test_city_not_belonging_to_state_is_rejected(): void
    {
        $stateA = State::first();
        $stateB = State::whereKeyNot($stateA->id)->first();
        $cityB = $stateB->cities()->first();

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'state_id' => $stateA->id,
            'city_id' => $cityB->id,
        ]));

        $response->assertSessionHasErrors(['city_id']);
    }

    public function test_invalid_image_type_and_oversized_image_are_rejected(): void
    {
        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'photo' => UploadedFile::fake()->create('bad.txt', 10, 'text/plain'),
        ]));
        $response->assertSessionHasErrors(['photo']);

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'photo' => UploadedFile::fake()->image('large.jpg', 800, 800)->size(3000),
        ]));
        $response->assertSessionHasErrors(['photo']);
    }

    public function test_member_married_without_wedding_date_is_rejected_and_zero_members_are_allowed(): void
    {
        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'members' => [[
                'name' => 'Riya',
                'birthdate' => now()->subYears(30)->toDateString(),
                'marital_status' => 'married',
                'education' => 'B.Com',
            ]],
        ]));
        $response->assertSessionHasErrors(['members.0.wedding_date']);

        $response = $this->from('/families/create')->post('/families', $this->validFamilyPayload([
            'members' => [],
        ]));
        $response->assertRedirect('/families');
    }

    public function test_index_page_shows_family_member_count(): void
    {
        Storage::fake('public');

        $payload = $this->validFamilyPayload([
            'photo' => UploadedFile::fake()->image('head.jpg', 600, 600)->size(100),
            'members' => [
                [
                    'name' => 'Riya',
                    'birthdate' => now()->subYears(30)->toDateString(),
                    'marital_status' => 'unmarried',
                    'education' => 'B.Com',
                    'photo' => UploadedFile::fake()->image('member.jpg', 600, 600)->size(100),
                ],
                [
                    'name' => 'Kiran',
                    'birthdate' => now()->subYears(25)->toDateString(),
                    'marital_status' => 'unmarried',
                    'education' => 'M.Sc',
                    'photo' => UploadedFile::fake()->image('member2.jpg', 600, 600)->size(100),
                ],
            ],
        ]);

        $this->post('/families', $payload);

        $this->get('/families')
            ->assertOk()
            ->assertSeeText('2 members');
    }

    public function test_show_endpoint_returns_head_hobbies_and_members(): void
    {
        Storage::fake('public');

        $payload = $this->validFamilyPayload([
            'photo' => UploadedFile::fake()->image('head.jpg', 600, 600)->size(100),
            'members' => [
                [
                    'name' => 'Riya',
                    'birthdate' => now()->subYears(30)->toDateString(),
                    'marital_status' => 'unmarried',
                    'education' => 'B.Com',
                    'photo' => UploadedFile::fake()->image('member.jpg', 600, 600)->size(100),
                ],
            ],
        ]);

        $this->post('/families', $payload);

        $family = \App\Models\FamilyHead::first();

        $this->get('/families/' . $family->id)
            ->assertOk()
            ->assertSeeText('Reading')
            ->assertSeeText('Riya');
    }

    public function test_cities_endpoint_returns_only_the_cities_of_the_selected_state(): void
    {
        $state = State::first();
        $response = $this->getJson('/locations/cities?state_id=' . $state->id);

        $response->assertOk();
        $response->assertJsonCount($state->cities()->count());
        foreach ($response->json() as $city) {
            $this->assertEquals($state->id, $city['state_id'] ?? $state->id);
        }
    }
}
