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
            ['label' => Yii::t('app', 'Projects'), 'url' => ['/project/']],
        ];
        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => Yii::t('app', 'Signup'), 'url' => ['/site/signup']];
            $menuItems[] = ['label' => Yii::t('app', 'Login'), 'url' => ['/site/login']];
        } else {
            $menuItems[] = [
                'label' => Yii::$app->user->identity->username,
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
        <?= Alert::widget() ?>
    </div>

    <?= $content ?>

</div>

<footer>
    <div class="container">
        <div class="row marginbot30">
            <div class="col-lg-3">
                <div class="widget">

                    <h5 class="widgetheading">
                        <img
                            src="https://camo.githubusercontent.com/d10ea4bd497025fc11f5d609258752fe68345290/68747470733a2f2f696d672e736869656c64732e696f2f62616467652f506f77657265645f62792d5969695f4672616d65776f726b2d677265656e2e7376673f7374796c653d666c6174"></p>
                    </h5>

                    <p><?= Yii::t('app', 'Yii is a high-performance PHP framework best for developing Web 2.0 applications.') ?></p>

                    <div class="copyright">
                        <p><span>© 2009 — <?= date('Y') ?>, <?= Yii::t('app', 'Yii community') ?></span>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="widget">
                    <h5 class="widgetheading"><?= Yii::t('app', 'Navigation') ?></h5>
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
                    <h5 class="widgetheading"><?= Yii::t('app', 'Support') ?></h5>
                    <ul class="link-list">
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Leave feedback'),
                                'http://yiiframework.ru/forum/viewforum.php?f=5',
                                ['target' => '_blank']
                            ) ?>
                        </li>
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
