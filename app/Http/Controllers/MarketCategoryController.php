<?php

namespace App\Http\Controllers;

use App\Models\MarketMainCategory;
use App\Models\MarketSubCategory;
use App\Models\MarketSubSubCategory;
use App\Models\MarketItem;
use App\Models\MarketItemAttachment;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class MarketCategoryController extends Controller
{
    // ==========================================
    // 1. الفئات الرئيسية (MarketMainCategory)
    // ==========================================

    public function mainIndex()
    {
        $categories = MarketMainCategory::latest()->get();
        return view('admin.market_main_category.all', compact('categories'));
    }

    public function mainCreate()
    {
        return view('admin.market_main_category.add');
    }

    public function mainStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => '⚠️ الرجاء إدخال اسم الفئة الرئيسية',
            'name.string' => '⚠️ الرجاء التأكد من كتابة الاسم بشكل صحيح',
            'name.max' => '⚠️ يجب ألا يتجاوز الاسم 255 حرفاً',
            'image_path.image' => '⚠️ الملف المرفوع يجب أن يكون صورة',
            'image_path.mimes' => '⚠️ صيغة الصورة يجب أن تكون jpeg, png, jpg, gif, webp',
            'image_path.max' => '⚠️ يجب ألا يتجاوز حجم الصورة 2 ميجابايت',
        ]);

        $save_url = null;

        if ($request->file('image_path')) {
            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/main_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image)->resize(350, 350);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/main_category/' . $name_gen;
        }

        MarketMainCategory::create([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم إضافة الفئة الرئيسية بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.main_categories.index')->with($notification);
    }

    public function mainEdit($id)
    {
        $category = MarketMainCategory::findOrFail($id);
        return view('admin.market_main_category.edit', compact('category'));
    }

    public function mainUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:market_main_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'name.required' => '⚠️ الرجاء إدخال اسم الفئة الرئيسية',
            'image_path.image' => '⚠️ الملف المرفوع يجب أن يكون صورة',
        ]);

        $category = MarketMainCategory::findOrFail($request->id);
        $save_url = $category->image_path;

        if ($request->file('image_path')) {
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
            }

            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/main_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image)->resize(350, 350);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/main_category/' . $name_gen;
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم تعديل الفئة الرئيسية بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.main_categories.index')->with($notification);
    }

    public function mainDelete($id)
    {
        $category = MarketMainCategory::findOrFail($id);

        if ($category->image_path && file_exists(public_path($category->image_path))) {
            unlink(public_path($category->image_path));
        }

        $category->delete();

        $notification = [
            'message' => 'تم حذف الفئة الرئيسية بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.main_categories.index')->with($notification);
    }


    // ==========================================
    // 2. الفئات الفرعية (MarketSubCategory)
    // ==========================================

    public function subIndex()
    {
        $subcategories = MarketSubCategory::with('mainCategory')->latest()->get();
        return view('admin.market_sub_category.all', compact('subcategories'));
    }

    public function subCreate()
    {
        $mainCategories = MarketMainCategory::orderBy('name', 'asc')->get();
        return view('admin.market_sub_category.add', compact('mainCategories'));
    }

    public function subStore(Request $request)
    {
        $request->validate([
            'market_main_category_id' => 'required|exists:market_main_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'market_main_category_id.required' => '⚠️ الرجاء اختيار الفئة الرئيسية',
            'market_main_category_id.exists' => '⚠️ الفئة الرئيسية المحددة غير صالحة',
            'name.required' => '⚠️ الرجاء إدخال اسم الفئة الفرعية',
            'image_path.image' => '⚠️ الملف المرفوع يجب أن يكون صورة',
        ]);

        $save_url = null;

        if ($request->file('image_path')) {
            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/sub_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image)->resize(350, 350);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/sub_category/' . $name_gen;
        }

        MarketSubCategory::create([
            'market_main_category_id' => $request->market_main_category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم إضافة الفئة الفرعية بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.sub_categories.index')->with($notification);
    }

    public function subEdit($id)
    {
        $subcategory = MarketSubCategory::findOrFail($id);
        $mainCategories = MarketMainCategory::orderBy('name', 'asc')->get();
        return view('admin.market_sub_category.edit', compact('subcategory', 'mainCategories'));
    }

    public function subUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:market_sub_categories,id',
            'market_main_category_id' => 'required|exists:market_main_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'market_main_category_id.required' => '⚠️ الرجاء اختيار الفئة الرئيسية',
            'name.required' => '⚠️ الرجاء إدخال اسم الفئة الفرعية',
        ]);

        $subcategory = MarketSubCategory::findOrFail($request->id);
        $save_url = $subcategory->image_path;

        if ($request->file('image_path')) {
            if ($subcategory->image_path && file_exists(public_path($subcategory->image_path))) {
                unlink(public_path($subcategory->image_path));
            }

            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/sub_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image)->resize(350, 350);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/sub_category/' . $name_gen;
        }

        $subcategory->update([
            'market_main_category_id' => $request->market_main_category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم تعديل الفئة الفرعية بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.sub_categories.index')->with($notification);
    }

    public function subDelete($id)
    {
        $subcategory = MarketSubCategory::findOrFail($id);

        if ($subcategory->image_path && file_exists(public_path($subcategory->image_path))) {
            unlink(public_path($subcategory->image_path));
        }

        $subcategory->delete();

        $notification = [
            'message' => 'تم حذف الفئة الفرعية بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.sub_categories.index')->with($notification);
    }


    // ==========================================
    // 3. الفئات الفرعية المتفرعة (MarketSubSubCategory)
    // ==========================================

    public function subSubIndex()
    {
        $subsubcategories = MarketSubSubCategory::with('subCategory.mainCategory')->latest()->get();
        return view('admin.market_sub_sub_category.all', compact('subsubcategories'));
    }

    public function subSubCreate()
    {
        $subCategories = MarketSubCategory::with('mainCategory')->orderBy('name', 'asc')->get();
        return view('admin.market_sub_sub_category.add', compact('subCategories'));
    }

    public function subSubStore(Request $request)
    {
        $request->validate([
            'market_sub_category_id' => 'required|exists:market_sub_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'market_sub_category_id.required' => '⚠️ الرجاء اختيار الفئة الفرعية التابعة لها',
            'market_sub_category_id.exists' => '⚠️ الفئة الفرعية المحددة غير صالحة',
            'name.required' => '⚠️ الرجاء إدخال اسم الفئة الفرعية المتفرعة',
            'image_path.image' => '⚠️ الملف المرفوع يجب أن يكون صورة',
        ]);

        $save_url = null;

        if ($request->file('image_path')) {
            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/sub_sub_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image)->resize(350, 350);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/sub_sub_category/' . $name_gen;
        }

        MarketSubSubCategory::create([
            'market_sub_category_id' => $request->market_sub_category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم إضافة الفئة الفرعية المتفرعة بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.sub_sub_categories.index')->with($notification);
    }

    public function subSubEdit($id)
    {
        $subsubcategory = MarketSubSubCategory::findOrFail($id);
        $subCategories = MarketSubCategory::with('mainCategory')->orderBy('name', 'asc')->get();
        return view('admin.market_sub_sub_category.edit', compact('subsubcategory', 'subCategories'));
    }

    public function subSubUpdate(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:market_sub_sub_categories,id',
            'market_sub_category_id' => 'required|exists:market_sub_categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_path' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'market_sub_category_id.required' => '⚠️ الرجاء اختيار الفئة الفرعية',
            'name.required' => '⚠️ الرجاء إدخال اسم الفئة الفرعية المتفرعة',
        ]);

        $subsubcategory = MarketSubSubCategory::findOrFail($request->id);
        $save_url = $subsubcategory->image_path;

        if ($request->file('image_path')) {
            if ($subsubcategory->image_path && file_exists(public_path($subsubcategory->image_path))) {
                unlink(public_path($subsubcategory->image_path));
            }

            $image = $request->file('image_path');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
            $path = public_path('upload/market/sub_sub_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image)->resize(350, 350);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/market/sub_sub_category/' . $name_gen;
        }

        $subsubcategory->update([
            'market_sub_category_id' => $request->market_sub_category_id,
            'name' => $request->name,
            'description' => $request->description,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم تعديل الفئة الفرعية المتفرعة بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.sub_sub_categories.index')->with($notification);
    }

    public function subSubDelete($id)
    {
        $subsubcategory = MarketSubSubCategory::findOrFail($id);

        if ($subsubcategory->image_path && file_exists(public_path($subsubcategory->image_path))) {
            unlink(public_path($subsubcategory->image_path));
        }

        $subsubcategory->delete();

        $notification = [
            'message' => 'تم حذف الفئة الفرعية المتفرعة بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('market.sub_sub_categories.index')->with($notification);
    }

    // ==========================================
    // 4. إدارة المنتجات المضافة من المستخدمين (MarketItem)
    // ==========================================

    public function itemsIndex()
    {
        $items = MarketItem::with(['user', 'mainCategory', 'subCategory', 'subSubCategory'])->latest()->get();
        return view('admin.market_item.all', compact('items'));
    }

    public function itemsToggleStatus($id)
    {
        $item = MarketItem::findOrFail($id);
        $newStatus = ($item->status == 'active') ? 'inactive' : 'active';
        $item->update(['status' => $newStatus]);

        $notification = [
            'message' => 'تم تغيير حالة المنتج بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }

    public function itemsDelete($id)
    {
        $item = MarketItem::findOrFail($id);

        // Delete attachments files and records
        $attachments = MarketItemAttachment::where('market_item_id', $item->id)->get();
        foreach ($attachments as $attachment) {
            if ($attachment->attachment_path && file_exists(public_path($attachment->attachment_path))) {
                unlink(public_path($attachment->attachment_path));
            }
            $attachment->delete();
        }

        // Delete main image if exists
        if ($item->image_path && file_exists(public_path($item->image_path))) {
            unlink(public_path($item->image_path));
        }

        $item->delete();

        $notification = [
            'message' => 'تم حذف المنتج بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->back()->with($notification);
    }
}
