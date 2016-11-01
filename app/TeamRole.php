<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamRole extends Model
{
    protected $table = "team_roles";

    public function getAllPerms() {
        $columns = $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
        $columns = array_diff($columns, ['id', 'created_at', 'updated_at', 'name', 'default', 'owning_team']);
        return $columns;
    }
}
