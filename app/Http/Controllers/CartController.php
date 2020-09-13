<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $product=$request->product_id;
        $qty=$request->qty;

        $cart = Cart::create([
            'identifier' => Str::random(13),
            //'content' => 44,

        ]);

        for ($item=0; $item < count($product); $item++) {
            if ($product[$item] != '') {
                $cart->products()->attach($product[$item], [
                    'qty' => $qty[$item],
                    'row_id' => Str::random(32),
                ]);
            }
        }

        if (!$cart->save()){
            return response()->json(["message" => "Cart not created "], 500);
        }

        return response()->json(["message" => "Cart created successfully"], 200);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        $dataCart = array(
            'cart'      => $code,
            'message'   => $code_message,
            'data'      => $message
        );
        return response()->json(["message" => "Cart created successfully"], 200);
    }

    public function getPrice(Cart $cart)
    {
        $prices=array();
        foreach ($cart->products() as $product ) {
            $priceNet = $product->price * $product->qty;
            array_push($priceNet,$prices);
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {

        $car->update($request->all());
    }

    public function delete(Request $request, Cart $cart)
    {

        $car->products()->detach($request->row_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {

    }
}
