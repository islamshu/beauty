<?php

namespace App\Http\Controllers;

use App\Events\OrderNotification;
use App\Models\Aboutus;
use App\Models\Appointment;
use App\Models\Area;
use App\Models\Category;
use App\Models\Client;
use App\Models\Contact;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\Order;
use App\Models\Package;
use App\Models\Partner;
use App\Models\Product;
use App\Models\Service;
use App\Models\Slider;
use App\Models\User;
use App\Notifications\CourceNotification;
use App\Notifications\PackgeNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
class HomeController extends Controller
{
    public function add_perm(){
        // Permission::firstOrCreate(['name' =>'إضافة زيارة' ]);
        // Permission::firstOrCreate(['name' =>'إضافة مدفوعات' ]);
        // Permission::firstOrCreate(['name' =>'الاحصائيات' ]);

        $adminRole = Role::firstOrCreate(['name' => 'الإدارة']);
        $permissions = Permission::all();
        $adminRole->syncPermissions($permissions);
        auth()->user()->assignRole($adminRole);
        dd('done');

    }
    public function contact_us()
    {
        return view('frontend.sections.contact_us');
    }
    public function packge_order()
    {
        return view('dashboard.orders.packges')->with('orders', Order::with('client')->orderby('id', 'desc')->get());
    }
    public function cource_order(Enrollment $order)
    {
        return view('dashboard.orders.course_show', compact('order'));
    }
    public function pacgkeorders($id)
    {
        $order = Order::find($id);
        $order->status = 1;
        $order->save();
        $notifications = auth()->user()->notifications;

        // جلب أول إشعار غير مقروء وتحديثه إلى مقروء


        return view('dashboard.orders.packge_order')->with('order', $order);
    }
    public function pacgkeorders_delete($id)
    {
        $order = Order::find($id);
        $order->delete();
        return redirect()->back()->with('toastr_success', 'تم حذف الطلب بنجاح!');
    }
    public function cource_order_delete($id)
    {
        $order = Enrollment::find($id);
        $order->delete();
        return redirect()->route('courses_order')->with('toastr_success', 'تم حذف الطلب بنجاح!');
    }


    public function updateStatus_course_order(Request $request, $orderId)
    {
        $order = Enrollment::find($orderId);

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }

        // Update the status of the order
        $order->status = $request->status;
        $order->save();

        // Return a JSON response indicating success
        return response()->json(['success' => true, 'message' => 'تم تحديث الحالة بنجاح']);
    }



    public function service_order()
    {
        return view('dashboard.orders.services')->with('orders', Appointment::orderby('id', 'desc')->get());
    }
    public function course_order()
    {
        return view('dashboard.orders.courses')->with('orders', Enrollment::orderby('id', 'desc')->get());
    }
    public function contact_order()
    {
        return view('dashboard.orders.contact')->with('contacts', Contact::orderby('id', 'desc')->get());
    }
    public function contact_order_edit($id)
    {
        $contact = Contact::find($id);
        $contact->show = 1;
        $contact->save();
        return view('dashboard.orders.contact_show')->with('contact', $contact);
    }
    public function contact_order_delete($id)
    {
        $contact = Contact::find($id);
        $contact->delete();
        return redirect()->back()->with('toastr_success', 'تم الحذف بنجاح.');
    }
    public function single_products($id)
    {
        
            $product = Product::findOrFail($id);
        
            $relatedProducts = $product->relatedProducts()
                ->where('status', 1)
                ->where('id', '!=', $product->id)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        
            if ($relatedProducts->isEmpty()) {
                $relatedProducts = Product::where('status', 1)
                    ->where('id', '!=', $product->id)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get();
            }
        
            return view('frontend.single_products', compact('product', 'relatedProducts'));
        
            }

    public function store_contact(Request $request)
    {
        // قواعد التحقق مع رسائل مخصصة بالعربية
        $rules = [
            'contact-form-name' => 'required|string|max:255',
            'contact-form-email' => 'required|email|max:255',
            'contact-form-mobile' => 'required|string|max:20',
            'contact-form-message' => 'required|string',
        ];

        // رسائل الخطأ المخصصة بالعربية
        $customMessages = [
            'required' => 'حقل :attribute مطلوب.',
            'string' => 'حقل :attribute يجب أن يكون نصاً.',
            'email' => 'حقل :attribute يجب أن يكون بريداً إلكترونياً صحيحاً.',
            'max' => 'حقل :attribute يجب ألا يتجاوز :max حرف.',

            // رسائل محددة للحقول
            'contact-form-name.required' => 'الاسم الكامل مطلوب.',
            'contact-form-email.required' => 'البريد الإلكتروني مطلوب.',
            'contact-form-email.email' => 'يجب إدخال بريد إلكتروني صحيح.',
            'contact-form-mobile.required' => 'رقم الجوال مطلوب.',
            'contact-form-message.required' => 'الرسالة مطلوبة.',
        ];

        // أسماء الحقول المعربة
        $attributes = [
            'contact-form-name' => 'الاسم الكامل',
            'contact-form-email' => 'البريد الإلكتروني',
            'contact-form-mobile' => 'رقم الجوال',
            'contact-form-message' => 'الرسالة',
        ];

        // تنفيذ التحقق مع الرسائل المخصصة
        $validatedData = $request->validate($rules, $customMessages, $attributes);

        try {
            // تخزين البيانات في قاعدة البيانات
            Contact::create([
                'name' => $validatedData['contact-form-name'],
                'email' => $validatedData['contact-form-email'],
                'phone' => $validatedData['contact-form-mobile'],
                'message' => $validatedData['contact-form-message'],
            ]);

            // إرجاع رسالة نجاح
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال رسالتك بنجاح، شكراً لتواصلك معنا!'
            ]);
        } catch (\Exception $e) {
            // في حالة حدوث خطأ غير متوقع
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء محاولة إرسال الرسالة. يرجى المحاولة مرة أخرى لاحقاً.'
            ], 500);
        }
    }
    public function products_old(Request $request)
    {
        $query = Product::query();

        // Search if there's a search term
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $perPage = 12; // Number of items per load
        $page = $request->get('page', 1); // Get current page or default to 1

        $products = $query->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            return view('frontend.partials._products', compact('products'))->render();
        }

        return view('frontend.products', compact('products'));
    }
    public function packegs()
    {
        return view('frontend.packegs')->with('packages', Package::orderby('id', 'desc')->get());
    }
    public function services(Request $request)
    {
        $query = Service::query()->where('status', 1);

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $perPage = 12; // Number of items per load
        $page = $request->get('page', 1); // Get current page or default to 1

        $services = $query->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            return view('frontend.partials._services', compact('services'))->render();
        }

        return view('frontend.services', compact('services'));
    }
    public function products(Request $request)
    {
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', "%{$search}%");
        }

        $perPage = 12; // Number of items per load
        $page = $request->get('page', 1); // Get current page or default to 1

        $products = $query->orderBy('id', 'desc')
            ->paginate($perPage, ['*'], 'page', $page);

        if ($request->ajax()) {
            return view('frontend.partials._products', compact('products'))->render();
        }

        return view('frontend.products', compact('products'));
    }


    public function single_course($id)
    {
        return view('frontend.course')->with('course', Course::find($id));
    }
    public function index()
    {
        $sliders = Slider::where('status', 1)->get();
        $abouts = Aboutus::first();
        $categories = Category::has('services')->get();
        $services = Service::where('status', 1)->take(8)->get();
        $first_service = Service::first();
        $courses = Course::where('status', 1)->get();
        $packages = Package::where('status', 1)->take(3)->orderby('id', 'desc')->get();
        $galleries = Gallery::orderby('id', 'desc')->get();
        $categoriesgal = Category::has('gallery')->with('gallery')->get();
        $partners = Partner::get();
        $products = Product::orderBy('id', 'desc')->take(12)->get();
        return view('frontend.index', compact('sliders', 'abouts', 'categories', 'services', 'first_service', 'courses', 'packages', 'galleries', 'categoriesgal', 'partners', 'products'));
    }
    public function purchase(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'full_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'country_code'=> 'required',
            'address' => 'required|string',
        ]);
    
        // معالجة نهائية لرقم الهاتف
        $phone = $request->phone;
        $countryCode = $request->input('country_code', '+970');
        $numberPart = substr($phone, 1);
        
        $phone = $countryCode . $numberPart;
        $order = Order::create([
            'package_id' => $request->package_id,
            'full_name' => $request->full_name,
            'phone' => $phone,
            'address' => $request->address,
            'country_code' => $countryCode,
            'phone_number' => $numberPart,
        ]);

        $admins = User::role('الإدارة')->get();

        foreach ($admins as $admin) {
            $admin->notify(new PackgeNotification($order));
        }
        $template = Message::where('key', 'welcome_message')->first()?->content ?? '';
        $message_register = str_replace('{full_name}', $request->full_name, $template);
        
        sendMessage($phone, $message_register);
       
        $message =Message::where('key', 'admin_message')->first()?->content ?? '';
        $message .=  route('packge_order', $order->id) . "\n\n";
        sendMessage(get_general_value('whatsapp_number'),$message);
        return response()->json(['success' => true]);
       
    }
    public function enroll(Request $request)
    {
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'experience' => 'nullable|string|in:beginner,intermediate,advanced',
            'goal' => 'nullable|string|max:500',
            'address' => 'required|string|max:500',
            'whatsapp' => 'nullable|string|max:15',
        ]);

        // حفظ الاشتراك مع جميع البيانات
        $cource =  Enrollment::create($validated);
        $admins = User::role('admin')->get(); // جلب جميع المستخدمين الذين لديهم دور "إداري"

        foreach ($admins as $admin) {
            $admin->notify(new CourceNotification($cource)); // إرسال الإشعار للمستخدم
        }
        $this->sendWhatsAppNotification($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'تم التسجيل بنجاح! سوف نتصل بك قريباً لتأكيد الحجز.'
        ]);
    }
    private function sendWhatsAppNotification($data)
    {
        $phone = get_general_value('whatsapp_number');
        $message = "مرحباً {$data['name']}، شكراً لتسجيلك في دورتنا. سنتواصل معك قريباً!";

        $url = "https://wa.me/{$phone}?text=" . urlencode($message);

        return redirect()->away($url);
    }
    public function appointmentstore(Request $request)
    {

        // التحقق من صحة البيانات
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'appointment_date' => 'required|date',
            'full_name' => 'required|string|max:255',
            'id_number' => 'required|numeric',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
        ]);
        $request_all = $request->except(['id_number', 'appointment_date']);
        $request_all['date'] = $request->appointment_date;
        $request_all['idnumber'] = $request->id_number;

        Appointment::create($request_all);

        return response()->json(['message' => 'تم الحجز بنجاح!']);
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function calender()
    {

        return view('dashboard.calender')->with('clients',Client::all())->with('users',User::all())->with('services',Service::all());
    }


    public function service_show($id)
    {
        // Find the service by ID
        $service = Service::find($id);

        // If the service is not found, return a 404 error
        if (!$service) {
            return response()->json([
                'error' => 'Service not found',
            ], 404);
        }

        // Return the service details as JSON
        return response()->json([
            'id' => $service->id,
            'title' => $service->title,
            'description' => $service->description,
            'price' => $service->price,
            'image' => asset('uploads/' . $service->image), // Ensure the image path is correct
        ]);
    }
    public function whataspp_key(){
        return view('dashboard.whatsapp_key');
    }
    public function updateWebSiteKey(Request $request)
    {
        

        $envPath = base_path('.env');

        // التحقق من وجود ملف .env
        if (!File::exists($envPath)) {
            return response()->json(['error' => 'ملف .env غير موجود'], 404);
        }

        // قراءة محتوى الملف
        $envContent = File::get($envPath);

        // استبدال القيمة القديمة أو إضافة جديدة إذا لم تكن موجودة
        if (str_contains($envContent, 'whatassp_key=')) {
            $envContent = preg_replace(
                '/whatassp_key=.*/',
                'whatassp_key=' . $request->whatassp_key,
                $envContent
            );
        } else {
            $envContent .= "\nwhatassp_key=" . $request->whatassp_key;
        }

        // حفظ التعديلات
        File::put($envPath, $envContent);

        // مسح الكاش للتأكد من قراءة القيم الجديدة
        // Artisan::call('config:clear');

        return redirect()->back()->with('toastr_success', 'تم تحديث المفتاح بنجاح!');
    }

}
