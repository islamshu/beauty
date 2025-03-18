<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
            public function index()
        {
            $reservations = Reservation::with(['client', 'user'])->get();
        
            $events = [];
            foreach ($reservations as $reservation) {
                $events[] = [
                    'id' => $reservation->id,
                    'start' => $reservation->start,
                    'end' => $reservation->end,
                    'nots' => $reservation->nots,
                    'client' => $reservation->client ? $reservation->client->name : 'غير محدد', // اسم العميل
                    'user' => $reservation->user ? $reservation->user->name : 'غير محدد', // اسم المستخدم
                    'phone_number' => $reservation->client->phone,
                    'address' => $reservation->client->address,
                    'title' => $reservation->title,
                    'services' => $reservation->services, // إضافة الخدمات
                ];
            }
        
            return response()->json($events);
        }
    

    public function store(Request $request)
    {
        $event = new Reservation();
        $event->title = $request->title;
        $event->start = Carbon::parse($request->start)->toDateTimeString();
        $event->end = Carbon::parse($request->end)->toDateTimeString();
        $event->nots = $request->nots;
        $event->save();

        return redirect()->back()->with('toastr_success', 'تم إضافة الحدث بنجاح!');
    }

    public function destroy($id)
    {
        $event = Reservation::findOrFail($id);
        $event->delete();

        return redirect()->back()->with('toastr_success', 'تم حذف الحدث بنجاح!');
    }

}
