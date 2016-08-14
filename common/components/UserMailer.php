<?php
namespace common\components;


use common\models\user\User;

/**
 * UserMailer sends various emails to user
 */
class UserMailer
{
    private $user;

    /**
     * UserMailer constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function sendPasswordResetSuccessEmail()
    {
        return \Yii::$app->mailer->compose(['html' => 'passwordResetSuccess-html'], ['user' => $this->user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->user->email)
            ->setSubject(\Yii::t('user', 'Password for {appname} was reset', ['appname' => \Yii::$app->name]))
            ->send();
    }

    public function sendNewSignupEmail()
    {
        return \Yii::$app->mailer->compose(['html' => 'newRegister-html'], ['user' => $this->user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->user->email)
            ->setSubject(\Yii::t('user', 'Welcome to {appname}', ['appname' => \Yii::$app->name]))
            ->send();
    }

    public function sendConfirmationEmail()
    {
        return \Yii::$app->mailer->compose(['html' => 'confirmEmail-html'], ['user' => $this->user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->user->email)
            ->setSubject(\Yii::t('user', 'Please confirm your email for {appname}', ['appname' => \Yii::$app->name]))
            ->send();
    }
}