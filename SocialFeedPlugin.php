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
            'socialfeed/default' => array('action' => 'socialFeed/default/index'),
            'socialfeed/facebook' => array('action' => 'socialFeed/facebook/index'),
            'socialfeed/instagram' => array('action' => 'socialFeed/instagram/index'),
        );
    }
}
