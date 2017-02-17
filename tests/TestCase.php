<?php

namespace Tests;

use App\Team;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

abstract class TestCase extends BaseTestCase {
    use CreatesApplication, DatabaseMigrations, WithoutMiddleware;

    /**
     * Creates a user for use with testing
     * @return User|\Illuminate\Database\Query\Builder
     */
    protected function createUser() {
        $user = factory(User::class)->make();
        $this->post('/register', ['name' => $user->name, 'email' => $user->email, 'password' => 'secret', 'password_confirmation' => 'secret']);
        return User::whereEmail($user->email)->first();
    }

    /**
     * Creates a team owned by the given user
     * @param User $user
     * @return mixed
     */
    protected function createTeam(User $user) {
        $team = factory(Team::class)->create(['owner_id' => $user->id]);
        return $team;
    }
}
