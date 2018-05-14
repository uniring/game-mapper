<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Waypoint extends Model 
{

    protected $table = 'waypoints';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'quest_id',
        'point_id',
        'text',
        'mode'
    ];

    public function quest()
    {
        return $this->belongsTo('Quest');
    }

    public function point()
    {
        return $this->belongsTo('Point');
    }

}