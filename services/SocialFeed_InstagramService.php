<?php
namespace Craft;

if (!class_exists('Instagram')) 
{
    require_once(CRAFT_PLUGINS_PATH.'socialfeed/vendor/autoload.php');
}

class SocialFeed_InstagramService extends BaseApplicationComponent
{

    public function getInstagramFeed()
    {

        $settings = craft()->socialFeed->getSettings();

        $instagram = new \MetzWeb\Instagram\Instagram($settings['instagramClientId']);

        $instagram->setAccessToken($settings['instagramAccessToken']);

        $result = $instagram->getUserMedia($settings['instagramUserId'], (int)$settings['instagramFeedLimit']);

        $posts = array();

        foreach ($result->data as $media) {

            // skip videos for now, will add when we have time to add video player
            if ($media->type === 'video') 
            {
                break;
            } 

            $image = $media->images->low_resolution->url;

            $caption = (!empty($media->caption->text)) ? $media->caption->text : '';

            array_push($posts, array(
                "image" => $image,
                "caption" => $caption
            ));
        }

        return $posts;
    }

    public function displayInstagramFeed()
    {

        foreach (craft()->config->get('defaultTemplateExtensions') as $extension) 
        {
            if ( IOHelper::fileExists( craft()->path->getTemplatesPath() . 'socialFeedPlugin/_instagram' . "." . $extension) ) 
            {
                $html = craft()->templates->render('socialFeedPlugin/_instagram');
            }
            else
            {
                $sitePath = craft()->path->getTemplatesPath();
                $pluginPath = craft()->path->getPluginsPath() . 'socialfeed/templates';

                craft()->path->setTemplatesPath($pluginPath);

                $html = craft()->templates->render('frontend/_instagram', [ 'instagramFeed' => $this->getInstagramFeed(), 'settings' => craft()->socialFeed->getSettings()]);

                // Reset Template Path
                craft()->path->setTemplatesPath($sitePath);
            }
        }
        
        return TemplateHelper::getRaw($html);

    }
}