<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

use yii\helpers\Html;
?>
<tr>
    <td>
        <?= \common\widgets\Gravatar::widget([
            'email' => Html::encode($user->email),
            'size' => 25,
            'options' => [
                'class' => 'img-thumbnail',
                'title' => Html::encode($user->username),
                'alt' => Html::encode($user->username)
            ]
        ]) ?>
        <?= Html::encode($user->username) ?></td>
    <td><?= Yii::$app->formatter->asDatetime($user->created_at, 'long') ?></td>
    <td><?= Html::a(Yii::t('app', 'View Profile'), ['/profile/view', 'id' => $user->id]) ?></td>
</tr>