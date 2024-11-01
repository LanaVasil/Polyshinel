<?php

namespace App\Services;

use App\Interfaces\CartInterface;
use App\Models\Device;

class CartService implements CartInterface
{ 

  public function get(): mixed

  {
    if (session()->has('cart')){
      return session()->get('cart');
    }

    return[];
  }

  public function getTotal(): int
  {
    return 1;
  }

  public function clear(): void
  {

  }

  // public function add(Device $device): void
  // {
  //   session()->push('cart', $device);
  // }

  // public function remove(Device $device): bool
  // {

  // }

  public function update(Device $device): void
  {

  }



}