<?php

namespace App\Http\Controllers;

use App\Product;
use App\ProductItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Product list
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(Product::all());
    }

    /**
     * CREATE A NEW PRODUCT
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255|unique:products',
            'description' => 'required'
        ]);

        $product = Product::create($request->all());

        return response()->json(['id' => $product->product_id], 201);
    }

    /**
     * ADD ITEMS IN STOCK FOR A PRODUCT
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function addItems(Request $request)
    {
        $this->validate($request, [
            'quantity' => 'required|integer|min:0',
            'product_id' => 'required|exists:products',
            'expired_date' => 'required|date'
        ]);

        $productItems = ProductItems::create($request->all());

        return response()->json($productItems, 201);
    }

    /**
     * UPDATE PRODUCT
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product != NULL) {
            if ($request->input('name') != NULL) {
                $product->name = $request->input('name');
            }
            if ($request->input('description') != NULL) {
                $product->description = $request->input('description');
            }
            if ($request->input('price') != NULL) {
                $product->price = $request->input('price');
            }

            $product->save();
            return response()->json($product, 200);
        }
        else {
            return response()->json(["error" => 1, "message" => "Product " . $id . " does not exist"], 404);
        }
    }

    /**
     * SET THE PRICE FOR A PRODUCT
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setProductPrice(Request $request, $id)
    {
        $this->validate($request, [
            'price' => 'required|integer|min:0'
        ]);

        return $this->update($request, $id);
    }

    /**
     * GET PRODUCT PRICE
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function getProductPrice(Request $request, $id)
    {
        if (!$id) {
            return response()->json(["error" => 1, "message" => "Product id must required"], 400);
        }

        $this->validate($request, [
            'quantity' => 'required|integer|min:0'
        ]);

        $result = 0;

        $product = Product::find($id);

        if ($product != NULL) {
            $quantityRequest = $request->input('quantity');
            if ($quantityRequest > 0) {
                $price = $product->price;

                //get items expire in next 48h
                $itemsBefore48H = ProductItems::where('product_id', '=', $id)
                        ->whereDate('expired_date', '>=', Carbon::now()->toDateString())
                        ->whereDate('expired_date', '<=', Carbon::now()->addDays(2)->toDateString())
                        ->orderBy('quantity', 'DESC')
                        ->get();

                if ($itemsBefore48H != NULL) {
                    foreach ($itemsBefore48H as $item) {
                        $quantity = $item->quantity;
                        $quantityRest = $quantityRequest - $quantity;
                        if ($quantityRest <= 0) {
                            //If an item will expire in the next 48h a discount of 50% is applied.
                            $result += $quantityRequest * ($price * 0.5);
                            $quantityRequest = 0;
                            break;
                        }
                        else {
                            //If an item will expire in the next 48h a discount of 50% is applied.
                            $result += $quantity * ($price * 0.5);
                            $quantityRequest = $quantityRest;
                        }
                    }
                }

                if ($quantityRequest > 0) {
                    //get items expire after 48h
                    $itemsAfter48H = ProductItems::where('product_id', '=', $id)
                        ->whereDate('expired_date', '>', Carbon::now()->addDays(2)->toDateString())
                        ->orderBy('quantity', 'DESC')
                        ->get();

                    if ($itemsAfter48H != NULL) {
                        foreach ($itemsAfter48H as $item) {
                            $quantity = $item->quantity;
                            $quantityRest = $quantityRequest - $quantity;
                            if ($quantityRest <= 0) {
                                $result += $quantityRequest * $price;
                                $quantityRequest = 0;
                                break;
                            }
                            else {
                                $result += $quantity * $price;
                                $quantityRequest = $quantityRest;
                            }
                        }
                    }
                }

                if ($quantityRequest > 0) {
                    return response()->json(["error" => 1, "message" => "There are not enough items"], 400);
                }
            }
        }
        else {
            return response()->json(["error" => 1, "message" => "Product " . $id . " does not exist"], 404);
        }

        return response()->json(['total_price' => $result], 200);
    }
}
