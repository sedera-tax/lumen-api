<?php

namespace App\Http\Controllers;

use App\Order;
use App\Product;
use App\ProductItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'order_id' => 'required|integer|unique:orders',
            'content' => 'required'
        ]);

        $content = $request->input('content');
        $result = [];
        foreach ($content as $basket) {
            $product_id = $basket['product_id'];
            $quantityRequest = $basket['quantity'];

            $product = Product::find($product_id);

            if ($product != NULL) {
                if ($quantityRequest > 0) {
                    //get items expire in next 48h
                    $itemsBefore48H = ProductItems::where('product_id', '=', $product_id)
                        ->whereDate('expired_date', '>=', Carbon::now()->toDateString())
                        ->whereDate('expired_date', '<=', Carbon::now()->addDays(2)->toDateString())
                        ->orderBy('quantity', 'ASC')
                        ->get();

                    if ($itemsBefore48H != NULL) {
                        foreach ($itemsBefore48H as $item) {
                            $quantity = $item->quantity;
                            $quantityRest = $quantityRequest - $quantity;
                            if ($quantityRest <= 0) {
                                $result[] = [
                                    'product_items_id' => $item->product_items_id,
                                    'quantity' => $quantityRequest
                                ];
                                $quantityRequest = 0;
                                break;
                            }
                            else {
                                $result[] = [
                                    'product_items_id' => $item->product_items_id,
                                    'quantity' => $quantity
                                ];
                                $quantityRequest = $quantityRest;
                            }
                        }
                    }

                    if ($quantityRequest > 0) {
                        //get items expire after 48h
                        $itemsAfter48H = ProductItems::where('product_id', '=', $product_id)
                            ->whereDate('expired_date', '>', Carbon::now()->addDays(2)->toDateString())
                            ->orderBy('quantity', 'ASC')
                            ->get();

                        if ($itemsAfter48H != NULL) {
                            foreach ($itemsAfter48H as $item) {
                                $quantity = $item->quantity;
                                $quantityRest = $quantityRequest - $quantity;
                                if ($quantityRest <= 0) {
                                    $result[] = [
                                        'product_items_id' => $item->product_items_id,
                                        'quantity' => $quantityRequest
                                    ];
                                    $quantityRequest = 0;
                                    break;
                                }
                                else {
                                    $result[] = [
                                        'product_items_id' => $item->product_items_id,
                                        'quantity' => $quantity
                                    ];
                                    $quantityRequest = $quantityRest;
                                }
                            }
                        }
                    }

                    if ($quantityRequest > 0) {
                        $result = NULL;
                        return response()->json(["error" => 1, "message" => "There are not enough items"], 400);
                    }
                }
            }
            else {
                return response()->json(["error" => 1, "message" => "Product " . $product_id . " does not exist"], 404);
            }

            if (!empty($result)) {
                foreach ($result as $res) {
                    $item = ProductItems::find($res["product_items_id"]);
                    $item->quantity = $item->quantity - $res["quantity"];
                    $item->save();
                }
            }
        }

        $orders = Order::create($request->all());

        return response()->json($orders, 201);
    }
}
