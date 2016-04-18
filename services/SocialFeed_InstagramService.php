<?php
namespace Craft;

if (!class_exists('Instagram')) 
{
    require_once(CRAFT_PLUGINS_PATH.'socialfeed/vendor/autoload.php');
}

class SocialFeed_InstagramService extends BaseApplicationComponent
{
    public function getInstagramSettingsByAttr()
    {
        $record = SocialFeed_InstagramRecord::model()->findByAttributes(array("settingsId" => "instagramSettings"));

        if ($record) {
            $model =  SocialFeed_InstagramModel::populateModel($record);
        } else {
            $record = new SocialFeed_InstagramRecord();
            $model =  SocialFeed_InstagramModel::populateModel($record);
        }

        return $model;
    }

    public function getInstagramSettings()
    {
        $model = $this->getInstagramSettingsByAttr();

        if (!$model)
        {
            return false;
        } else {
            $result = $model->attributes;

            if ($result)
            {
                unset($result['id']);
                unset($result['dateCreated']);
                unset($result['dateUpdated']);
                unset($result['uid']);
            }

            return $result;
        }
    }

    public function saveInstagramSettings(SocialFeed_InstagramModel $model)
    {

        if (!$model)
        {
            return false;
        }

        $record = SocialFeed_InstagramRecord::model()->findByAttributes(array("settingsId" => "instagramSettings"));
        if (!$record)
        {
            $record = new SocialFeed_InstagramRecord();
        }

        $record->setAttributes($model->getAttributes(), false);

        try
        {
            $record->validate();
            $model->addErrors($record->getErrors());

            if (!$model->hasErrors())
            {
                $record->save(false);

                $model->setAttribute('id', $record->getAttribute('id'));

                return true;
            } 
            else 
            {
                return false;
            }
        }
        catch (\Exception $ex)
        {

            throw $ex;
        }
    }

    public function getInstagramFeed()
    {

        $settings = $this->getInstagramSettings();

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

                $html = craft()->templates->render('frontend/_instagram', [ 'instagramFeed' => $this->getInstagramFeed(), 'settings' => $this->getInstagramSettings()]);

                // Reset Template Path
                craft()->path->setTemplatesPath($sitePath);
            }
        }

    
        return TemplateHelper::getRaw($html);

    }
}