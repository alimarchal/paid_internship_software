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
            'degree_level' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'date_of_birth' => [
                'required',
                'date', // Ensure that the input is a valid date
                'before_or_equal:' . '2006-06-11', // Must be 18 years or older
                'after_or_equal:' .  '1997-06-01',  // Must be less than 27 years
            ],
            'nationality' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($value === 'Pakistani_National') {
                        $fail('You are not eligible.');
                    }
                },
            ],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();



        $user = User::create([
            'name' => $input['name'],
            'degree_level' => $input['degree_level'],
            'email' => $input['email'],
            'date_of_birth' => $input['date_of_birth'],
            'password' => Hash::make($input['password']),
            'batch_no' => 'Batch-02',
        ]);

        $role = Role::find(1);
        $user->assignRole($role);


        return $user;
    }
}
