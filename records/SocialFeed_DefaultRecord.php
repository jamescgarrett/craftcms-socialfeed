<?php
namespace Craft;

class SocialFeed_DefaultRecord extends BaseRecord
{
    public function getTableName()
    {
        return 'socialfeed_default_settings';
    }

    protected function defineAttributes()
    {
         return array(
            'settingsId'        => AttributeType::String,
            'facebookActive'    => AttributeType::Bool,
            'instagramActive'   => AttributeType::Bool
        );
    }
}
