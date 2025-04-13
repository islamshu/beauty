@extends('layouts.master')
@section('title', 'إدارة الاشتراكات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">تقارير الاشتراكات</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('الاشتراكات') }}</h4>
                            <div class="filter-section mt-3">
                                <form method="GET" action="{{ route('reports.subsciption') }}">
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label>الباقة</label>
                                            <select name="package_id" class="form-control">
                                                <option value="">كل الباقات</option>
                                                @foreach ($packages as $package)
                                                    <option value="{{ $package->id }}"
                                                        {{ request('package_id') == $package->id ? 'selected' : '' }}>
                                                        {{ $package->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>العميل</label>
                                            <select name="client_id" class="form-control select2" id="clientSelect">
                                                <option value="">كل العملاء</option>
                                                @foreach ($clients as $client)
                                                    <option value="{{ $client->id }}"
                                                        {{ request('client_id') == $client->id ? 'selected' : '' }}>
                                                        {{ $client->name . ' - ' . $client->id_number }}
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
                                            <a href="{{ route('reports.subsciption') }}" class="btn btn-secondary">إعادة
                                                تعيين</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>العميل</th>
                                            <th>الباقة</th>
                                            <th>الحالة</th>
                                            <th>تاريخ البدء</th>
                                            <th>تاريخ الانتهاء</th>
                                            <th>الزيارات</th>
                                            <th>الإجراءات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($subscriptions as $subscription)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $subscription->client->name . ' - ' . $subscription->client->id_number }}
                                                </td>
                                                <td>{{ $subscription->package->name }}</td>
                                                <td>
                                                    <span
                                                        class="font-weight-bold 
                                {{ $subscription->status === 'active'
                                    ? 'text-success'
                                    : ($subscription->status === 'suspended'
                                        ? 'text-warning'
                                        : 'text-danger') }}">
                                                        {{ __("subscription.status.{$subscription->status}") }}
                                                    </span>
                                                </td>
                                                <td>{{ $subscription->start_at }}</td>
                                                <td>{{ $subscription->end_at }}</td>
                                                <td>{{ $subscription->total_visit }} / {{ $subscription->package_visit }}
                                                </td>
                                                <td>
                                                    <a href="{{ route('subscription.show', $subscription->id) }}"
                                                        class="btn btn-info btn-sm">
                                                        <i class="la la-eye"></i>
                                                    </a>

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
<script>
    $(document).ready(function() {
        // تهيئة Select2 مع دعم اللغة العربية
        $('#clientSelect').select2({
            language: "ar",
            placeholder: "اختر عميلاً",
            allowClear: true,
            width: '100%'
        });
        
        // إذا كنت تريد البحث حسب الاسم أو رقم العضوية
        $('#clientSelect').select2({
            language: "ar",
            placeholder: "ابحث باسم العميل أو رقم العضوية",
            allowClear: true,
            width: '100%',
            matcher: function(params, data) {
                // إذا كان هناك بحث
                if ($.trim(params.term) === '') {
                    return data;
                }
                
                // البحث في النص المعروض (الاسم + رقم العضوية)
                if (data.text.toLowerCase().indexOf(params.term.toLowerCase()) > -1) {
                    return data;
                }
                
                // إذا لم يتم العثور على تطابق
                return null;
            }
        });
    });
    </script>
@endsection
