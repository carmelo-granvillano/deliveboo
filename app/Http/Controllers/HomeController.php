<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Auth;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * Char Order
     */
    public function charOrder()
    {
        $year = date('Y');

        $orders = Order::select('created_at')->where('user_id', Auth::user()->id)->whereYear('created_at', $year)->get()->groupBy(function($d) {
            return Carbon::parse($d->created_at)->format('m');
        });

        //$orders = Order::selectRaw("MONTH(created_at) as month")->distinct()->get();
        $char = [];
        if($orders){
            foreach($orders as $key => $order) {
                $char['orders'][(int)$key] = count($order);
            }
        }
        return $char;
    }
}
