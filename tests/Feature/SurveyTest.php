<?php

namespace Tests\Feature;

use App\Survey;
use App\Team;
use Tests\TestCase;

class SurveyTest extends TestCase {

    private $user;
    private $team;
    private $survey;

    protected function setUp() {
        parent::setUp();
        $this->user = $this->createUser();
        $this->team = factory(Team::class)->create(['owner_id' => $this->user->id]);
        $this->survey = factory(Survey::class)->create(['creator_id' => $this->user->id, 'team_id' => $this->team->id]);
    }

    /**
     * Test that creating surveys actually create surveys
     */
    public function testCreateSurvey() {
        $this->actingAs($this->user)->post('/survey/create', ['select_team' => $this->team->id, 'survey_name' => 'Test Survey']);
        $this->assertDatabaseHas('surveys', ['team_id' => $this->team->id]);
    }

    /**
     * Test adding questions to surveys
     */
    public function testAddQuestion() {
        $json = $this->actingAs($this->user)->get('/api/survey/1/new-question')->assertJson(['survey_id' => $this->survey->id])->json();
        $this->assertDatabaseHas('questions', ['survey_id' => $this->survey->id]);

        // verify pin
        $this->assertDatabaseHas('pin', ['question_id' => $json['id']]);

        // check adding for a question that doesn't exist
        $this->actingAs($this->user)->get('/api/survey/999/new-question')->assertStatus(404)->assertJson(['error' => 'Survey not found']);
    }

    /**
     * Test editing questions
     */
    public function testEditQuestion() {
        $json = $this->actingAs($this->user)->get('/api/survey/1/new-question')->assertJson(['survey_id' => $this->survey->id])->json();
        $this->actingAs($this->user)->post('/api/question/' . $json['id'] . '/update', ['data' => [
            'question_name' => 'testing',
            'question_type' => 'long_text',
            'extra_data' => '{}',
            'order' => 1]
        ]);

        $this->assertDatabaseHas('questions', ['id' => $json['id'], 'question_name' => 'testing', 'question_type' => 'long_text', 'order' => '1']);
    }
}
