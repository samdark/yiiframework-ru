<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user \common\models\user\User */

$confirmEmailLink = Yii::$app->urlManager->createAbsoluteUrl(['site/confirmed', 'token' => $user->email_token]);
?>
<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to confirm your email:</p>

    <p><?= Html::a(Html::encode($confirmEmailLink), $confirmEmailLink) ?></p>
</div>
