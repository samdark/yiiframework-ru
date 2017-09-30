<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \app\models\User */

$confirmEmailLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirmed', 'token' => $user->email_token]);
?>
<div class="password-reset">
    <p>Здравствуйте <?= Html::encode($user->username) ?>,</p>

    <p>Пройдите по ссылке, чтобы подтвердить вашу почту:</p>

    <p><?= Html::a(Html::encode($confirmEmailLink), $confirmEmailLink) ?></p>
</div>
