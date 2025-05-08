<script src="{{ asset('backend/app-assets/vendors/js/vendors.min.js') }}" type="text/javascript"></script>
<!-- BEGIN VENDOR JS-->
<!-- BEGIN PAGE VENDOR JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/ui/jquery.sticky.js') }}"></script>
<script type="text/javascript" src="{{ asset('backend/app-assets/vendors/js/charts/jquery.sparkline.min.js') }}">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/chart.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/raphael-min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/morris.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-2.0.3.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/charts/jvector/jquery-jvectormap-world-mill.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/data/jvector/visitor-data.js') }}" type="text/javascript"></script>
<!-- END PAGE VENDOR JS-->
<!-- BEGIN MODERN JS-->
<script src="{{ asset('backend/app-assets/js/core/app-menu.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/core/app.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/customizer.js') }}" type="text/javascript"></script>
<!-- END MODERN JS-->
<!-- BEGIN PAGE LEVEL JS-->
<script type="text/javascript" src="{{ asset('backend/app-assets/js/scripts/ui/breadcrumbs-with-stats.js') }}">
</script>
<script src="{{ asset('backend/app-assets/js/scripts/pages/dashboard-sales.js') }}" type="text/javascript"></script>
{{-- <script src="{{ asset('backend/app-assets/vendors/js/forms/select/selectivity-full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/select/form-selectivity.js') }}" type="text/javascript"></script> --}}

<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>


<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/datatables.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/tables/datatable/dataTables.buttons.min.js') }}"
    type="text/javascript"></script>
@if (app()->getLocale() == 'en')
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advanced.js') }}"
        type="text/javascript"></script>
@else
    <script src="{{ asset('backend/app-assets/js/scripts/tables/datatables/datatable-advancedar.js') }}"
        type="text/javascript"></script>
@endif
<script src="{{ asset('backend/app-assets/vendors/js/extensions/sweetalert.min.js') }}" type="text/javascript">
</script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/toastr.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/extensions/toastr.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/custom-js/custom.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/vendors/js/extensions/jquery.steps.min.js') }}" type="text/javascript">
</script>

<!-- END PAGE VENDOR JS-->
<script src="{{ asset('backend/app-assets/js/scripts/forms/wizard-steps.js') }}" type="text/javascript"></script>
</script>
<script src="{{ asset('backend/app-assets/vendors/js/forms/tags/tagging.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('backend/app-assets/js/scripts/forms/tags/tagging.js') }}" type="text/javascript"></script>
<!-- jQuery (Required for Toastr) -->
<!-- Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

@livewireScripts


<script>
    
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("editor")) {
            CKEDITOR.replace("editor", {
                height: 200,
            });

            document.querySelector("form").addEventListener("submit", function(e) {
                let editor = CKEDITOR.instances.editor;
                if (editor) {
                    let editorData = editor.getData().trim();
                    let errorMsg = document.getElementById("editor-error");

                    if (!editorData) {
                        e.preventDefault();
                        errorMsg.style.display = "block";
                    } else {
                        errorMsg.style.display = "none";
                    }
                }
            });
        }
    });
</script>




<script>
    $(document).ready(function() {
        @if (session('toastr_success'))
            toastr.success("{{ session('toastr_success') }}");
        @endif

        @if (session('toastr_error'))
            toastr.error("{{ session('toastr_error') }}");
        @endif
    });
</script>

<script>
    $(document).ready(function() {
        $('#image').on('change', function() {
            let reader = new FileReader();

            reader.onload = function(e) {
                $('.image-preview').attr('src', e.target.result);
            };

            if (this.files && this.files[0]) {
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>

<script>
    $(".imagee").change(function() {

        if (this.files && this.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.image-previeww').attr('src', e.target.result);
            }

            reader.readAsDataURL(this.files[0]);
        }

    });
    $('.delete-confirm').click(function(event) {
        var form = $(this).closest("form");
        var name = $(this).data("name");
        event.preventDefault();
        swal({
                title: `هل متأكد من حذف العنصر ؟`,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    form.submit();
                }
            });
    });
</script>

<script></script>


<script>
    let elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        let switchery = new Switchery(html, {
            size: 'small'
        });
    });
   
</script>

@yield('script')
<script>
    function fetchNotifications() {
    fetch('/dashboard/notifications')
        .then(response => response.json()) // تحويل الاستجابة إلى JSON
        .then(data => {
            if (data.length > 0) {
                updateNotificationsDropdown(data);
                updateNotificationBadge(data.length);
            }
        })
        .catch(error => console.error('Error fetching notifications:', error));
}

// تحديث إشعارات الـ Dropdown في الواجهة
function updateNotificationsDropdown(notifications) {
    const notificationList = document.querySelector('.media-list');
    notificationList.innerHTML = ''; // مسح الإشعارات القديمة

    notifications.forEach(notification => {
        const notificationItem = document.createElement('a');
        notificationItem.href = `/dashboard/show_notofication/`+notification.id; // رابط الإشعار

        notificationItem.innerHTML = `
            <div class="media">
                <div class="media-left align-self-center">
                    <i class="ft-bell icon-bg-circle bg-cyan"></i> <!-- أيقونة الإشعار -->
                </div>
                <div class="media-body">
                    <h6 class="media-heading">${notification.data.title}</h6>
                    <p class="notification-text font-small-3 text-muted">${notification.data.body}</p>
                    <small>
                        <time class="media-meta text-muted">${notification.created_at}</time>
                    </small>
                </div>
            </div>
        `;

        notificationList.appendChild(notificationItem);
    });
}

// تحديث العدادات
function updateNotificationBadge(count) {
    const badge = document.querySelector('.badge-danger');
    if (badge) {
        badge.textContent = count;
    }
}

// استعلام كل 30 ثانية
setInterval(fetchNotifications, 30000);

// استعلام فوري عند تحميل الصفحة
fetchNotifications();
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('clientSearch');
        const resultsDiv = document.getElementById('clientResults');

        // تعريف روابط Laravel باستخدام Blade
        const searchRoute = @json(route('client.search'));
        const clientShowRoute = @json(route('clients.show', ['client' => '__ID__'])); // placeholder __ID__

        searchInput.addEventListener('keyup', function () {
            let term = this.value.trim();

            if (term.length >= 2) {
                fetch(`${searchRoute}?term=${term}`)
                    .then(response => response.json())
                    .then(data => {
                        resultsDiv.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(client => {
                                const item = document.createElement('a');
                                item.href = clientShowRoute.replace('__ID__', client.id); // استبدال placeholder
                                item.className = 'dropdown-item';
                                item.innerText = `${client.name} - ${client.id_number}`;
                                resultsDiv.appendChild(item);
                            });
                            resultsDiv.style.display = 'block';
                        } else {
                            resultsDiv.style.display = 'none';
                        }
                    });
            } else {
                resultsDiv.style.display = 'none';
            }
        });

        document.addEventListener('click', function (e) {
            if (!searchInput.contains(e.target) && !resultsDiv.contains(e.target)) {
                resultsDiv.style.display = 'none';
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        @if (!Route::is('calender'))

        $('table').DataTable({
            language: {
                "sProcessing":   "جاري التحميل...",
                "sLengthMenu":   "أظهر _MENU_ مدخلات",
                "sZeroRecords":  "لم يعثر على أية سجلات",
                "sInfo":         "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "sInfoEmpty":    "يعرض 0 إلى 0 من أصل 0 سجل",
                "sInfoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "sInfoPostFix":  "",
                "search": "<span class='search-label'><i class='la la-search'></i> ابحث</span>:",
                "sUrl":          "",
                "oPaginate": {
                    "sFirst":    "الأول",
                    "sPrevious": "السابق",
                    "sNext":     "التالي",
                    "sLast":     "الأخير"
                },
              
            },
        
            direction: 'ltr'
        });
        @endif

    });
    </script>

<!-- END PAGE LEVEL JS-->
</body>

</html>
