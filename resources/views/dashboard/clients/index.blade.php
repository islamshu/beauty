@extends('layouts.master')
@section('title','العملاء')

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
                        <a href="{{ route('clients.create') }}" class="btn btn-primary">{{ __('إضافة عميل جديد') }}</a>
                    </div>
                    <div class="card-body">
                        @include('dashboard.inc.alerts')
                        <table class="table" id="clientsTable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('رمز QR') }}</th>

                                    <th>{{ __('الاسم') }}</th>
                                    <th>{{ __('رقم العميل') }}</th>
                                    <th>{{ __('رقم الهاتف') }}</th>
                                    <th>{{ __('الإجراءات') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clients as $key => $client)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td><img src="{{asset($client->qr_code)}}" width="80" height="80" alt=""></td>

                                        <td>{{ $client->name }}</td>
                                        <td>{{ $client->id_number }}</td>
                                        <td>{{ $client->phone }}</td>
                                        <td>
                                            <a href="{{ route('clients.edit', $client->id) }}" class="btn btn-warning">{{ __('تعديل') }}</a>
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST" style="display:inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('هل أنت متأكد؟') }}')">{{ __('حذف') }}</button>
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