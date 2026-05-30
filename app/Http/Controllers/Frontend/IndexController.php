<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Home;
use App\Models\News;
use App\Models\Planne;
use App\Models\Service;
use App\Models\TeamWork;
use App\Models\Companywork;
use App\Models\MainCounter;
use App\Models\SocialMedia;
use Illuminate\Http\Request;
use App\Models\CompanyClient;
use App\Models\HmakHelpCategory;
use App\Models\HmakHelpUserRequest;
use App\Models\HmakHelpAttachment;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\HomeSlider;
use App\Models\Article;

class IndexController extends Controller
{

    public function showHome()
    {

        $home = Home::latest()->get();

        // $companywork = Companywork::latest()->get();


                $companywork = Companywork::latest()->limit(4)->get();


        $mainCounter = MainCounter::latest()->get();

        // $service = Service::latest()->get();

        $service = Service::latest()->limit(6)->get();



        $planne = Planne::latest()->limit(3)->get();



        $teamWork = TeamWork::latest()->limit(4)->get();


        $companyClient = CompanyClient::latest()->get();

                $news = News::latest()->limit(3)->get();

                $categoriesWithNews = \App\Models\NewsCategory::latest()->get()->map(function($category) {
                    $category->latest_news = \App\Models\News::where('news_category_id', $category->id)
                        ->where('status', 'active')
                        ->latest()
                        ->limit(3)
                        ->get();
                    return $category;
                })->filter(function($category) {
                    return $category->latest_news->count() > 0;
                });

        $sliders = HomeSlider::latest()->get();
        $articles = Article::with('author')->latest()->limit(4)->get();

         return view('frontend.hmak.index',compact('home','companywork','mainCounter','service','planne','teamWork','companyClient','news','categoriesWithNews','sliders','articles'));
    }

    public function showArticleDetails($id)
    {
        $article = Article::with('author')->findOrFail($id);
        return view('frontend.hmak.pages.article_details', compact('article'));
    }


    public function showSoon()
    {
        // Generate math captcha for coming soon page
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        session(['captcha_num1' => $num1, 'captcha_num2' => $num2]);

        return view('frontend.soon', compact('num1', 'num2'));
    }

    public function showUserDashboard()
    {
        $home = Home::latest()->get();
        $user = Auth::user();
        
        $newsEyes = NewsEye::where('user_id', $user->id)->latest()->get();
        $getUserService = userService::where('user_id', $user->id)->latest()->get();
        $services = Service::all();
        $hmakHelpRequests = HmakHelpUserRequest::with(['category', 'attachments'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        $marketItems = \App\Models\MarketItem::with(['mainCategory', 'subCategory', 'subSubCategory'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('frontend.pages.user.services_dashboard', compact('home', 'user', 'newsEyes', 'getUserService', 'services', 'hmakHelpRequests', 'marketItems'));
    }

    public function myHmakHelpRequests()
    {
        $user = Auth::user();
        $requests = HmakHelpUserRequest::with(['category', 'attachments'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();
        
        return view('frontend.pages.user.my_hmak_help_requests', compact('requests'));
    }

    public function showSoundLibrary()
    {
        $categories = \App\Models\SoundLibraryCategory::withCount('sounds')->latest()->get();
        $authors = \App\Models\SoundAuthor::withCount('sounds')->latest()->get();
        return view('frontend.hmak.pages.sound_library.index', compact('categories', 'authors'));
    }

    public function showSoundLibraryCategory($id)
    {
        $category = \App\Models\SoundLibraryCategory::findOrFail($id);
        $sounds = \App\Models\SoundLibrary::with(['author'])
            ->where('sound_library_category_id', $id)
            ->oldest()
            ->get();
        return view('frontend.hmak.pages.sound_library.browse_category', compact('category', 'sounds'));
    }

    public function showSoundLibraryAuthor($id)
    {
        $author = \App\Models\SoundAuthor::findOrFail($id);
        $sounds = \App\Models\SoundLibrary::with(['category'])
            ->where('sound_author_id', $id)
            ->latest()
            ->get();
        return view('frontend.hmak.pages.sound_library.browse_author', compact('author', 'sounds'));
    }

    public function showMarket()
    {
        $categories = \App\Models\MarketMainCategory::with('subCategories')->latest()->get();
        return view('frontend.hmak.pages.market', compact('categories'));
    }

    public function showMarketMain($id, Request $request)
    {
        $category = \App\Models\MarketMainCategory::with('subCategories')->findOrFail($id);
        $subcategories = $category->subCategories;
        
        $query = \App\Models\MarketItem::where('market_main_category_id', $id)
            ->where('status', 'active');
            
        // Sorting logic
        $sort = $request->query('sort', 'latest');
        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
        
        $items = $query->get();
        
        return view('frontend.hmak.pages.market_main_browse', compact('category', 'subcategories', 'items', 'sort'));
    }

    public function showMarketSub($id, Request $request)
    {
        $subcategory = \App\Models\MarketSubCategory::with(['subSubCategories', 'mainCategory'])->findOrFail($id);
        $subsubcategories = $subcategory->subSubCategories;
        
        $query = \App\Models\MarketItem::where('market_sub_category_id', $id)
            ->where('status', 'active');
            
        // Sorting logic
        $sort = $request->query('sort', 'latest');
        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
        
        $items = $query->get();
        
        return view('frontend.hmak.pages.market_sub_browse', compact('subcategory', 'subsubcategories', 'items', 'sort'));
    }

    public function showMarketSubSub($id, Request $request)
    {
        $subsubcategory = \App\Models\MarketSubSubCategory::with(['subCategory.mainCategory'])->findOrFail($id);
        
        $query = \App\Models\MarketItem::where('market_sub_sub_category_id', $id)
            ->where('status', 'active');
            
        // Sorting logic
        $sort = $request->query('sort', 'latest');
        if ($sort == 'price_asc') {
            $query->orderBy('price', 'asc');
        } elseif ($sort == 'price_desc') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest();
        }
        
        $items = $query->get();
        
        return view('frontend.hmak.pages.market_subsub_browse', compact('subsubcategory', 'items', 'sort'));
    }

    public function createMarketItem()
    {
        $mainCategories = \App\Models\MarketMainCategory::orderBy('name', 'asc')->get();
        return view('frontend.hmak.pages.add_market_item', compact('mainCategories'));
    }

    public function getSubcategories($main_id)
    {
        $subcategories = \App\Models\MarketSubCategory::where('market_main_category_id', $main_id)
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($subcategories);
    }

    public function getSubSubcategories($sub_id)
    {
        $subsubcategories = \App\Models\MarketSubSubCategory::where('market_sub_category_id', $sub_id)
            ->orderBy('name', 'asc')
            ->get();
        return response()->json($subsubcategories);
    }

    public function storeMarketItem(Request $request)
    {
        $request->validate([
            'market_main_category_id' => 'required|exists:market_main_categories,id',
            'market_sub_category_id' => 'required|exists:market_sub_categories,id',
            'market_sub_sub_category_id' => 'nullable|exists:market_sub_sub_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'phone' => 'required|string|max:50',
            'whatsapp' => 'required|string|max:50',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'video' => 'nullable|file|mimes:mp4,mov,avi,webm|max:20480', // Max 20MB short video
        ], [
            'market_main_category_id.required' => '⚠️ الرجاء اختيار القسم الرئيسي',
            'market_sub_category_id.required' => '⚠️ الرجاء اختيار القسم الفرعي',
            'name.required' => '⚠️ الرجاء إدخال اسم المنتج أو الخدمة',
            'phone.required' => '⚠️ رقم الهاتف للتواصل مطلوب',
            'whatsapp.required' => '⚠️ رقم الواتساب للتواصل مطلوب',
            'image_path.required' => '⚠️ الصورة الأساسية للمنتج مطلوبة',
            'image_path.image' => '⚠️ الملف المرفوع للملف الأساسي يجب أن يكون صورة',
            'video.mimes' => '⚠️ صيغة الفيديو غير مدعومة (يجب أن يكون mp4, mov, avi, webm)',
            'video.max' => '⚠️ يجب ألا يتجاوز حجم الفيديو 20 ميجابايت',
        ]);

        // 1. Upload Main Cover Image
        $save_url = null;
        if ($request->file('image_path')) {
            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/items/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            $imageResized = $imageManager->read($image)->resize(500, 500);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/items/' . $name_gen;
        }

        // 2. Create the Market Item
        $item = \App\Models\MarketItem::create([
            'user_id' => \Auth::id(),
            'market_main_category_id' => $request->market_main_category_id,
            'market_sub_category_id' => $request->market_sub_category_id,
            'market_sub_sub_category_id' => $request->market_sub_sub_category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp,
            'image_path' => $save_url,
            'status' => 'active'
        ]);

        // 3. Upload Additional Images (Attachments)
        if ($request->hasFile('images')) {
            $pathAttach = public_path('upload/market/attachments/');
            if (!file_exists($pathAttach)) {
                mkdir($pathAttach, 0777, true);
            }

            $imageManager = new \Intervention\Image\ImageManager(new \Intervention\Image\Drivers\Gd\Driver());
            
            foreach ($request->file('images') as $file) {
                $nameGenAttach = hexdec(uniqid()) . '.' . $file->getClientOriginalExtension();
                $imageResizedAttach = $imageManager->read($file)->resize(500, 500);
                $imageResizedAttach->save($pathAttach . $nameGenAttach);

                \App\Models\MarketItemAttachment::create([
                    'market_item_id' => $item->id,
                    'attachment_name' => $file->getClientOriginalName(),
                    'attachment_path' => 'upload/market/attachments/' . $nameGenAttach,
                    'type' => 'image'
                ]);
            }
        }

        // 4. Upload Optional Video Attachment
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $nameGenVideo = hexdec(uniqid()) . '.' . $video->getClientOriginalExtension();
            $pathVideo = public_path('upload/market/attachments/');

            if (!file_exists($pathVideo)) {
                mkdir($pathVideo, 0777, true);
            }

            $video->move($pathVideo, $nameGenVideo);

            \App\Models\MarketItemAttachment::create([
                'market_item_id' => $item->id,
                'attachment_name' => $video->getClientOriginalName(),
                'attachment_path' => 'upload/market/attachments/' . $nameGenVideo,
                'type' => 'video'
            ]);
        }

        // Redirect to the most specific category page that contains the new item
        if ($item->market_sub_sub_category_id) {
            return redirect()
                ->route('market.public.subsub', $item->market_sub_sub_category_id)
                ->with('success', 'تم إضافة إعلانك بنجاح وهو معروض الآن في القسم! 🎉');
        }

        return redirect()
            ->route('market.public.sub', $item->market_sub_category_id)
            ->with('success', 'تم إضافة إعلانك بنجاح وهو معروض الآن في القسم! 🎉');

    }

    public function showMarketItemDetails($id)
    {
        $item = \App\Models\MarketItem::with(['attachments', 'mainCategory', 'subCategory', 'subSubCategory', 'user'])->findOrFail($id);
        
        // Fetch related products in the same subcategory
        $relatedItems = \App\Models\MarketItem::where('market_sub_category_id', $item->market_sub_category_id)
            ->where('id', '!=', $item->id)
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        return view('frontend.hmak.pages.market_item_details', compact('item', 'relatedItems'));
    }

    // ==========================================
    // HAMAK AL-KHAIR (FRONTEND)
    // ==========================================

    public function showHmakHelp()
    {
        $categories = HmakHelpCategory::latest()->get();
        return view('frontend.hmak.pages.hmak_help.index', compact('categories'));
    }

    public function createHmakHelpRequest($category_id)
    {
        $category = HmakHelpCategory::findOrFail($category_id);
        return view('frontend.hmak.pages.hmak_help.create_request', compact('category'));
    }

    public function storeHmakHelpRequest(Request $request)
    {
        $request->validate([
            'hmak_help_category_id' => 'required|exists:hmak_help_categories,id',
            'description' => 'required|string',
            'address' => 'nullable|string',
            'phone' => 'required|string|max:50',
            'nationality' => 'nullable|string|max:255',
            'current_location' => 'nullable|string|max:255',
            'files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,mp4,mov,avi,webm|max:20480', // Max 20MB per file
        ], [
            'description.required' => '⚠️ الرجاء إدخال شرح أو تفاصيل طلب المساعدة',
            'phone.required' => '⚠️ رقم الهاتف للتواصل مطلوب',
            'files.*.mimes' => '⚠️ صيغة الملف غير مدعومة (يجب أن يكون صورة، فيديو، أو ملف PDF)',
            'files.*.max' => '⚠️ حجم الملف يجب ألا يتجاوز 20 ميجابايت',
        ]);

        $helpRequest = HmakHelpUserRequest::create([
            'user_id' => Auth::id(),
            'hmak_help_category_id' => $request->hmak_help_category_id,
            'description' => $request->description,
            'address' => $request->address,
            'phone' => $request->phone,
            'nationality' => $request->nationality,
            'current_location' => $request->current_location,
            'status' => 'pending',
        ]);

        if ($request->hasFile('files')) {
            $path = public_path('upload/help_attachments/');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            foreach ($request->file('files') as $file) {
                $extension = strtolower($file->getClientOriginalExtension());
                $nameGen = hexdec(uniqid()) . '.' . $extension;
                $file->move($path, $nameGen);

                $type = 'image';
                if (in_array($extension, ['mp4', 'mov', 'avi', 'webm'])) {
                    $type = 'video';
                } elseif ($extension === 'pdf') {
                    $type = 'pdf';
                }

                HmakHelpAttachment::create([
                    'hmak_help_user_request_id' => $helpRequest->id,
                    'file_path' => 'upload/help_attachments/' . $nameGen,
                    'type' => $type,
                ]);
            }
        }

        return redirect()->route('front.help.success');
    }

    public function showHelpSuccess()
    {
        return view('frontend.hmak.pages.hmak_help.success');
    }

    public function createCompetition()
    {
        $categories = \App\Models\Category::where('status', 'active')->latest()->get();
        return view('frontend.hmak.pages.create_competition', compact('categories'));
    }

    public function storeCompetition(Request $request)
    {
        $request->validate([
            'game_name' => 'required|string|max:255',
            'players_count' => 'required|integer|min:2|max:4',
            'categories' => 'required|array|size:6',
            'categories.*' => 'required|integer|exists:categories,id',
        ], [
            'game_name.required' => 'يرجى إدخال اسم اللعبة.',
            'players_count.required' => 'يرجى تحديد عدد اللاعبين.',
            'players_count.min' => 'يجب اختيار لاعبين على الأقل.',
            'players_count.max' => 'الحد الأقصى للاعبين هو 4.',
            'categories.required' => 'يرجى اختيار الفئات.',
            'categories.size' => 'يجب اختيار 6 فئات بالضبط.',
        ]);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            $game = \App\Models\Game::create([
                'game_name' => $request->game_name,
                'user_id_created' => Auth::id(),
                'created_at' => \Carbon\Carbon::now(),
            ]);

            foreach ($request->categories as $categoryId) {
                \App\Models\GamesCategories::create([
                    'game_id' => $game->id,
                    'category_id' => $categoryId,
                    'created_at' => \Carbon\Carbon::now(),
                ]);
            }

            $playersCount = (int)$request->players_count;
            $playerNames = $request->input('player_names', []);
            for ($i = 1; $i <= $playersCount; $i++) {
                $customName = isset($playerNames[$i - 1]) && !empty(trim($playerNames[$i - 1]))
                    ? trim($playerNames[$i - 1])
                    : 'اللاعب ' . $i;

                \App\Models\Team::create([
                    'team_name' => $customName,
                    'number_members' => 1,
                    'result' => 0,
                    'game_id' => $game->id,
                    'created_at' => \Carbon\Carbon::now(),
                ]);
            }

            \Illuminate\Support\Facades\DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'تم إنشاء اللعبة بنجاح!',
                'game' => $game->load('categories', 'teams', 'team'),
            ], 200);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ اللعبة: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function playCompetition($id)
    {
        $game = \App\Models\Game::with(['categories', 'teams', 'team'])->findOrFail($id);

        $answeredQuestionIds = \App\Models\QuestionsRegister::where('game_id', $id)
            ->pluck('question_id')
            ->toArray();

        $board = [];
        foreach ($game->categories as $category) {
            $q200 = \App\Models\Question::with('answers')
                ->where('category_id', $category->id)
                ->where('qu_points', 200)
                ->orderBy('id')
                ->take(2)
                ->get();

            $q400 = \App\Models\Question::with('answers')
                ->where('category_id', $category->id)
                ->where('qu_points', 400)
                ->orderBy('id')
                ->take(2)
                ->get();

            $q600 = \App\Models\Question::with('answers')
                ->where('category_id', $category->id)
                ->where('qu_points', 600)
                ->orderBy('id')
                ->take(2)
                ->get();

            $categoryQuestions = $q200->merge($q400)->merge($q600);

            $board[$category->id] = [
                'category' => $category,
                'questions' => $categoryQuestions
            ];
        }

        return view('frontend.hmak.pages.play_competition', compact('game', 'board', 'answeredQuestionIds'));
    }

    public function answerQuestion(Request $request, $id)
    {
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'team_id' => 'nullable|exists:teams,id',
        ]);

        $question = \App\Models\Question::findOrFail($request->question_id);

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            \App\Models\QuestionsRegister::create([
                'game_id' => $id,
                'team_id' => $request->team_id,
                'question_id' => $request->question_id,
                'answer' => $request->team_id ? 1 : 0,
                'created_at' => \Carbon\Carbon::now(),
            ]);

            if ($request->team_id) {
                $team = \App\Models\Team::findOrFail($request->team_id);
                $team->increment('result', $question->qu_points);
            }

            \Illuminate\Support\Facades\DB::commit();

            $game = \App\Models\Game::with('categories')->findOrFail($id);
            
            // Calculate total questions on the board
            $totalQuestionsCount = 0;
            foreach ($game->categories as $category) {
                $q200Count = \App\Models\Question::where('category_id', $category->id)->where('qu_points', 200)->orderBy('id')->take(2)->count();
                $q400Count = \App\Models\Question::where('category_id', $category->id)->where('qu_points', 400)->orderBy('id')->take(2)->count();
                $q600Count = \App\Models\Question::where('category_id', $category->id)->where('qu_points', 600)->orderBy('id')->take(2)->count();
                $totalQuestionsCount += ($q200Count + $q400Count + $q600Count);
            }

            $answeredCount = \App\Models\QuestionsRegister::where('game_id', $id)->count();
            
            $gameFinished = false;
            $winners = [];
            
            $teams = \App\Models\Team::where('game_id', $id)->get();

            if ($totalQuestionsCount > 0 && $answeredCount >= $totalQuestionsCount) {
                $gameFinished = true;
                $maxScore = $teams->max('result');
                $winners = $teams->where('result', $maxScore)->values();
                
                if ($winners->isNotEmpty()) {
                    \App\Models\Game::where('id', $id)->update([
                        'team_id_winner' => $winners->first()->id
                    ]);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'تم تسجيل الإجابة بنجاح.',
                'teams' => $teams,
                'game_finished' => $gameFinished,
                'winners' => $winners,
            ], 200);

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء حفظ الإجابة: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function deleteMarketItem($id)
    {
        $item = \App\Models\MarketItem::with('attachments')->where('user_id', \Auth::id())->findOrFail($id);
        
        // Delete main image
        if ($item->image_path) {
            $mainImagePath = public_path($item->image_path);
            if (file_exists($mainImagePath)) {
                @unlink($mainImagePath);
            }
        }
        
        // Delete attachments
        foreach ($item->attachments as $attachment) {
            if ($attachment->attachment_path) {
                $attachPath = public_path($attachment->attachment_path);
                if (file_exists($attachPath)) {
                    @unlink($attachPath);
                }
            }
            $attachment->delete();
        }
        
        $item->delete();
        
        return redirect()->back()->with('success', 'تم حذف المنتج بنجاح! 🎉');
    }
}

