<?php

namespace App\Models\DB;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $table = 'group';
    public $incrementing = false;

    public function createdBy()
    {
        return $this->belongsTo('App\Models\DB\User', 'created_by', 'id');
    }

    public function groupUsers()
    {
        return $this->hasMany('App\Models\DB\GroupUser', 'group_id', 'id');
    }

    public function restaurants()
    {
        return $this->hasMany('App\Models\DB\Restaurant', 'group_id', 'id');
    }

    public function activityLog()
    {
        return $this->hasMany('App\Models\DB\ActivityLog', 'group_id', 'id');
    }

    public function generate()
    {
        return $this->hasOne('App\Models\DB\Generate', 'group_id', 'id');
    }
}
