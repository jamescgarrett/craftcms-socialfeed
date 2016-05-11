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
}