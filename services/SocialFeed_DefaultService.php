<?php
namespace Craft;

class SocialFeed_DefaultService extends BaseApplicationComponent
{

    /**
     * Get a specific ingredient from the database based on ID. If no ingredient exists, null is returned.
     *
     * @param  int   $id
     * @return mixed
     */
    public function getDefaultSettingsByAttr()
    {
        $record = SocialFeed_DefaultRecord::model()->findByAttributes(array("settingsId" => "defaultSettings"));

        if ($record) {
            $model =  SocialFeed_DefaultModel::populateModel($record);
        } else {
            $record = new SocialFeed_DefaultRecord();
            $model =  SocialFeed_DefaultModel::populateModel($record);
        }

        return $model;
    }

    public function getSocialFeedTabs()
    {

        $model = $this->getDefaultSettingsByAttr();

        if (!$model)
        {
            return false;
        } 
        else 
        {
            $result = $model->attributes;

            $settingsTabs = array("socialfeed" => array(
                "label" => "Social Feed", 
                "url" => "default"
            ));

            if ($result['facebookActive']) {
                $settingsTabs['facebook'] = array(
                    "label" => "Facebook", 
                    "url" => "facebook"
                );
            }
            
            if ($result['instagramActive']) {
                $settingsTabs['instagram'] = array(
                    "label" => "Instagram", 
                    "url" => "instagram"
                );
            }
            
            return $settingsTabs;
        }
        
    }

    public function getDefaultSettings()
    {
        $model = $this->getDefaultSettingsByAttr();

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

    public function saveDefaultSettings(SocialFeed_DefaultModel $model)
    {

        if (!$model)
        {
            return false;
        }

        $record = SocialFeed_DefaultRecord::model()->findByAttributes(array("settingsId" => "defaultSettings"));
        if (!$record)
        {
            $record = new SocialFeed_DefaultRecord();
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
}