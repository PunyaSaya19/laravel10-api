<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductApiController extends Controller
{
    public function index()
    {
        $products = Products::orderBy('name')->get();
        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Ambil Semua Data',
            'data' => $products,
            'errors' => []
        ], 200);
    }

    public function show($id)
    {
        $product = Products::findOrFail($id);
        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Ambil satu data',
            'data' => $product,
            'errors' => []
        ]); 
    }

    public function store(Request $request)
    {
        // validation
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'price' => 'required|integer',
            'photo' => 'required|image|mimes:jpg,png|max:2048'
        ]);

        // validation fails
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => 'Validation Errors',
                'data' => [],
                'errors' => $validator->errors()->first()
            ], 422);
        }

        // upload file
        $path = $request->file('photo')->store('img/products');
        
        // save database
        $product = Products::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'photo' => $path
        ]);

        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Tambah Data',
            'data' => $product,
            'errors' => []
        ]);
    }

    public function update(Request $request)
    {
        $rules = [
            'id' => 'required',
            'name' => 'required',
            'price' => 'required|integer',
        ];
        if($request->hasFile('photo')) {
            $rules['photo'] = 'required|image|mimes:jpg,png|max:2048';
        }
        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json([
                'status' => false,
                'msg' => 'Validation Errors',
                'data' => [],
                'errors' => $validator->errors()->first()
            ], 422); 
        }

        $data = $validator->validate();
        if($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('img/products');
        }
        $product = Products::whereId($request->id)->update($data);
        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Update Data',
            'data' => $product,
            'errors' => []
        ]);
    }

    public function destroy($id)
    {
        Products::destroy($id);
        return response()->json([
            'status' => true,
            'msg' => 'Berhasil Hapus Data',
            'data' => [],
            'errors' => []
        ]);
    }
}
