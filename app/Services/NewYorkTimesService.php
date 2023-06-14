<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class NewYorkTimesService
{

    public function fetchNews($params)
    {
        $modifiedParams =  [
            'query' => $params['search'],
            'begin_date' => $params['start_date'] ? Carbon::parse($params['start_date'])->format('Ymd') : null,
            'end_date' => $params['end_date'] ? Carbon::parse($params['end_date'])->format('Ymd') : null,
        ];

        if ($params['category']) {
            $modifiedParams['fq'] = 'news_desk:("'.$params['category'].'")';
        }

        $response = Http::get(env('NEW_YORK_TIMES_URL').'search/v2/articlesearch.json?api-key='
            .env('NEW_YORK_TIMES_KEY').'&'.http_build_query($modifiedParams));
        $data = $response->json();

        $news = [];

        if ($data['status']  === 'OK') {
            foreach ($data['response']['docs'] as $index => $article) {
                $news[$index] = [
                    'title' => $article['headline']['main'],
                    'description' => $article['lead_paragraph'],
                    'main_source' => 'NEW_YORK_TIMES',
                    'date' => $article['pub_date'],
                    'source' => $article['source'],
                    'url' => $article['web_url'],
                ];

                if (isset($article['multimedia'][0]['url'])) {
                    $news[$index]['image'] = "https://static01.nyt.com/".$article['multimedia'][0]['url'];
                }
            }
        }

        return $news;
    }

    public function fetchCategories()
    {
        return [
            'Adventure Sports' => 'Adventure Sports',
            'Arts & Leisure' => 'Arts & Leisure',
            'Arts' => 'Arts',
            'Automobiles' => 'Automobiles',
            'Blogs' => 'Blogs',
            'Books' => 'Books',
            'Booming' => 'Booming',
            'Business Day' => 'Business Day',
            'Business' => 'Business',
            'Cars' => 'Cars',
            'Circuits' => 'Circuits',
            'Classifieds' => 'Classifieds',
            'Connecticut' => 'Connecticut',
            'Crosswords & Games' => 'Crosswords & Games',
            'Culture' => 'Culture',
            'DealBook' => 'DealBook',
            'Dining' => 'Dining',
            'Editorial' => 'Editorial',
            'Education' => 'Education',
            'Energy' => 'Energy',
            'Entrepreneurs' => 'Entrepreneurs',
            'Environment' => 'Environment',
            'Escapes' => 'Escapes',
            'Fashion & Style' => 'Fashion & Style',
            'Fashion' => 'Fashion',
            'Favorites' => 'Favorites',
            'Financial' => 'Financial',
            'Flight' => 'Flight',
            'Food' => 'Food',
            'Foreign' => 'Foreign',
            'Generations' => 'Generations',
            'Giving' => 'Giving',
            'Global Home' => 'Global Home',
            'Health & Fitness' => 'Health & Fitness',
            'Health' => 'Health',
            'Home & Garden' => 'Home & Garden',
            'Home' => 'Home',
            'Jobs' => 'Jobs',
            'Key' => 'Key',
            'Letters' => 'Letters',
            'Long Island' => 'Long Island',
            'Magazine' => 'Magazine',
            'Market Place' => 'Market Place',
            'Media' => 'Media',
            'Mens Health' => 'Mens Health',
            'Metro' => 'Metro',
            'Metropolitan' => 'Metropolitan',
            'Movies' => 'Movies',
            'Museums' => 'Museums',
            'National' => 'National',
            'Nesting' => 'Nesting',
            'Obits' => 'Obits',
            'Obituaries' => 'Obituaries',
            'Obituary' => 'Obituary',
            'OpEd' => 'OpEd',
            'Opinion' => 'Opinion',
            'Outlook' => 'Outlook',
            'Personal Investing' => 'Personal Investing',
            'Personal Tech' => 'Personal Tech',
            'Play' => 'Play',
            'Politics' => 'Politics',
            'Regionals' => 'Regionals',
            'Retail' => 'Retail',
            'Retirement' => 'Retirement',
            'Science' => 'Science',
            'Small Business' => 'Small Business',
            'Society' => 'Society',
            'Sports' => 'Sports',
            'Style' => 'Style',
            'Sunday Business' => 'Sunday Business',
            'Sunday Review' => 'Sunday Review',
            'Sunday Styles' => 'Sunday Styles',
            'T Magazine' => 'T Magazine',
            'T Style' => 'T Style',
            'Technology' => 'Technology',
            'Teens' => 'Teens',
            'Television' => 'Television',
            'The Arts' => 'The Arts',
            'The Business of Green' => 'The Business of Green',
            'The City Desk' => 'The City Desk',
            'The City' => 'The City',
            'The Marathon' => 'The Marathon',
            'The Millennium' => 'The Millennium',
            'The Natural World' => 'The Natural World',
            'The Upshot' => 'The Upshot',
            'The Weekend' => 'The Weekend',
            'The Year in Pictures' => 'The Year in Pictures',
            'Theater' => 'Theater',
            'Then & Now' => 'Then & Now',
            'Thursday Styles' => 'Thursday Styles',
            'Times Topics' => 'Times Topics',
            'Travel' => 'Travel',
            'U.S.' => 'U.S.',
            'Universal' => 'Universal',
            'Upshot' => 'Upshot',
            'UrbanEye' => 'UrbanEye',
            'Vacation' => 'Vacation',
            'Washington' => 'Washington',
            'Wealth' => 'Wealth',
            'Weather' => 'Weather',
            'Week in Review' => 'Week in Review',
            'Week' => 'Week',
            'Weekend' => 'Weekend',
            'Westchester' => 'Westchester',
            'Wireless Living' => 'Wireless Living',
            'Womens Health' => 'Womens Health',
            'Working' => 'Working',
            'Workplace' => 'Workplace',
            'World' => 'World',
            'Your Money' => 'Your Money',
        ];
    }
}
