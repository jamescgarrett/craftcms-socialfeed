<?php
namespace Craft;

class SocialFeedRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'socialfeed_settings';
    }

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
            'facebookFeedLimit'     => array(AttributeType::String, 'default' => '10'),
            'instagramUsername'     => AttributeType::String,
            'instagramUserId'       => AttributeType::String,
            'instagramClientId'     => AttributeType::String,
            'instagramAccessToken'  => AttributeType::String,
            'instagramFeedLimit'    => array(AttributeType::String, 'default' => '10'),
            'twitterUsername'       => AttributeType::String,
            'twitterConsumerKey'    => AttributeType::String,
            'twitterConsumerSecret' => AttributeType::String,
            'twitterAccessToken'    => AttributeType::String,
            'twitterTokenSecret'    => AttributeType::String,
            'twitterFeedLimit'      => array(AttributeType::String, 'default' => '10')
        );
    }
}
