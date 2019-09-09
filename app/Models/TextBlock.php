<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextBlock extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'lesson_id', 'position', 'content'
    ];

    public function lesson()
    {
        return $this->belongsTo('App\Models\Lesson', 'lesson_id', 'id');
    }
}
