<?php

namespace App\Http\Controllers;

use App\Services\CategoryAggregatorService;
use App\Services\NewsAggregatorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {

        $request->validate([
            'search' => 'required|string',
            'start_date' => 'date_format:Y-m-d',
            'end_date' => 'date_format:Y-m-d',
            'sources' => 'nullable|array',
            'category' => 'nullable|string',
        ]);

        $params = [
            'search' => $request->search,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'sources' => $request->sources,
            'category' => $request->category,
        ];

        $newsAggregator = new NewsAggregatorService($params);

        $news = $newsAggregator->getAggregatedNews();
    
        return response()->json(['success' => true, 'data' => $news]);
    }

    public function getCategories()
    {
        $categoryAggregator = new CategoryAggregatorService();

        $categories = $categoryAggregator->getAggregatedCategories();

        return response()->json(['success' => true, 'data' => $categories]);
    }
}
