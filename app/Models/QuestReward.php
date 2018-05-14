<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestReward extends Model 
{

    protected $table = 'quest_rewards';
    public $timestamps = true;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'quest_id',
        'name'
    ];

    public function quest()
    {
        return $this->belongsTo('Quest');
    }

}