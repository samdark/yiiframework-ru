<?php

use app\assets\AppAsset;
use app\helpers\GoogleAnalytics;
use yii\bootstrap\Nav;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= $this->blocks['body-class'] ?>">
<?php $this->beginBody() ?>

<?php /*
<div class="important-message"></div>
*/ ?>

<nav class="navbar navbar-default" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <?php
            if (Yii::$app->user->isGuest) {
                echo Html::a('', ['/site/login'], ['class' => 'b-enter enter-key']);
            } else {
                echo Html::a(
                    '',
                    ['/user/view', 'id' => Yii::$app->user->getId()],
                    [
                        'class' => 'b-enter user-avatar',
                        'style' => 'background-image: url("' . (
                            new \app\widgets\Gravatar(
                                [
                                    'email' => Html::encode(Yii::$app->user->identity->email),
                                    'size' => 64,
                                    'options' => [
                                        'class' => 'img-thumbnail',
                                        'title' => Html::encode(Yii::$app->user->identity->username),
                                        'alt' => Html::encode(Yii::$app->user->identity->username)
                                    ]
                                ]
                            )
                            )->getUrl() . '")'
                    ]
                );
            }
            ?>
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Yii::$app->homeUrl ?>"></a>
        </div>

        <div class="navbar-collapse navbar-main-collapse collapse">
            <?php
            $menuItems = [
                ['label' => '1.1', 'url' => ['/site/legacy']],
                ['label' => 'Руководство', 'url' => 'http://stuff.cebe.cc/yii2docs-ru/guide-README.html', 'linkOptions' => ['target' => '_blank', 'rel' => 'noopener noreferrer']],
                ['label' => 'API', 'url' => 'http://stuff.cebe.cc/yii2docs-ru/index.html', 'linkOptions' => ['target' => '_blank', 'rel' => 'noopener noreferrer']],
                ['label' => 'Расширения', 'url' => 'https://yiigist.com/', 'linkOptions' => ['target' => '_blank', 'rel' => 'noopener noreferrer']],
//                [
//                    'label' => 'Вопросы',
//                    'url' => ['/qa'],
//                    'active' => Yii::$app->controller->id === 'qa'
//                ],
                ['label' => 'Чат', 'url' => 'https://join.slack.com/t/yii/shared_invite/MjIxMjMxMTk5MTU1LTE1MDE3MDAwMzMtM2VkMTMyMjY1Ng', 'linkOptions' => ['target' => '_blank', 'rel' => 'noopener noreferrer']],
                ['label' => 'Форум', 'url' => '/forum/', 'linkOptions' => ['target' => '_blank', 'rel' => 'noopener noreferrer']],
                ['label' => 'Проекты', 'url' => 'http://yiipowered.com/ru/'],
                ['label' => 'Пользователи', 'url' => ['/user/index']],
            ];

            echo Nav::widget(
                ['options' => ['class' => 'nav navbar-nav'], 'items' => $menuItems, 'activateParents' => true]
            );
            ?>
        </div>
    </div>
</nav>

<div class="container">
    <?= \lavrentiev\widgets\toastr\NotificationFlash::widget([
        'options' => [
            "closeButton" => false,
            "debug" => false,
            "newestOnTop" => false,
            "progressBar" => false,
            "positionClass" => "toast-top-right",
            "preventDuplicates" => false,
            "onclick" => null,
            "showDuration" => "300",
            "hideDuration" => "1000",
            "timeOut" => "5000",
            "extendedTimeOut" => "1000",
            "showEasing" => "swing",
            "hideEasing" => "linear",
            "showMethod" => "fadeIn",
            "hideMethod" => "fadeOut"
        ]
    ]) ?>
</div>

<?= $content ?>

<div class="container-fluid footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="yii-lable">
                    <img src="https://camo.githubusercontent.com/d10ea4bd497025fc11f5d609258752fe68345290/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f506f77657265645f62792d5969695f4672616d65776f726b2d677265656e2e7376673f7374796c653d666c6174"/>
                </div>

                <div class="fiiter-yii-info">
                    Yii — это высокопроизводительный PHP фреймворк, отлично подходящий для Web 2.0 приложений.
                </div>

                <div class="footer-social">
                    <a href="https://github.com/yiisoft/yii2" class="github" target="_blank" rel="noopener noreferrer"></a>
                    <a href="https://twitter.com/yiiframework_ru" class="twitter" target="_blank" rel="noopener noreferrer"></a>
                    <a href="https://www.facebook.com/groups/yiitalk/" class="facebook" target="_blank" rel="noopener noreferrer"></a>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="b-footer-cent">
                    <div class="footer-title">Навигация</div>
                    <ul class="footer-nav">
                        <?php
                        foreach ($menuItems as $item) {
                            $anchor = Html::a($item['label'], $item['url'], isset($item['linkOptions']) ? $item['linkOptions'] : []);
                            echo Html::tag('li', $anchor);
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="b-footer-cent">
                    <div class="footer-title">Поддержка</div>
                    <ul class="footer-nav">
                        <li><a href="http://yiiframework.ru/forum/viewforum.php?f=5" target="_blank" rel="noopener noreferrer">Оставить пожелание</a></li>
                        <li><a href="https://join.slack.com/t/yii/shared_invite/MjIxMjMxMTk5MTU1LTE1MDE3MDAwMzMtM2VkMTMyMjY1Ng" target="_blank" rel="noopener noreferrer">Чат</a></li>
                        <li><a href="https://github.com/samdark/yiiframework-ru" target="_blank" rel="noopener noreferrer">Исходный код сайта</a></li>
                        <li><a href="https://github.com/samdark/yiiframework-ru/issues" target="_blank" rel="noopener noreferrer">Сообщить об ошибке</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="footer-copyright">
                    <p>
                        © 2009 — <?= date('Y') ?>, Сообщество Yii
                        <br>и Александр Макаров
                        <br><?= Html::a('Условия и конфиденциальность', ['site/terms']) ?>
                    </p>

                    <p>
                        Дизайн — Сергей Хильков<br>
                        <a href="http://www.eshill.ru/" target="_blank" rel="noopener noreferrer">www.eshill.ru</a>
                    </p>

                    <p><a href="https://ru.icons8.com/icon">При поддержке Icons8</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php GoogleAnalytics::track('UA-11885794-1') ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
