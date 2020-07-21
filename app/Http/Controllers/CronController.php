<?php

namespace App\Http\Controllers;

use App\ProductItems;
use Carbon\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\AlertEmail;

class CronController extends Controller
{
    public function alertExpiredProduct()
    {
        //get items expire in next 48h
        $itemsBefore48H = ProductItems::whereDate('expired_date', '>=', Carbon::now()->toDateString())
            ->whereDate('expired_date', '<=', Carbon::now()->addDays(2)->toDateString())
            //->groupBy('product_id')
            ->get();

        if ($itemsBefore48H != NULL) {
            $ids = [];
            foreach ($itemsBefore48H as $item) {
                if(!in_array($item->product_id, $ids)) {
                    $ids[] = $item->product_id;
                }
            }
            $data = [
                'ids' => implode(',',$ids)
            ];
            Mail::to('sedera.aina@gmail.com')->send(new AlertEmail($data));
        }
    }
}
