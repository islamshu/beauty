@extends('layouts.master')
@section('title','تقارير المدفوعات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('المدفوعات') }}</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('المدفوعات') }}</h4>
                            <div class="filter-section mt-3">
                                <form method="GET" action="{{ route('reports.payments') }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>الباقة</label>
                                            <select name="package_id" class="form-control">
                                                <option value="">كل الباقات</option>
                                                @foreach($packages as $package)
                                                    <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                                        {{ $package->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>العميل</label>
                                            <select name="client_id" class="form-control">
                                                <option value="">كل العملاء</option>
                                                @foreach($clients as $client)
                                                    <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>من تاريخ</label>
                                            <input type="date" name="start_date" class="form-control" 
                                                   value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label>إلى تاريخ</label>
                                            <input type="date" name="end_date" class="form-control" 
                                                   value="{{ request('end_date') }}">
                                        </div>
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary mr-2">بحث</button>
                                            <a href="{{ route('reports.payments') }}" class="btn btn-secondary">إعادة تعيين</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @include('dashboard.inc.alerts')

                            <table class="table">
                                <thead>
                                    <tr>
                                        <td>#</td>
                                        <th>{{ __('اسم العميل') }}</th>
                                        <th>{{ __('الباقة') }}</th>
                                        <th>{{ __('المبلغ') }}</th>
                                        <th>{{ __('تاريخ الدفع') }}</th>
                                        <th>{{ __('مشاهدة') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subs as $key => $sub)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td><a href="{{route('clients.show',$sub->subscription->client->id)}}">{{ $sub->subscription->client->name }}</a></td>
                                            <td>
                                                <button type="button" class="btn btn-link" data-toggle="modal" data-target="#packageModal{{ $sub->subscription->package->id }}">
                                                    {{ $sub->subscription->package->name }}
                                                </button>
                                            </td>
                                            <td>{{$sub->amount}} شيكل</td>
                                            <td>{{ $sub->created_at->format('Y-m-d H:i') }}</td>
                                            <td>
                                               <a class="btn btn-info btn-sm" href="{{route('subscription.show',$sub->subscription)}}">    <i class="la la-eye"></i> </a>
                                            </td>
                                        </tr>

                                        <!-- Modal for Package Details -->
                                        <div class="modal fade" id="packageModal{{ $sub->subscription->package->id }}" tabindex="-1" role="dialog" aria-labelledby="packageModalLabel{{ $sub->subscription->package->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="packageModalLabel{{ $sub->subscription->package->id }}">تفاصيل الباقة: {{ $sub->subscription->package->name }}</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <p><strong>الاسم:</strong> {{ $sub->subscription->package->name }}</p>
                                                                <p><strong>السعر:</strong> {{ $sub->subscription->package->price }}</p>
                                                                <p><strong>المدة:</strong> {{ format_package_duration($sub->subscription->package->id)  }} </p>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <p><strong>الخدمات:</strong></p>
                                                                <p>@foreach ($sub->subscription->package->services as $item)
                                                                    {{$item->title}}
                                                                    @if(!$loop->last),@endif
                                                                @endforeach</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    @endpush
@endsection