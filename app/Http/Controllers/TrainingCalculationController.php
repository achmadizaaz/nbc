<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeProbability;
use App\Models\ClassLabel;
use App\Models\ClassProbability;
use App\Models\TrainingData;
use App\Models\TrainingDataAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingCalculationController extends Controller
{
    protected $training, $trainingAttribute, $class, $classProbability, $attribute, $attributeProbability;

    public function __construct(TrainingData $training, TrainingDataAttribute $trainingAttribute,ClassLabel $class, ClassProbability $classProbability, Attribute $attribute,AttributeProbability $attributeProbability)
    {
        $this->training = $training;
        $this->trainingAttribute = $trainingAttribute;
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
        $countTraining = count($this->training->all());
        return view('calculations.training.index', compact('classes','prior_classes', 'prior_attributes', 'countTraining'));
    }

    public function store(Request $request)
    {
        // Get total data training by class
        $prior_class = $this->training->select('class_label_id', DB::raw('count(*) as total'))
        ->groupBy('class_label_id')
        ->get();
        // Get total data training
        $training_data = $this->training->with(['dataAttribute'])->get();

        DB::beginTransaction();
        try{

            // CLASS CALCULATE
            // Remove all data in classProbability
            $this->classProbability->truncate();

            // Calculate prior probability class
            foreach($prior_class as $prior){
                $result_prior_class[] = [
                    'class_label_id' => $prior->class_label_id,
                    'total_data' => $prior->total,
                    'prior_probability' => $prior->total / $training_data->count(),
                ] ;
            }
            // Input insert, prior_probability
            $this->classProbability->insert($result_prior_class);
            
            // END CLASS CALCULATE
            
            // ATRRIBUTE CALCULATE
            // Remove all data in attributeProbability
            $this->attributeProbability->truncate();
            // Calculate prior probability attributes

            foreach($training_data as $training)
            {
                $result_training [] = [
                    'class_label_id' => $training->class_label_id,
                    'attributes' => [], 
                ];
                foreach($training->dataAttribute as $dataAttribute){
                    $result_training[count($result_training) - 1]['attributes'][$dataAttribute->attribute_id] = $dataAttribute->attribute_value;
                }

            }
            
            // Hitung total kemunculan tiap kelas
            $class_counts = [];
            foreach ($result_training as $row) {
                $class_id = $row['class_label_id'];
                if (!isset($class_counts[$class_id])) {
                    $class_counts[$class_id] = 0;
                }
                $class_counts[$class_id]++;
            }

            // Hitung frekuensi setiap nilai atribut dalam setiap kelas
            $attribute_counts = [];
            foreach ($result_training as $row) {
                $class_id = $row['class_label_id'];
                
                foreach ($row['attributes'] as $attribute_id => $attribute_value) {
                    if (!isset($attribute_counts[$class_id][$attribute_id])) {
                        $attribute_counts[$class_id][$attribute_id] = [];
                    }
                    
                    if (!isset($attribute_counts[$class_id][$attribute_id][$attribute_value])) {
                        $attribute_counts[$class_id][$attribute_id][$attribute_value] = 0;
                    }
                    
                    $attribute_counts[$class_id][$attribute_id][$attribute_value]++;
                }
            }

            //  Hitung probabilitas bersyarat dengan Laplace Smoothing
            $feature_probabilities = [];
            $result_prior_attribute = [];
            ksort($attribute_counts);
            foreach ($attribute_counts as $class_id => $attributes) {
                // dd($attribute_counts);
                foreach ($attributes as $attribute_id => $values) {
                    $total_class_samples = $class_counts[$class_id];
                    
                    $attribute_probabilities = [];
                    // dd($values);
                    foreach ($values as $attribute_value => $count) {
                        // Laplace smoothing (COUNT(*) + 1) / (total class samples + total possible values)
                        // dd($total_class_samples + count($values));
                        // $probability = ($count + 1) / ($total_class_samples + count($values));
                        $probability = $count / $total_class_samples;
                        $feature_probabilities[$class_id][$attribute_id][$attribute_value] = $probability;

                
                        $attribute_probabilities['class_label_id'] =  $class_id;
                        $attribute_probabilities['attribute_id'] =  $attribute_id;
                        $attribute_probabilities['attribute_value'] =  $attribute_value;
                        $attribute_probabilities['total_data'] =  $count;
                        $attribute_probabilities['total_class'] =  $total_class_samples;
                        $attribute_probabilities['conditional_probability'] =  $probability;
                        $attribute_probabilities['created_at'] =  now();
                        $attribute_probabilities['updated_at'] =  now();
                        $result_prior_attribute[] = $attribute_probabilities;
                    }

                    // dd($attribute_probabilities);
                }
            }
            $this->attributeProbability->insert($result_prior_attribute);
            // dd($feature_probabilities);

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('failed', 'Terjadi kesalahan pada sistem.');
        }

        return back()->with('success', 'Hitung ulang probabilitas sudah selesai');
    }
}
