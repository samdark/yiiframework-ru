<?php

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $user common\models\User */

use yii\helpers\Html;
use yii\widgets\LinkPager;

$this->title = Yii::t('app', 'Member List');
?>

<div class="container page-wrapper page-cont-col">
    <div class="row">

        <?php foreach ($provider->getModels() as $user): ?>
            <div class="col-sm-6 col-md-3">
                <div class="c-user-item">
                    <a href="user_profile.html" class="c-user-avatar">
                        <?= \common\widgets\Gravatar::widget([
                            'email' => Html::encode($user->email),
                            'size' => 160,
                            'options' => [
                                'title' => Html::encode($user->username),
                                'alt' => Html::encode($user->username)
                            ]
                        ]) ?>
                    </a>
                    <a href="user_profile.html" class="c-user-name"><?= Html::encode($user->username) ?></a>

                    <div class="c-user-info">
                        <span class="name">Никнейм</span><span class="info">Sam Dark</span><br>
                        <span class="name">Город</span><span class="info">Воронеж</span><br>
                        <span class="name"><?= Yii::t('app', 'Registration') ?>:</span><span
                            class="info"><?= Yii::$app->formatter->asDate($user->created_at) ?></span>
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