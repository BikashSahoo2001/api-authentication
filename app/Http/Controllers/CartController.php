<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ]);

        $user = $request->user(); // authenticated user from Sanctum

        DB::table('carts')->insert([
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
