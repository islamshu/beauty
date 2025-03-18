@extends('layouts.master')
@section('title','طلبات المنتجات')
 
@section('content')
    <div class="app-content content">

        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('طلبات المنتجات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('طلبات المنتجات') }}</h4>
                        <button class="btn btn-primary" data-toggle="modal"
                            data-target="#addImageModal">{{ __('إضافة شريك جديد') }}</button>
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')

                        <table class="table ">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>اسم العميل</th>
                                    <th>رقم الهاتف</th>
                                    <th>العنوان</th>
                                    <th>السعر الإجمالي</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->customer_phone }}</td>
                                        <td>{{ $order->customer_address }}</td>
                                        <td>{{ $order->total_price }} $</td>
                                        <td>{{ $order->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}"
                                                class="btn btn-info btn-sm">عرض</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        {{ $orders->links() }} <!-- روابط التقسيم -->
                    </div>
                </div>
            </div>
        </div>
    @endsection
