<?php

use Illuminate\Database\Migrations\Migration;

class UnifySchema extends Migration {

    private $remap = ['pin' => [
        'question' => 'question_id'
    ],
    'responses'=> [
        'survey'=>'survey_id',
        'submitted_by'=>'submitter_id',
    ],
    'surveys'=>[
        'created_by'=>'creator_id',
        'team_owner'=>'team_id'
    ],
    'teams'=>[
        'owner'=>'owner_id'
    ],
    'team_invites'=>[
        'sender'=>'sender_id',
        'receiver'=>'receiver_id',
    ],
    'team_roles'=> [
        'owning_team'=>'team_id'
    ]];

    private $vals = array();

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        foreach ($this->remap as $table => $values) {
            $this->vals = $values;
            Schema::table($table, function (\Illuminate\Database\Schema\Blueprint $blueprint) {
                foreach ($this->vals as $from => $to) {
                    $blueprint->renameColumn($from, $to);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        foreach ($this->remap as $table => $values) {
            $this->vals = $values;
            Schema::table($table, function (\Illuminate\Database\Schema\Blueprint $blueprint) {
                foreach ($this->vals as $from => $to) {
                    $blueprint->renameColumn($to, $from);
                }
            });
        }
    }
}
