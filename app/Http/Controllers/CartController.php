<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResource;
use App\Models\Cart;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
   public function addToCart(Request $request)
    {
        $user = Auth::user();
       // dd($user);
       $fields= Validator::make($request->all(),[
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            
        ]);
       
           if($fields->fails()){
            return response()->json($fields->errors());
        }
       try {
       
       
        $item = Item::find($request->item_id);
        if(!$item){
            return response()->json('item not found');
        }
    
        // Check if product exists in user's cart
        $cartItem = Cart::where('user_id', $user->id)
                        ->where('item_id', $item->id)
                        ->first();
      // $total= $request->quantity * $item->price;
       //dd($cartItem->quantity);
        if ($cartItem) {
             $cartItem->increment('quantity');
             $cartItem->total_price = $cartItem->quantity * $item->price;
             $cartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'quantity' => $request->quantity,
                'price' => $item->price,
                'total_price' => $request->quantity * $item->price,
            ]);
        }

        return response()->json(['message' => 'Item added to request page successfully']);

        } catch (\Exception $exception) {

    return response()->json(['error'=>$exception->getMessage()]);
   }
    }

    public function viewUserCart()
    {
        $user = Auth::user();
        $cartItems = Cart::where('user_id', $user->id)->with('item')->get();
        return CartResource::collection($cartItems);
     //  return response()->json(['cart' => $cartItems]);
    }

    public function removeItemFromCart(Request $request){

        $request->validate([
            'item_id' => 'required|integer',
        ]);

        $user = auth()->user();

        $cartItem = Cart::where('user_id', $user->id)
                        ->where('item_id', $request->item_id)
                        ->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Item not found in cart.'], 404);
        }

        // If quantity > 1, decrease by 1
        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
            $cartItem->total_price = $cartItem->price * $cartItem->quantity;
            $cartItem->save();

            return response()->json(['message' => 'Item quantity decreased.']);
        }

        // If quantity is 1, remove the item
        $cartItem->delete();
        return response()->json(['message' => 'Item removed from cart.']);
    }

}
