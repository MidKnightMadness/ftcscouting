<?php

namespace Tests\Unit;

use App\Team;
use App\TeamInvite;
use Tests\TestCase;

class InviteTest extends TestCase {

    private $team, $user, $invite;

    protected function setUp() {
        parent::setUp();
        $this->user = $this->createUser();
        $this->team = factory(Team::class)->create(['owner_id' => $this->user->id]);
        $this->invite = new TeamInvite(['team_id' => $this->team->id, 'sender_id' => -1, 'receiver_id' => $this->user->id, 'pending' => false, 'accepted' => true, 'public' => true]);
        $this->invite->save();
    }

    public function testAcceptInvite() {
        // Accept a valid id
        $req = $this->actingAs($this->user)->get('/team/acceptInvite/' . $this->invite->id)->assertSessionHas(['message' => 'Success:You are not a member of Team ' . $this->team->team_number]);
        // Accept an invalid id
        $this->actingAs($this->user)->get('/team/acceptInvite/-1')->assertSessionHas(['message' => 'Error:That invite does not exist!']);
    }

    public function testCancelInvite() {
        $this->actingAs($this->user, 'api')->post('/api/invite/cancel', ['id' => $this->invite->id])->assertJson(['status' => 'Deleted!']);
        $this->assertDatabaseMissing('team_invites', ['id' => $this->invite->id]);

        // attempt to cancel an invalid id
        $this->actingAs($this->user, 'api')->post('/api/invite/cancel', ['id' => 40])->assertStatus(404)->assertJson(['error' => 'That invite does not exist!']);
    }
}
