<?php

// namespace App\Http\Controllers\Admin;
namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\PhotoGallery;
use Illuminate\Http\Request;
use App\Models\PhotosGallery;
use App\Http\Controllers\Controller;

class GalleryController extends Controller
{
    // Show all galleries
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    // Show add gallery form
    public function create()
    {
        return view('admin.gallery.create');
    }

    // Store new gallery
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'des' => 'nullable|string',
            'des_en' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $gallery = Gallery::create($request->only(['title','title_en','des','des_en']));

        if($request->hasFile('photos')){
            foreach($request->file('photos') as $photo){
                $filename = time().'_'.$photo->getClientOriginalName();
                $photo->move(public_path('upload/gallery'), $filename);
                PhotosGallery::create([
                    'gallery_id' => $gallery->id,
                    'photo' => 'upload/gallery/'.$filename,
                ]);
            }
        }

        return redirect()->route('all.gallery')->with('success','Gallery added successfully.');
    }

    // Show edit gallery form
    public function edit($id)
    {
        $gallery = Gallery::with('photos')->findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    // Update gallery
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:galleries,id',
            'title' => 'nullable|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'des' => 'nullable|string',
            'des_en' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp',
        ]);

        $gallery = Gallery::findOrFail($request->id);
        $gallery->update($request->only(['title','title_en','des','des_en']));

        if($request->hasFile('photos')){
            foreach($request->file('photos') as $photo){
                $filename = time().'_'.$photo->getClientOriginalName();
                $photo->move(public_path('upload/gallery'), $filename);
                PhotosGallery::create([
                    'gallery_id' => $gallery->id,
                    'photo' => 'upload/gallery/'.$filename,
                ]);
            }
        }

        return redirect()->route('all.gallery')->with('success','Gallery updated successfully.');
    }

    // Delete gallery
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // Delete all associated photos from filesystem
        foreach($gallery->photos as $photo){
            if(file_exists(public_path($photo->photo))){
                unlink(public_path($photo->photo));
            }
        }

        $gallery->delete();
        return redirect()->route('all.gallery')->with('success','Gallery deleted successfully.');
    }

    // Delete single photo from gallery
    public function deletePhoto($id)
    {
        $photo = PhotosGallery::findOrFail($id);

        if(file_exists(public_path($photo->photo))){
            unlink(public_path($photo->photo));
        }

        $photo->delete();
        return back()->with('success','Photo deleted successfully.');
    }
}
