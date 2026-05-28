<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NewsCategoryController extends Controller
{
    // عرض كل التصنيفات
    public function allNewsCategories()
    {
        $values = NewsCategory::latest()->get();
        return view('admin.news_category.all_news_categories', compact('values'));
    }

    // صفحة إضافة تصنيف جديد
    public function addNewsCategory()
    {
        return view('admin.news_category.add_news_category');
    }

    // تخزين تصنيف جديد
    public function storeNewsCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $save_url = null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/news_category/');

            // Ensure directory exists
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/news_category/' . $name_gen;
        }

        NewsCategory::create([
            'name' => $request->name,
            'image' => $save_url,
        ]);

        return redirect()->route('all.news.categories')->with('success', 'تمت إضافة التصنيف بنجاح');
    }

    // صفحة تعديل التصنيف
    public function editNewsCategory($id)
    {
        $value = NewsCategory::findOrFail($id);
        return view('admin.news_category.edit_news_category', compact('value'));
    }

    // تحديث التصنيف
    public function editNewsCategoryStore(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:news_category,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png',
        ]);

        $category = NewsCategory::findOrFail($request->id);
        $save_url = $category->image;

        if ($request->file('image')) {
            if ($category->image && file_exists(public_path($category->image))) {
                unlink(public_path($category->image));
            }

            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/news_category/');

            // Ensure directory exists
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/news_category/' . $name_gen;
        }

        $category->update([
            'name' => $request->name,
            'image' => $save_url,
        ]);

        return redirect()->route('all.news.categories')->with('success', 'تم تعديل التصنيف بنجاح');
    }

    // حذف التصنيف
    public function deleteNewsCategory($id)
    {
        $category = NewsCategory::findOrFail($id);
        if ($category->image && file_exists(public_path($category->image))) {
            unlink(public_path($category->image));
        }
        $category->delete();

        return redirect()->route('all.news.categories')->with('success', 'تم حذف التصنيف بنجاح');
    }
}
