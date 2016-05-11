<?php
namespace Craft;

class SocialFeedController extends BaseController
{

    public function actionIndex()
    {
        $this->renderTemplate('socialFeed/_settings/_default-settings', array(
            'settings' => craft()->socialFeed->getSettings()
        ));
    }
    
    public function actionSaveSettings()
    {
        $this->requirePostRequest();

        $model = craft()->socialFeed->getSettingsByAttr();

        $model->settingsId = "socialfeedsettings";
        $model->useJavascript = craft()->request->getPost('useJavascript');
        $model->useYourOwnJavascriptFile = craft()->request->getPost('useYourOwnJavascriptFile');

        $model->facebookActive = craft()->request->getPost('facebookActive');
        $model->instagramActive = craft()->request->getPost('instagramActive');
        $model->twitterActive = craft()->request->getPost('twitterActive');

        $model->facebookPageName = craft()->request->getPost('facebookPageName');
        $model->facebookAppId = craft()->request->getPost('facebookAppId');
        $model->facebookAppSecret = craft()->request->getPost('facebookAppSecret');
        $model->facebookFeedLimit = craft()->request->getPost('facebookFeedLimit');

        $model->instagramUsername = craft()->request->getPost('instagramUsername');
        $model->instagramUserId = craft()->request->getPost('instagramUserId');
        $model->instagramClientId = craft()->request->getPost('instagramClientId');
        $model->instagramAccessToken = craft()->request->getPost('instagramAccessToken');
        $model->instagramFeedLimit = craft()->request->getPost('instagramFeedLimit');

        $model->twitterUsername = craft()->request->getPost('twitterUsername');
        $model->twitterConsumerKey = craft()->request->getPost('twitterConsumerKey');
        $model->twitterConsumerSecret = craft()->request->getPost('twitterConsumerSecret');
        $model->twitterAccessToken = craft()->request->getPost('twitterAccessToken');
        $model->twitterTokenSecret = craft()->request->getPost('twitterTokenSecret');
        $model->twitterFeedLimit = craft()->request->getPost('twitterFeedLimit');

        if (craft()->socialFeed->saveSettings($model)) 
        {
            craft()->userSession->setNotice(Craft::t('Settings saved.'));
        } 
        else 
        {
            craft()->userSession->setError(Craft::t('Couldn’t save settings.'));
        }
    }

}