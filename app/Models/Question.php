<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    // use HasFactory;
    protected $fillable = ['subID', 'question'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
