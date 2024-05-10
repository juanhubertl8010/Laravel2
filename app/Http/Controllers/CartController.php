<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;
use stdClass;

class CartController extends Controller
{
    private function data() : \Illuminate\Support\Collection
    {
        if (!Session::has('cart'))
        {
            return \collect([]);
        }

        $data = Session::get('cart');

        foreach ($data as $key => $d) {
            $d['item'] = DB::table('product')
                ->where('id', '=', $d['id'])
                ->first();

            $data[$key] = $d;
        }

        return $data;
    }

    private function dataPush(array $d)
    {
        $data = $this->data();
        if ($data->where('id', '=', $d['id'])->count() > 0)
        {
            foreach ($data as $k => $e) {
                if ($e['id'] == $d['id'])
                {
                    $e['total'] = $e['total'] + 1;
                    // This is hacky, but this works
                    $data[$k] = $e;
                }
            }
        }
        else
        {
            $data[] = $d;
        }
        // dd($data);
        Session::put('cart', $data);

        return $data;
    }

    private function calculateTotal()
    {
        return 0;
    }

    public function Index()
    {
        $cart = new stdClass();
        $cart->grandTotal = $this->calculateTotal();

        return \view('cart', [
            "data" => $this->data(),
            "cart" => $cart
        ]);
    }

    public function CartAddAction(Request $request, int $id)
    {
        // Mengonversi $id menjadi int jika diperlukan
    $id = (int) $id;

    $d = DB::table('product')
        ->where('id', '=', $id)
        ->first();

    if ($d == null) return \response()
        ->json([
            "statusCode" => 404,
            "message" => "Item not found!"
        ]);

    $this->dataPush([
        'id' => $id,
        'total' => 1
    ]);

    return \response()->json([
        'statusCode' => 201,
        "message" => "Item added!"
    ]);
    }
    public function cartdelete($id)
    {
        $cart = Session::get('cart', []);

        $deleted = false;
        foreach ($cart as $index => $product) {
            if ($product['id'] == $id) {
                unset($cart[$index]);
                $deleted = true;
                break; 
            }
        }
    
        if (!$deleted) {
            return redirect('/cart')->with("error", "Product not found in the cart.");
        }
    
        Session::put('cart', $cart);
        return redirect('/cart')->with("success", "Cart record {$id} deleted!");
    }

}
