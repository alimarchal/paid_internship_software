<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
            'date_of_birth' => [
                'required',
                'date', // Ensure that the input is a valid date
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'), // Must be 18 years or older
                'after_or_equal:' . now()->subYears(25)->format('Y-m-d'),  // Must be less than 25 years
            ],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();



        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'date_of_birth' => $input['date_of_birth'],
            'password' => Hash::make($input['password']),
        ]);

        $role = Role::find(1);
        $user->assignRole($role);


        return $user;
    }
}
