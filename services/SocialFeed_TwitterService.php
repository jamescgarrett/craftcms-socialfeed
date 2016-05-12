<?php
namespace Craft;

if (!class_exists('TwitterOAuth')) 
{
    require_once(CRAFT_PLUGINS_PATH.'socialfeed/vendor/autoload.php');
}

class SocialFeed_TwitterService extends BaseApplicationComponent
{

    public function getTwitterFeed()
    {
        $settings = craft()->socialFeed->getSettings();
        $connection = new \Abraham\TwitterOAuth\TwitterOAuth(
            $settings['twitterConsumerKey'], 
            $settings['twitterConsumerSecret'], 
            $settings['twitterAccessToken'], 
            $settings['twitterTokenSecret']
        );
        $tweets = $connection->get("statuses/user_timeline", ["screen_name" => $settings['twitterUsername'], "count" => $settings['twitterFeedLimit']]);
        $results = array();
        foreach ($tweets as $tweet) 
        {   
            $text = $this->pregUrls($tweet->text);
            $date = $tweet->created_at;
            array_push($results, array(
                "date" => $date,
                "text" => $text,
            ));
        }
        return $results;
    }

    public function displayTwitterFeed()
    {
        $settings = craft()->socialFeed->getPublicSettings();

        $file = '_twitter';
        $data = ['twitterFeed' => $this->getTwitterFeed(), 'settings' => $settings];
        
        if ($settings['useJavascript'])
        {
            craft()->socialFeed->getScripts();
            $file = '_js_twitter';
            $data = [];
        }
        craft()->socialFeed->log($file);
        if ( IOHelper::fileExists( craft()->path->getTemplatesPath() . 'plugin_socialfeed/' . $file . '.twig') ) 
        {
            $html = craft()->templates->render('plugin_socialfeed/' . $file . '', $data);
        }
        else
        {
            $sitePath = craft()->path->getTemplatesPath();
            $pluginPath = craft()->path->getPluginsPath() . 'socialfeed/templates';

            craft()->path->setTemplatesPath($pluginPath);

            $html = craft()->templates->render('frontend/' . $file . '', $data);

            // Reset Template Path
            craft()->path->setTemplatesPath($sitePath);
        }

        return TemplateHelper::getRaw($html);
    }

    private function pregUrls($text)
    {
        $pattern = "@\b(https?://)?(([0-9a-zA-Z_!~*'().&=+$%-]+:)?[0-9a-zA-Z_!~*'().&=+$%-]+\@)?(([0-9]{1,3}\.){3}[0-9]{1,3}|([0-9a-zA-Z_!~*'()-]+\.)*([0-9a-zA-Z][0-9a-zA-Z-]{0,61})?[0-9a-zA-Z]\.[a-zA-Z]{2,6})(:[0-9]{1,4})?((/[0-9a-zA-Z_!~*'().;?:\@&=+$,%#-]+)*/?)@";
        $text = preg_replace($pattern, '<a target="_blank" href="\0">\0</a>', $text);
        return $text;
    }
}