<?php

/* @var $this yii\web\View */
/* @var $user common\models\User */

use yii\helpers\Html;
?>
<tr>
    <td><?= $user->username ?></td>
    <td><?= Yii::$app->formatter->asDatetime($user->created_at, 'long') ?></td>
    <td><?= Html::a(Yii::t('app', 'View Profile'), ['/profile/view', 'id' => $user->id]) ?></td>
</tr>