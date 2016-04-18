<?php
namespace Craft;

class SocialFeed_DefaultController extends BaseController
{

    public function actionIndex()
    {
        $this->renderTemplate('socialFeed/_settings/_default-settings', array(
            'settings' => craft()->socialFeed_default->getDefaultSettings(),
            'tabs' => craft()->socialFeed_default->getSocialFeedTabs()
        ));
    }
    
    public function actionSaveDefaultSettings()
    {
        $this->requirePostRequest();

        $model = craft()->socialFeed_default->getDefaultSettingsByAttr();

        $model->settingsId = "defaultSettings";
        $model->facebookActive = craft()->request->getPost('facebookActive');
        $model->instagramActive = craft()->request->getPost('instagramActive');

        if (craft()->socialFeed_default->saveDefaultSettings($model)) 
        {
            craft()->userSession->setNotice(Craft::t('Settings saved.'));
        } 
        else 
        {
            craft()->userSession->setError(Craft::t('Couldn’t save settings.'));
        }
    }

}