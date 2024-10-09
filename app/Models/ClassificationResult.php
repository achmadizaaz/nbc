<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassificationResult extends Model
{
    use HasFactory;
    protected $fillable = ['testing_data_id', 'predicted_class_id', 'probability'];
}
