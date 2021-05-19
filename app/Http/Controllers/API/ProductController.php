<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\Request;
use \App\Product;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Product as ProductResource;

class ProductController extends BaseController
{
    public function index(){
        $products = Product::all();
        
        return $this->sendResponse(ProductResource::collection($products), 'Products retrieved successfully.');
    }
    
    public function store(Request $request){
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'barcode' => 'required|unique:products',
            'name' => 'required',
            'price' => 'required'
        ]);
        
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        
        $product = Product::create($input);
        
        return $this->sendResponse(new ProductResource($product), 'Product created successfully.');
    }
    
    public function show($id){
        $product = Product::find($id);
        
        if (is_null($product)) {
            return $this->sendError('Product not found.');
        }
        
        return $this->sendResponse(new ProductResource($product), 'Product retrieved successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }

        $updated = $product->fill($request->all())->save();
        $product->name = $request->name;
        $product->barcode = $request->barcode;
        $product->price = $request->price;
        $product->save();
        
        if ($updated) {
            return response()->json([
            'success' => true,
            'message' => 'product with id ' . $id . ' succesfuly be updated'
            ], 200);
        } else {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, product could not be updated'
            ], 500);
        }
    }
    
    public function destroy($id)
    {
        $product = Product::find($id);
        
        if (!$product) {
            return response()->json([
            'success' => false,
            'message' => 'Sorry, product with id ' . $id . ' cannot be found'
            ], 400);
        }
        
        if ($product->delete()) {
            return response()->json([
            'success' => true,
            'message' => 'product with id ' . $id . ' succesfuly be deleted'
            ], 200);
        } else {
            return response()->json([
            'success' => false,
            'message' => 'product could not be deleted'
            ], 500);
        }
    }
}
