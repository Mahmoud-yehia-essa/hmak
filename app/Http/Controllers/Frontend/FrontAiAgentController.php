<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\News;
use App\Models\About;
use App\Models\Planne;
use App\Models\Service;
use App\Models\TeamWork;
use App\Models\Companywork;
use App\Models\ContactInfo;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\CompanyClient;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class FrontAiAgentController extends Controller
{
    // عرض الصفحة
    public function showAiAgent()
    {
        $home = Home::latest()->get();
        return view('frontend.pages.ai_agent', compact('home'));
    }



    // استقبال السؤال من المستخدم والرد
// public function askAiAgent(Request $request)
// {
//     $request->validate([
//         'question' => 'required|string',
//     ]);

//     $question = $request->question;

//     // جمع المعلومات من الجداول
//     $about = About::first();
//     $news = News::where('status','active')->get();
//     $clients = CompanyClient::where('status','active')->get();
//     $team = TeamWork::where('status','active')->get();
//     $plans = Planne::all();
//     $works = Companywork::where('status','active')->get();
//     $services = Service::where('status','active')->get();
//     $contactInfo = \App\Models\ContactInfo::first(); // جدول معلومات الاتصال


//     $socialMedia = SocialMedia::all();

//     // تجهيز المحتوى لإرساله للـ API
//     $context = "هذه معلومات عن الشركة:\n";

//     if($about) {
//         $context .= "عن الشركة: " . ($about->title ?? '') . " - " . ($about->des ?? '') . "\n";
//     }

//     if($news->count()) {
//         $context .= "أخبار الشركة:\n";
//         foreach($news as $n){
//             $context .= "- " . ($n->title ?? '') . ": " . ($n->des ?? '') . " (رابط: " . url('/news/details/'.$n->id) . ")\n";
//         }
//     }

//     if($clients->count()) {
//         $context .= "عملاء الشركة:\n";
//         foreach($clients as $c){
//             $context .= "- " . ($c->title ?? '') . ": " . ($c->des ?? '') . "\n";
//         }
//     }

//     if($team->count()) {
//         $context .= "فريق العمل:\n";
//         foreach($team as $t){
//             $context .= "- " . ($t->name ?? '') . ": " . ($t->position ?? '') . "\n";
//         }
//     }

//     if($plans->count()) {
//         $context .= "خطط الشركة:\n";
//         foreach($plans as $p){
//             $context .= "- " . ($p->title ?? '') . ": " . ($p->des ?? '') . " بسعر " . ($p->price ?? '') . " (رابط: " . url('/plans/details/'.$p->id) . ")\n";
//         }
//     }

//     if($works->count()) {
//         $context .= "أعمال الشركة:\n";
//         foreach($works as $w){
//             $context .= "- " . ($w->title ?? '') . ": " . ($w->des ?? '') . " (رابط: " . url('/works/details/'.$w->id) . ")\n";
//         }
//     }

//     if($services->count()) {
//         $context .= "خدمات الشركة:\n";
//         foreach($services as $s){
//             $context .= "- " . ($s->title ?? '') . ": " . ($s->des ?? '') . " (رابط: " . url('/services/details/'.$s->id) . ")\n";
//         }
//     }

//     if($contactInfo) {
//         $context .= "معلومات الاتصال:\n";
//         $context .= "- الاسم: " . ($contactInfo->title ?? '') . "\n";
//         $context .= "- الوصف: " . ($contactInfo->des ?? '') . "\n";
//         $context .= "- الهاتف: " . ($contactInfo->phone ?? '') . "\n";
//         $context .= "- البريد الإلكتروني: " . ($contactInfo->email ?? '') . "\n";
//         $context .= "- الموقع على الخريطة: https://maps.google.com/?q=" . ($contactInfo->latitude ?? '') . "," . ($contactInfo->longitude ?? '') . "\n";
//     }

//     // إضافة السؤال
//     $prompt = $context . "\nسؤال المستخدم: " . $question;

//     // إرسال الطلب إلى Gemini API
//     $apiKey = env('GEMINI_API_KEY');
//     $response = Http::withHeaders([
//         'Content-Type' => 'application/json',
//         'X-goog-api-key' => $apiKey,
//     ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
//         "contents" => [
//             [
//                 "parts" => [
//                     [
//                         "text" => $prompt
//                     ]
//                 ]
//             ]
//         ]
//     ]);

//     $answer = "لم يتم الحصول على رد";

//     if($response->ok()) {
//         $data = $response->json();
//         if(isset($data['candidates'][0]['content']['parts'][0]['text'])){
//             $answer = $data['candidates'][0]['content']['parts'][0]['text'];
//         }
//     }

//     return response()->json([
//         'answer' => $answer
//     ]);
// }



// public function askAiAgent(Request $request)
// {
//     $request->validate([
//         'question' => 'required|string',
//     ]);

//     $question = $request->question;

//     // جمع المعلومات من الجداول
//     $about = About::first();
//     $news = News::where('status','active')->get();
//     $clients = CompanyClient::where('status','active')->get();
//     $team = TeamWork::where('status','active')->get();
//     $plans = Planne::all();
//     $works = Companywork::where('status','active')->get();
//     $services = Service::where('status','active')->get();
//     $contactInfo = \App\Models\ContactInfo::first();
//     $socialMedia = \App\Models\SocialMedia::all(); // جدول التواصل الاجتماعي

//     // تجهيز المحتوى لإرساله للـ API
//     $context = "هذه معلومات عن الشركة:\n";

//     if($about) {
//         $context .= "عن الشركة: " . ($about->title ?? '') . " - " . ($about->des ?? '') . "\n";
//     }

//     if($news->count()) {
//         $context .= "أخبار الشركة:\n";
//         foreach($news as $n){
//             $context .= "- " . ($n->title ?? '') . ": " . ($n->des ?? '') . " ([رابط](" . url('/news/details/'.$n->id) . "))\n";
//         }
//     }

//     if($clients->count()) {
//         $context .= "عملاء الشركة:\n";
//         foreach($clients as $c){
//             $context .= "- " . ($c->title ?? '') . ": " . ($c->des ?? '') . "\n";
//         }
//     }

//     if($team->count()) {
//         $context .= "فريق العمل:\n";
//         foreach($team as $t){
//             $context .= "- " . ($t->name ?? '') . ": " . ($t->position ?? '') . "\n";
//         }
//     }

//     if($plans->count()) {
//         $context .= "خطط الشركة:\n";
//         foreach($plans as $p){
//             $context .= "- " . ($p->title ?? '') . ": " . ($p->des ?? '') . " بسعر " . ($p->price ?? '') . " ([رابط](" . url('/plans/details/'.$p->id) . "))\n";
//         }
//     }

//     if($works->count()) {
//         $context .= "أعمال الشركة:\n";
//         foreach($works as $w){
//             $context .= "- " . ($w->title ?? '') . ": " . ($w->des ?? '') . " ([رابط](" . url('/works/details/'.$w->id) . "))\n";
//         }
//     }

//     if($services->count()) {
//         $context .= "خدمات الشركة:\n";
//         foreach($services as $s){
//             $context .= "- " . ($s->title ?? '') . ": " . ($s->des ?? '') . " ([رابط](" . url('/services/details/'.$s->id) . "))\n";
//         }
//     }

//     if($contactInfo) {
//         $context .= "معلومات الاتصال:\n";
//         $context .= "- الاسم: " . ($contactInfo->title ?? '') . "\n";
//         $context .= "- الوصف: " . ($contactInfo->des ?? '') . "\n";
//         $context .= "- الهاتف: " . ($contactInfo->phone ?? '') . "\n";
//         $context .= "- البريد الإلكتروني: " . ($contactInfo->email ?? '') . "\n";
//         $context .= "- الموقع على الخريطة: [Google Maps](https://maps.google.com/?q=" . ($contactInfo->latitude ?? '') . "," . ($contactInfo->longitude ?? '') . ")\n";
//     }

//     if($socialMedia->count()) {
//         $context .= "تواصل معنا على وسائل التواصل الاجتماعي:\n";
//         foreach($socialMedia as $sm){
//             $context .= "- " . ($sm->title ?? '') . ": [" . ($sm->title ?? '') . "](" . ($sm->link ?? '#') . ")\n";
//         }
//     }

//     // إضافة السؤال
//     $prompt = $context . "\nسؤال المستخدم: " . $question;

//     // إرسال الطلب إلى Gemini API
//     $apiKey = env('GEMINI_API_KEY');
//     $response = Http::withHeaders([
//         'Content-Type' => 'application/json',
//         'X-goog-api-key' => $apiKey,
//     ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
//         "contents" => [
//             [
//                 "parts" => [
//                     [
//                         "text" => $prompt
//                     ]
//                 ]
//             ]
//         ]
//     ]);

//     $answer = "لم يتم الحصول على رد";

//     if($response->ok()) {
//         $data = $response->json();
//         if(isset($data['candidates'][0]['content']['parts'][0]['text'])){
//             $answer = $data['candidates'][0]['content']['parts'][0]['text'];
//         }
//     }

//     return response()->json([
//         'answer' => $answer
//     ]);
// }



// 2
// public function askAiAgent(Request $request)
// {
//     $request->validate([
//         'question' => 'required|string',
//     ]);

//     $question = $request->question;

//     // جمع المعلومات من الجداول
//     $about = About::first();
//     $news = News::where('status','active')->get();
//     $clients = CompanyClient::where('status','active')->get();
//     $team = TeamWork::where('status','active')->get();
//     $plans = Planne::all();
//     $works = Companywork::where('status','active')->get();
//     $services = Service::where('status','active')->get();
//     $contactInfo = \App\Models\ContactInfo::first();
//     $socialMedia = \App\Models\SocialMedia::all();

//     // تجهيز المحتوى لإرساله للـ API
//     $context = "هذه معلومات عن الشركة:\n";

//     if($about) {
//         $context .= "عن الشركة: " . ($about->title ?? '') . " - " . ($about->des ?? '') . "\n";
//     }

//     if($news->count()) {
//         $context .= "أخبار الشركة:\n";
//         foreach($news as $n){
//             $context .= "- " . ($n->title ?? '') . ": " . ($n->des ?? '') . " (رابط: " . url('/news/details/'.$n->id) . ")\n";
//         }
//     }

//     if($clients->count()) {
//         $context .= "عملاء الشركة:\n";
//         foreach($clients as $c){
//             $context .= "- " . ($c->title ?? '') . ": " . ($c->des ?? '') . "\n";
//         }
//     }

//     if($team->count()) {
//         $context .= "فريق العمل:\n";
//         foreach($team as $t){
//             $context .= "- " . ($t->name ?? '') . ": " . ($t->position ?? '') . "\n";
//         }
//     }

//     if($plans->count()) {
//         $context .= "خطط الشركة:\n";
//         foreach($plans as $p){
//             $context .= "- " . ($p->title ?? '') . ": " . ($p->des ?? '') . " بسعر " . ($p->price ?? '') . " (رابط: " . url('/plans/details/'.$p->id) . ")\n";
//         }
//     }

//     if($works->count()) {
//         $context .= "أعمال الشركة:\n";
//         foreach($works as $w){
//             $context .= "- " . ($w->title ?? '') . ": " . ($w->des ?? '') . " (رابط: " . url('/works/details/'.$w->id) . ")\n";
//         }
//     }

//     if($services->count()) {
//         $context .= "خدمات الشركة:\n";
//         foreach($services as $s){
//             $context .= "- " . ($s->title ?? '') . ": " . ($s->des ?? '') . " (رابط: " . url('/services/details/'.$s->id) . ")\n";
//         }
//     }

//     if($contactInfo) {
//         $context .= "معلومات الاتصال:\n";
//         $context .= "- الاسم: " . ($contactInfo->title ?? '') . "\n";
//         $context .= "- الوصف: " . ($contactInfo->des ?? '') . "\n";
//         $context .= "- الهاتف: " . ($contactInfo->phone ?? '') . "\n";
//         $context .= "- البريد الإلكتروني: " . ($contactInfo->email ?? '') . "\n";
//         $context .= "- الموقع على الخريطة: https://maps.google.com/?q=" . ($contactInfo->latitude ?? '') . "," . ($contactInfo->longitude ?? '') . "\n";
//     }

//     if($socialMedia->count()) {
//         $context .= "روابط التواصل الاجتماعي:\n";
//         foreach($socialMedia as $sm){
//             $context .= "- " . ($sm->title ?? '') . ": " . ($sm->link ?? '') . "\n";
//         }
//     }

//     // تعليمات لتقييد الردود
//     $instructions = "انت مساعد افتراضي للشركة. أجب فقط على الأسئلة المتعلقة بالمعلومات الموجودة أدناه. إذا كان السؤال خارج نطاق هذه المعلومات، رد بـ 'عذرًا، لا أستطيع الإجابة على هذا السؤال'. لا تكتب أي جمل تمهيدية مثل 'بناءً على المعلومات المقدمة'.";

//     // إنشاء الـ prompt
//     $prompt = $instructions . "\n\n" . $context . "\nسؤال المستخدم: " . $question;

//     // إرسال الطلب إلى Gemini API
//     $apiKey = env('GEMINI_API_KEY');
//     $response = Http::withHeaders([
//         'Content-Type' => 'application/json',
//         'X-goog-api-key' => $apiKey,
//     ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
//         "contents" => [
//             [
//                 "parts" => [
//                     [
//                         "text" => $prompt
//                     ]
//                 ]
//             ]
//         ]
//     ]);

//     $answer = "لم يتم الحصول على رد";

//     if($response->ok()) {
//         $data = $response->json();
//         if(isset($data['candidates'][0]['content']['parts'][0]['text'])){
//             $answer = $data['candidates'][0]['content']['parts'][0]['text'];
//         }
//     }

//     return response()->json([
//         'answer' => $answer
//     ]);
// }



public function askAiAgent(Request $request)
{
    $request->validate([
        'question' => 'required|string',
    ]);

    $question = $request->question;

    // جمع المعلومات من الجداول
    $about = About::first();
    $news = News::where('status','active')->get();
    $clients = CompanyClient::where('status','active')->get();
    $team = TeamWork::where('status','active')->get();
    $plans = Planne::all();
    $works = Companywork::where('status','active')->get();
    $services = Service::where('status','active')->get();
    $contactInfo = \App\Models\ContactInfo::first();
    $socialMedia = \App\Models\SocialMedia::all();

    // تجهيز المحتوى لإرساله للـ API
    $context = "هذه معلومات عن الشركة:\n";

    if($about) {
        $context .= "عن الشركة: " . ($about->title ?? '') . " - " . ($about->des ?? '') . "\n";
    }

    if($news->count()) {
        $context .= "أخبار الشركة:\n";
        foreach($news as $n){
            $context .= "- " . ($n->title ?? '') . ": " . ($n->des ?? '') . " (رابط: " . url('/news/details/'.$n->id) . ")\n";
        }
    }

    if($clients->count()) {
        $context .= "عملاء الشركة:\n";
        foreach($clients as $c){
            $context .= "- " . ($c->title ?? '') . ": " . ($c->des ?? '') . "\n";
        }
    }

    if($team->count()) {
        $context .= "فريق العمل:\n";
        foreach($team as $t){
            $context .= "- " . ($t->name ?? '') . ": " . ($t->position ?? '') . "\n";
        }
    }

    if($plans->count()) {
        $context .= "خطط الشركة:\n";
        foreach($plans as $p){
            $context .= "- " . ($p->title ?? '') . ": " . ($p->des ?? '') . " بسعر " . ($p->price ?? '') . " (رابط: " . url('/plans/details/'.$p->id) . ")\n";
        }
    }

    if($works->count()) {
        $context .= "أعمال الشركة:\n";
        foreach($works as $w){
            $context .= "- " . ($w->title ?? '') . ": " . ($w->des ?? '') . " (رابط: " . url('/works/details/'.$w->id) . ")\n";
        }
    }

    if($services->count()) {
        $context .= "خدمات الشركة:\n";
        foreach($services as $s){
            $context .= "- " . ($s->title ?? '') . ": " . ($s->des ?? '') . " (رابط: " . url('/services/details/'.$s->id) . ")\n";
        }
    }

    if($contactInfo) {
        $context .= "معلومات الاتصال:\n";
        $context .= "- الاسم: " . ($contactInfo->title ?? '') . "\n";
        $context .= "- الوصف: " . ($contactInfo->des ?? '') . "\n";
        $context .= "- الهاتف: " . ($contactInfo->phone ?? '') . "\n";
        $context .= "- البريد الإلكتروني: " . ($contactInfo->email ?? '') . "\n";
        $context .= "- الموقع على الخريطة: https://maps.google.com/?q=" . ($contactInfo->latitude ?? '') . "," . ($contactInfo->longitude ?? '') . "\n";
    }

    if($socialMedia->count()) {
        $context .= "روابط التواصل الاجتماعي:\n";
        foreach($socialMedia as $sm){
            $context .= "- " . ($sm->title ?? '') . ": " . ($sm->link ?? '') . "\n";
        }
    }

    // تعليمات لتقييد الردود فقط خارج الأسئلة العامة والترحيب
//     $instructions = "
// انت مساعد افتراضي لشركة المقام.
// - أجب بشكل كامل على الأسئلة المتعلقة بالشركة باستخدام المعلومات أعلاه وروابط التفاصيل.
// - إذا كان السؤال خارج نطاق الشركة، رد برسالة لطيفة مثل: 'أنا هنا لأساعدك بما يتعلق بشركة المقام فقط.'
// - الردود الترحيبية والختامية (السلام عليكم، مع السلامة، شكراً، إلخ) مسموحة.
// - لا تكتب أي جمل تمهيدية مثل 'بناءً على المعلومات المقدمة'.
// ";


$instructions = "
انت مساعد افتراضي لشركة المقام.
- أجب بشكل كامل على الأسئلة المتعلقة بالشركة باستخدام المعلومات أعلاه وروابط التفاصيل.
- لا تبدأ أي ردود بعبارات تمهيدية مثل 'السلام عليكم' أو 'بناءً على المعلومات المقدمة'.
- إذا كان السؤال خارج نطاق الشركة، رد برسالة لطيفة مثل: 'أنا هنا لأساعدك بما يتعلق بشركة المقام فقط.'
- الردود الترحيبية والختامية (مثل شكرًا، مع السلامة، إلخ) مسموحة فقط إذا كانت مناسبة للسياق.
";


    // إنشاء الـ prompt
    $prompt = $instructions . "\n\n" . $context . "\nسؤال المستخدم: " . $question;

    // إرسال الطلب إلى Gemini API
    $apiKey = env('GEMINI_API_KEY');
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'X-goog-api-key' => $apiKey,
    ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent', [
        "contents" => [
            [
                "parts" => [
                    [
                        "text" => $prompt
                    ]
                ]
            ]
        ]
    ]);

    $answer = "لم يتم الحصول على رد";

    if($response->ok()) {
        $data = $response->json();
        if(isset($data['candidates'][0]['content']['parts'][0]['text'])){
            $answer = $data['candidates'][0]['content']['parts'][0]['text'];
        }
    }

    return response()->json([
        'answer' => $answer
    ]);
}



}
