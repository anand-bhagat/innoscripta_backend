<?php

namespace App\Services;

use Illuminate\Support\Collection;

class CategoryAggregatorService
{
    public function getAggregatedCategories()
    {
        $categories = [];

        $newsApiService = new NewsApiService();
        $categories['NEWS_API'] = $newsApiService->fetchCategories();

        $newYorkTimesService = new NewYorkTimesService();
        $categories['NEW_YORK_TIMES'] = $newYorkTimesService->fetchCategories();

        $theGuardianService = new TheGuardianService();
        $categories['THE_GUARDIAN'] = $theGuardianService->fetchCategories();
        
        return $categories;
    }
}

