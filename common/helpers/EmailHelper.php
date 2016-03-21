<?php

namespace common\helpers;

use common\models\User;

class EmailHelper
{
	public static function sendPasswordResetSuccess(User $user)
	{
		return \Yii::$app->mailer->compose(['html' => 'passwordResetSuccess-html'], ['user' => $user])
			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
			->setTo($user->email)
			->setSubject('Password Reset Success for ' . \Yii::$app->name)
			->send();
	}

	public static function sendNewRegister(User $user)
	{
		return \Yii::$app->mailer->compose(['html' => 'newRegister-html'], ['user' => $user])
			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
			->setTo($user->email)
			->setSubject('New Register for ' . \Yii::$app->name)
			->send();
	}

	public static function sendConfirmEmail(User $user)
	{
		return \Yii::$app->mailer->compose(['html' => 'confirmEmail-html'], ['user' => $user])
			->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name . ' robot'])
			->setTo($user->email)
			->setSubject('Confirm Email for ' . \Yii::$app->name)
			->send();
	}

}