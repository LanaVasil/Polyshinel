<?php

namespace App\Http\Controllers\Admin;

// use App\Services\CartService;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveDeviceRequest;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Devtype;
use App\Models\Brand;


class DevicesAdminController extends Controller
{

  // // об'являємо корзину cart
  // protected CartService $cartService;

  // public function __construct()
  // {
  //   $this->cartService = new CartService();
  // }

  /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // $devices = Device::all();
        $devices = Device::paginate(10);
        // dd($devices);
        return view('admin.devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {        
        // потрібно на формі form-fields.blade.php
        $device = []; 
        $brands = Brand::orderBy('sort')->pluck('name', 'id');
        $devtypes = Devtype::orderBy('sort')->pluck('name', 'id');
        return view('admin.devices.create', compact('device', 'brands', 'devtypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveDeviceRequest $request)
    {
        
        $data = $request->validated();
        Device::create($data);
        // session()->flash('notification', 'device.stored');
        session()->flash('success', 'Додано новий запис.');
        return redirect()->route('admin.devices.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $device = Device::findOrFail($id);
        // $brands = Brand::all();
        $brands = Brand::orderBy('sort')->pluck('name', 'id');
        $devtypes = Devtype::orderBy('sort')->pluck('name', 'id');
        return view('admin.devices.show', compact('device', 'brands', 'devtypes'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        // $devtypes = Devtype::orderBy('sort')->pluck('name', 'id');
        $device = Device::findOrFail($id);
        $brands = Brand::orderBy('sort')->pluck('name', 'id');
        $devtypes = Devtype::orderBy('sort')->pluck('name', 'id');
        return view('admin.devices.edit', compact('device', 'brands', 'devtypes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveDeviceRequest $request, string $id)
    {

        $device = Device::findOrFail($id);
        $device->update($request->validated());

        session()->flash('success', 'Зміни збережено.');
    
        return redirect()->route('admin.devices.show', $device->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $device = Device::findOrFail($id);

        // if ($device->repdevices->count() == 0) {
          $device->delete();
          session()->flash('success', "Запис $device->name було видалено");
        // } else {
        // session()->flash('success', 'Видалити не сожливо є підпорядковані записи.');
        // };
    
        return redirect()->route('admin.devices.index');
    }

    public function addToCart($id) 
    {
        
      $device = Device::query()->find($id);

        if (is_null($device)) {
          return back();
        }
        session('cart',$device);
        // $this->cartService->add($device);

        return back();
    }

  // public function remove(string $id)
  // {
  //   Device::onlyTrashed()->findOrFail($id)->forceDelete();
  //   return redirect()->route('devices.index');
  // }

  // public function trash()
  // {
  //   $devices = Device::onlyTrashed()->get();
  //   return view('devices.admin.trash', compact('devices'));
  // }

  // public function restore($id)
  // {
  //   $device = Device::onlyTrashed()->findOrFail($id);
  //   $device->restore();
  //   return redirect()->route('devices.show', [$device->id]);
  // }    
}
