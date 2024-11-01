<?php

namespace App\Http\Controllers;

use App\Http\Requests\Repairs\Save as SaveRequest;
use App\Models\Unit;
use App\Models\Device;
use App\Models\Repair;
use App\Models\Worker;
use App\Models\Document;
use App\Enums\Repair\Status as RepairStatus;
use Carbon\Carbon;

class Repairs extends Controller
{
  public function index()
  {
    // $repairs = Repair::all();
    $repairs = Repair::withCount('repdevices')->orderByDesc('created_at')->get();

    // return view('repairs.index', compact('repairs', 'devices'));
    return view('repairs.index', compact('repairs'));
  }


  public function create()
  {
    $repair = [];
    $units = Unit::orderBy('name')->pluck('name', 'id');
    $workers = Worker::orderBy('name')->pluck('name', 'id');
    return view('repairs.create', compact('repair', 'units', 'workers'));
  }


  public function store(SaveRequest $request)
  {
    $data = $request->validated();
    $repair = Repair::create($data);
    session()->flash('notifications', 'repair.stored');

    // $workers = Worker::orderBy('name')->pluck('name', 'id');
    return redirect()->route('repairs.show', [$repair->id]);
  }


  public function show($id)
  {
    $repair = Repair::findOrFail($id);
    $units = Unit::orderBy('name')->pluck('name', 'id');
    $workers = Worker::orderBy('name')->pluck('name', 'id');
    $devices = Device::orderBy('name')->pluck('name', 'id');
    $documents = Document::orderBy('income')->pluck('income', 'id');
    $repdevice = [];


    // Carbon::setLocale(('ua_UA'));
    // $date = Carbon::parse(now());
    // dd($date->translatedFormat('F'));
    //dd($date->format('d/m/Y')->translatedFormat('F'));

    // dd($devices);
    // dd($repair->status);
    // закти для огляду
    // if ($repair->status !==RepairStatus::APPROVED) 404
    return view('repairs.show', compact('repair', 'units', 'workers', 'devices', 'documents', 'repdevice'));
  }


  public function edit($id)
  {
    $repair = Repair::findOrFail($id);
    // $repair->status = RepairStatus::APPROVED;
    // $repair->save();
    // dd($repair);
    $units = Unit::orderBy('name')->pluck('name', 'id');
    $workers = Worker::orderBy('name')->pluck('name', 'id');
    return view('repairs.edit', compact('repair', 'units', 'workers'));
  }


  public function update(SaveRequest $request, $id)
  {
    $data = $request->validated();
    $repair = Repair::findOrFail($id);
    $repair->update($data);

    $units = Unit::orderBy('name')->pluck('name', 'id');
    $devices = Device::orderBy('name')->pluck('name', 'id');
    $workers = Worker::orderBy('name')->pluck('name', 'id');
    $documents = Document::orderBy('income')->pluck('income', 'id');

    $repdevice = [];

    session()->flash('notifications', 'repair.update');
    return view('repairs.show', compact('repair', 'units', 'workers', 'devices', 'documents', 'repdevice'));
  }


  public function destroy($id)
  {
    $repair = Repair::findOrFail($id);

    session()->flash('notification', 'repairs.destroy');
    $repair->delete();
    return redirect()->route('repairs.index');
  }


  public function trash()
  {
    $repairs = Repair::onlyTrashed()->get();
    return view('repairs.trash', compact('repairs'));
  }


  public function restore($id)
  {
    $repair = Repair::onlyTrashed()->findOrFail($id);
    $repair->restore();
    session()->flash('notification', 'repairs.restore');
    return redirect()->route('repairs.show', [$repair->id]);
  }


  public function destroyForewer($id)
  {
    Repair::onlyTrashed()->findOrFail($id)->forceDelete();
    return redirect()->route('repairs.index');
  }



  public function change($id)
  {
    $repair = Repair::findOrFail($id);

    // dd($status);
    // $repair->status = RepairStatus::APPROVED;
    // призначення нового статуса
    switch ($repair->status->name) {
      case 'DRAFT':
        $repair->status = RepairStatus::APPROVED;
        break;
      case 'APPROVED':
        $repair->status = RepairStatus::POSTPONED;
        break;
      case 'POSTPONED':
        $repair->status = RepairStatus::ARCHIVED;
        break;
      case 'ARCHIVED':
        $repair->status = RepairStatus::DRAFT;
        break;
      default:
        $repair->status = RepairStatus::DRAFT;
        break;
    }
    $repair->save();

    $repairs = Repair::withCount('repdevices')->orderByDesc('created_at')->get();
    return view('repairs.index', compact('repairs'));
  }
}
