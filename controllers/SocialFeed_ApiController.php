<?php
namespace Craft;

class SocialFeed_ApiController extends BaseController
{

    protected $allowAnonymous = true;

    public function actionFacebook()
    {
        $variables['feed'] = craft()->socialFeed_facebook->getFacebookFeed();

        // Get Templates Paths
        $sitePath = craft()->path->getTemplatesPath();
        $pluginPath = craft()->path->getPluginsPath() . 'socialfeed/templates';

        // Temp Set Template Path to Plugin Templates
        craft()->path->setTemplatesPath($pluginPath);

        $this->renderTemplate('api/_feed-data', $variables);

        // Reset Template Path
        craft()->path->setTemplatesPath($sitePath);
    }

    public function actionInstagram()
    {
        $variables['feed'] = craft()->socialFeed_instagram->getInstagramFeed();

        // Get Templates Paths
        $sitePath = craft()->path->getTemplatesPath();
        $pluginPath = craft()->path->getPluginsPath() . 'socialfeed/templates';

        // Temp Set Template Path to Plugin Templates
        craft()->path->setTemplatesPath($pluginPath);

        $this->renderTemplate('api/_feed-data', $variables);

        // Reset Template Path
        craft()->path->setTemplatesPath($sitePath);
    }

    public function actionTwitter()
    {
        $variables['feed'] = craft()->socialFeed_twitter->getTwitterFeed();

        // Get Templates Paths
        $sitePath = craft()->path->getTemplatesPath();
        $pluginPath = craft()->path->getPluginsPath() . 'socialfeed/templates';

        // Temp Set Template Path to Plugin Templates
        craft()->path->setTemplatesPath($pluginPath);

        $this->renderTemplate('api/_feed-data', $variables);

        // Reset Template Path
        craft()->path->setTemplatesPath($sitePath);
    }

}