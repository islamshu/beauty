@extends('layouts.master')
@section('title', 'تفاصيل الطلب #' . $order->id)
@section('content')
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="content-header-title">تفاصيل الطلب #{{ $order->id }}</h3>
                <div class="row breadcrumbs-top">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('courses_order') }}">طلبات الدورات</a></li>
                            <li class="breadcrumb-item active">تفاصيل الطلب</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section class="card">
                <div class="card-header">
                    <h4 class="card-title">معلومات الطلب</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="info-box">
                                    <h5><i class="fas fa-user"></i> معلومات العميل</h5>
                                    <ul class="list-unstyled">
                                        <li><strong>الاسم:</strong> {{ $order->name }}</li>
                                        <li><strong>الهاتف:</strong> {{ $order->phone }}</li>
                                        <li><strong>الواتساب:</strong> 
                                            @if($order->whatsapp)
                                                <a href="https://wa.me/{{ $order->whatsapp }}" target="_blank">
                                                    {{ $order->whatsapp }} <i class="fab fa-whatsapp text-success"></i>
                                                </a>
                                            @else
                                                غير متوفر
                                            @endif
                                        </li>
                                        <li><strong>مستوى الخبرة:</strong> 
                                            @switch($order->experience)
                                                @case('beginner') مبتدئ @break
                                                @case('intermediate') متوسط @break
                                                @case('advanced') متقدم @break
                                                @default غير محدد
                                            @endswitch
                                        </li>
                                        <li><strong>العنوان:</strong> {{ $order->address }}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="info-box">
                                    <h5><i class="fas fa-book"></i> معلومات الدورة</h5>
                                    <ul class="list-unstyled">
                                        <li><a href="{{route('courses.show', @$order->course->id)}}"><strong>اسم الدورة:</strong> {{ @$order->course->title ?? 'تم حذف الدورة' }}</a></li>
                                        <li><strong>السعر:</strong> ₪{{ @$order->course->price ?? 'تم حذف الدورة' }}</li>
                                      
                                        <li><strong>تاريخ التسجيل:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-12">
                                <div class="info-box">
                                    <h5><i class="fas fa-bullseye"></i> هدف العميل من الدورة</h5>
                                    <p>{{ $order->goal ?? 'لم يتم تحديد هدف' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="action-buttons">
                                    <a href="{{ route('courses_order') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right"></i> رجوع
                                    </a>
                                    <a href="@whatsappLink($order->whatsapp ?? $order->phone)" 
                                        class="btn btn-success" 
                                        target="_blank">
                                         <i class="fab fa-whatsapp"></i> تواصل عبر الواتساب
                                     </a>
                                    
                                    <button class="btn btn-danger" onclick="confirmDelete({{ $order->id }})">
                                        <i class="fas fa-trash"></i> حذف الطلب
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<form id="deleteForm" action="{{ route('cource_order.delete', $order->id)}}" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>

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
                document.getElementById('deleteForm').submit();

            }
        })
    }
</script>
@endsection

<style>
    .info-box {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 20px;
        height: 100%;
    }
    .info-box h5 {
        color: #d63384;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
        margin-bottom: 15px;
    }
    .info-box ul li {
        padding: 5px 0;
    }
    .action-buttons .btn {
        margin-left: 10px;
    }
    .whatsapp-btn {
        background-color: #25D366;
        border-color: #25D366;
    }
</style>
@endsection