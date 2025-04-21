@extends('layouts.master')
@section('title', 'طلبات التواصل')
@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('طلبات التواصل') }}</h3>
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
                                        <th>{{ __('حالة الطلب') }}</th>
                                        <th>{{ __('الاجراءات') }}</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contacts as $key => $order)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $order->name }}</td>
                                            <td>{{ $order->phone }}</td>
                                            <td><span
                                                    class="btn btn-{{ $order->show == '1' ? 'success' : 'danger' }}">{{ $order->show == '1' ? 'تمت المشاهدة' : 'غير مشاهد' }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ route('contact_order_edit', $order->id) }}"
                                                    class="btn btn-info">{{ __('مشاهدة') }}</a>
                                                    @if(isAdmin())   

                                                <form action="{{ route('contact_order_delete', $order->id) }}" method="POST"
                                                    style="display: inline-block;">
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
