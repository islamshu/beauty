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


        .modal-dialog {
            max-width: 90%;
            /* زيادة عرض المودال */
        }

        .select2-container {
            z-index: 1055;
            /* تأكد من أن select2 يظهر فوق محتويات المودال */
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
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reservationModal">
                إضافة حجز
            </button>
            <!-- التقويم -->
            <div id="calendar" class="mt-4"></div>

            <!-- Modal لإضافة حدث جديد -->


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
                       <!-- استخدام صفوف وأعمدة لتنسيق الحقول -->
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
                               <strong>موعد الحجز :</strong> <span id="eventDetailsStart"></span>
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
                           <ul id="eventDetailsServices" class="list-group"></ul> <!-- قائمة الخدمات -->
                       </div>
                   </div>
                   <div class="modal-footer">
                       <button type="button" class="btn btn-danger" onclick="deleteEvent()">حذف الحجز</button>
                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                   </div>
               </div>
           </div>
       </div>
       
            <!-- مودال الحجز -->
            <div class="modal fade" id="reservationModal" tabindex="-1" aria-labelledby="reservationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg"> <!-- modal-lg لتوسيع المودال -->
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
        document.addEventListener('DOMContentLoaded', function() {
            // التحقق عند تغيير حقل وقت النهاية
            const endTimeInput = document.querySelector('[name="end_time"]');
            endTimeInput.addEventListener('change', function() {
                const startDate = document.querySelector('[name="date"]').value;
                const startTime = document.querySelector('[name="start_time"]').value;
                const endTime = endTimeInput.value;

                // تحويل التاريخ والوقت إلى طوابع زمنية
                const startDateTime = new Date(startDate + 'T' + startTime);
                const endDateTime = new Date(startDate + 'T' + endTime);

                if (endDateTime <= startDateTime) {
                    // إذا كان وقت النهاية أصغر أو يساوي وقت البداية
                    alert('تاريخ ووقت النهاية يجب أن يكون بعد تاريخ ووقت البداية');
                    endTimeInput.value = ''; // إفراغ حقل وقت النهاية
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            $('#services').select2({
                dropdownParent: $('#reservationModal') // تحديد المودال كأب للقائمة المنسدلة
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek', // العرض الافتراضي (أسبوعي)
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'ar', // تعيين اللغة العربية
                direction: 'rtl', // اتجاه النص من اليمين لليسار
                events: "{{ route('events.index') }}", // رابط لجلب الأحداث
                editable: true, // تفعيل تحرير الأحداث
                selectable: true, // تفعيل اختيار التواريخ
                slotMinTime: '08:00:00', // يبدأ التقويم من الساعة 8 صباحًا
                eventClick: function(info) {
                    const startDate = info.event.start;
                    const endDate = info.event.end;

                    // تنسيق التاريخ باستخدام toLocaleDateString و toLocaleTimeString
                    const formattedStartDate = startDate.toLocaleDateString('ar-EG', {
                        weekday: 'long', // اليوم بالأسم
                        day: 'numeric', // اليوم بالأرقام
                        month: 'long', // الشهر بالأسم
                        year: 'numeric', // السنة بالأرقام
                    });

                    const formattedStartTime = startDate.toLocaleTimeString('ar-EG', {
                        hour: '2-digit', // ساعة
                        minute: '2-digit', // دقيقة
                    });

                    const formattedEndTime = endDate.toLocaleTimeString('ar-EG', {
                        hour: '2-digit', // ساعة
                        minute: '2-digit', // دقيقة
                    });

                    // دمج النصوص معًا مع إضافة الفئات المناسبة للأوقات
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
                    document.getElementById('eventDetailsReason').textContent = info.event.extendedProps
                        .reason || 'غير محدد';
                    document.getElementById('eventDetailsaddress').textContent = info.event
                        .extendedProps.address || 'غير محدد';

                    const servicesList = document.getElementById('eventDetailsServices');
                    servicesList.innerHTML = '';
                    if (info.event.extendedProps.services && info.event.extendedProps.services.length >
                        0) {
                        info.event.extendedProps.services.forEach(service => {
                            const li = document.createElement('li');
                            li.textContent = `${service.title} - ${service.price} شيكل`;
                            servicesList.appendChild(li);
                        });
                    } else {
                        servicesList.innerHTML = '<li>لا توجد خدمات مرتبطة</li>';
                    }

                    document.querySelector('#eventDetailsModal .btn-danger').setAttribute(
                        'data-event-id', info.event.id);

                    const eventDetailsModal = new bootstrap.Modal(document.getElementById(
                        'eventDetailsModal'));
                    eventDetailsModal.show();
                }
            });


            calendar.render(); // عرض التقويم
        });

        // دالة لحفظ الحدث
        function saveEvent() {
            const title = document.getElementById('eventTitle').value;
            const start = document.getElementById('startTime').value;
            const end = document.getElementById('endTime').value;
            const nots = document.getElementById('nots').value;

            if (title && start && end) {
                axios.post("{{ route('events.store') }}", {
                    title: title,
                    start: start,
                    end: end,
                    nots: nots
                }).then(response => {
                    // إعادة تحميل الأحداث وإغلاق الـ Modal
                    document.getElementById('eventForm').reset();
                    bootstrap.Modal.getInstance(document.getElementById('eventModal')).hide();

                    // إظهار رسالة نجاح باستخدام Toastr
                    toastr.success('تم إضافة الحدث بنجاح!', 'نجاح');

                    setTimeout(function() {
                        window.location.reload();
                    }, 1000); // إعادة تحميل الصفحة لتحديث التقويم
                }).catch(error => {
                    // إظهار رسالة خطأ في حالة فشل العملية
                    toastr.error('حدث خطأ أثناء إضافة الحدث!', 'خطأ');
                });
            } else {
                alert('يرجى ملء جميع الحقول المطلوبة');
            }
        }

        // دالة لحذف الحدث
        function deleteEvent() {
    const eventId = document.querySelector('#eventDetailsModal .btn-danger').getAttribute('data-event-id');

    // عرض نافذة تأكيد للمستخدم قبل تنفيذ الحذف
    const userConfirmed = confirm('هل أنت متأكد أنك تريد حذف هذا الحجز؟');

    if (userConfirmed && eventId) {
        // إذا أكد المستخدم، قم بإرسال طلب الحذف
        axios.get("{{ route('events.destroy', ['id' => 'PLACEHOLDER']) }}".replace('PLACEHOLDER', eventId))
            .then(response => {
                // إغلاق الـ Modal وإعادة تحميل الصفحة
                bootstrap.Modal.getInstance(document.getElementById('eventDetailsModal')).hide();

                // إظهار رسالة نجاح باستخدام Toastr
                toastr.success('تم حذف الحدث بنجاح!', 'نجاح');

                setTimeout(function() {
                    window.location.reload();
                }, 1000);
            }).catch(error => {
                // إظهار رسالة خطأ في حالة فشل العملية
                toastr.error('حدث خطأ أثناء حذف الحدث!', 'خطأ');
            });
    } else {
        // في حال رفض المستخدم
        toastr.info('تم إلغاء عملية الحذف', 'إلغاء');
    }
}

    </script>
    <script>
        $(document).ready(function() {
            // تهيئة Select2
            $('.select2').select2({
                placeholder: "{{ __('اختر') }}",
                allowClear: true
            });

            // دالة التحقق من Select2
            function validateSelect2Field(selector) {
                let select2Element = $(selector);
                let parentDiv = select2Element.closest('.form-group'); // البحث عن أقرب div يحتوي على input
                let errorMessage = parentDiv.find('.select2-error-message');

                if (select2Element.val() === null || select2Element.val().length === 0) {
                    parentDiv.find('.select2-selection').css('border', '2px solid red'); // إضافة إطار أحمر
                    if (errorMessage.length === 0) {
                        parentDiv.append(
                            '<small class="text-danger select2-error-message">{{ __('هذا الحقل مطلوب') }}</small>'
                        );
                    }
                    return false;
                } else {
                    parentDiv.find('.select2-selection').css('border', ''); // إزالة الإطار الأحمر
                    errorMessage.remove(); // حذف رسالة الخطأ
                    return true;
                }
            }

            // تحديث التحقق عند تغيير القيم
            $('#client_id, #user_id, #services').on('change', function() {
                validateSelect2Field(this);
            });

            // التحقق عند إرسال النموذج
            $('#reservationForm').on('submit', function(e) {
                let isValid = true;

                if (!validateSelect2Field('#client_id')) isValid = false;
                if (!validateSelect2Field('#user_id')) isValid = false;
                if (!validateSelect2Field('#services')) isValid = false;

                // إلغاء الإرسال إذا كان هناك خطأ
                if (!isValid) {
                    e.preventDefault();
                    alert("{{ __('يرجى ملء جميع الحقول المطلوبة') }}");
                }
            });
        });
    </script>
@endsection
