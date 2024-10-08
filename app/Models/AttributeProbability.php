<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeProbability extends Model
{
    use HasFactory;

    protected $fillable = ['class_label_id', 'attribute_id', 'attribute_value', 'conditional_probability'];

    public function class()
    {
        return $this->belongsTo(ClassLabel::class, 'class_label_id');
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id');
    }
}
