<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ListingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

// مسارات عامة (بدون تسجيل دخول)
Route::get('listings', [ListingController::class, 'index']);
Route::get('listings/{id}', [ListingController::class, 'show']);

// ✅ قائمة الدول — يستخدمها نموذج إنشاء الحساب لتحديد country_id تلقائياً
Route::get('countries', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Country::all(),
    ]);
});

Route::get('categories', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get(),
    ]);
});

// ✅ البانرات — فلترة حسب الفئة المستهدفة
Route::get('banners', function (Request $request) {
    $query = \App\Models\Banner::where('is_active', true);

    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    } else {
        $query->whereNull('category_id');
    }

    return response()->json([
        'success' => true,
        'data' => $query->orderBy('sort_order')->get(),
    ]);
});

Route::get('cities', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\City::with('state')->get(),
    ]);
});

Route::get('faqs', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Faq::where('is_active', true)
            ->orderBy('sort_order')
            ->get(),
    ]);
});

// ✅ صفحة عامة واحدة بالـ Slug
Route::get('pages/{slug}', function (string $slug) {
    $page = \App\Models\Page::where('slug', $slug)
        ->where('is_active', true)
        ->first();

    if (!$page) {
        return response()->json(['success' => false, 'message' => 'الصفحة غير موجودة'], 404);
    }

    return response()->json(['success' => true, 'data' => $page]);
});

// ✅ قائمة المندوبين — نشطين فقط، مرتبين
Route::get('agents', function () {
    return response()->json([
        'success' => true,
        'data' => \App\Models\Agent::where('is_active', true)
            ->orderBy('sort_order')
            ->get(),
    ]);
});

// مسارات محمية (تحتاج تسجيل دخول)
Route::middleware('auth:sanctum')->group(function () {
    Route::get('my-listings', [ListingController::class, 'myListings']);
    Route::post('listings', [ListingController::class, 'store']);
    Route::put('listings/{id}', [ListingController::class, 'update']);
    Route::delete('listings/{id}', [ListingController::class, 'destroy']);
    Route::post('listings/{id}/images', [ListingController::class, 'uploadImages']);
    Route::delete('listing-images/{imageId}', [ListingController::class, 'deleteImage']);
});