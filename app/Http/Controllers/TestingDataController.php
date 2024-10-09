<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestingDataRequest;
use App\Models\Attribute;
use App\Models\ClassLabel;
use App\Models\TestingData;
use App\Models\TestingDataAttribute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestingDataController extends Controller
{
    protected $model, $dataAttribute, $attribute, $class;
    public function __construct(TestingData $model, TestingDataAttribute $data, Attribute $attribute, ClassLabel $class)
    {
        $this->model = $model;
        $this->dataAttribute = $data;
        $this->attribute = $attribute;
        $this->class = $class;
    }

    public function index()
    {
        return view('testing_data.index', [
            'attributes' => $this->attribute->get(),
            'testing' => $this->model->paginate(15),
        ]);
    }

    public function create()
    {
        return view('testing_data.create', [
            'attributes' => $this->attribute->all(),
            'classes' => $this->class->all(),
        ]);
    }

    public function store(TestingDataRequest $request)
    {
        // Check input total attribute
        if(count($request->attribute) != $this->attribute->all()->count()){
            return back()->with('failed', 'Input attribute is incorrect, make sure the attribute field is filled in correctly.');
        }

        DB::beginTransaction();
        try{
            $testing = $this->model->create([
                'name' => $request->name,
                'class_label_id' => $request->class
            ]);

            foreach ($request->input('attribute') as $id => $value) {
                // Save or perform other operations with $id and $value data
                // Example: Attribute::find($id)->update(['value' => $value]);;
                $this->dataAttribute->create([
                    'testing_data_id' => $testing->id,
                    'attribute_id' => $id,
                    'attribute_value' => strtolower($value)
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();
            Log::error('Store data testing failed: '.$e->getMessage());
            return back()->with('failed', 'An error occurred in the system');
        }


        return back()->with('success', 'Testing data has been created!');
    }

    public function show($id)
    {
        return response()->json($this->model->findOrFail($id));
    }

    public function update($id, Request $request)
    {
        $testing_data = $this->model->findOrFail($id);
        $testing_data->update(['name' => $request->name]);

        return back()->with('success', 'Testing data has been updated!');
    }
    
    public function destroy($id)
    {
        $testing_data = $this->model->findOrFail($id);
        $testing_data->delete();
        return back()->with('success', 'testing data has been updated!');
    }
}
