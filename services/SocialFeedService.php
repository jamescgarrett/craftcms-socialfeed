<?php
namespace Craft;

class SocialFeedService extends BaseApplicationComponent
{

    public function log($dataToLog)
    {
        SocialFeedPlugin::log(print_r($dataToLog, true));
    }

    /**
     * Get a specific ingredient from the database based on ID. If no ingredient exists, null is returned.
     *
     * @param  int   $id
     * @return mixed
     */
    public function getSettingsByAttr()
    {
        $record = SocialFeedRecord::model()->findByAttributes(array("settingsId" => "socialfeedsettings"));

        if ($record) {
            $model =  SocialFeedModel::populateModel($record);
        } else {
            $record = new SocialFeedRecord();
            $model =  SocialFeedModel::populateModel($record);
        }

        return $model;
    }

    public function getSettings()
    {
        $model = $this->getSettingsByAttr();

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

    public function getPublicSettings()
    {
        $model = $this->getSettingsByAttr();

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
                
                // Hide secret stuff
                unset($result['settingsId']);
                unset($result['facebookActive']);
                unset($result['instagramActive']);
                unset($result['twitterActive']);
                unset($result['facebookAppId']);
                unset($result['facebookAppSecret']);
                unset($result['facebookFeedLimit']);
                unset($result['instagramUserId']);
                unset($result['instagramClientId']);
                unset($result['instagramAccessToken']);
                unset($result['instagramFeedLimit']);
                unset($result['twitterConsumerKey']);
                unset($result['twitterConsumerSecret']);
                unset($result['twitterAccessToken']);
                unset($result['twitterTokenSecret']);
                unset($result['twitterFeedLimit']);
            }

            return $result;
        }
    }

    public function saveSettings(SocialFeedModel $model)
    {

        if (!$model)
        {
            return false;
        }

        $record = SocialFeedRecord::model()->findByAttributes(array("settingsId" => "socialfeedsettings"));
        if (!$record)
        {
            $record = new SocialFeedRecord();
        }

        $record->setAttributes($model->getAttributes(), false);

        try
        {
            $record->validate();
            $model->addErrors($record->getErrors());

            $this->log($record);

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

    public function getScripts()
    {
        if ( $this->isSecureSite() )
        {
            $protocol = 'https://';
        }
        else 
        {
            $protocol = 'http://';
        }

        $settings =  $this->getSettings();

        craft()->templates->includeJsFile(UrlHelper::getResourceUrl('socialfeed/src/js/socialfeed.js'));

        if (!$settings['useYourOwnJavascriptFile'])
        {
            $this->addSocialFeedJavascript($settings);
        }
    }

    public function addSocialFeedJavascript($settings)
    {
        craft()->templates->includeJs('document.addEventListener("DOMContentLoaded",function(){new SocialFeed({
            facebook: "' . $settings['facebookActive'] . '",
            instagram: "' . $settings['instagramActive'] . '",
            twitter: "' . $settings['twitterActive'] . '"
        });});');
    }

    public function isSecureSite()
    {
      return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') || $_SERVER['SERVER_PORT'] == 443;
    }
}