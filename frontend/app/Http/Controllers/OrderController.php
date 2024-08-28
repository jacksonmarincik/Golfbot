<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function index(Request $request){
    
        $get = DB::table('orders')->join('user_setting', 'user_setting.id', 'orders.siteid');

        if($request->username != ''){
            $get->where('siteid', $request->username);
        }

        if($request->date != ''){
            $get->where('book_date', $request->date);
        }

        if($request->status != ''){
            $get->where('orders.status', $request->status);
        }
        
        $orders = $get->select('user_name', 'book_time', 'book_date', 'orders.status')->paginate(10);

        $user_setting_data = DB::table('user_setting')->pluck('user_name', 'id')->toArray();

        return view('pages.orders.index', compact('orders', 'user_setting_data'));
    }
}
