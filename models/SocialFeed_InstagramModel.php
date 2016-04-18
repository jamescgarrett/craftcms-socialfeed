<?php
namespace Craft;

class SocialFeed_InstagramModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'settingsId'                => AttributeType::String,
            'instagramUsername'         => AttributeType::String,
            'instagramUserId'         	=> AttributeType::String,
            'instagramClientId'         => AttributeType::String,
            'instagramAccessToken'      => AttributeType::String,
            'instagramFeedLimit'        => AttributeType::String
        );
    }
}