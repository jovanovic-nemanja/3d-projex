<?php

namespace App;

use App\Orderlist;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Orderlist extends Model
{
    public $table = 'orderlist';
	
    public $fillable = ['order_number', 'checking_num', 'model_name', 'model_price', 'model_photo', 'order_count', 'userid', 'order_date'];

    /**
    * generate the order number for checkout
    *
    * @author Nemanja
    * @since 2021-04-14
    * @return order number as unique
    */
    public static function generateOrderNum()
    {
    	$num = substr("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", mt_rand(0, 51), 1).substr(md5(time()), 1);
    	return $num;
    }

}
