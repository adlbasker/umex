<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $table = 'apps';

    public function project()
    {
        return $this->belongsTo('App\Models\Project', 'project_id');
    }
}
