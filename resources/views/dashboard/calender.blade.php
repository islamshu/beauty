@extends('layouts.master')
@section('title','الحجوزات')

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
                            <p><strong>اسم الزبون:</strong> <span id="eventDetailsClient"></span></p>
                            <p><strong>اسم الموظف:</strong> <span id="eventDetailsUser"></span></p>
                            <p><strong>عنوان الحجز:</strong> <span id="eventDetailsTitle"></span></p>
                            <p><strong>رقم الهاتف:</strong> <span id="eventDetailsPhone"></span></p>
                            <p><strong>وقت البدء:</strong> <span id="eventDetailsStart"></span></p>
                            <p><strong>وقت الانتهاء:</strong> <span id="eventDetailsEnd"></span></p>
                            <p><strong>عنوان العميل:</strong> <span id="eventDetailsaddress"></span></p>
                            <p><strong>السبب:</strong> <span id="eventDetailsReason"></span></p>
                            <p><strong>الملاحظات:</strong> <span id="eventDetailsNots"></span></p>
                            <p><strong>الخدمات:</strong></p>
                            <ul id="eventDetailsServices"></ul> <!-- قائمة الخدمات -->
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" onclick="deleteEvent()">حذف الحجز</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
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
        document.getElementById('eventDetailsTitle').textContent = info.event.title;
        document.getElementById('eventDetailsStart').textContent = info.event.start.toLocaleString();
        document.getElementById('eventDetailsEnd').textContent = info.event.end ? info.event.end.toLocaleString() : 'غير محدد';
        document.getElementById('eventDetailsNots').textContent = info.event.extendedProps.nots || 'لا يوجد ملاحظات';
        document.getElementById('eventDetailsClient').textContent = info.event.extendedProps.client || 'غير محدد';
        document.getElementById('eventDetailsUser').textContent = info.event.extendedProps.user || 'غير محدد';
        document.getElementById('eventDetailsPhone').textContent = info.event.extendedProps.phone_number || 'غير محدد';
        document.getElementById('eventDetailsReason').textContent = info.event.extendedProps.reason || 'غير محدد';
        document.getElementById('eventDetailsaddress').textContent = info.event.extendedProps.address || 'غير محدد';

        const servicesList = document.getElementById('eventDetailsServices');
        servicesList.innerHTML = '';
        if (info.event.extendedProps.services && info.event.extendedProps.services.length > 0) {
            info.event.extendedProps.services.forEach(service => {
                const li = document.createElement('li');
                li.textContent = `${service.title} - ${service.price} ريال`;
                servicesList.appendChild(li);
            });
        } else {
            servicesList.innerHTML = '<li>لا توجد خدمات مرتبطة</li>';
        }

        document.querySelector('#eventDetailsModal .btn-danger').setAttribute('data-event-id', info.event.id);

        const eventDetailsModal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
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

            if (eventId) {
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
            }
        }
    </script>
@endsection
