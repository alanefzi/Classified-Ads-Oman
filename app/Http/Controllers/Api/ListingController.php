<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use App\Models\ListingImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ListingController extends Controller
{
    // عرض كل الإعلانات مع الفلترة
    public function index(Request $request)
    {
        $query = Listing::with(['user:id,name,avatar', 'category', 'city', 'images'])
            ->where('status', 'active');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('city_id')) {
            $query->where('city_id', $request->city_id);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->filled('search')) {
            $query->where('title', 'ilike', '%' . $request->search . '%');
        }

        // ✅ فلترة حسب بلد المنشأ (مواصفة داخل حقل attributes الـ JSON، مو فئة)
        if ($request->filled('origin')) {
            $query->where('attributes->origin', $request->origin);
        }

        $listings = $query->latest()->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $listings,
        ]);
    }

    // عرض تفاصيل إعلان واحد
    public function show($id)
    {
        $listing = Listing::with(['user:id,name,avatar,phone', 'category', 'city', 'images'])
            ->findOrFail($id);

        $listing->increment('views_count');

        return response()->json([
            'success' => true,
            'data' => $listing,
        ]);
    }

    // نشر إعلان جديد
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'currency' => 'required|string',
            'is_negotiable' => 'boolean',
            'condition' => 'nullable|in:new,used',
            'attributes' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $listing = Listing::create([
            'user_id' => $request->user()->id,
            'country_id' => $request->user()->country_id,
            'category_id' => $request->category_id,
            'city_id' => $request->city_id,
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'currency' => $request->currency,
            'is_negotiable' => $request->boolean('is_negotiable'),
            'condition' => $request->condition,
            'attributes' => $request->attributes ?? [],
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال الإعلان للمراجعة',
            'data' => $listing,
        ], 201);
    }

    // تعديل إعلان (فقط صاحبه)
    public function update(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        if ($listing->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'لا تملك صلاحية تعديل هذا الإعلان',
            ], 403);
        }

        $listing->update($request->only([
            'title', 'description', 'price', 'is_negotiable',
            'condition', 'attributes', 'category_id', 'city_id',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الإعلان',
            'data' => $listing,
        ]);
    }

    // حذف إعلان (فقط صاحبه)
    public function destroy(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        if ($listing->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'لا تملك صلاحية حذف هذا الإعلان',
            ], 403);
        }

        $listing->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الإعلان',
        ]);
    }

    // إعلاناتي الخاصة
    public function myListings(Request $request)
    {
        $listings = Listing::with(['category', 'city', 'images'])
            ->where('user_id', $request->user()->id)
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $listings,
        ]);
    }

    // رفع صور للإعلان
    public function uploadImages(Request $request, $id)
    {
        $listing = Listing::findOrFail($id);

        if ($listing->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'لا تملك صلاحية على هذا الإعلان',
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'images' => 'required|array|max:8',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $uploadedImages = [];

        foreach ($request->file('images') as $index => $file) {
            $path = $file->store('listings', 'public');

            $image = ListingImage::create([
                'listing_id' => $listing->id,
                'path' => $path,
                'sort_order' => $index,
            ]);

            $uploadedImages[] = $image;
        }

        return response()->json([
            'success' => true,
            'message' => 'تم رفع الصور بنجاح',
            'data' => $uploadedImages,
        ], 201);
    }

    // حذف صورة
    public function deleteImage(Request $request, $imageId)
    {
        $image = ListingImage::findOrFail($imageId);

        if ($image->listing->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'لا تملك صلاحية على هذه الصورة',
            ], 403);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الصورة',
        ]);
    }
}