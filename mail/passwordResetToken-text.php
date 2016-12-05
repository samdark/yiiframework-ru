<?php

/* @var $this yii\web\View */
/* @var $user \app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);
?>
Привет, <?= $user->username ?>,

Пройдите по ссылке, чтобы сбросить пароль:

<?= $resetLink ?>
