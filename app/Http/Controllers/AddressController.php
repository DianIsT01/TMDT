<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        return view('/account/address/create');
    }

    public function store(){

        $data  = request()->validate([
            'street_address' => 'required|alpha_num',
            'city' => 'required|alpha',
            'province' => 'required|alpha',
            'postal_code' => 'required|alpha_num',
            'country' => 'required|alpha',
        ]);

        auth()->user()->addresses()->create([
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'province' => $data['province'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
        ]);

        return redirect('/home');
    }

    public function restaurantAddress(){
        $data  = request()->validate([
            'street_address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
            'country' => 'required',
        ]);

        auth()->user()->addresses()->create([
            'description' => 'restaurant_location',
            'street_address' => $data['street_address'],
            'city' => $data['city'],
            'province' => $data['province'],
            'postal_code' => $data['postal_code'],
            'country' => $data['country'],
        ]);

        return redirect('/home');
    }
}
