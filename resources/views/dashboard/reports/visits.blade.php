@extends('layouts.master')
@section('title', 'إدارة الزيارات')

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">إدارة الزيارات</h3>
                </div>
            </div>
            <div class="content-body">
                <section>
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">{{ __('الزيارات') }}</h4>
                            <div class="filter-section mt-3">
                                <form method="GET" action="{{ route('reports.visits') }}">
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
                                            <label>العملاء</label>
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
                                            <label>المشرف</label>
                                            <select name="supervisor" class="form-control select2" id="supervisorSelect">
                                                <option value="">كل المشرفين</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}"
                                                        {{ request('supervisor') == $user->id ? 'selected' : '' }}>
                                                        {{ $user->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label>من تاريخ</label>
                                            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                                        </div>
                                        <div class="col-md-2">
                                            <label>إلى تاريخ</label>
                                            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                                        </div>

                                        <div class="col-md-2 d-flex align-items-end">
                                            <button type="submit" class="btn btn-primary mr-2">بحث</button>
                                            <a href="{{ route('reports.visits') }}" class="btn btn-secondary">إعادة
                                                تعيين</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card-body">
                            @if (isset($supervisorName) && isset($supervisorVisitCount))
                                <div class="alert alert-info">
                                    <strong>المشرف:</strong> {{ $supervisorName }}<br>
                                    <strong>عدد الزيارات:</strong> {{ $supervisorVisitCount }}
                                </div>
                            @endif
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>العميل</th>
                                            <th>الباقة</th>
                                            <th>المشرف</th>
                                            <th>تاريخ الزيارة</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($vistis as $visit)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $visit->client->name . ' - ' . $visit->client->id_number }}
                                                </td>
                                                <td>{{ $visit->package->name }}</td>

                                                <td>{{ $visit->supervisor->name }}</td>
                                                </td>
                                               
                                                <td>{{ $visit->visit_date }}</td>
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
            $('#supervisorSelect').select2({
                language: "ar",
                placeholder: "اختر مشرف",
                allowClear: true,
                width: '100%'
            });

            // إذا كنت تريد البحث حسب الاسم أو رقم العضوية
            $('#supervisorSelect').select2({
                language: "ar",
                placeholder: "ابحث باسم المشرف ",
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
