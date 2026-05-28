<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Exception;

class AiNewsGeneratorController extends Controller
{
    // عرض صفحة توليد الأخبار
    public function index()
    {
        $categories = NewsCategory::latest()->get();
        return view('admin.news.ai_generator', compact('categories'));
    }

    // توليد الأخبار باستخدام الذكاء الاصطناعي
    public function generate(Request $request)
    {
        $request->validate([
            'news_category_id' => 'required|exists:news_category,id',
            'count' => 'required|integer|min:1|max:10',
            'custom_prompt' => 'nullable|string|max:1000',
        ]);

        $category = NewsCategory::findOrFail($request->news_category_id);
        $count = $request->count;
        $customPrompt = $request->custom_prompt;

        $currentDate = date('Y-m-d');

        // تجهيز الـ Prompt لـ Gemini
        $prompt = "تاريخ اليوم الحالي هو: {$currentDate}.
أنت صحفي محترف ومحرر أخبار ذكي.
مطلوب منك توليد عدد {$count} من الأخبار الواقعية والاحترافية والمثيرة للاهتمام باللغة العربية فقط في القسم أو التصنيف التالي: \"{$category->name}\".
يجب أن تركز الأخبار على سياق دولة الكويت ومنطقة الخليج العربي أو الأخبار العالمية البارزة التي تهم القارئ الكويتي.
استعن بأداة البحث من Google (Google Search Grounding) المتاحة لديك للبحث في الويب المباشر عن آخر التطورات والأخبار الحقيقية والحديثة جداً التي جرت اليوم أو خلال الأيام القليلة الماضية وصغها بأسلوب صحفي جذاب وحي.";

        if (!empty($customPrompt)) {
            $prompt .= "\n\nتعليمات إضافية مخصصة من المشرف يجب الالتزام بها تماماً أثناء صياغة وتوليد هذه الأخبار: \"{$customPrompt}\"";
        }

        $prompt .= "\n\nيجب أن تقوم بإرجاع المخرجات بصيغة JSON فقط كـ Array (مصفوفة) تحتوي على كائنات (Objects).
كل كائن (خيار أو خبر) يجب أن يحتوي على الحقول التالية فقط باللغة العربية:
- \"title\": عنوان الخبر باللغة العربية (جذاب ومهني).
- \"des\": وصف أو ملخص قصير للخبر باللغة العربية (سطرين أو ثلاثة).
- \"more_des\": المحتوى التفصيلي الكامل للخبر باللغة العربية (من فقرتين إلى ثلاث فقرات، بأسلوب صحفي رصين).

تعليمات هامة جداً:
1. لا تكتب أي نصوص تمهيدية أو ختامية خارج الـ JSON.
2. يجب أن تكون المخرجات عبارة عن JSON صالح وقابل للتحليل (Valid JSON array).
3. لا تقم بتضمين أي وسوم برمجية مثل ```json في الإجابة، ابدأ مباشرة بـ [ وانتهِ بـ ].
4. لا تقم بتضمين علامات مراجع البحث أو مصادر الاقتباسات (مثل [1] أو [2]) داخل قيم حقول الـ JSON (العنوان، الوصف، التفاصيل)، بل صغ النص كخبر متكامل ومباشر.
5. يجب عدم استخدام أسطر جديدة حقيقية (literal newlines) أو علامات تبويب (tabs) داخل قيم النصوص في الـ JSON، بل استخدم الرمز \n بدلاً منها للسطر الجديد و \t لعلامة التبويب.";

        $apiKey = env('GEMINI_API_KEY');
        if (!$apiKey) {
            return response()->json([
                'success' => false,
                'message' => 'مفتاح GEMINI_API_KEY غير مهيأ في ملف البيئة .env'
            ], 400);
        }
        try {
            $models = [
                [
                    'url' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent',
                    'name' => 'gemini-2.5-flash'
                ],
                [
                    'url' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-3.5-flash:generateContent',
                    'name' => 'gemini-3.5-flash'
                ],
                [
                    'url' => 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent',
                    'name' => 'gemini-2.0-flash'
                ]
            ];
            $response = null;
            $lastError = null;

            foreach ($models as $modelCfg) {
                try {
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'X-goog-api-key' => $apiKey,
                    ])->post($modelCfg['url'], [
                        "contents" => [
                            [
                                "parts" => [
                                    [
                                        "text" => $prompt
                                    ]
                                ]
                            ]
                        ],
                        "tools" => [
                            [
                                "google_search" => (object)[]
                            ]
                        ],
                        "generationConfig" => [
                            "maxOutputTokens" => 8192,
                            "temperature" => 0.7
                        ]
                    ]);

                    if ($response->successful()) {
                        break;
                    } else {
                        $lastError = $response->body();
                    }
                } catch (Exception $innerEx) {
                    $lastError = $innerEx->getMessage();
                }
            }

            if (!$response || !$response->successful()) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل الاتصال بخدمة الذكاء الاصطناعي لكافة النماذج المتاحة. تفاصيل الخطأ: ' . $lastError
                ], 500);
            }

            $data = $response->json();
            $answer = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

            if (!$answer) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم إرجاع أي رد من نموذج الذكاء الاصطناعي.'
                ], 500);
            }

            // استخراج مصفوفة الـ JSON بشكل مرن ومتوافق مع علامات الاقتباس والرموز المهربة
            $rawText = $this->extractJson($answer);

            if (!$rawText) {
                // محاولة احتياطية كحل بديل
                $rawText = trim($answer);
                $startPos = strpos($rawText, '[');
                $endPos = strrpos($rawText, ']');
                if ($startPos !== false && $endPos !== false && $endPos > $startPos) {
                    $rawText = substr($rawText, $startPos, $endPos - $startPos + 1);
                } else {
                    if (strpos($rawText, '```json') === 0) {
                        $rawText = substr($rawText, 7);
                    }
                    if (substr($rawText, -3) === '```') {
                        $rawText = substr($rawText, 0, -3);
                    }
                    $rawText = trim($rawText);
                }
            }

            // إزالة الفواصل الزائدة (trailing commas) التي قد يضعها النموذج وتسبب فشل التحليل
            $rawText = preg_replace('/,\s*([}\]])/', '\1', $rawText);

            // معالجة الأسطر الجديدة الحقيقية، علامات التبويب، والشرطات المائلة غير الصالحة داخل النصوص المقتبسة لتجنب أخطاء التحليل
            $rawText = preg_replace_callback('/"([^"\\\\]|\\\\.)*"/', function($matches) {
                $str = $matches[0];
                // ترميز الشرطات المائلة العكسية غير الصالحة (ليست جزءاً من رمز مهرّب معتمد في JSON)
                $str = preg_replace('/\\\\(?!["\\\\\/bfnrtu])/', '\\\\\\\\', $str);
                // استبدال الأسطر والتبويبات الحقيقية بالرموز المهربة المقابلة
                return str_replace(["\r\n", "\r", "\n", "\t"], ['\n', '\n', '\n', '\t'], $str);
            }, $rawText);

            $articles = json_decode($rawText, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return response()->json([
                    'success' => false,
                    'message' => 'فشل في تحليل المخرجات من الذكاء الاصطناعي كـ JSON صالح: ' . json_last_error_msg(),
                    'raw' => $answer // إرجاع النص الخام الأصلي للمساعدة في تشخيص الخطأ
                ], 500);
            }

            return response()->json([
                'success' => true,
                'articles' => $articles
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ غير متوقع: ' . $e->getMessage()
            ], 500);
        }
    }

    // حفظ الخبر المولد في قاعدة البيانات مباشرة
    public function store(Request $request)
    {
        $request->validate([
            'news_category_id' => 'required|exists:news_category,id',
            'title' => 'required|string|max:255',
            'des' => 'nullable|string',
            'more_des' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        try {
            $save_url = null;

            if ($request->file('photo')) {
                $image = $request->file('photo');
                $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
                $path = public_path('upload/news/');

                $imageManager = new ImageManager(new Driver());
                $imageResized = $imageManager->read($image);
                $imageResized->save($path . $name_gen);

                $save_url = 'upload/news/' . $name_gen;
            }

            $news = News::create([
                'news_category_id' => $request->news_category_id,
                'title' => $request->title,
                'title_en' => $request->title, // تكرار المحتوى العربي لتلبية شروط قاعدة البيانات
                'des' => $request->des,
                'des_en' => $request->des, // تكرار المحتوى العربي لتلبية شروط قاعدة البيانات
                'more_des' => $request->more_des,
                'more_des_en' => $request->more_des, // تكرار المحتوى العربي لتلبية شروط قاعدة البيانات
                'photo' => $save_url,
                'show_in_ticker' => 0,
                'status' => 'active',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم نشر الخبر بنجاح وعرضه في الموقع!',
                'news_id' => $news->id
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل في حفظ الخبر: ' . $e->getMessage()
            ], 500);
        }
    }

    // استخراج مصفوفة أو كائن الـ JSON بشكل مرن يتجاهل النصوص التمهيدية والاقتباسات والمراجع الخارجية
    private function extractJson($text)
    {
        $length = strlen($text);
        $inString = false;
        $escape = false;
        $startChar = null;
        $endChar = null;
        $startPos = -1;
        $brackets = 0;

        for ($i = 0; $i < $length; $i++) {
            $char = $text[$i];

            if ($inString) {
                if ($escape) {
                    $escape = false;
                } elseif ($char === '\\') {
                    $escape = true;
                } elseif ($char === '"') {
                    $inString = false;
                }
            } else {
                if ($char === '"') {
                    $inString = true;
                } elseif ($startChar === null) {
                    if ($char === '[' || $char === '{') {
                        $startChar = $char;
                        $endChar = ($char === '[') ? ']' : '}';
                        $startPos = $i;
                        $brackets = 1;
                    }
                } else {
                    if ($char === $startChar) {
                        $brackets++;
                    } elseif ($char === $endChar) {
                        $brackets--;
                        if ($brackets === 0) {
                            return substr($text, $startPos, $i - $startPos + 1);
                        }
                    }
                }
            }
        }

        return null;
    }
}
