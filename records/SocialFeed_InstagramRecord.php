<?php
namespace Craft;

class SocialFeed_InstagramRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'socialfeed_instagram_settings';
    }

    protected function defineAttributes()
    {
         return array(
            'settingsId'                => AttributeType::String,
            'instagramUsername'         => AttributeType::String,
            'instagramUserId'           => AttributeType::String,
            'instagramClientId'         => AttributeType::String,
            'instagramAccessToken'      => AttributeType::String,
            'instagramFeedLimit'        => array(AttributeType::String, 'default' => '10')
        );
    }
}

