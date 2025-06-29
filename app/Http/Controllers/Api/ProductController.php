<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function getAll()
    {
        return Product::all();
    }

    public function getByID($id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json(
                [
                    'message' => 'No product with that ID was found'
                ], 200
            );
        }
        return response()->json([$product],200);
    }

    public function save(Request $req)
    {
        $valid = Validator::make($req->all(), [
            'name' => 'required',
            'description' => 'required',
            'code' => 'required|unique:product',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return response()->json(
                [
                    'message' => 'Some fields are missing or are incorrect, please check the request',
                    'errors' => $valid->errors()
                ], 400);
        }

        $product = Product::create([
            'name' => $req->name,
            'description' => $req->description,
            'code' => $req->code,
            'status' => $req->status
        ]);

        if (!$product) {
            return response()->json(['message' => 'Error creating the product'], 500);
        }

        return response()->json($product, 200);
    }

    public function updateByID($id,Request $req)
    {

        $product = Product::find($id);

        if(!$product){
             return response()->json(
                [
                    'message' => 'No product with that ID was found'
                ], 400
            );
        }

        $valid = Validator::make($req->all(), [
            'name' => 'required',
            'description' => 'required',
            'code' => 'required',
            'status' => 'required'
        ]);

        if ($valid->fails()) {
            return response()->json(
                [
                    'message' => 'Some fields are missing or are incorrect, please check the request',
                    'errors' => $valid->errors()
                ], 400);
        }

        $product->name = $req->name;
        $product->description = $req->description;
        $product->code = $req->code;
        $product->status = $req->status;
        $product->save();


        return response()->json([
            'message'=>'Product updated',
            'updatedProduct'=>$product
        ]);
    }

    public function deleteByID($id)
    {
        $product = Product::find($id);

        if(!$product){
             return response()->json(
                [
                    'message' => 'No product with that ID was found'
                ], 200
            );
        }

        $product->delete();

        return response()->json(['message'=> 'Product deleted','product'=> $product],200);
    }
}
