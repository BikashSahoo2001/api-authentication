<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1'
        ]);

        $user = auth('api')->user();

        // check if product already exists in cart
        $cart = CartItem::where('user_id', $user->id)
                        ->where('product_id', $request->product_id)
                        ->first();

        if ($cart) {
            $cart->quantity += $request->quantity;
            $cart->save();
        } else {
            CartItem::create([
                'user_id'    => $user->id,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity
            ]);
        }

        return response()->json(['message' => 'Product added to cart successfully']);
    }
}
