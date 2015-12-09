<?php

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $user common\models\User */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = Yii::t('profile', 'Member List');
?>

<div class="container page-wrapper page-cont-col">
    <div class="row">

        <?php foreach ($provider->getModels() as $user): ?>
            <div class="col-sm-6 col-md-3">
                <div class="c-user-item">
                    <a href="<?= \yii\helpers\Url::toRoute(['profile/view', 'id' => $user->id])?>" class="c-user-avatar">
                        <?= \common\widgets\Gravatar::widget([
                            'email' => Html::encode($user->email),
                            'size' => 160,
                            'options' => [
                                'title' => Html::encode($user->username),
                                'alt' => Html::encode($user->username)
                            ]
                        ]) ?>
                    </a>
                    <?= Html::a(Html::encode($user->username), ['profile/view', 'id' => $user->id], ['class' => 'c-user-name']) ?>

                    <div class="c-user-info">
                        <span class="name"><?= Yii::t('profile', 'Username') ?>:</span>
                        <span class="info"><?= Html::encode($user->getFullName()) ?></span>
                        <br>

                        <span class="name"><?= Yii::t('profile', 'City') ?>:</span>
                        <span class="info"><?= Html::encode($user->city) ?></span>
                        <br>

                        <span class="name"><?= Yii::t('profile', 'Registration') ?>:</span>
                        <span class="info"><?= Yii::$app->formatter->asDate($user->created_at) ?></span>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>

    <?= LinkPager::widget([
        'options' => ['class' => 'pagination'],
        'pagination' => $provider->getPagination(),
    ]) ?>

</div>