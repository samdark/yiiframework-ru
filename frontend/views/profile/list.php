<?php

use yii\helpers\Html;
use \yii\helpers\Url;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $provider yii\data\ActiveDataProvider */
/* @var $user common\models\User */

$this->title = Yii::t('app', 'Users');
?>
<div class="container page-wrapper page-cont-col">
    <div class="row">

        <?php foreach ($provider->getModels() as $user): ?>
            <div class="col-sm-6 col-md-3">
                <div class="c-user-item">
                    <a href="<?= Url::to(['/profile/view', 'id' => $user->id]) ?>" class="c-user-avatar">
                        <?= \common\widgets\Gravatar::widget([
                            'email' => Html::encode($user->email),
                            'size' => 160,
                            'options' => [
                                'title' => Html::encode($user->username),
                                'alt' => Html::encode($user->username)
                            ]
                        ]) ?>
                    </a>
                    <?= Html::encode($user->fullname) ?><br />
                    <a href="<?= Url::to(['/profile/view', 'id' => $user->id]) ?>" class="c-user-name"><?= Html::encode($user->username) ?></a>
                </div>
            </div>
        <?php endforeach ?>

    </div>

    <?= LinkPager::widget([
        'options' => ['class' => 'pagination'],
        'pagination' => $provider->getPagination(),
    ]) ?>

</div>
