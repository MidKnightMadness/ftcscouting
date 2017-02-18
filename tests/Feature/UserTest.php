<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class UserTest extends TestCase {
    /**
     * Checks registration of users
     *
     * @return void
     */
    public function testRegistration() {
        $this->post('/register', ['name' => 'John Doe', 'email' => 'john.doe@example.com', 'password' => 'secret', 'password_confirmation' => 'secret']);
        // Check if the user exists in the database
        $this->assertDatabaseHas('users', ['name' => 'John Doe', 'email' => 'john.doe@example.com']);
        $user = User::whereEmail('john.doe@example.com')->first();

        // Check if the user's data exists in the database
        $this->assertDatabaseHas('user_data', ['user_id' => $user->id]);
    }

    /**
     * Checks password changes
     */
    public function testChangePassword() {
        $user = $this->createUser();

        // assert invalid password
        $this->actingAs($user)->post('/profile/changePassword', [
            'current_password'=>str_random(10),
            'password'=>'testing',
            'password_confirmation' => 'testing'
        ]);
        $this->actingAs($user)->post('/profile/changePassword', [
            'current_password' => 'secret',
            'password' => 'testing',
            'password_confirmation' => 'testing'
        ]);

        // verify in database
        $user = User::whereId($user->id)->first();

        $this->assertTrue(\Hash::check('testing', $user->password), 'The passwords do not match!');
    }


    /**
     * Tests updating a user's profile
     */
    public function testUpdateProfile() {
        $user = $this->createUser();

        $this->assertNotEquals('test-person@example.com', $user->email);
        $this->assertNotEquals('This-Is-A-Test_person', $user->name);
        $this->actingAs($user)->post('/profile/update', [
            'name' => 'This-Is-A-Test-Person',
            'email' => 'test-person@example.com'
        ]);

        $user = User::whereId($user->id)->first();
        $this->assertEquals('This-Is-A-Test-Person', $user->name);
        $this->assertEquals('test-person@example.com', $user->email);
    }
}
