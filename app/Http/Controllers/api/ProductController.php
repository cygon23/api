<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    public function index(){
         $product = Product::get();

         if($product->count() > 0){
             return ProductResource::collection($product);
         }
         else{
            return response()->json(['message' => 'No record availabel'],200);
         }
    }

     public function store(Request $request){

        $validator = Validator::make($request->all(),[
               'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|integer|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fild are required',
                'error' => $validator->messages(),

            ],422);
        }


      $product= Product::create([
         'name' => $request->name,
           'description' => $request->description,
             'price' => $request->price,
       ]);

       return response([
        'message' => 'product created succefully',
        'data' => new ProductResource($product)
       ],200);
    }


     public function show(Product $product){
        return new ProductResource($product);
    }

      public function update(Request $request, Product $product){


        $validator = Validator::make($request->all(),[
               'name' => 'required|string|max:255',
        'description' => 'required',
        'price' => 'required|integer|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => 'All fild are required',
                'error' => $validator->messages(),

            ],422);
        }


      $product->update([
         'name' => $request->name,
           'description' => $request->description,
             'price' => $request->price,
       ]);

       return response([
        'message' => 'product updated succefully',
        'data' => new ProductResource($product)
       ],200);
    }


      public function destroy(Product $product){
          $product->delete();
            return response([
        'message' => 'product deleted succefully',
       ],200);
    }


}
