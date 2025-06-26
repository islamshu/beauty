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
        return view('dashboard.events.index')->with('reservations', Reservation::orderBy('id', 'desc')->get())->with('clients', Client::all())->with('users', User::all())->with('services', Service::all());
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

        $conflicting = Reservation::where('user_id', $request->user_id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    // الحالة 1: بداية الحجز الجديد داخل حجز موجود
                    $q->where('start', '<', $start)
                        ->where('end', '>', $start);
                })->orWhere(function ($q) use ($start, $end) {
                    // الحالة 2: نهاية الحجز الجديد داخل حجز موجود
                    $q->where('start', '<', $end)
                        ->where('end', '>', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    // الحالة 3: الحجز الجديد يحتوي تماماً على حجز موجود
                    $q->where('start', '>=', $start)
                        ->where('end', '<=', $end);
                });
            })
            ->first();

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

        // التحقق من وجود تعارض في المواعيد (النسخة المعدلة)
        $hasConflict = Reservation::where('user_id', $request->user_id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    // الحالة 1: بداية الحجز الجديد داخل حجز موجود
                    $q->where('start', '<', $start)
                        ->where('end', '>', $start);
                })->orWhere(function ($q) use ($start, $end) {
                    // الحالة 2: نهاية الحجز الجديد داخل حجز موجود
                    $q->where('start', '<', $end)
                        ->where('end', '>', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    // الحالة 3: الحجز الجديد يحتوي تماماً على حجز موجود
                    $q->where('start', '>=', $start)
                        ->where('end', '<=', $end);
                });
            })
            ->exists();

        if ($hasConflict) {
            return redirect()->back()
                ->withInput()
                ->with('toastr_error', 'يوجد تعارض مع حجز آخر. الرجاء اختيار وقت آخر.');
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

        // ربط الخدمات بالحجز
        if ($request->has('services')) {
            $reservation->services()->sync($request->services);
        }

        return redirect()->back()
            ->with('toastr_success', 'تم إضافة الحجز بنجاح.');
    }
    public function getLastByUser(Request $request)
    {
        $lastReservation = Reservation::where('user_id', $request->user_id)
            ->whereDate('start', $request->date)
            ->orderBy('end', 'desc')
            ->first(['end', 'title']);

        return response()->json([
            'lastReservation' => $lastReservation ? [
                'end_time' => $lastReservation->end ? date('H:i', strtotime($lastReservation->end)) : null,
                'title' => $lastReservation->title
            ] : null
        ]);
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
    public function edit(string $id)
    {
        $reservation = Reservation::with(['client', 'user', 'services'])->findOrFail($id);

        $date = Carbon::parse($reservation->start)->format('Y-m-d');
        $start = Carbon::parse($reservation->start)->format('H:i');
        $end = Carbon::parse($reservation->end)->format('H:i');

        // جلب آخر حجز لنفس الموظف في نفس اليوم (باستثناء الحجز الحالي)
        $lastReservation = Reservation::where('user_id', $reservation->user_id)
            ->whereDate('start', $date)
            ->where('id', '!=', $id)
            ->orderBy('end', 'desc')
            ->first();

        return view('dashboard.events.edit', [
            'reservation' => $reservation,
            'clients' => Client::all(),
            'users' => User::all(),
            'services' => Service::all(),
            'date' => $date,
            'start' => $start,
            'end' => $end,
            'lastReservation' => $lastReservation
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'title' => 'required|string|max:255',
            'services' => 'required|array',
            'services.*' => 'exists:services,id',
        ]);

        $reservation = Reservation::findOrFail($id);

        $start = Carbon::parse($request->date . ' ' . $request->start_time);
        $end = Carbon::parse($request->date . ' ' . $request->end_time);

        // التحقق من التعارضات (باستثناء الحجز الحالي)
        $conflict = Reservation::where('user_id', $request->user_id)
            ->where('id', '!=', $id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start, $end) {
                    $q->where('start', '<', $start)
                        ->where('end', '>', $start);
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '<', $end)
                        ->where('end', '>', $end);
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start', '>=', $start)
                        ->where('end', '<=', $end);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withInput()->with('error', 'يوجد تعارض مع حجز آخر للموظف في هذا الوقت');
        }

        // تحديث بيانات الحجز
        $reservation->update([
            'client_id' => $request->client_id,
            'user_id' => $request->user_id,
            'title' => $request->title,
            'start' => $start,
            'end' => $end,
            'nots' => $request->nots,
            'reason' => $request->reason,
        ]);

        // تحديث الخدمات المرتبطة
        $reservation->services()->sync($request->services);

        return redirect()->route('reservations.index')
            ->with('success', 'تم تحديث الحجز بنجاح');
    }

    public function getLastReservation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'exclude_id' => 'nullable|exists:reservations,id'
        ]);

        $query = Reservation::where('user_id', $request->user_id)
            ->whereDate('start', $request->date)
            ->orderBy('end', 'desc');

        if ($request->exclude_id) {
            $query->where('id', '!=', $request->exclude_id);
        }

        $lastReservation = $query->first(['end', 'title']);

        return response()->json([
            'lastReservation' => $lastReservation ? [
                'end_time' => $lastReservation->end ? Carbon::parse($lastReservation->end)->format('H:i') : null,
                'title' => $lastReservation->title
            ] : null
        ]);
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
