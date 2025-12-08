<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ]);

        // ✅ JWT authenticated user
        $user = JWTAuth::parseToken()->authenticate();

        DB::table('cart_items')->insert([
            'user_id'    => $user->id,
            'product_id' => $request->product_id,
            'quantity'   => $request->quantity,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json([
            'message' => 'Product added to cart successfully'
        ]);
    }
}
