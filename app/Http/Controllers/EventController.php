<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.events.index')->with('reservations',Reservation::orderBy('id','desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.events.create')->with('clients',Client::all())->with('users',User::all())->with('services',Service::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        // التحقق من البيانات وحفظها
        $reservation = Reservation::create([
            'title' => $request->title,
            'start' => $request->date .' '. $request->start_time,
            'end' => $request->date .' '.$request->end_time,
            'nots' => $request->nots,
            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'reason' => $request->reason,
        ]);
        $reservation->services()->sync($request->services);

        // إعادة توجيه مع رسالة نجاح
        return redirect()->back()->with('toastr_success', 'تم إضافة الحجز بنجاح.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('dashboard.events.edit')
            ->with('reservation', Reservation::findOrFail($id))
            ->with('clients', Client::all())
            ->with('users', User::all())
            ->with('services', Service::all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReservationRequest $request, $id)
    {
        // جلب الحجز المطلوب تعديله
        $reservation = Reservation::findOrFail($id);
    
        // تحديث بيانات الحجز
        $reservation->update([
            'title' => $request->title,
            'start' => $request->start,
            'end' => $request->end,
            'nots' => $request->nots,
            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'reason' => $request->reason,
        ]);
    
        // تحديث الخدمات المرتبطة بالحجز
        $reservation->services()->sync($request->services);
    
        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('reservations.index')->with('toastr_success', 'تم تحديث الحجز بنجاح.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = Reservation::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('toastr_success', 'تم حذف الحدث بنجاح!');
    }
}
