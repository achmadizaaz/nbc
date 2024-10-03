<?php

namespace App\Http\Controllers;

use App\Models\ClassLabel;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    protected $model;
    public function __construct(ClassLabel $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('class', [
            'clases' => $this->model->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $this->model->create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Attribute has been created!');
    }

    public function show($id)
    {
        return response()->json($this->model->findOrFail($id));
    }

    public function update($id, Request $request)
    {
        $class = $this->model->findOrFail($id);
        $class->update(['name' => $request->name]);

        return back()->with('success', 'Attribute has been updated!');
    }
    
    public function destroy($id)
    {
        $class = $this->model->findOrFail($id);
        $class->delete();
        return back()->with('success', 'Attribute has been updated!');
    }
}
