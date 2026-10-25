<?php

namespace Tests\Feature;

use App\Models\City;
use App\Models\State;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FamilyFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_default_seeder_loads_states_and_cities(): void
    {
        $this->artisan('db:seed')
            ->assertSuccessful();

        $this->assertGreaterThan(0, State::count());
        $this->assertGreaterThan(0, City::count());
    }

    public function test_create_page_has_dashboard_back_link(): void
    {
        $state = State::create(['name' => 'Test State']);
        City::create(['state_id' => $state->id, 'name' => 'Test City']);

        $response = $this->get('/families/create');

        $response->assertOk();
        $response->assertSee('Back to Dashboard');
    }
}
