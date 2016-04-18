<?php
namespace Craft;

class SocialFeed_FacebookModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'settingsId'            => AttributeType::String,
            'facebookPageName'      => AttributeType::String,
            'facebookAppId'         => AttributeType::String,
            'facebookAppSecret'     => AttributeType::String,
            'facebookFeedLimit'     => AttributeType::String
        );
    }
}