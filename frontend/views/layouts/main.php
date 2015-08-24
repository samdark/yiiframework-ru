<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <header>
        <?php
        NavBar::begin(
            [
                'brandLabel' => '<span class="animated flash text-orange">y</span><span class="animated flash text-green">i</span><span class="animated flash text-blue">i</span>framework.ru',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar navbar-default drop navbar-static-top',
                ],
            ]
        );
        $menuItems = [
            ['label' => '1.1', 'url' => ['/site/legacy']],
            ['label' => 'Twitter', 'url' => 'http://twitter.com/yiiframework_ru'],
            ['label' => Yii::t('app', 'Guide'), 'url' => 'http://www.yiiframework.com/doc-2.0/guide-index.html'],
            ['label' => 'API', 'url' => 'http://www.yiiframework.com/doc-2.0/index.html'],
            ['label' => Yii::t('app', 'Extensions'), 'url' => 'https://yiigist.com/'],
            ['label' => Yii::t('app', 'Chat'), 'url' => 'https://gitter.im/yiisoft/yii2/rus'],
            ['label' => Yii::t('app', 'Forum'), 'url' => '/forum/'],
            ['label' => Yii::t('app', 'Member List'), 'url' => ['/profile/list']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
            $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' => Yii::t('app', '{username}', ['username' => Yii::$app->user->identity->username]),
                'url' => '#',
                'items' => [
                    ['label' => Yii::t('app', 'My profile'), 'url' => ['/profile/index']],
                    ['label' => Yii::t('app', 'Edit profile'), 'url' => ['/profile/update']],
                    [
                        'label' => Yii::t('app', 'Logout'),
                        'url' => ['/site/logout'],
                        'linkOptions' => ['data-method' => 'post']
                    ]
                ]
            ];
        }
        echo Nav::widget(
            [
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]
        );
        NavBar::end();
        ?>
    </header>

    <div class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-7 col-lg-8">
                <?= Breadcrumbs::widget(
                    [
                        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                    ]
                ) ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4 text-right">
                <div class="versions">
                    <?= Yii::t('app', 'Get last stable version:') ?>
                    <?= Html::a(\Yii::$app->params['yii1-tag-name'], \Yii::$app->params['yii1-html-url']) ?> /
                    <?= Html::a(\Yii::$app->params['yii2-tag-name'], \Yii::$app->params['yii2-html-url']) ?>
                </div>
            </div>
        </div>

        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="widget">
                    <h5 class="widgetheading">Yii framework.</h5>

                    <p>Yii is a high-performance PHP framework best for developing Web 2.0 applications.</p>

                    <div class="copyright">
                        <p><span>© 2009 — <?= date('Y') ?>, Yii community</span></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget">
                    <h5 class="widgetheading">Navigation</h5>
                    <ul class="link-list">
                        <?
                        foreach ($menuItems as $item) {
                            $anchor = Html::a($item['label'], $item['url']);

                            echo Html::tag('li', $anchor);
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget">
                    <h5 class="widgetheading">Support</h5>
                    <ul class="link-list">
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Leave feedback'),
                                'http://yiiframework.ru/forum/viewforum.php?f=5',
                                ['target' => '_blank']
                            ) ?>                        </li>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Public chat'),
                                'https://gitter.im/yiisoft/yii2/rus',
                                ['target' => '_blank']
                            ) ?>
                        </li>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Report a bug'),
                                'https://github.com/samdark/yiiframework-ru/issues',
                                ['target' => '_blank']
                            ) ?>
                        </li>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Twitter'),
                                'https://twitter.com/yiiframework_ru',
                                ['target' => '_blank']
                            ) ?>
                        </li>
                        <li>
                            <?= Html::a(Yii::t('app', 'Forum'), ['/forum']) ?>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget">

                </div>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
