<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrainingDataRequest;
use App\Models\Attribute;
use App\Models\ClassLabel;
use App\Models\TrainingData;
use App\Models\TrainingDataAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrainingDataController extends Controller
{
    protected $model, $dataAttribute, $attribute, $class;
    public function __construct(TrainingData $model, TrainingDataAttribute $data, Attribute $attribute, ClassLabel $class)
    {
        $this->model = $model;
        $this->dataAttribute = $data;
        $this->attribute = $attribute;
        $this->class = $class;
    }

    public function index()
    {
        return view('training_data.index', [
            'attributes' => $this->attribute->get(),
            'training' => $this->model->paginate(15),
        ]);
    }

    public function create()
    {
        return view('training_data.create', [
            'attributes' => $this->attribute->all(),
            'classes' => $this->class->all(),
        ]);
    }

    public function store(TrainingDataRequest $request)
    {
        // Check input total attribute
        if(count($request->attribute) != $this->attribute->all()->count()){
            return back()->with('failed', 'Input attribute is incorrect, make sure the attribute field is filled in correctly.');
        }

        DB::beginTransaction();
        try{
            $training = $this->model->create([
                'name' => $request->name,
                'class_label_id' => $request->class
            ]);

            foreach ($request->input('attribute') as $id => $value) {
                // Save or perform other operations with $id and $value data
                // Example: Attribute::find($id)->update(['value' => $value]);;
                $this->dataAttribute->create([
                    'training_data_id' => $training->id,
                    'attribute_id' => $id,
                    'attribute_value' => strtolower($value)
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Store data training failed: '.$e->getMessage());
            return back()->with('failed', 'An error occurred in the system');
        }


        return back()->with('success', 'Attribute has been created!');
    }

    public function show($id)
    {
        return response()->json($this->model->findOrFail($id));
    }

    public function update($id, Request $request)
    {
        $training_data = $this->model->findOrFail($id);
        $training_data->update(['name' => $request->name]);

        return back()->with('success', 'Training data has been updated!');
    }
    
    public function destroy($id)
    {
        $training_data = $this->model->findOrFail($id);
        $training_data->delete();
        return back()->with('success', 'Training data has been updated!');
    }
}
