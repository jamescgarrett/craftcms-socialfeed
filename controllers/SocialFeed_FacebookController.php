<?php
namespace Craft;

class SocialFeed_FacebookController extends BaseController
{
    public function actionIndex()
    {
        $this->renderTemplate('socialFeed/_settings/_facebook-settings', array(
            'settings' => craft()->socialFeed_facebook->getFacebookSettings(),
            'tabs' => craft()->socialFeed_default->getSocialFeedTabs()
        ));
    }

    public function actionSaveFacebookSettings()
    {
        $this->requirePostRequest();

        $model = craft()->socialFeed_facebook->getFacebookSettingsByAttr();

        $model->settingsId = "facebookSettings";
        $model->facebookPageName = craft()->request->getPost('facebookPageName');
        $model->facebookAppId = craft()->request->getPost('facebookAppId');
        $model->facebookAppSecret = craft()->request->getPost('facebookAppSecret');
        $model->facebookFeedLimit = craft()->request->getPost('facebookFeedLimit');

        if (craft()->socialFeed_facebook->saveFacebookSettings($model)) 
        {
            craft()->userSession->setNotice(Craft::t('Settings saved.'));
        } 
        else 
        {
            craft()->userSession->setError(Craft::t('Couldn’t save settings.'));
        }
    }
}