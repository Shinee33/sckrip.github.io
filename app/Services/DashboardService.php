<?php

namespace App\Services;

use App\Contracts\ActivityLogRepositoryInterface;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\ProductRepositoryInterface;

class DashboardService
{
    public function __construct(
        protected ProductRepositoryInterface $productRepository,
        protected CategoryRepositoryInterface $categoryRepository,
        protected ActivityLogRepositoryInterface $activityLogRepository
    ) {
    }

    public function getAdminData(): array
    {
        $stats = $this->productRepository->getDashboardStats();
        $latestProducts = $this->productRepository->getLatest(10);
        $recentActivities = $this->activityLogRepository->getLatest(8);

        // Calculate dynamic incoming/outgoing product analytics chart data
        $months = [];
        $incomingData = [];
        $outgoingData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $months[] = $date->format('M Y');
            // Realtime aggregate from product entry dates and activity logs
            $incomingData[] = \App\Models\Product::whereMonth('entry_date', $date->month)
                ->whereYear('entry_date', $date->year)->count();
            $outgoingData[] = \App\Models\ActivityLog::where('action', 'delete_product')
                ->whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)->count();
        }

        return [
            'stats' => $stats,
            'latest_products' => $latestProducts,
            'recent_activities' => $recentActivities,
            'chart' => [
                'labels' => $months,
                'incoming' => $incomingData,
                'outgoing' => $outgoingData,
            ],
        ];
    }

    public function getUserData(): array
    {
        return [
            'stats' => $this->productRepository->getDashboardStats(),
            'categories' => $this->categoryRepository->all(),
            'latest_products' => $this->productRepository->getLatest(8),
        ];
    }
}
