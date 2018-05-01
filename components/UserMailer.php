<?php
namespace app\components;


use app\models\User;

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
        if (empty($this->user->email)) {
            return false;
        }

        return \Yii::$app->mailer->compose(['html' => 'passwordResetSuccess-html'], ['user' => $this->user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->user->email)
            ->setSubject('Восстановление пароля для ' . \Yii::$app->name)
            ->send();
    }

    public function sendNewSignupEmail()
    {
        if (empty($this->user->email)) {
            return false;
        }

        return \Yii::$app->mailer->compose(['html' => 'newRegister-html'], ['user' => $this->user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->user->email)
            ->setSubject('Добро пожаловать на ' . \Yii::$app->name)
            ->send();
    }

    public function sendConfirmationEmail()
    {
        if (empty($this->user->email)) {
            return false;
        }

        return \Yii::$app->mailer->compose(['html' => 'confirmEmail-html'], ['user' => $this->user])
            ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
            ->setTo($this->user->email)
            ->setSubject('Подтвердите адрес электронной почты для ' . \Yii::$app->name)
            ->send();
    }
}