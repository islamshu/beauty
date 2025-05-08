@extends('layouts.master')
@section('title','الرئيسية')
@section('content')
@can('الاحصائيات')
    <div class="row">

        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="info">{{ App\Models\User::count() }}</h3>
                                <h6>عدد الموظفين</h6>
                            </div>
                            <div>
                                <i class="la la-users info font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="success">{{ App\Models\Package::where('status', 1)->count() }}</h3>
                                <h6>عدد الباقات المتاحة</h6>
                            </div>
                            <div>
                                <i class="la la-server success font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="danger">{{ App\Models\Service::where('status', 1)->count() }}</h3>
                                <h6>عدد الخدمات المتاحة</h6>
                            </div>
                            <div>
                                <i class="la la-server danger font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="warning">{{ App\Models\Course::where('status', 1)->count() }}</h3>
                                <h6>عدد الدورات الفعالة</h6>
                            </div>
                            <div>
                                <i class="la la-server warning font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-warning" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="info">{{  App\Models\Client::count() }}</h3>
                                <h6>عدد العملاء </h6>
                            </div>
                            <div>
                                <i class="la la-users info font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-info" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                @php
                                      $activeClients = App\Models\Client::has('activeSubscription')->count();

                                        $inactiveClients = App\Models\Client::whereDoesntHave('activeSubscription')->count();
                                @endphp
                                <h3 class="success">{{$activeClients }}</h3>
                                <h6>عدد العملاء الفعالين </h6>
                            </div>
                            <div>
                                <i class="la la-server success font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-success" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="media-body text-left">
                                <h3 class="danger">{{ $inactiveClients }}</h3>
                                <h6>عدد العملاء الغير فعالين</h6>
                            </div>
                            <div>
                                <i class="la la-server danger font-large-2 float-right"></i>
                            </div>
                        </div>
                        <div class="progress progress-sm mt-1 mb-0 box-shadow-2">
                            <div class="progress-bar bg-gradient-x-danger" role="progressbar" style="width: 80%"
                                aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-2 col-xl-3 col-lg-6 col-12">
            <div class="card pull-up">
                <div class="card-content">
                    <div class="card-body">
                       
                        <!-- Stats Row -->
                        <div class="row text-center pt-2">
                            <!-- المستحق للدفع -->
                            <div class="col-4 border-right">
                                <h3 class="danger mb-0">{{ get_sum_main_paid() }}</h3>
                                <small class="text-muted">المستحق للدفع</small>
                            </div>
                            
                            <!-- المدفوعات -->
                            <div class="col-4 border-right">
                                <h3 class="danger mb-0">{{ get_sum_total_paid() }}</h3>
                                <small class="text-muted">المدفوعات</small>
                            </div>
                            
                            <!-- المتبقي -->
                            <div class="col-4">
                                <h3 class="danger mb-0">{{ get_sum_total_remaning() }}</h3>
                                <small class="text-muted">المتبقي (الدين)</small>
                            </div>
                        </div>
                        
                        <!-- Progress Bar -->
                     
                    </div>
                </div>
            </div>
        </div>
        

        
    </div>
@endcan
  
@endsection
