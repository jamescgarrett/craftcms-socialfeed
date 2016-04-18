<?php
namespace Craft;

class SocialFeed_DefaultModel extends BaseModel
{
    protected function defineAttributes()
    {
        return array(
            'settingsId'        => AttributeType::String,
            'facebookActive'    => AttributeType::Bool,
            'instagramActive'   => AttributeType::Bool,
        );
    }
}