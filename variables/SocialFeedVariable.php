<?php
namespace Craft;

class SocialFeedVariable
{
    public function displayFacebookFeed()
    {
        return craft()->socialFeed_facebook->displayFacebookFeed();
    }

    public function displayInstagramFeed()
    {
        return craft()->socialFeed_instagram->displayInstagramFeed();
    }
}