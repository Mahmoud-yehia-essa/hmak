<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\TeamWork;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // ✅ عرض كل المقالات
    public function allArticles()
    {
        $articles = Article::with('author')->latest()->get();
        return view('admin.article.all_article', compact('articles'));
    }

    // ✅ صفحة إضافة مقال جديد
    public function addArticle()
    {
        $authors = TeamWork::latest()->get();
        return view('admin.article.add_article', compact('authors'));
    }

    // ✅ تخزين المقال الجديد
    public function storeArticle(Request $request)
    {
        $request->validate([
            'title'             => 'required|string|max:255',
            'team_work_id'      => 'nullable|exists:team_works,id',
            'short_description' => 'nullable|string',
            'long_description'  => 'nullable|string',
            'image_path'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ], [
            'title.required'    => 'عنوان المقال مطلوب',
            'image_path.image'  => 'يجب أن يكون الملف المرفوع صورة',
            'image_path.mimes'  => 'الصيغ المدعومة هي: jpg, jpeg, png, gif, webp',
            'image_path.max'    => 'حجم الصورة يجب ألا يتجاوز 4 ميجابايت',
        ]);

        $save_path = null;
        if ($request->hasFile('image_path')) {
            $image = $request->file('image_path');
            $filename = date('YmdHi') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/articles/');
            
            // إنشاء المجلد إذا لم يكن موجوداً
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image->move($path, $filename);
            $save_path = 'upload/articles/' . $filename;
        }

        Article::create([
            'title'             => $request->title,
            'team_work_id'      => $request->team_work_id,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'image_path'        => $save_path,
        ]);

        $notification = array(
            'message' => 'تمت إضافة المقال بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('all.articles')->with($notification);
    }

    // ✅ صفحة تعديل المقال
    public function editArticle($id)
    {
        $article = Article::findOrFail($id);
        $authors = TeamWork::latest()->get();
        return view('admin.article.edit_article', compact('article', 'authors'));
    }

    // ✅ تحديث المقال
    public function updateArticleStore(Request $request)
    {
        $request->validate([
            'id'                => 'required|exists:articles,id',
            'title'             => 'required|string|max:255',
            'team_work_id'      => 'nullable|exists:team_works,id',
            'short_description' => 'nullable|string',
            'long_description'  => 'nullable|string',
            'image_path'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ], [
            'title.required'    => 'عنوان المقال مطلوب',
            'image_path.image'  => 'يجب أن يكون الملف المرفوع صورة',
            'image_path.mimes'  => 'الصيغ المدعومة هي: jpg, jpeg, png, gif, webp',
            'image_path.max'    => 'حجم الصورة يجب ألا يتجاوز 4 ميجابايت',
        ]);

        $article = Article::findOrFail($request->id);
        $save_path = $article->image_path;

        if ($request->hasFile('image_path')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($article->image_path && file_exists(public_path($article->image_path))) {
                unlink(public_path($article->image_path));
            }

            $image = $request->file('image_path');
            $filename = date('YmdHi') . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/articles/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $image->move($path, $filename);
            $save_path = 'upload/articles/' . $filename;
        }

        $article->update([
            'title'             => $request->title,
            'team_work_id'      => $request->team_work_id,
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'image_path'        => $save_path,
        ]);

        $notification = array(
            'message' => 'تم تعديل المقال بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('all.articles')->with($notification);
    }

    // ✅ حذف المقال
    public function deleteArticle($id)
    {
        $article = Article::findOrFail($id);

        if ($article->image_path && file_exists(public_path($article->image_path))) {
            unlink(public_path($article->image_path));
        }

        $article->delete();

        $notification = array(
            'message' => 'تم حذف المقال بنجاح',
            'alert-type' => 'success'
        );

        return redirect()->route('all.articles')->with($notification);
    }
}
