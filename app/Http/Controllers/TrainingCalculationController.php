<?php

namespace App\Http\Controllers;

use App\Models\ClassProbability;
use App\Models\TrainingData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrainingCalculationController extends Controller
{
    protected $training, $classProbability;
    public function __construct(TrainingData $training, ClassProbability $classProbability)
    {
        $this->training = $training;
        $this->classProbability = $classProbability;
    }

    public function index()
    {
        $prior_classes = ClassProbability::all();
        return view('calculations.training.index', compact('prior_classes'));
    }

    public function store(Request $request)
    {
        // Get total data training by class
        $prior_class = $this->training->select('class_label_id', DB::raw('count(*) as total'))
        ->groupBy('class_label_id')
        ->get();
        // Get total data training
        $training_data= $this->training->all();

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

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            return back()->with('failed', 'Terjadi kesalahan pada sistem.');
        }

        return back()->with('success', 'Hitung ulang probabilitas sudah selesai');
    }
}
