<?php
namespace App;

use Illuminate\Support\ServiceProvider;

class TwitterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(TwitterOAuth::class, function ($app) {
            return new TwitterOAuth(
                config('services.twitter.consumer_key'),
                config('services.twitter.consumer_secret'),
                config('services.twitter.access_token'),
                config('services.twitter.access_token_secret')
            );
        });

        $this->app->singleton(TwitterClient::class, function ($app) {
            return new TwitterClient($app->make(TwitterOAuth::class));
        });

        $this->app->alias(TwitterClient::class, 'Twitter');
    }


}

