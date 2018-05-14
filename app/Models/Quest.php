<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quest extends Model 
{

    protected $table = 'quests';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name'
    ];

    public function rewards()
    {
        return $this->hasMany('QuestReward');
    }

    public function waypoints()
    {
        return $this->hasMany('Waypoint');
    }

    public function points()
    {
        return $this->hasManyThrough('Point', 'Waypoint');
    }

}