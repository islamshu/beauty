@extends('layouts.master')
@section('title','الحجوزات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الحجوزات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة الحجوزات') }}</h4>
                            <a href="{{ route('reservations.create') }}"
                                class="btn btn-primary">{{ __('إضافة حجز جديد') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="reservationstable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('العنوان') }}</th>

                                        <th>{{ __('العميل') }}</th>
                                        <th>{{ __('المستخدم') }}</th>
                                        <th>{{ __('رقم الهاتف') }}</th>
                                        <th>{{ __('تاريخ البداية') }}</th>
                                        <th>{{ __('تاريخ النهاية') }}</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reservations as $key => $reservation)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $reservation->title }}</td>

                                            <td>{{ $reservation->client->name }}</td>
                                            <!-- افترض أن العميل لديه حقل name -->
                                            <td>{{ $reservation->user->name }}</td>
                                            <!-- افترض أن المستخدم لديه حقل name -->
                                            <td>{{ $reservation->client->phone }}</td>
                                            <td>{{ $reservation->start }}</td>
                                            <td>{{ $reservation->end }}</td>
                                            <td>
                                                <a href="{{ route('reservations.edit', $reservation->id) }}"
                                                    class="btn btn-warning">{{ __('تعديل') }}</a>
                                                <form action="{{ route('reservations.destroy', $reservation->id) }}"
                                                    method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger"
                                                        onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#reservationstable").on("change", ".js-switch", function() {
            let status = $(this).prop('checked') === true ? 1 : 0;
            let reservation_id = $(this).data('id');
            $.ajax({
                type: "get",
                dataType: "json",
                url: '{{ route('update_status_reservation') }}',
                data: {
                    'status': status,
                    'reservation_id': reservation_id
                },
                success: function(data) {
                    toastr.success("تم تعديل الحالة بنجاح");
                }
            });
        });
    </script>
@endsection
