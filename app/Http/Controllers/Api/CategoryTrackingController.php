<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryTrackingController extends Controller
{
    /**
     * يسجّل ضغطة جديدة على فئة (يزيد العداد بواحد)
     * يُستدعى في كل مرة يفتح فيها المستخدم فئة من التطبيق
     */
    public function trackView(int $id): JsonResponse
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['status' => 'not_found'], 404);
        }

        $category->increment('views_count');

        return response()->json(['status' => 'ok']);
    }

    /**
     * يرجّع أكثر الفئات بحثاً (مرتبة حسب عدد الضغطات)
     * جاهزة للاستخدام لاحقاً لما يصير عندك زوار حقيقيين
     */
    public function mostSearched()
    {
        $categories = Category::whereNull('parent_id')
            ->where('views_count', '>', 0)
            ->orderByDesc('views_count')
            ->limit(5)
            ->get(['id', 'name_ar', 'name_en', 'icon', 'views_count']);

        return response()->json(['data' => $categories]);
    }
}