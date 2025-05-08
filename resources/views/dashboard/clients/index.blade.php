@extends('layouts.master')
@section('title', 'العملاء')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('العملاء') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('قائمة العملاء') }}</h4>
                            <a href="{{ route('clients.create') }}"
                                class="btn btn-sm btn-primary">{{ __('إضافة عميل جديد') }}</a>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')
                            <table class="table" id="clientsTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('رمز QR') }}</th>

                                        <th>{{ __('الاسم') }}</th>
                                        <th>{{ __('رقم العضوية') }}</th>
                                        <th>{{ __('رقم الهاتف') }}</th>
                                        <th>الحالة</th>
                                        <th>{{ __('الإجراءات') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($clients as $key => $client)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><img src="{{ asset($client->qr_code) }}" width="80" height="80"
                                                    alt=""></td>

                                            <td>{{ $client->name }}</td>
                                            <td>{{ $client->id_number }}</td>
                                            <td style="direction: ltr">{{ $client->phone }}</td>
                                            <td>
                                                @if ($client->activeSubscription)
                                                    <div class="shadow-sm border rounded px-2 py-2 text-center"
                                                        style="background: #f8f9fa;">
                                                        <div class="text-muted small mb-1">
                                                            حالة الاشتراك:
                                                            <span
                                                                class="font-weight-bold 
                                                            {{ $client->activeSubscription->status === 'active'
                                                                ? 'text-success'
                                                                : ($client->activeSubscription->status === 'suspended'
                                                                    ? 'text-warning'
                                                                    : 'text-danger') }}">
                                                                {{ __("subscription.status.{$client->activeSubscription->status}") }}
                                                            </span>
                                                        </div>

                                                        <div class="btn-group btn-group-sm" role="group"
                                                            aria-label="Subscription Controls">
                                                            @if ($client->activeSubscription->status !== 'active')
                                                                <form
                                                                    action="{{ route('subscriptions.activate', $client->activeSubscription) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-outline-success"
                                                                        title="تفعيل">
                                                                        <i class="ft-check"></i>
                                                                    </button>
                                                                </form>
                                                            @endif


                                                            @if (isAdmin())
                                                                @if ($client->activeSubscription->status !== 'canceled')
                                                                    <form
                                                                        action="{{ route('subscriptions.cancel', $client->activeSubscription) }}"
                                                                        method="POST"
                                                                        onsubmit="return confirm('هل أنت متأكد من إلغاء الاشتراك؟')">
                                                                        @csrf
                                                                        <button type="submit"
                                                                            class="btn btn-sm btn-outline-danger"
                                                                            title="إلغاء">
                                                                            إلغاء الاشتراك
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="text-center">
                                                        <span class="badge badge-warning mb-2 d-block">لا يوجد اشتراك</span>
                                                        <button type="button" class="btn btn-sm btn-sm btn-primary"
                                                            data-toggle="modal" data-target="#addClientModal"
                                                            data-client-id="{{ $client->id }}">
                                                            <i class="ft-plus"></i> إضافة باقة
                                                        </button>
                                                    </div>
                                                @endif
                                            </td>


                                            <td>
                                                <a href="{{ route('clients.show', $client->id) }}"
                                                    class="btn btn-sm btn-info">{{ __('عرض') }}</a>

                                                <a href="{{ route('clients.edit', $client->id) }}"
                                                    class="btn btn-sm btn-warning">{{ __('تعديل') }}</a>
                                                @if(isAdmin())   
                                                <form action="{{ route('clients.destroy', $client->id) }}" method="POST"
                                                    style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"
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
    <!-- Modal -->
@include('dashboard.clients._addpackge')
    <!-- Modal -->
@endsection
@section('script')
@include('dashboard.clients._scirpt')

@endsection
