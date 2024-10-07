<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassProbability extends Model
{
    use HasFactory;

    protected $fillable = ['class_label_id', 'prior_probability'];

    public function class(){
        return $this->belongsTo(ClassLabel::class, 'class_label_id');
    }
}
