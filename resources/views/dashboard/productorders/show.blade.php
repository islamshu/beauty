@extends('layouts.master')

@section('title', ' تفاصيل الطلب')

@section('content')
    <div class="app-content content">

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('تفاصيل الطلب ') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('طلبات المنتجات') }}</h4>
                    
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <h2>تفاصيل الطلب #{{ $order->id }}</h2>
                        <div class="card">
                            <div class="card-body">
                                <h5>معلومات العميل</h5>
                                <p><strong>الاسم:</strong> {{ $order->customer_name }}</p>
                                <p><strong>الهاتف:</strong> {{ $order->customer_phone }}</p>
                                <p><strong>العنوان:</strong> {{ $order->customer_address }}</p>
                                <p><strong>السعر الإجمالي:</strong> {{ $order->total_price }} $</p>
                                <p><strong>تاريخ الطلب:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>

                                <h5 class="mt-4">المنتجات المطلوبة</h5>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>الصورة</th>
                                            <th>المنتج</th>
                                            <th>الكمية</th>
                                            <th>السعر</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->items as $item)
                                            <tr>
                                                <td><img src="{{ asset('uploads/' . $item->product->image) }}" width="50"></td>
                                                <td>{{ $item->product->title }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ $item->price }} $</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">رجوع</a>
                    </div>
                @endsection
