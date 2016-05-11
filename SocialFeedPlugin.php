<?php
namespace Craft;

class SocialFeedPlugin extends BasePlugin
{
	public function getName()
	{
	    return 'Social Feed';
	}

	public function getVersion()
	{
	    return '1.0.0';
	}

	public function getDeveloper()
	{
	    return 'James C Garrett';
	}

	public function getDeveloperUrl()
	{
	    return 'http://www.jamescgarrett.com';
	}

    public function hasCpSection()
    {
        return true;
    }

    public function registerCpRoutes()
    {
        return array(
            'socialfeed/settings' => array('action' => 'socialFeed/index')
        );
    }

    public function registerSiteRoutes()
    {
        return array(
            'api/craft/socialfeedplugin/facebook' => array('action' => 'socialFeed/api/facebook'),
            'api/craft/socialfeedplugin/instagram' => array('action' => 'socialFeed/api/instagram'),
            'api/craft/socialfeedplugin/twitter' => array('action' => 'socialFeed/api/twitter')
        );
    }
}
