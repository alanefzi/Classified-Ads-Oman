<?php
namespace App\Filament\Widgets;
use App\Models\Banner;
use App\Models\Category;
use App\Models\City;
use App\Models\Faq;
use App\Models\Listing;
use App\Models\Page;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(__('nav.stat_active_listings'), Listing::where('status', 'active')->count())
                ->description(__('nav.stat_active_listings_desc'))
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success')
                ->icon('heroicon-o-rectangle-stack'),
            Stat::make(__('nav.stat_pending'), Listing::where('status', 'pending')->count())
                ->description(__('nav.stat_pending_desc'))
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make(__('nav.stat_users'), User::count())
                ->description(__('nav.stat_users_desc'))
                ->descriptionIcon('heroicon-m-user-group')
                ->color('info')
                ->icon('heroicon-o-users'),
            Stat::make(__('nav.stat_categories'), Category::count())
                ->description(__('nav.stat_categories_desc'))
                ->descriptionIcon('heroicon-m-tag')
                ->color('primary')
                ->icon('heroicon-o-tag'),
            Stat::make(__('nav.stat_banners'), Banner::count())
                ->description(__('nav.stat_banners_desc'))
                ->descriptionIcon('heroicon-m-photo')
                ->color('primary')
                ->icon('heroicon-o-photo'),
            Stat::make(__('nav.stat_faqs'), Faq::count())
                ->description(__('nav.stat_faqs_desc'))
                ->descriptionIcon('heroicon-m-question-mark-circle')
                ->color('gray')
                ->icon('heroicon-o-question-mark-circle'),
            Stat::make(__('nav.stat_pages'), Page::count())
                ->description(__('nav.stat_pages_desc'))
                ->descriptionIcon('heroicon-m-document-text')
                ->color('gray')
                ->icon('heroicon-o-document-text'),
            Stat::make(__('nav.stat_wilayats'), City::count())
                ->description(__('nav.stat_wilayats_desc'))
                ->descriptionIcon('heroicon-m-map-pin')
                ->color('success')
                ->icon('heroicon-o-map-pin'),
        ];
    }
}
