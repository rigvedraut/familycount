<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreFamilyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'surname' => ['required', 'string', 'max:100'],
            'birthdate' => [
                'required',
                'date',
                'before_or_equal:today',
            ],
            'mobile_no' => [
                'required',
                'regex:/^[6-9]\d{9}$/',
                'unique:family_heads,mobile_no',
            ],
            'address' => ['required', 'string'],
            'state_id' => ['required', 'exists:states,id'],
            'city_id' => [
                'required',
                Rule::exists('cities', 'id')->where(function ($query) {
                    $query->where('state_id', $this->input('state_id'));
                }),
            ],
            'pincode' => ['required', 'digits:6'],
            'marital_status' => ['required', Rule::in(['married', 'unmarried'])],
            'wedding_date' => [
                'nullable',
                'required_if:marital_status,married',
                'date',
                'before_or_equal:today',
                'after:birthdate',
            ],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'hobbies' => ['nullable', 'array'],
            'hobbies.*' => ['required', 'string', 'max:100', 'distinct'],

            'members' => ['nullable', 'array'],
            'members.*.name' => ['required', 'string', 'max:100'],
            'members.*.birthdate' => ['required', 'date', 'before:today'],
            'members.*.marital_status' => ['required', Rule::in(['married', 'unmarried'])],
            'members.*.wedding_date' => ['nullable', 'date', 'before_or_equal:today'],
            'members.*.education' => ['nullable', 'string', 'max:150'],
            'members.*.photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'mobile_no.regex' => 'Mobile number must start with 6-9 and contain 10 digits.',
            'wedding_date.required_if' => 'Wedding date is required when the family head is married.',
            'wedding_date.after' => 'Wedding date must be after the birthdate.',
            'hobbies.*.distinct' => 'Hobbies must be unique.',
            'members.*.birthdate.before' => 'Each family member must have a valid birthdate before today.',
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                $headStatus = $this->input('marital_status');
                $headBirthdate = $this->input('birthdate');
                $headWedding = $this->input('wedding_date');

                $minimumAllowedBirthdate = now()->subYears(21);

                if ($headBirthdate && Carbon::parse($headBirthdate)->gt($minimumAllowedBirthdate)) {
                    $validator->errors()->add('birthdate', 'Birthdate must be above 21 years.');
                }

                if ($headStatus === 'unmarried' && filled($headWedding)) {
                    $validator->errors()->add('wedding_date', 'Wedding date must be empty when the family head is unmarried.');
                }

                if ($headStatus === 'married' && empty($headWedding)) {
                    $validator->errors()->add('wedding_date', 'Wedding date is required when the family head is married.');
                }

                if ($headWedding && $headBirthdate && Carbon::parse($headWedding)->lte(Carbon::parse($headBirthdate))) {
                    $validator->errors()->add('wedding_date', 'Wedding date must be after the birthdate.');
                }

                foreach ((array) $this->input('members', []) as $index => $member) {
                    $status = $member['marital_status'] ?? null;
                    $memberBirthdate = $member['birthdate'] ?? null;
                    $memberWedding = $member['wedding_date'] ?? null;

                    if ($status === 'married' && empty($memberWedding)) {
                        $validator->errors()->add("members.$index.wedding_date", 'Wedding date is required when a family member is married.');
                    }

                    if ($status === 'unmarried' && filled($memberWedding)) {
                        $validator->errors()->add("members.$index.wedding_date", 'Wedding date must be empty when a family member is unmarried.');
                    }

                    if ($memberWedding && $memberBirthdate && Carbon::parse($memberWedding)->lte(Carbon::parse($memberBirthdate))) {
                        $validator->errors()->add("members.$index.wedding_date", 'Wedding date must be after the member birthdate.');
                    }
                }
            },
        ];
    }
}
