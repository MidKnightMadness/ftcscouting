<?php

namespace Tests\Feature;

use App\Team;
use App\TeamInvite;
use Tests\TestCase;

class TeamTest extends TestCase {
    /**
     * Tests creation of a team
     */
    public function testCreate() {
        $user = $this->createUser();
        $this->actingAs($user)->put('/team/create', ['team-name' => 'Test Team', 'team-number' => 7854]);
        // assert the team exists in the database
        $this->assertDatabaseHas('teams', ['team_number' => 7854]);
        // assert the user has been invited to the team
        $this->assertDatabaseHas('team_invites', ['receiver_id' => $user->id, 'accepted' => true]);
    }

    /**
     * Tests inviting a user to a team
     */
    public function testInvite() {
        $user = $this->createUser();
        $otherUser = $this->createUser();
        $team = factory(Team::class)->create(['owner_id' => $user->id]);

        // Verify that the user can't invite someone who doesn't exist
        $this->actingAs($user, 'api')->post('/api/invite', ['username' => 'some.nonexistent.person@example.com', 'teamNumber' => $team->team_number])
            ->assertJson(['error' => '"some.nonexistent.person@example.com" does not have an account!']);
        // Send and invite
        $this->actingAs($user, 'api')->post('/api/invite', ['username' => $otherUser->email, 'teamNumber' => $team->team_number])
            ->assertJson(['status' => 'Invite Sent!']);
        // Verify that the user can't be invited twice
        $this->actingAs($user, 'api')->post('/api/invite', ['username' => $otherUser->email, 'teamNumber' => $team->team_number])
            ->assertJson(['error' => "$otherUser->email is already invited!"]);
    }
}
