<?php
namespace Craft;

if (!class_exists('Facebook')) 
{
    require_once(CRAFT_PLUGINS_PATH.'socialfeed/vendor/autoload.php');
}

class SocialFeed_FacebookService extends BaseApplicationComponent
{

    public function getFacebookSettingsByAttr()
    {
        $record = SocialFeed_FacebookRecord::model()->findByAttributes(array("settingsId" => "facebookSettings"));

        if ($record) {
            $model =  SocialFeed_FacebookModel::populateModel($record);
        } else {
            $record = new SocialFeed_FacebookRecord();
            $model =  SocialFeed_FacebookModel::populateModel($record);
        }

        return $model;
    }

    public function getFacebookSettings()
    {
        $model = $this->getFacebookSettingsByAttr();

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

    public function saveFacebookSettings(SocialFeed_FacebookModel $model)
    {

        if (!$model)
        {
            return false;
        }

        $record = SocialFeed_FacebookRecord::model()->findByAttributes(array("settingsId" => "facebookSettings"));
        if (!$record)
        {
            $record = new SocialFeed_FacebookRecord();
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

    public function getFacebookFeed()
    {

        $settings = $this->getFacebookSettings();

        $fb = new \Facebook\Facebook([
            'app_id' => $settings['facebookAppId'],
            'app_secret' => $settings['facebookAppSecret'],
            'default_graph_version' => 'v2.5'
        ]);

        $fb->setDefaultAccessToken('' . $settings['facebookAppId'] .'|' . $settings['facebookAppSecret'] .'');

        try {
            $request = $fb->get('/' . $settings['facebookPageName'] . '/feed?fields=message,object_id,created_time&limit=' . $settings['facebookFeedLimit'] . '');
        } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
        } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
        }

        $graphEdges = $request->getGraphEdge();
        
        $posts = array();

        foreach ($graphEdges as $request) {
            if (!isset($request["message"])) continue;
            /*
             * Get post id for use in link
             */
            if (($pos = strpos($request["id"], "_")) !== FALSE) { 
                $post_id = substr($request["id"], $pos + 1); 
            }
            /*
             * Get date and time
             */
            $date = $request["created_time"]->format("F j, Y");
            $time = $request["created_time"]->format("h:i A");
            /*
             * get post text
             */
            $message = preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1" target="_blank">$1</a>', $request["message"]);
            /*
             * Get image if available
             */
            if (isset($request["object_id"])) {
                $imageSrc = "https://graph.facebook.com/" . $request["object_id"] . "/picture";
            } else {
                $imageSrc = '';
            }
            array_push($posts, array(
                "postId" => $post_id,
                "date" => $date,
                "time" => $time,
                "message" => $message,
                "imageSrc" => $imageSrc
            ));
        }
        return $posts;
    }

    public function displayFacebookFeed()
    {

        foreach (craft()->config->get('defaultTemplateExtensions') as $extension) 
        {
            if ( IOHelper::fileExists( craft()->path->getTemplatesPath() . 'socialFeedPlugin/_facebook' . "." . $extension) ) 
            {
                $html = craft()->templates->render('socialFeedPlugin/_facebook');
            }
            else
            {
                $sitePath = craft()->path->getTemplatesPath();
                $pluginPath = craft()->path->getPluginsPath() . 'socialfeed/templates';

                craft()->path->setTemplatesPath($pluginPath);

                $html = craft()->templates->render('frontend/_facebook', [ 'facebookFeed' => $this->getFacebookFeed(), 'settings' => $this->getFacebookSettings()]);

                // Reset Template Path
                craft()->path->setTemplatesPath($sitePath);
            }
        }

    
        return TemplateHelper::getRaw($html);
    }
}