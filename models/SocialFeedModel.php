<?php
namespace Craft;

class SocialFeedModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'settingsId'            => AttributeType::String,
            'useJavascript'         => AttributeType::Bool,
            'useYourOwnJavascriptFile' => AttributeType::Bool,
            'facebookActive'        => AttributeType::Bool,
            'instagramActive'       => AttributeType::Bool,
            'twitterActive'         => AttributeType::Bool,
            'facebookPageName'      => AttributeType::String,
            'facebookAppId'         => AttributeType::String,
            'facebookAppSecret'     => AttributeType::String,
            'facebookFeedLimit'     => AttributeType::String,
            'instagramUsername'     => AttributeType::String,
            'instagramUserId'       => AttributeType::String,
            'instagramClientId'     => AttributeType::String,
            'instagramAccessToken'  => AttributeType::String,
            'instagramFeedLimit'    => AttributeType::String,
            'twitterUsername'       => AttributeType::String,
            'twitterConsumerKey'    => AttributeType::String,
            'twitterConsumerSecret' => AttributeType::String,
            'twitterAccessToken'    => AttributeType::String,
            'twitterTokenSecret'    => AttributeType::String,
            'twitterFeedLimit'      => AttributeType::String
        );
    }
}