@extends('layouts.master')
@section('title', 'طلبات الباقات')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('طلبات الباقات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                     
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table" id="storestable">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('اسم المستخدم') }}</th>
                                        <th>{{ __('رقم الهاتف') }}</th>
                                        <th>{{ __('رقم الهوية') }}</th>
                                        <th>{{ __('العنوان') }}</th>
                                        <th>{{ __('الباقة') }}</th>
                                        <th>{{ __('سعر الباقة') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{$order->full_name}}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td>{{ $order->id_number }}</td>
                                            <td>{{ $order->address }}</td>
                                            <td>{{ @$order->package->name ?? 'تم حذف الباقة' }}</td>
                                            <td>{{ @$order->package->price ?? 'تم حذف الباقة' }}</td>

                                            
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


