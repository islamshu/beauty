@extends('layouts.master')
@section('title', 'تفاصيل الطلب')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-4 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تفاصيل الطلب') }}</h3>
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('الرئيسية') }}</a></li>
                                <li class="breadcrumb-item active">{{ __('تفاصيل الطلب') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-body">
                            <form id="orderForm">
                                <div class="row">
                                    <!-- الاسم -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="name">{{ __('الاسم') }}</label>
                                            <input type="text" name="name" value="{{ $order->full_name }}" readonly
                                                id="name" class="form-control">
                                        </div>
                                    </div>

                                    <!-- البريد الإلكتروني -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mobile">{{ __('رقم الهاتف') }}</label>
                                            <input type="text" value="{{ $order->phone }}" readonly name="mobile"
                                                id="mobile" class="form-control">
                                        </div>
                                    </div>


                                    <!-- رقم الهاتف -->
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mobile">{{ __('أسم الباقة ') }}</label>
                                            <input type="text" value="{{ $order->package->name }}" readonly
                                                name="mobile" id="mobile" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="mobile">{{ __('سعر الباقة') }}</label>
                                            <input type="text" value="{{ $order->package->price }}" readonly
                                                name="mobile" id="mobile" class="form-control">
                                        </div>
                                    </div>



                                    <div class="col-md-6">

                                        <!-- الرسالة -->
                                        <div class="form-group">
                                            <label for="message">{{ __('العنوان') }}</label>
                                            <textarea name="message" readonly id="message" class="form-control">{{ $order->address }}</textarea>
                                        </div>
                                    </div>

                                    <!-- زر الإرسال (بدون وظيفة إرسال) -->
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "{{ __('اختر الموضوع') }}",
                allowClear: true
            });
        });
    </script>
@endsection
