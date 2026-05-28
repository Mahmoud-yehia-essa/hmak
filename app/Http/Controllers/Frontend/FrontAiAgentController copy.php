<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\News;
use App\Models\About;

// استدعاء الموديلات
use App\Models\Planne;
use App\Models\Service;
use App\Models\TeamWork;
use App\Models\Companywork;
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

        return view('frontend.pages.ai_agent',compact('home'));
    }

    // استقبال السؤال من المستخدم والرد
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

        // تجهيز المحتوى لإرساله للـ API
        $context = "هذه معلومات عن الشركة:\n";
        if($about) {
            $context .= "عن الشركة: " . ($about->title ?? '') . " - " . ($about->des ?? '') . "\n";
        }

        if($news->count()) {
            $context .= "أخبار الشركة:\n";
            foreach($news as $n){
                $context .= "- " . ($n->title ?? '') . ": " . ($n->des ?? '') . "\n";
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
                $context .= "- " . ($p->title ?? '') . ": " . ($p->des ?? '') . " بسعر " . ($p->price ?? '') . "\n";
            }
        }

        if($works->count()) {
            $context .= "أعمال الشركة:\n";
            foreach($works as $w){
                $context .= "- " . ($w->title ?? '') . ": " . ($w->des ?? '') . "\n";
            }
        }

        if($services->count()) {
            $context .= "خدمات الشركة:\n";
            foreach($services as $s){
                $context .= "- " . ($s->title ?? '') . ": " . ($s->des ?? '') . "\n";
            }
        }

        // إضافة السؤال
        $prompt = $context . "\nسؤال المستخدم: " . $question;

        // إرسال الطلب إلى Gemini API
        $apiKey = env('GEMINI_API_KEY'); // ضع الـ API Key في ملف .env
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
            if(isset($data['candidates'][0]['content'])){
                $answer = $data['candidates'][0]['content'];
            }
        }

        return response()->json([
            'answer' => $answer
        ]);
    }
}
