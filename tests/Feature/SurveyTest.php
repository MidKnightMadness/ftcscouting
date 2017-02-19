<?php

namespace Tests\Feature;

use App\PIN;
use App\Question;
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
     * Tests the cloning of a survey
     */
    public function testClone() {
        $survey = factory(Survey::class)->create(['creator_id' => $this->user->id, 'team_id' => $this->team->id]);
        $question = factory(Question::class)->create(['survey_id' => $survey->id]);
        $pin = new PIN(['question_id' => $question->id, 'pin_data' => '{}']);
        $pin->save();

        $surveyName = 'Cloned-' . str_random();
        $this->actingAs($this->user)->post('/survey/create', ['select_team' => $this->team->id, 'survey_name' => $surveyName, 'clone_from' => $survey->id]);
        $this->assertDatabaseHas('surveys', ['name' => $surveyName]);
        // assert question exists
        $cloned = Survey::whereName($surveyName)->first();
        $this->assertNotNull($cloned);

        $this->assertDatabaseHas('questions', ['survey_id' => $cloned->id]);

        // verify the pin exists
        $survey = Survey::whereId($cloned->id)->first();
        $questions = $survey->questions[0];
        $this->assertDatabaseHas('pin', ['question_id' =>$questions->id]);
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

    public function testSubmitSurvey() {
        $survey = factory(Survey::class)->create(['creator_id' => $this->user->id, 'team_id' => $this->team->id]);
        $question = factory(Question::class)->create(['survey_id' => $survey->id]);

        $this->assertDatabaseHas('surveys', ['id' => $survey->id]);
        $this->assertDatabaseHas('questions', ['id' => $question->id]);

        $this->actingAs($this->user)->put('/survey/' . $survey->id . '/submit', [
            'team_number' => 1234,
            'match_number' => 1,
            'initial' => 0,
            'question-1' => str_random(5)
        ]);
        $this->assertDatabaseHas('responses', ['survey_id' => $survey->id, 'team' => 1234, 'match_number' => 1]);
        $this->assertDatabaseHas('response_data', ['response_id' => 1, 'question_id' => $question->id]);
    }
}
