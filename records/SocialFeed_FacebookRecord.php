<?php
namespace Craft;

class SocialFeed_FacebookRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'socialfeed_facebook_settings';
    }

    protected function defineAttributes()
    {
         return array(
            'settingsId'            => array(AttributeType::String),
            'facebookPageName'      => array(AttributeType::String, 'required' => true),
            'facebookAppId'         => array(AttributeType::String, 'required' => true),
            'facebookAppSecret'     => array(AttributeType::String, 'required' => true),
            'facebookFeedLimit'     => array(AttributeType::String, 'default' => '10')
        );
    }
}