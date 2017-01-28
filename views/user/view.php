<?php

use app\components\MetaTagsRegistrar;
use yii\helpers\Html;
use app\models\Post;

/* @var $this yii\web\View */
/* @var $model \app\models\User */
/* @var $providerPost \yii\data\ActiveDataProvider */

(new MetaTagsRegistrar($this))
    ->setTitle("Пользователь «{$model->username}»")
    ->setDescription("Страница пользователя «{$model->username}» в русскоязычном сообществе Yii.")
    ->register();
?>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

    <symbol id="ico_like" viewBox="0 0 29 26">
        <path
            d="M24.8513339,4.11991813 C21.9944483,1.30038188 17.3660135,1.29337806 14.500125,4.09890668 C11.6342366,1.29337806 7.00480149,1.30038188 4.14791585,4.11991813 C1.28402805,6.9464582 1.28402805,11.5299556 4.14791585,14.3564956 C4.28695896,14.4945709 11.0840661,21.1702082 13.5868419,23.6285476 C14.0919985,24.1238175 14.9072512,24.1238175 15.4124078,23.6285476 C17.9151837,21.1702082 24.7122908,14.4945709 24.8513339,14.3564956 C27.716222,11.5299556 27.716222,6.9464582 24.8513339,4.11991813 L24.8513339,4.11991813 Z"></path>
    </symbol>

    <symbol id="ico_view" viewBox="0 0 25 15">
        <path
            d="M12.500,-0.000 C7.048,-0.000 2.322,3.048 -0.000,7.500 C2.322,11.952 7.048,15.000 12.500,15.000 C17.952,15.000 22.678,11.952 25.000,7.500 C22.678,3.048 17.952,-0.000 12.500,-0.000 ZM18.663,3.977 C20.132,4.877 21.377,6.081 22.312,7.500 C21.377,8.918 20.132,10.123 18.663,11.023 C16.818,12.153 14.686,12.750 12.500,12.750 C10.313,12.750 8.182,12.153 6.337,11.023 C4.868,10.123 3.623,8.918 2.688,7.500 C3.623,6.081 4.868,4.877 6.337,3.977 C6.432,3.919 6.529,3.862 6.626,3.806 C6.383,4.447 6.250,5.138 6.250,5.859 C6.250,9.173 9.048,11.859 12.500,11.859 C15.952,11.859 18.750,9.173 18.750,5.859 C18.750,5.138 18.617,4.447 18.374,3.806 C18.471,3.862 18.568,3.919 18.663,3.977 ZM12.500,5.109 C12.500,6.352 11.451,7.359 10.156,7.359 C8.862,7.359 7.812,6.352 7.812,5.109 C7.812,3.867 8.862,2.859 10.156,2.859 C11.451,2.859 12.500,3.867 12.500,5.109 Z"/>
    </symbol>

    <symbol id="ico_comment" viewBox="0 0 443 443">
        <path
            d="M76.579,433.451V335.26C27.8,300.038,0,249.409,0,195.254C0,93.155,99.486,10.09,221.771,10.09 s221.771,83.065,221.771,185.164s-99.486,185.164-221.771,185.164c-14.488,0-29.077-1.211-43.445-3.604L76.579,433.451z"/>
    </symbol>

</svg>

<div class="container page-wrapper page-cont-col">
    <div class="row">
        <div class="col-xs-12">
            <div class="c-block-user">
                <div class="block-user-bg"></div>
                <div class="block-user-name">
                    <h2><?= Html::encode($model->username) ?></h2>
                    <h3><?= Html::encode($model->fullname) ?></h3>
                    <?php if (Yii::$app->user->getId() === $model->id) : ?>
                        <?= Html::a(Yii::t('user', 'Edit profile'), ['/user/edit'], ['class' => 'btn btn-link']) ?>
                    <?php endif ?>
                </div>
                <div class="block-user-info">
                    <span class="name">Сайт:</span>
                    <span class="info">
                        <?= Html::encode($model->site) ? Html::a(Html::encode($model->site), Html::encode($model->site), ['target' => '_blank']) : Yii::t('user', 'No Website') ?>
                    </span><br>
                    <span class="name">Github:</span>
                    <span class="info">
                        <?= Html::encode($model->github) ? Html::a(Html::encode($model->github), 'https://github.com/' . Html::encode($model->github), ['target' => '_blank']) : Yii::t('user', 'No Github') ?>
                    </span><br>
                    <span class="name">Twitter:</span>
                    <span class="info">
                        <?= Html::encode($model->twitter) ? Html::a(Html::encode($model->twitter), 'https://twitter.com/' . Html::encode($model->twitter), ['target' => '_blank']) : Yii::t('user', 'No Twitter') ?>
                    </span><br>
                    <span class="name">Facebook:</span>
                    <span class="info">
                        <?= Html::encode($model->facebook) ? Html::a(Html::encode($model->facebook), 'https://facebook.com/' . Html::encode($model->facebook), ['target' => '_blank']) : Yii::t('user', 'No Facebook') ?>
                    </span><br>
                    <span class="name">Регистрация:</span>
                    <span class="info"><?= Yii::$app->formatter->asDatetime($model->created_at, 'long') ?></span>
                    <!-- Logout button -->
                    <div class="clearfix"></div>
                    <?php if (Yii::$app->user->getId() === $model->id) : ?>
                        <div class="logout col-md-4 col-lg-2 col-sm-8 col-xs-12">
                            <a href="<?= \yii\helpers\Url::to(['site/logout'])?>"
                               class="glyphicon glyphicon-log-out btn btn-border-success btn-block"
                               data-method="post">Выйти
                            </a>
                        </div>                        
                    <?php endif ?>
                    
                </div>
            </div>

            <div class="big-user-avatar">
                <?= \app\widgets\Gravatar::widget([
                    'email' => Html::encode($model->email),
                    'size' => 160,
                    'options' => [
                        'title' => Html::encode($model->username),
                        'alt' => Html::encode($model->username)
                    ]
                ]) ?>
            </div>

            <div class="user-posts">
                <h2><?= Yii::t('user', 'Posts from {username}', [
                        'username' => Html::encode($model->username)
                    ]) ?> <sup>(<?= $providerPost->totalCount ?>)</sup></h2>

                <div class="row b-clear">
                    <ul>
                    <?php foreach ($providerPost->getModels() as $post): ?>
                        <li>
                            <?= Html::a(Html::encode($post->title), ['/post/view', 'id' => $post->id, 'slug' => $post->slug])?>
                            <?= Yii::$app->formatter->asDate($post->created_at, 'medium') ?>
                            <?php if ((int)$post->status !== Post::STATUS_ACTIVE): ?>
                                <small><?= $post->getStatusLabel($post->status) ?></small>
                            <?php endif ?>
                            <?php if (Yii::$app->user->id == $post->user_id && $post->status == $post::STATUS_INACTIVE) : ?>
                                <span class="margin-line">|</span> <?= Html::a(Yii::t('post', 'Edit post'), ['post/update', 'id' => $post->id]) ?>
                            <?php endif; ?>
                        </li>
                    <?php endforeach ?>
                    </ul>
                </div>
            </div>

        </div>
    </div>
</div>
