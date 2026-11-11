<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'role' => ['required', 'in:customer,seller'],
            'phone' => ['nullable', 'string', 'max:20'],

            // Seller-only fields (conditionally validated later)
            'address' => ['nullable','required_if:role,seller', 'string', 'max:255'],
            'city' => ['nullable','required_if:role,seller', 'string', 'max:255'],
            'postcode' => ['nullable','required_if:role,seller', 'string', 'max:20'],
            'state' => ['nullable','required_if:role,seller', 'string', 'max:255'],
            'country' => ['nullable','required_if:role,seller', 'string', 'max:255'],
            'description' => ['nullable','required_if:role,seller', 'string', 'max:500'],
            ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => $input['role'],
            'phone' => $input['phone'] ?? null,
            'address' => $input['address'] ?? null,
            'city' => $input['city'] ?? null,
            'postcode' => $input['postcode'] ?? null,
            'state' => $input['state'] ?? null,
            'country' => $input['country'] ?? null,
            'description' => $input['description'] ?? null,
        ]);
    }
}
