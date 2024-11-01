<?php

namespace App\Http\Controllers\Pro;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CartProController extends Controller
{
    public function index()
    {
        view('pro.cart.index');
    }

    public function add(Device $device) : RedirectResponse
    {
      session()->flash('success', 'Пристрий додано в пакет.');
      // flash('success', 'Пристрий додано в пакет.');

      // return redirect()->route('admin.devices.show', $device->id); 
      return redirect()->intended(route('cart')); 
    }

    public function quantity(): RedirectResponse
    {
      session()->flash('success', 'Кількість пристроїв змінено.');
      return redirect()->intended(route('cart')); 
    }

    public function delete(): RedirectResponse 
    {
      session()->flash('success', 'Видалено з пакета.');      
      return redirect()->intended(route('cart')); 
    }

    public function truncate(): RedirectResponse 
    {
      session()->flash('success', 'Пакет порожній.');      
      return redirect()->intended(route('cart')); 
    }


}
