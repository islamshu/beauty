@extends('layouts.master')
@section('title', 'الحجوزات')

@section('style')
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <!-- تضمين مكتبة FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@6.1.9/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/timegrid@6.1.9/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@6.1.9/index.global.min.js"></script>
    <!-- تضمين ملف اللغة العربية -->
    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.9/locales/ar.global.min.js"></script>
    <!-- تضمين مكتبة axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <!-- تضمين Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- تضمين Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">
    <style>
        input[type="date"],
        input[type="time"] {
            max-width: 150px;
            text-align: center;
            font-size: 14px;
        }

        .fc-daygrid-day.highlighted-day {
            background-color: #ffe082 !important;
            border: 2px solid #ff9800;
            box-shadow: 0 0 8px #ffa000;
            border-radius: 6px;
        }

        .modal-dialog {
            max-width: 90%;
        }

        .select2-container {
            z-index: 1055;
        }

        /* تنسيقات البحث */
        .search-box {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .search-box .input-group {
            max-width: 500px;
            margin: 0 auto;
        }

        .search-box .form-control {
            border-radius: 20px 0 0 20px;
        }

        .search-box .btn {
            border-radius: 0 20px 20px 0;
        }

        .fc-toolbar-title {
            font-size: 1.5em;
            font-weight: bold;
        }

        .fc-button {
            padding: 0.4em 0.8em;
        }

        .search-results {
            max-height: 300px;
            overflow-y: auto;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px;
            background-color: #f9f9f9;
        }

        .search-results .list-group-item {
            background-color: #ffffff;
            border-radius: 6px;
            margin-bottom: 8px;
            border: 1px solid #e3e3e3;
            transition: all 0.2s ease-in-out;
        }

        .search-results .list-group-item:hover {
            background-color: #f1f1f1;
        }

        .search-results .go-to-event {
            min-width: 80px;
        }

        .search-box .input-group input {
            border-radius: 0.375rem 0 0 0.375rem;
        }

        .search-box .input-group button {
            border-radius: 0;
        }

        .search-box .input-group .btn-outline-secondary {
            border-radius: 0 0.375rem 0.375rem 0;
        }

        #resetSearchBtn {
            margin-right: 2%;
            border-radius: 0
        }
    </style>
@endsection

@section('content')
    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-2">
                    <h3 class="content-header-title">{{ __('الحجوزات') }}</h3>
                </div>
            </div>

            <!-- زر إضافة حدث جديد -->
            <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#reservationModal">
                <i class="fas fa-plus"></i> إضافة حجز
            </button>

            <!-- حقل البحث البسيط -->

            <div class="search-box mb-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="input-group shadow-sm">
                            <input type="text" id="globalSearch" class="form-control"
                                placeholder="ابحث في الحجوزات (اسم العميل، الموظف، التاريخ، العنوان...)">
                            <button class="btn btn-primary" type="button" id="searchBtn">
                                <i class="fas fa-search"></i> بحث
                            </button>
                            <button class="btn btn-outline-secondary" type="button" id="resetSearchBtn">
                                <i class="fas fa-times"></i> إلغاء
                            </button>
                        </div>
                    </div>

                    <!-- ✅ مكان نتائج البحث -->
                    <div class="col-md-8 mx-auto">
                        <div id="searchResults" class="search-results mt-3"></div>
                    </div>
                </div>
            </div>


            <!-- التقويم -->
            <div id="calendarContainer">
                <div id="calendar" class="mt-4"></div>
            </div>

            <!-- Modal لعرض تفاصيل الحدث -->
            <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-labelledby="eventDetailsModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="eventDetailsModalLabel">تفاصيل الحجز</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>اسم الزبون:</strong> <span id="eventDetailsClient"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>اسم الموظف:</strong> <span id="eventDetailsUser"></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>عنوان الحجز:</strong> <span id="eventDetailsTitle"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>رقم الهاتف:</strong> <span id="eventDetailsPhone"></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>موعد الحجز:</strong> <span id="eventDetailsStart"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>عنوان العميل:</strong> <span id="eventDetailsaddress"></span>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>السبب:</strong> <span id="eventDetailsReason"></span>
                                </div>
                                <div class="col-md-6">
                                    <strong>الملاحظات:</strong> <span id="eventDetailsNots"></span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <strong>الخدمات:</strong>
                                <ul id="eventDetailsServices" class="list-group"></ul>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" onclick="editEvent()">تعديل الحجز</button>

                            <button type="button" class="btn btn-danger" onclick="deleteEvent()">حذف الحجز</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- مودال الحجز -->
            <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="reservationModalLabel">إضافة حجز</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>
                        <form action="{{ route('reservations.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <!-- اسم الزبون -->
                                    <div class="col-md-6 mb-3">
                                        <label for="client_id" class="form-label">اسم الزبون <span
                                                class="text-danger">*</span></label>
                                        <select name="client_id" id="client_id" class="form-control" required>
                                            <option value="" disabled selected>اختر العميل</option>
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- عنوان الحجز -->
                                    <div class="col-md-6 mb-3">
                                        <label for="title" class="form-label">عنوان الحجز <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="title" id="title" class="form-control"
                                            value="{{ old('title') }}" required>
                                    </div>

                                    <!-- التاريخ -->
                                    <div class="form-group border rounded p-3 bg-white shadow-sm">
                                        <label class="font-weight-bold mb-2">🗓️ تاريخ الحجز</label>

                                        <div class="d-flex align-items-center flex-wrap">
                                            <div class="d-flex align-items-center mr-3 mb-2">
                                                <i class="far fa-clock mr-2 text-muted"></i>
                                                <input type="date"
                                                    class="form-control rounded-pill bg-light border-0 px-3 py-2"
                                                    name="date" required>
                                            </div>

                                            <div class="d-flex align-items-center mb-2">
                                                <input type="time"
                                                    class="form-control rounded-pill bg-light border-0 px-3 py-2 mr-2"
                                                    name="start_time" required>
                                                <span class="mx-1">–</span>
                                                <input type="time"
                                                    class="form-control rounded-pill bg-light border-0 px-3 py-2"
                                                    name="end_time" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- اسم الموظف -->
                                    <div class="col-md-6 mb-3">
                                        <label for="user_id" class="form-label">اسم الموظف <span
                                                class="text-danger">*</span></label>
                                        <select name="user_id" id="user_id" class="form-control" required>
                                            <option value="" disabled selected>اختر المستخدم</option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- الخدمات -->
                                    <div class="col-md-6 mb-3">
                                        <label for="services" class="form-label">الخدمات <span
                                                class="text-danger">*</span></label>
                                        <select name="services[]" id="services" class="form-control select2" multiple>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->title }} -
                                                    {{ $service->price }} شيكل</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- الملاحظات -->
                                    <div class="col-md-6 mb-3">
                                        <label for="nots" class="form-label">الملاحظات</label>
                                        <textarea name="nots" id="nots" class="form-control">{{ old('nots') }}</textarea>
                                    </div>

                                    <!-- السبب -->
                                    <div class="col-md-6 mb-3">
                                        <label for="reason" class="form-label">السبب</label>
                                        <textarea name="reason" id="reason" class="form-control">{{ old('reason') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">حفظ الحجز</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <!-- تضمين Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- تضمين Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();

                let form = this;
                let data = {
                    date: $('input[name="date"]').val(),
                    start_time: $('input[name="start_time"]').val(),
                    end_time: $('input[name="end_time"]').val(),
                    user_id: $('#user_id').val(),
                    _token: '{{ csrf_token() }}'
                };

                $.post('{{ route('reservations.checkConflict') }}', data, function(response) {
                    if (response.status === 'conflict') {
                        const formattedStart = formatDateTime(response.start);
                        const formattedEnd = formatDateTime(response.end);

                        alert(
                            `⚠️ يوجد تعارض مع الحجز: "${response.title}" من ${formattedStart} إلى ${formattedEnd}`
                        );
                    } else {
                        form.submit(); // لا يوجد تعارض → أرسل النموذج
                    }
                }).fail(function() {
                    alert('حدث خطأ أثناء التحقق من التعارض');
                });
            });

            function formatDateTime(datetimeStr) {
                const date = new Date(datetimeStr);
                const options = {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                };
                return date.toLocaleString('ar-EG', options).replace(',', '');
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // التحقق عند تغيير حقل وقت النهاية
            const endTimeInput = document.querySelector('[name="end_time"]');
            endTimeInput.addEventListener('change', function() {
                const startDate = document.querySelector('[name="date"]').value;
                const startTime = document.querySelector('[name="start_time"]').value;
                const endTime = endTimeInput.value;

                const startDateTime = new Date(startDate + 'T' + startTime);
                const endDateTime = new Date(startDate + 'T' + endTime);

                if (endDateTime <= startDateTime) {
                    alert('تاريخ ووقت النهاية يجب أن يكون بعد تاريخ ووقت البداية');
                    endTimeInput.value = '';
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#services').select2({
                dropdownParent: $('#reservationModal')
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar;

            // تهيئة التقويم
            function initializeCalendar(events = null) {
                calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,timeGridWeek,timeGridDay'
                    },
                    locale: 'ar',
                    direction: 'rtl',
                    events: events ? events : "{{ route('events.index') }}",
                    editable: true,
                    selectable: true,
                    slotMinTime: '08:00:00',

                    // شكل مخصص للحدث
                    eventContent: function(arg) {
                        let clientName = arg.event.extendedProps.client_name || '';
                        let title = arg.event.title || '';
                        let startTime = arg.event.start ? new Date(arg.event.start).toLocaleTimeString(
                            'ar-EG', {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '';
                        let endTime = arg.event.end ? new Date(arg.event.end).toLocaleTimeString(
                            'ar-EG', {
                                hour: '2-digit',
                                minute: '2-digit'
                            }) : '';

                        return {
                            html: `
            <div class="fc-event-main-custom" style="text-align: right;">
                <div style="font-weight: bold;">${clientName}</div>
                <div style="font-size: 12px; color: #666;">
                    ${title} - ${startTime} إلى ${endTime}
                </div>
            </div>
        `
                        };
                    },

                    eventClick: function(info) {
                        showEventDetails(info);
                    }
                });

                calendar.render();
            }

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('go-to-event')) {
                    let dateTime = e.target.getAttribute('data-date');

                    // تحويل التاريخ إلى فقط تاريخ بدون وقت
                    const dateOnly = new Date(dateTime).toISOString().slice(0, 10); // النتيجة: 2025-06-18

                    // الانتقال للتاريخ في الكالندر
                    calendar.gotoDate(dateOnly);

                    // التمرير إلى التقويم
                    document.getElementById('calendarContainer')?.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });

                    // تأخير بسيط حتى يتم إعادة عرض التقويم
                    setTimeout(() => {
                        // إزالة تمييز سابق
                        document.querySelectorAll('.fc-daygrid-day.highlighted-day')
                            .forEach(el => el.classList.remove('highlighted-day'));

                        // العثور على اليوم وتلوينه
                        const cell = document.querySelector(
                            `.fc-daygrid-day[data-date="${dateOnly}"]`);
                        if (cell) {
                            cell.classList.add('highlighted-day');
                        } else {
                            console.warn('لم يتم العثور على خلية اليوم:', dateOnly);
                        }
                    }, 300);

                    toastr.info('تم الانتقال إلى الحدث في التقويم', 'تنقل');
                }
            });



            // عرض تفاصيل الحدث
            function showEventDetails(info) {
                const startDate = info.event.start;
                const endDate = info.event.end;

                const formattedStartDate = startDate.toLocaleDateString('ar-PS', {
                    weekday: 'long',
                    day: 'numeric',
                    month: 'numeric',
                    year: 'numeric',
                });

                const formattedStartTime = startDate.toLocaleTimeString('ar-PS', {
                    hour: '2-digit',
                    minute: '2-digit',
                });

                const formattedEndTime = endDate.toLocaleTimeString('ar-PS', {
                    hour: '2-digit',
                    minute: '2-digit',
                });

                document.getElementById('eventDetailsStart').innerHTML =
                    `${formattedStartDate} من <span style="font-weight: bold; color: red;">${formattedStartTime}</span> الى <span style="font-weight: bold; color: red;">${formattedEndTime}</span>`;

                document.getElementById('eventDetailsNots').textContent = info.event.extendedProps
                    .nots || 'لا يوجد ملاحظات';
                document.getElementById('eventDetailsClient').textContent = info.event.extendedProps
                    .client || 'غير محدد';
                document.getElementById('eventDetailsUser').textContent = info.event.extendedProps
                    .user || 'غير محدد';
                document.getElementById('eventDetailsPhone').textContent = info.event.extendedProps
                    .phone_number || 'غير محدد';

                document.getElementById('eventDetailsTitle').textContent = info.event.title

                document.getElementById('eventDetailsReason').textContent = info.event.extendedProps
                    .reason || 'غير محدد';
                document.getElementById('eventDetailsaddress').textContent = info.event
                    .extendedProps.address || 'غير محدد';

                const servicesList = document.getElementById('eventDetailsServices');
                servicesList.innerHTML = '';
                if (info.event.extendedProps.services && info.event.extendedProps.services.length > 0) {
                    info.event.extendedProps.services.forEach(service => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item';
                        li.textContent = `${service.title} - ${service.price} شيكل`;
                        servicesList.appendChild(li);
                    });
                } else {
                    servicesList.innerHTML = '<li class="list-group-item">لا توجد خدمات مرتبطة</li>';
                }

                document.querySelector('#eventDetailsModal .btn-danger').setAttribute(
                    'data-event-id', info.event.id);

                const eventDetailsModal = new bootstrap.Modal(document.getElementById(
                    'eventDetailsModal'));
                eventDetailsModal.show();
            }

            // البحث في التقويم
            document.getElementById('searchBtn').addEventListener('click', function() {
                const searchTerm = document.getElementById('globalSearch').value.trim();

                if (searchTerm.length === 0) {
                    toastr.warning('الرجاء إدخال كلمة للبحث', 'تحذير');
                    return;
                }

                axios.get("{{ route('events.search') }}", {
                        params: {
                            term: searchTerm
                        }
                    })
                    .then(response => {
                        const events = response.data;

                        // إعادة تحميل الأحداث في التقويم
                        calendar.removeAllEvents();
                        calendar.addEventSource(events);

                        const resultsContainer = document.getElementById('searchResults');
                        resultsContainer.innerHTML = ''; // تفريغ النتائج السابقة

                        if (events.length > 0) {
                            toastr.success('تم العثور على ' + events.length + ' نتيجة', 'نجاح');

                            // بناء القائمة
                            let list = '<div class="card"><div class="card-body">';
                            list +=
                                '<h5 class="card-title mb-3">نتائج البحث:</h5><ul class="list-group">';

                            events.forEach((event, index) => {
                                list += `
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                   
                         <div>
                            <strong>اسم الحجز : ${event.title}</strong><br>
                            <strong>التاريخ: ${new Date(event.start).toLocaleString('en')}</strong>
                        </div>
                        <div>
                            <strong>اسم العميل : ${event.extendedProps.client}</strong><br>
                            <strong>اسم الموظف : ${event.extendedProps.user}</strong><br>
                        </div>
                        <button class="btn btn-sm btn-primary go-to-event" data-date="${event.start}">
                            اذهب
                        </button>
                    </li>
                `;
                            });

                            list += '</ul></div></div>';
                            resultsContainer.innerHTML = list;
                        } else {
                            toastr.info('لا توجد نتائج مطابقة', 'معلومة');
                        }
                    })
                    .catch(error => {
                        toastr.error('حدث خطأ أثناء البحث', 'خطأ');
                    });
            });

            // زر إعادة تعيين البحث
            document.getElementById('resetSearchBtn').addEventListener('click', function() {
                document.getElementById('globalSearch').value = '';
                calendar.removeAllEvents();
                initializeCalendar();
                document.getElementById('searchResults').innerHTML = ''; // تفريغ النتائج
                setTimeout(() => {
                    // إزالة تمييز سابق
                    document.querySelectorAll('.fc-daygrid-day.highlighted-day')
                        .forEach(el => el.classList.remove('highlighted-day'));

                    // العثور على اليوم وتلوينه
                    const cell = document.querySelector(`.fc-daygrid-day[data-date="${dateOnly}"]`);
                    if (cell) {
                        cell.classList.add('highlighted-day');
                    } else {
                        console.warn('لم يتم العثور على خلية اليوم:', dateOnly);
                    }
                }, 300);
                toastr.info('تم إعادة تعيين البحث', 'إعلام');
            });

            // Enter لتنفيذ البحث
            document.getElementById('globalSearch').addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    document.getElementById('searchBtn').click();
                }
            });

            // زر "اذهب" للتنقل إلى الحدث


            // زر إعادة تعيين البحث

            // تهيئة التقويم عند تحميل الصفحة
            initializeCalendar();

            // دالة لحذف الحدث
            window.deleteEvent = function() {
                const eventId = document.querySelector('#eventDetailsModal .btn-danger').getAttribute(
                    'data-event-id');
                const userConfirmed = confirm('هل أنت متأكد أنك تريد حذف هذا الحجز؟');

                if (userConfirmed && eventId) {
                    axios.get("{{ route('events.destroy', ['id' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER',
                            eventId))
                        .then(response => {
                            bootstrap.Modal.getInstance(document.getElementById('eventDetailsModal'))
                                .hide();
                            toastr.success('تم حذف الحدث بنجاح!', 'نجاح');
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        }).catch(error => {
                            toastr.error('حدث خطأ أثناء حذف الحدث!', 'خطأ');
                        });
                } else {
                    toastr.info('تم إلغاء عملية الحذف', 'إلغاء');
                }
            }
            window.editEvent = function() {
                const eventId = document.querySelector('#eventDetailsModal .btn-danger').getAttribute(
                    'data-event-id');
                // alert(eventId);
                window.open("{{ route('reservations.edit', ':id') }}".replace(':id', eventId), '_blank');
                // window.location.href = "{{ url('dashboard/reservations/edit') }}/" + eventId;
            }
        });
    </script>
@endsection
