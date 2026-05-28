<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NewsController extends Controller
{
    // عرض كل الأخبار
    public function allNews()
    {
        $values = News::latest()->get();
        return view('admin.news.all_news', compact('values'));
    }

    // صفحة إضافة خبر جديد
    public function addNews()
    {
        $categories = NewsCategory::latest()->get();
        return view('admin.news.add_news', compact('categories'));
    }

    // تخزين خبر جديد
    public function storeNews(Request $request)
    {
        $request->validate([
            'news_category_id' => 'required|exists:news_category,id',
            'title' => 'required|string|max:255',
            'des' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'show_in_ticker' => 'nullable|boolean',
        ]);

        $save_url = null;

        if ($request->file('photo')) {
            $image = $request->file('photo');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/news/');

            $imageManager = new ImageManager(new Driver()); // or Imagick driver
            $imageResized = $imageManager->read($image); // no resizing
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/news/' . $name_gen;
        }

        News::create([
            'news_category_id' => $request->news_category_id,
            'title' => $request->title,
            'title_en' => $request->title,
            'des' => $request->des,
            'des_en' => $request->des,
            'photo' => $save_url,
            'more_des' => $request->more_des,
            'more_des_en' => $request->more_des,
            'show_in_ticker' => $request->show_in_ticker ? 1 : 0,
            'status' => 'active',
        ]);

        return redirect()->route('all.news')->with('success', 'تمت إضافة الخبر بنجاح');
    }

    // صفحة تعديل الخبر
    public function editNews($id)
    {
        $value = News::findOrFail($id);
        $categories = NewsCategory::latest()->get();
        return view('admin.news.edit_news', compact('value', 'categories'));
    }

    // تحديث الخبر
    public function editNewsStore(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:news,id',
            'news_category_id' => 'required|exists:news_category,id',
            'title' => 'required|string|max:255',
            'des' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png',
            'show_in_ticker' => 'nullable|boolean',
        ]);

        $news = News::findOrFail($request->id);
        $save_url = $news->photo;

        if ($request->file('photo')) {
            if ($news->photo && file_exists(public_path($news->photo))) {
                unlink(public_path($news->photo));
            }

            $image = $request->file('photo');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/news/');

            $imageManager = new ImageManager(new Driver()); // or Imagick driver
            $imageResized = $imageManager->read($image); // no resizing
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/news/' . $name_gen;
        }

        $news->update([
            'news_category_id' => $request->news_category_id,
            'title' => $request->title,
            'title_en' => $request->title,
            'des' => $request->des,
            'des_en' => $request->des,
            'photo' => $save_url,
            'more_des' => $request->more_des,
            'more_des_en' => $request->more_des,
            'show_in_ticker' => $request->show_in_ticker ? 1 : 0,
        ]);

        return redirect()->route('all.news')->with('success', 'تم تعديل الخبر بنجاح');
    }

    // حذف الخبر
    public function deleteNews($id)
    {
        $news = News::findOrFail($id);
        if ($news->photo && file_exists(public_path($news->photo))) {
            unlink(public_path($news->photo));
        }
        $news->delete();

        return redirect()->route('all.news')->with('success', 'تم حذف الخبر بنجاح');
    }

    // جعل الخبر غير نشط
    public function newsInactive($id)
    {
        News::findOrFail($id)->update(['status' => 'inactive']);
        return redirect()->route('all.news')->with('success', 'تم إخفاء الخبر');
    }

    // جعل الخبر نشط
    public function newsActive($id)
    {
        News::findOrFail($id)->update(['status' => 'active']);
        return redirect()->route('all.news')->with('success', 'تم إظهار الخبر');
    }
}
