<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Models\Client;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use Carbon\Carbon;
use Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.events.index')->with('reservations', Reservation::orderBy('id', 'desc')->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.events.create')->with('clients', Client::all())->with('users', User::all())->with('services', Service::all());
    }

    /**
     * Store a newly created resource in storage.
     */

    public function checkConflict(Request $request)
    {
        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end = Carbon::parse($request->date . ' ' . $request->end_time);

        $conflicting = Reservation::where(function ($query) use ($start, $end) {
            $query->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '<=', $start)
                        ->where('end', '>=', $end);
                });
        })->first();

        if ($conflicting) {
            return response()->json([
                'status' => 'conflict',
                'title' => $conflicting->title,
                'start' => $conflicting->start,
                'end' => $conflicting->end,
            ]);
        }

        return response()->json(['status' => 'ok']);
    }
    public function store(StoreReservationRequest $request)
    {
        // تحويل التاريخ والوقت إلى كائنات Carbon
        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end = Carbon::parse($request->date . ' ' . $request->end_time);

        // التحقق من وجود تعارض في المواعيد
        $hasConflict = Reservation::where(function ($query) use ($start, $end) {
            $query->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '<=', $start)
                        ->where('end', '>=', $end);
                });
        })->exists();

        if ($hasConflict) {
            return redirect()->back()->with('toastr_error', 'يوجد حجز آخر في نفس الفترة الزمنية.');
        }

        // حفظ الحجز إذا لم يوجد تعارض
        $reservation = Reservation::create([
            'title' => $request->title,
            'start' => $start,
            'end' => $end,
            'nots' => $request->nots,
            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'reason' => $request->reason,
        ]);

        $reservation->services()->sync($request->services);

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
        $event = Reservation::findOrFail($id);
        $date =   Carbon::parse($event->start)->format('Y-m-d');
        $start =   Carbon::parse($event->start)->format('H:i');
        $end =   Carbon::parse($event->end)->format('H:i');
        return view('dashboard.events.edit')
            ->with('reservation', $event)
            ->with('clients', Client::all())
            ->with('users', User::all())
            ->with('services', Service::all())
            ->with('date', $date)
            ->with('start', $start)
            ->with('end', $end);
    }
    public function search(Request $request)
    {
        $parsedDate = null;
        $term = $request->input('term');
        // إذا كانت الصيغة تشبه تاريخًا (مثل 10/05/2025 أو 2025-05-10)
        if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $term)) {
            try {
                $parsedDate = \Carbon\Carbon::createFromFormat('d/m/Y', $term)->format('Y-m-d');
            } catch (\Exception $e) {
                $parsedDate = null;
            }
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $term)) {
            try {
                $parsedDate = \Carbon\Carbon::parse($term)->format('Y-m-d');
            } catch (\Exception $e2) {
                $parsedDate = null;
            }
        }

        $events = Reservation::where(function ($query) use ($term, $parsedDate) {
            $query->where(function ($q) use ($term, $parsedDate) {
                $q->where('title', 'like', "%$term%")
                    ->orWhere('nots', 'like', "%$term%")
                    ->orWhere('reason', 'like', "%$term%");

                if ($parsedDate) {
                    $q->orWhereDate('start', $parsedDate)
                        ->orWhereDate('end', $parsedDate);
                }

                $q->orWhereHas('client', function ($qc) use ($term) {
                    $qc->where('name', 'like', "%$term%")
                        ->orWhere('phone', 'like', "%$term%");
                });

                $q->orWhereHas('user', function ($qu) use ($term) {
                    $qu->where('name', 'like', "%$term%");
                });
            });
        })
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start,
                    'end' => $event->end,
                    'extendedProps' => [
                        'client' => $event->client->name,
                        'user' => $event->user->name,
                        'phone_number' => $event->client->phone,
                        'address' => $event->client->address,
                        'nots' => $event->nots,
                        'reason' => $event->reason,
                        'services' => $event->services->map(function ($service) {
                            return [
                                'title' => $service->title,
                                'price' => $service->price
                            ];
                        })
                    ]
                ];
            });

        return response()->json($events);
    }





    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReservationRequest $request, $id)
    {
        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end = Carbon::parse($request->date . ' ' . $request->end_time);
        // جلب الحجز المطلوب تعديله
        $reservation = Reservation::findOrFail($id);
        $conflicting = Reservation::where('id', '!=', $reservation->id)->where(function ($query) use ($start, $end) {
            $query->whereBetween('start', [$start, $end])
                ->orWhereBetween('end', [$start, $end])
                ->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '<=', $start)
                        ->where('end', '>=', $end);
                });
        })->first();


        if ($conflicting) {
            $start_conf = Carbon::parse($conflicting->start);
            $end_conf = Carbon::parse($end);
            $message = 'يوجد حجز آخر في نفس الفترة الزمنية. اسم الحجز :  ' . $conflicting->title . ' من  الساعة ' . $start_conf->format('H:i') . ' الى ' . $end_conf->format('H:i');
            return redirect()->back()->with('toastr_error', $message);
        }
        // تحديث بيانات الحجز
        $reservation->update([
            'title' => $request->title,
            'start' => $start,
            'end' => $end,
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
