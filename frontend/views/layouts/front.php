<?php

/* @var $this \yii\web\View */
use yii\helpers\Html;

/* @var $content string */
?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>

<div class="promo">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <img src="/images/ui-kit-carpet.png" alt="yii-framework-ru" class="img-responsive">
            </div>
            <div class="col-md-7">
                <h1>Русскоязычное сообщество Yii</h1>

                <p>
                    Yii — это высокоэффективный основанный на компонентной структуре PHP-фреймворк
                    для разработки масштабных веб-приложений. Он позволяет максимально применить концепцию
                    повторного
                    использования кода и может существенно ускорить процесс веб-разработки.
                    Название Yii (произносится как Yee или [ji:]) означает простой (easy),
                    эффективный (efficient) и расширяемый (extensible).
                </p>
            </div>
        </div>
    </div>
</div>

<div id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-5 col-lg-4 text-right">
                <div class="versions">
                    <?= Yii::t('app', 'Get last stable version:') ?>
                    <?= Html::a(\Yii::$app->params['yii1-tag-name'], \Yii::$app->params['yii1-html-url']) ?> /
                    <?= Html::a(\Yii::$app->params['yii2-tag-name'], \Yii::$app->params['yii2-html-url']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <?= $content ?>
        </div>
        <div class="col-md-6">

            <a class="twitter-timeline"
               data-tweet-limit="3"
               data-link-color="#306495"
               data-dnt="true"
               href="https://twitter.com/yiiframework_ru"
               data-widget-id="344811392374820865">
            </a>

            <?php $this->registerJs(
                '!function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? "http" : "https";
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");'
            ); ?>

        </div>
    </div>
</div>
<?php $this->endContent() ?>
