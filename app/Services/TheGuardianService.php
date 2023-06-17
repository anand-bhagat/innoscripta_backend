<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class TheGuardianService
{
    public function fetchNews($params)
    {
        $modifiedParams =  [
            'q' => $params['search'],
            'from-date' => $params['start_date'],
            'to-date' => $params['end_date'],
            'section' => $params['category'],
        ];

        $response = Http::get(env('THE_GUARDIAN_URL').'search?api-key='
            .env('THE_GUARDIAN_KEY').'&'.http_build_query($modifiedParams));
        $data = $response->json();

        $news = [];

        if ($data['response']['status']  === 'ok') {
            foreach ($data['response']['results'] as $article) {
                $news[] = [
                    'title' => $article['webTitle'],
                    'description' => null,
                    'main_source' => 'THE_GUARDIAN',
                    'image' => null,
                    'date' => $article['webPublicationDate'],
                    'source' => 'The Guardian',
                    'url' => $article['webUrl'],
                ];
            }
        }

        return $news;
    }

    public function fetchCategories()
    {
        $response = Http::get(env('THE_GUARDIAN_URL').'sections?api-key='.env('THE_GUARDIAN_KEY'));

        $json = $response->json();

        $categories = [];

        if ($json['response']['status'] === 'ok') {
            $categories = array_reduce($json['response']['results'], function ($carry, $item) {
                $carry[$item['id']] = $item['webTitle'];
                return $carry;
            }, []);
        }

        return $categories;
    }
}
