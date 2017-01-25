<?php

use Illuminate\Database\Seeder;

class PopulateTestData extends Seeder {

    private $faker;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $this->faker = Faker\Factory::create();
        // Generate teams
        factory(App\Team::class, 5)->create()->each(function ($u) {
            $user = $this->makeUser();
            $u->owner = $user->id;
            $u->save();
        });

        // Generate 3 survey per team
        for ($i = 1; $i <= 5; $i++) {
            for ($j = 0; $j < 3; $j++) {
                $survey = $this->makeSurvey($i, $i);
                $this->makeResponses($survey);
            }
        }

        // generate a superuser that can view everything
        $user = new \App\User();
        $user->name = 'Superadmin';
        $user->email = 'admin@admin.com';
        $user->password = Hash::make('admin');
        $user->save();

        $userdata = new \App\UserData();
        $userdata->user_id = $user->id;
        $userdata->superadmin = 1;
        $userdata->bio = "Superadmin";
        $userdata->photo_location = "admin@admin.com";
        $userdata->save();

    }

    private function makeUser() {
        $user = factory(App\User::class)->create();
        $data = factory(App\UserData::class)->make();
        $data->user_id = $user->id;
        $data->save();
        return $user;
    }

    private function makeSurvey($owner, $created_by) {
        $survey = factory(App\Survey::class)->make();
        $survey->team_owner = $owner;
        $survey->created_by = $created_by;
        $survey->save();

        // create 10 random questions
        for ($i = 0; $i < 10; $i++) {
            $question = factory(App\Question::class)->make();
            $question->survey_id = $survey->id;
            $question->save();
            $this->makePin($question);
        }
        return $survey;
    }

    private function makePin($question) {
        Log::info($question->extra_data);
        $data = json_decode($question->extra_data);
        $options = $data->options;

        $pin_array = array();
        foreach ($options as $option) {
            $pin_array[$option->name] = random_int(0, 10);
        }
        $pin = new \App\PIN();
        $pin->question = $question->id;
        $pin->pin_data = json_encode($pin_array);
        $pin->save();
    }

    private function makeResponses($survey) {
        for ($i = 0; $i < 20; $i++) {
            $response = new App\Response();
            $response->survey = $survey->id;
            $response->initial = 0;
            $response->submitted_by = 1;
            $response->team = random_int(0, 10000);
            $response->match_number = random_int(0, 30);
            $response->save();
            foreach ($survey->questions as $question) {
                $data = json_decode($question->extra_data);
                $response_data = "";
                if ($question->question_type == "checkbox" || $question->question_type == "radio") {
                    $available_options = [];
                    foreach ($data->options as $option) {
                        $available_options[] = $option->name;
                    }
                    $response_data = $available_options[random_int(0, sizeof($data->options) - 1)];
                } else {
                    $response_data = $this->faker->sentence;
                }
            $r = new \App\ResponseData();
            $r->response_id = $response->id;
            $r->question_id = $question->id;
            $r->response_data = $response_data;
            $r->save();
        }
    }
}
}
