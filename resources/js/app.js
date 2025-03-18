import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction'; // إذا كنت بحاجة للسحب والإفلات

document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
        plugins: [dayGridPlugin, interactionPlugin], // أضف الإضافات التي تحتاجها
        locale: 'ar',
        initialView: 'dayGridMonth',
        selectable: true,
        events: '/api/reservations', // جلب الأحداث من API
        select: function(info) {
            let title = prompt("أدخل عنوان الحجز:");
            if (title) {
                fetch('/api/reservations', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: title,
                            start: info.startStr,
                            end: info.endStr
                        })
                    }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            calendar.refetchEvents(); // تحديث التقويم
                            alert("تمت إضافة الحجز!");
                        }
                    });
            }
        }
    });

    calendar.render();
});