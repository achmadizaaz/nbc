<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingData extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'class_label_id'];


    public function dataAttribute()
    {
        return $this->hasMany(TrainingDataAttribute::class, 'training_data_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(ClassLabel::class, 'class_label_id');
    }

}
