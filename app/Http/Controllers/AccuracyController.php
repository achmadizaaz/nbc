<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeProbability;
use App\Models\ClassLabel;
use App\Models\ClassProbability;
use App\Models\TestingData;
use App\Models\TestingDataAttribute;
use Illuminate\Http\Request;

class AccuracyController extends Controller
{
    protected $testing, $testingAttribute, $class, $classProbability, $attribute, $attributeProbability;

    public function __construct(TestingData $testing, TestingDataAttribute $testingAttribute,ClassLabel $class, ClassProbability $classProbability, Attribute $attribute,AttributeProbability $attributeProbability)
    {
        $this->testing = $testing;
        $this->testingAttribute = $testingAttribute;
        $this->class = $class;
        $this->classProbability = $classProbability;
        $this->attribute = $attribute;
        $this->attributeProbability = $attributeProbability;
    }

    public function index()
    {
        $prior_classes = $this->classProbability->all();
        $classes = $this->class->all();
        $prior_attributes = $this->attributeProbability;
        $countTesting = count($this->testing->all());
        return view('calculations.accuracy.index', compact('classes','prior_classes', 'prior_attributes', 'countTesting'));
    }

    public function store(Request $request)
    {
        
        return back()->with('success', 'Hitung ulang probabilitas sudah selesai');
    }
}
