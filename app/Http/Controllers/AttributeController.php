<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\Request;

class AttributeController extends Controller
{
    protected $model;
    public function __construct(Attribute $model)
    {
        $this->model = $model;
    }

    public function index()
    {
        return view('attribute', [
            'attributes' => $this->model->paginate(10),
        ]);
    }

    public function store(Request $request)
    {
        $this->model->create([
            'name' => $request->name
            // 'value' => 
        ]);

        return back()->with('success', 'Attribute has been created!');
    }

    public function show($id)
    {
        return response()->json($this->model->findOrFail($id));
    }

    public function update($id, Request $request)
    {
        $attribute = $this->model->findOrFail($id);
        $attribute->update(['name' => $request->name]);

        return back()->with('success', 'Attribute has been updated!');
    }
    
    public function destroy($id)
    {
        $attribute = $this->model->findOrFail($id);
        $attribute->delete();
        return back()->with('success', 'Attribute has been updated!');
    }

}
