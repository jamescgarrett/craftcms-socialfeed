<?php
namespace Craft;

class SocialFeed_InstagramController extends BaseController
{
    public function actionIndex()
    {
        $this->renderTemplate('socialFeed/_settings/_instagram-settings', array(
            'settings' => craft()->socialFeed_instagram->getInstagramSettings(),
            'tabs' => craft()->socialFeed_default->getSocialFeedTabs()
        ));
    }

    public function actionSaveInstagramSettings()
    {
        $this->requirePostRequest();

        $model = craft()->socialFeed_instagram->getInstagramSettingsByAttr();

        $model->settingsId = "instagramSettings";
        $model->instagramUsername = craft()->request->getPost('instagramUsername');
        $model->instagramUserId = craft()->request->getPost('instagramUserId');
        $model->instagramClientId = craft()->request->getPost('instagramClientId');
        $model->instagramAccessToken = craft()->request->getPost('instagramAccessToken');
        $model->instagramFeedLimit = craft()->request->getPost('instagramFeedLimit');

        if (craft()->socialFeed_instagram->saveInstagramSettings($model)) 
        {
            craft()->userSession->setNotice(Craft::t('Settings saved.'));
        } 
        else 
        {
            craft()->userSession->setError(Craft::t('Couldn’t save settings.'));
        }
    }
}