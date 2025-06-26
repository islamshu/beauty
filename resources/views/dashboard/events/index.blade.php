@extends('layouts.master')
@section('title', 'الحجوزات')
@section('style')
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection
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
                            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal"
                                data-bs-target="#reservationModal">
                                <i class="fas fa-plus"></i> إضافة حجز
                            </button>
                        </div>
                        @include('dashboard.events._model_create')
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
                                                @if (isAdmin())
                                                    <form action="{{ route('reservations.destroy', $reservation->id) }}"
                                                        method="POST" style="display: inline-block;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"
                                                            onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
                                                    </form>
                                                @endif
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%', // مهم لضبط الحجم
                dir: 'rtl' // إذا كنت تستخدم اللغة العربية
            });
        });
    </script>
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
    <script>
        $('form').on('submit', function(e) {
            e.preventDefault();

            let form = this;
            let data = {
                date: $('input[name="date"]').val(),
                start_time: $('input[name="start_time"]').val(),
                end_time: $('input[name="end_time"]').val(),
                user_id: $('#user_id').val(),
                _token: '{{ csrf_token() }}'
            };

            $.post('{{ route('reservations.checkConflict') }}', data, function(response) {
                if (response.status === 'conflict') {
                    const formattedStart = formatDateTime(response.start);
                    const formattedEnd = formatDateTime(response.end);

                    alert(
                        `⚠️ يوجد تعارض مع الحجز: "${response.title}" من ${formattedStart} إلى ${formattedEnd}`
                    );
                } else {
                    form.submit(); // لا يوجد تعارض → أرسل النموذج
                }
            }).fail(function() {
                alert('حدث خطأ أثناء التحقق من التعارض');
            });
        });



        function formatDateTime(datetimeStr) {
            const date = new Date(datetimeStr);
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            };
            return date.toLocaleString('ar-EG', options).replace(',', '');
        }
    </script>
  
@endsection
