<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestRequire extends Model 
{

    protected $table = 'quest_requires';
    public $timestamps = true;

    protected $fillable = [
        'quest_id',
        'required_quest_id'
    ];

    public function quest()
    {
        return $this->belongsTo('Quest');
    }

}