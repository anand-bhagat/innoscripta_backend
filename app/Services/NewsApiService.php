<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NewsApiService
{
    public function fetchNews($params)
    {
        $modifiedParams =  [
            'from' => $params['start_date'],
            'to' => $params['end_date'],
            'q' => $params['search'],
            'sortBy' => 'popularity',
            'category' => $params['category'],
        ];

        $response = Http::get(env('NEWS_API_URL').'v2/top-headlines?apiKey='.env('NEWS_API_KEY').
            '&'.http_build_query($modifiedParams));
        $data = $response->json();

        $news = [];

        if ($data['status']  === 'ok') {
            foreach ($data['articles'] as $article) {
                $news[] = [
                    'title' => $article['title'],
                    'description' => $article['description'],
                    'main_source' => 'NEWS_API',
                    'image' => $article['urlToImage'],
                    'date' => $article['publishedAt'],
                    'source' => $article['source']['name'],
                    'url' => $article['url'],
                ];
            }
        }

        return $news;
    }

    public function fetchCategories()
    {
        return [
            'business' =>'business',
            'entertainment' =>'entertainment',
            'general' =>'general',
            'health' =>'health',
            'science' =>'science',
            'sports' =>'sports',
            'technology' =>'technology'
        ];
    }
}
