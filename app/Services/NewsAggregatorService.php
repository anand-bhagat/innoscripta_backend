<?php

namespace App\Services;

use Illuminate\Support\Collection;

class NewsAggregatorService
{
    private $params;

    public function __construct(
       $params
    ) {
        $this->params = $params;
    }

    public function getAggregatedNews(): Collection
    {
        $news = new Collection();

        $defaultSources = ['NEWS_API', 'NEW_YORK_TIMES', 'THE_GUARDIAN'];

        if (isset($this->params['source'])) {
            $selectedSources = [$this->params['source']];
        } else {
            $selectedSources = $defaultSources;
        }

        if (in_array('NEWS_API', $selectedSources)) {
            $newsApiService = new NewsApiService();
            $news = $news->merge($newsApiService->fetchNews($this->params));
        }

        if (in_array('NEW_YORK_TIMES', $selectedSources)) {
            $newYorkTimesService = new NewYorkTimesService();
            $news = $news->merge($newYorkTimesService->fetchNews($this->params));
        }

        if (in_array('THE_GUARDIAN', $selectedSources)) {
            $theGuardianService = new TheGuardianService();
            $news = $news->merge($theGuardianService->fetchNews($this->params));
        }
        
        return $news;
    }
}

