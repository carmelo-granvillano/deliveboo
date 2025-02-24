<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Models\User;
use App\Models\Product;
use Auth;

class RestaurantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurants = User::with(['products' => fn($query) => $query->select('visibility')->where('visibility',1)])
        ->whereHas('products', fn($query) => $query->select('visibility')->where('visibility',1))->with('tags')->get();

        return response()->json([
            'success' => true,
            'results' => $restaurants
        ]);
    }

    /**
     * Show all products active in the restaurant
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function showProducts($slug)
    {

        $restaurant = User::with(['products' => fn($query) => $query->where('visibility',1)])
        ->whereHas('products', fn($query) => $query->where('visibility',1))->where('slug', $slug)->firstOrFail();

        /*
        $user = User::where('slug', $slug)->first();
        $products = Product::where('user_id', $user->id)->where('visibility',1)->get();
        */
        
        return $restaurant;
    }


    public function search(Request $request)
    {
        if($request->has('search')){
            $word = $request->query('search');
            $restaurants = User::where('name', 'LIKE', "%$word%")->whereHas('products', fn($query) => $query->where('visibility',1))->get();
            return $restaurants;
        }
    }

    public function auth()
    {
        $response = ['success' => false];

        if(Auth::user()){
            $user = Auth::user();
            $response['success'] = true;
            $response['auth'] = [
                'name' => $user->name,
                'email' => $user->email,
                'cover' => $user->cover
            ];
        }

        return $response;
    }

}
