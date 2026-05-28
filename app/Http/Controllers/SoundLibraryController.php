<?php

namespace App\Http\Controllers;

use App\Models\SoundLibraryCategory;
use App\Models\SoundAuthor;
use App\Models\SoundLibrary;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class SoundLibraryController extends Controller
{
    // ==========================================
    // 1. SOUND LIBRARY CATEGORIES CRUD
    // ==========================================

    public function allSoundCategories()
    {
        $categories = SoundLibraryCategory::latest()->get();
        return view('admin.sound_category.all_categories', compact('categories'));
    }

    public function addSoundCategory()
    {
        return view('admin.sound_category.add_category');
    }

    public function storeSoundCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $save_url = null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/sound_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/sound_category/' . $name_gen;
        }

        SoundLibraryCategory::create([
            'name' => $request->name,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم إضافة فئة الصوتيات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.categories')->with($notification);
    }

    public function editSoundCategory($id)
    {
        $category = SoundLibraryCategory::findOrFail($id);
        return view('admin.sound_category.edit_category', compact('category'));
    }

    public function updateSoundCategory(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sound_library_categories,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $category = SoundLibraryCategory::findOrFail($request->id);
        $save_url = $category->image_path;

        if ($request->file('image')) {
            if ($category->image_path && file_exists(public_path($category->image_path))) {
                unlink(public_path($category->image_path));
            }

            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/sound_category/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/sound_category/' . $name_gen;
        }

        $category->update([
            'name' => $request->name,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم تعديل فئة الصوتيات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.categories')->with($notification);
    }

    public function deleteSoundCategory($id)
    {
        $category = SoundLibraryCategory::findOrFail($id);

        if ($category->image_path && file_exists(public_path($category->image_path))) {
            unlink(public_path($category->image_path));
        }

        $category->delete();

        $notification = [
            'message' => 'تم حذف فئة الصوتيات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.categories')->with($notification);
    }


    // ==========================================
    // 2. SOUND AUTHORS CRUD
    // ==========================================

    public function allSoundAuthors()
    {
        $authors = SoundAuthor::latest()->get();
        return view('admin.sound_author.all_authors', compact('authors'));
    }

    public function addSoundAuthor()
    {
        return view('admin.sound_author.add_author');
    }

    public function storeSoundAuthor(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $save_url = null;

        if ($request->file('image')) {
            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/sound_author/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/sound_author/' . $name_gen;
        }

        SoundAuthor::create([
            'name' => $request->name,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم إضافة مؤلف الصوتيات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.authors')->with($notification);
    }

    public function editSoundAuthor($id)
    {
        $author = SoundAuthor::findOrFail($id);
        return view('admin.sound_author.edit_author', compact('author'));
    }

    public function updateSoundAuthor(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sound_authors,id',
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp',
        ]);

        $author = SoundAuthor::findOrFail($request->id);
        $save_url = $author->image_path;

        if ($request->file('image')) {
            if ($author->image_path && file_exists(public_path($author->image_path))) {
                unlink(public_path($author->image_path));
            }

            $image = $request->file('image');
            $name_gen = date('YmdHi') . '_' . $image->getClientOriginalName();
            $path = public_path('upload/sound_author/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $imageManager = new ImageManager(new Driver());
            $imageResized = $imageManager->read($image);
            $imageResized->save($path . $name_gen);

            $save_url = 'upload/sound_author/' . $name_gen;
        }

        $author->update([
            'name' => $request->name,
            'image_path' => $save_url,
        ]);

        $notification = [
            'message' => 'تم تعديل مؤلف الصوتيات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.authors')->with($notification);
    }

    public function deleteSoundAuthor($id)
    {
        $author = SoundAuthor::findOrFail($id);

        if ($author->image_path && file_exists(public_path($author->image_path))) {
            unlink(public_path($author->image_path));
        }

        $author->delete();

        $notification = [
            'message' => 'تم حذف مؤلف الصوتيات بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.authors')->with($notification);
    }


    // ==========================================
    // 3. SOUND LIBRARIES CRUD (ACTUAL SOUNDS)
    // ==========================================

    public function allSoundLibraries()
    {
        $sounds = SoundLibrary::with(['category', 'author'])->latest()->get();
        return view('admin.sound_library.all_sounds', compact('sounds'));
    }

    public function addSoundLibrary()
    {
        $categories = SoundLibraryCategory::orderBy('name', 'asc')->get();
        $authors = SoundAuthor::orderBy('name', 'asc')->get();
        return view('admin.sound_library.add_sound', compact('categories', 'authors'));
    }

    public function storeSoundLibrary(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'sound_library_category_id' => 'required|exists:sound_library_categories,id',
            'sound_author_id' => 'nullable|exists:sound_authors,id',
            'sound_type' => 'required|in:recorded,live,report,episode',
            'sound_url' => 'nullable|string|max:1000',
            'sound_file' => 'nullable|file|mimes:mp3,wav,ogg,aac,m4a,flac|max:51200', // max 50MB
        ]);

        $save_file = null;

        if ($request->file('sound_file')) {
            $file = $request->file('sound_file');
            $name_gen = date('YmdHi') . '_' . $file->getClientOriginalName();
            $path = public_path('upload/sounds/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $name_gen);
            $save_file = 'upload/sounds/' . $name_gen;
        }

        SoundLibrary::create([
            'name' => $request->name,
            'sound_library_category_id' => $request->sound_library_category_id,
            'sound_author_id' => $request->sound_author_id,
            'sound_type' => $request->sound_type,
            'sound_url' => $request->sound_url,
            'sound_file_path' => $save_file,
        ]);

        $notification = [
            'message' => 'تم إضافة الملف الصوتي بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.libraries')->with($notification);
    }

    public function editSoundLibrary($id)
    {
        $sound = SoundLibrary::findOrFail($id);
        $categories = SoundLibraryCategory::orderBy('name', 'asc')->get();
        $authors = SoundAuthor::orderBy('name', 'asc')->get();
        return view('admin.sound_library.edit_sound', compact('sound', 'categories', 'authors'));
    }

    public function updateSoundLibrary(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:sound_libraries,id',
            'name' => 'required|string|max:255',
            'sound_library_category_id' => 'required|exists:sound_library_categories,id',
            'sound_author_id' => 'nullable|exists:sound_authors,id',
            'sound_type' => 'required|in:recorded,live,report,episode',
            'sound_url' => 'nullable|string|max:1000',
            'sound_file' => 'nullable|file|mimes:mp3,wav,ogg,aac,m4a,flac|max:51200', // max 50MB
        ]);

        $sound = SoundLibrary::findOrFail($request->id);
        $save_file = $sound->sound_file_path;

        if ($request->file('sound_file')) {
            if ($sound->sound_file_path && file_exists(public_path($sound->sound_file_path))) {
                unlink(public_path($sound->sound_file_path));
            }

            $file = $request->file('sound_file');
            $name_gen = date('YmdHi') . '_' . $file->getClientOriginalName();
            $path = public_path('upload/sounds/');

            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }

            $file->move($path, $name_gen);
            $save_file = 'upload/sounds/' . $name_gen;
        }

        $sound->update([
            'name' => $request->name,
            'sound_library_category_id' => $request->sound_library_category_id,
            'sound_author_id' => $request->sound_author_id,
            'sound_type' => $request->sound_type,
            'sound_url' => $request->sound_url,
            'sound_file_path' => $save_file,
        ]);

        $notification = [
            'message' => 'تم تعديل الملف الصوتي بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.libraries')->with($notification);
    }

    public function deleteSoundLibrary($id)
    {
        $sound = SoundLibrary::findOrFail($id);

        if ($sound->sound_file_path && file_exists(public_path($sound->sound_file_path))) {
            unlink(public_path($sound->sound_file_path));
        }

        $sound->delete();

        $notification = [
            'message' => 'تم حذف الملف الصوتي بنجاح',
            'alert-type' => 'success'
        ];

        return redirect()->route('all.sound.libraries')->with($notification);
    }
}
