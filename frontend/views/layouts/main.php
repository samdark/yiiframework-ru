<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" contdent="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="<?= $this->blocks['body-class'] ?>">
<?php $this->beginBody() ?>

<?php
NavBar::begin(
    [
        'brandLabel' => '',
        'brandUrl' => Yii::$app->homeUrl,
    ]
);
$menuItems = [
    ['label' => '1.1', 'url' => ['/site/legacy']],
    ['label' => Yii::t('app', 'Guide'), 'url' => 'http://www.yiiframework.com/doc-2.0/guide-index.html'],
    ['label' => 'API', 'url' => 'http://www.yiiframework.com/doc-2.0/index.html'],
    ['label' => Yii::t('app', 'Extensions'), 'url' => 'https://yiigist.com/'],
    ['label' => Yii::t('app', 'Questions'), 'url' => ['/qa']],
    ['label' => Yii::t('app', 'Chat'), 'url' => 'https://gitter.im/yiisoft/yii2/rus'],
    ['label' => Yii::t('app', 'Forum'), 'url' => '/forum/'],
    ['label' => Yii::t('app', 'Member List'), 'url' => ['/profile/list']],
    ['label' => Yii::t('app', 'Projects'), 'url' => ['/project/']],
];
if (Yii::$app->user->isGuest) {
    echo Html::a('', ['/site/login'], ['class' => 'b-enter enter-key']);
} else {
    echo Html::a('', ['/profile/index'], ['class' => 'b-enter user-avatar', 'style' => 'background-image: url("' . (new \common\widgets\Gravatar([
            'email' => Html::encode(Yii::$app->user->identity->email),
            'size' => 150,
            'options' => [
                'class' => 'img-thumbnail',
                'title' => Html::encode(Yii::$app->user->identity->username),
                'alt' => Html::encode(Yii::$app->user->identity->username)
            ]
        ]))->getUrl() . '")']);}
echo Nav::widget(
    [
        'options' => ['class' => 'nav navbar-nav'],
        'items' => $menuItems,
    ]
);
NavBar::end();
?>


<div class="container">
    <?= Alert::widget() ?>
</div>

<?= $content ?>

<div class="container-fluid footer">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                <div class="yii-lable">
                    <img
                        src="https://camo.githubusercontent.com/d10ea4bd497025fc11f5d609258752fe68345290/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f506f77657265645f62792d5969695f4672616d65776f726b2d677265656e2e7376673f7374796c653d666c6174"></p>

                </div>

                <div class="fiiter-yii-info">
                    <?= Yii::t('app', 'Yii is a high-performance PHP framework best for developing Web 2.0 applications.') ?>
                </div>

                <div class="footer-social">
                    <a href="https://github.com/yiisoft/yii2" class="github" target="_blank"></a>
                    <a href="https://twitter.com/yiiframework_ru" class="twitter" target="_blank"></a>
                    <a href="https://www.facebook.com/groups/yiitalk/" class="facebook" target="_blank"></a>
                </div>
            </div>
            <div class="col-xs-6 col-sm-4 col-md-3 col-lg-3">
                <div class="b-footer-cent">
                    <div class="footer-title">Навигация</div>
                    <ul class="footer-nav">
                        <?php
                        foreach ($menuItems as $item) {
                            $anchor = Html::a($item['label'], $item['url']);
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
                        <li><a href="#">Оставить пожелание</a></li>
                        <li><a href="#">Открытый чат</a></li>
                        <li><a href="#">Сообщать об ошибке</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="footer-copyright">
                    <p>
                        © 2009 — <?= date('Y') ?>, <?= Yii::t('app', 'Yii community') ?>, Александр Макаров<br>
                        и группа переводчиков русской документации
                    </p>

                    <p>
                        © 2008 — <?= date('Y') ?>, Yii Software LLC<br>
                        <a href="">Условия использования</a>
                    </p>

                    <p>
                        Дизайн — Сергей Хильков<br>
                        <a href="http://www.eshill.ru/" target="_blank">www.eshill.ru</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
