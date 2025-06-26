<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Models\Category;
use App\Models\Item;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class ItemsController extends Controller
{
    public function addItems(Request $request){

        $user = auth('api')->user();

        try {
      DB::table('items')->insert(
          [
           'name' => $request->name,
           'price' => $request->price,
           'user_id'=>$user->id, 
           'description' => $request->description,
           'image' => $request->image,
           'quantity' => $request->quantity,
           'main_category' => $request->main_category,
           'created_date' => now()->toDateString(),
            ]
          );
          return response()->json(['message' => 'Item created successfully']);
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Failed to create item',
            'error' => $e->getMessage()
        ], 500);
    
    
    }
}

 public function getMainCategory(Request $request){

        $category= Category::select('image', 'name')->get();

        return response()->json($category); 
      
  } 

public function getItemByCategory(Request $request){

    $item= DB::select('select image,name, price, main_category from items where main_category = ?',
         [$request->main_category]);

         if (!$item) {
        return response()->json(['message' => 'Category not found'], 404);
    }

        return response()->json($item);
    
}

public function getItemById($id){

     $item = Item::with(['user:id,name'])->findOrFail($id);

    
   return response()->json([
        'id' => $item->id,
        'name' => $item->name,
        'image' => $item->image,
        'description' => $item->description,
        'price' => $item->price,
        'quantity' => $item->quantity,
        'creation_date' => $item->created_date,
        'owner_name' => $item->user->name
    ]);

}



public function viewItem($categoryName){

 $items = Item::where('main_category', $categoryName)
             ->with('user:id,name') // load only user name
             ->get();

     return ItemResource::collection($items);
}
}
