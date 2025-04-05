@extends('layouts.master')
@section('title', 'طلبات الدورات')
@section('style')
    <style>
        .badge-warning {
            background-color: #ffc107;
            color: #212529;
        }

        .badge-success {
            background-color: #28a745;
        }

        .badge-danger {
            background-color: #dc3545;
        }

        .btn-group .btn {
            margin: 0 3px;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(0, 0, 0, .03);
        }

        .status-badge {
            font-size: 0.9rem;
            padding: 5px 10px;
            min-width: 80px;
            display: inline-block;
            text-align: center;
        }

        .action-buttons {
            white-space: nowrap;
        }
    </style>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('طلبات الدورات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <div class="table-responsive">
                                <table class="table table-hover" id="ordersTable">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('اسم العميل') }}</th>
                                            <th>{{ __('الهاتف') }}</th>
                                            <th>{{ __('الدورة') }}</th>
                                            <th>{{ __('الحالة') }}</th>
                                            <th>{{ __('تاريخ التسجيل') }}</th>
                                            <th>{{ __('العمليات') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr id="order-row-{{ $order->id }}">
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->name }}</td>
                                                <td>
                                                    <a href="tel:{{ $order->phone }}">
                                                        {{ $order->phone }}
                                                    </a>
                                                </td>
                                                <td>{{ @$order->course->title ?? '--' }}</td>
                                                <td>
                                                    <span id="status-badge-{{ $order->id }}"
                                                        class="status-badge badge-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'approved' ? 'success' : 'danger') }}">
                                                        {{ $order->status == 'pending' ? 'قيد الانتظار' : ($order->status == 'approved' ? 'مقبول' : 'ملغى') }}
                                                    </span>
                                                </td>
                                                <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                                <td class="action-buttons">
                                                    <div class="btn-group">
                                                        <a href="{{ route('cource_order', $order->id) }}"
                                                            class="btn btn-sm btn-primary" title="عرض التفاصيل">
                                                            <i class="la la-eye"></i>
                                                        </a>
                                                        <a href="@whatsappLink($order->whatsapp ?? $order->phone)"
                                                            class="btn btn-sm btn-success" 
                                                            target="_blank" 
                                                            title="واتساب">
                                                            <i class="la la-whatsapp"></i>
                                                         </a>
                                                        <button
                                                            onclick="changeStatus({{ $order->id }}, 'approved' ,'{{ route('updateStatus_course_order', ['order' => $order->id]) }}')"
                                                            class="btn btn-sm btn-success" title="قبول">
                                                            <i class="la la-check"></i>
                                                        </button>
                                                        <button
                                                            onclick="changeStatus({{ $order->id }}, 'rejected' ,'{{ route('updateStatus_course_order', ['order' => $order->id]) }}')"
                                                            class="btn btn-sm btn-danger" title="رفض">
                                                            <i class="la la-times"></i>
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="confirmDelete({{ $order->id }})" title="حذف">
                                                            <i class="la la-trash"></i>
                                                        </button>
                                                    </div>
                                                    <form id="delete-form-{{ $order->id }}"
                                                        action="{{ route('cource_order.delete', $order->id) }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "لن تتمكن من استعادة هذا الطلب!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'نعم، احذفه!',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function changeStatus(button, newStatus, url) {
            // Modify the URL to include the status as a query parameter
            const updatedUrl = `${url}?status=${newStatus}`;

            // Use AJAX GET request for this
            $.ajax({
                url: updatedUrl, // The updated URL with the query parameter
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                },
                success: function(data) {
                    // If successful, update the UI and show a success message
                    if (data.success) {
                        updateStatusUI(button, newStatus);
                        Swal.fire('تم!', data.message, 'success');
                    }
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.error('Error:', error);
                    Swal.fire('خطأ!', 'حدث خطأ أثناء تحديث الحالة', 'error');
                }
            });
        }





        function updateStatusUI(orderId, newStatus) {
            const statusMap = {
                'pending': {
                    text: 'قيد الانتظار',
                    class: 'warning'
                },
                'approved': {
                    text: 'مقبول',
                    class: 'success'
                },
                'rejected': {
                    text: 'ملغى',
                    class: 'danger'
                }
            };

            const badge = document.querySelector(`#status-badge-${orderId}`);
            if (badge) {
                badge.className = `status-badge badge-${statusMap[newStatus].class}`;
                badge.textContent = statusMap[newStatus].text;
            }
        }
    </script>
@endsection
