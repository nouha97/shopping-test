<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Discount;
use App\Models\Product;
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
        //return response()->json(["message" => "Cart created successfully"], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $product=$request->product_id;
        $qty=$request->quantity;

        $cart = Cart::create([
            'identifier' => Str::random(13),

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
    public function show($id)
    {
        $cart= Cart::where('identifier',$id)->get();
        if($car == null) {
            return response()->json(["message" => "Cart not found"],404);
        }
        $tax = config('tax.tax');
        $dataitems=array();
        $sum =0;
        foreach($cart->products as $item) {

            $data =  [
            "row_id" => $item->pivot->row_id,
            "product_id" => $item->id,
            "name" => $item->description,
            "qty" => $item->pivot->qty,
            "price" => $item->price,
            "options" => $item->images_urls,
            "tax" => ($tax * $item->price)/100,
            "subtotal" => getPrice($item->price,$item->pivot->qty,$tax),
            ];

            array_push($dataitems,$data);

            //total sum calclated
            $sum=$sum+getPrice($item->price,$item->pivot->qty,$tax);
            }

            //discount apply
            if ($cart->discount_id != null){

            $discount_info = Discount::where('id',$cart->discount_id)->pluck('discount_code','percentage_value');

            $sum= $sum - $sum * ($discount_info->percentage_value/100);

    }

    // cart content
            $Cartdata = [

                "cart" => [
                    "identifier" => $cart->identifier,
                    "items" => $dataitems,
                    "discount" => [
                        "code" =>
                        $discount_info->discount_code,
                        "value" => $discount_info->percentage_value,
                    ],
                        "summarry" => [
                            "total" => $sum,

                        ]
                ]

        ];

        return response()->json($cartData , 200);
    }

    public function getPrice($price,$qt,$tax)
    {
        $subtotal = $qt*($price+$price*($tax/100));
        return $subtotal;

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
    public function update(Request $request, $id)
    {
        $cart= Cart::where('identifier',$id)->get();
        if($car == null) {
            return response()->json(["message" => "Cart not found"],404);
        }

        $cart->products()->updateExistingPivot($request->product_id, ['qty' => $request->quantity]);
        return  response()->json(["message" => "Product updated from cart successfully "], 200);


    }

    public function discount(Request $request, $id)
    {
        $cart= Cart::where('identifier',$id)->get();
        if($cart == null) {
            return response()->json(["message" => "Cart not found"],404);
        }

        $discount_id = Discount::where('discount_code', $request->discount_code)->get('id')->first();
        if ($discount_id == null) {
            return response()->json(["message" => "Discount code not found"], 404);
        }
        else {
            $cart->discount_id = $discount_id;
            return  response()->json(["message" => "Discount code applied successfully "], 200);
        }

    }

    public function delete(Request $request, $id)
    {
        $cart= Cart::where('identifier',$id)->get();
        if($cart == null) {
            return response()->json(["message" => "Cart not found"],404);
        }
        $cart->products()->wherePivot('row_id',$request->row_id)->detach();
        return  response()->json(["message" => "Product removed from cart successfully "], 200);
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
//
    }
}
