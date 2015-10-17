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

                <div class="row">
                    <div class="col-xs-5">
                        <?= Html::a(
                            '<span class="flaticon-github10"></span>&nbsp;' . \Yii::$app->params['yii2-tag-name'],
                            \Yii::$app->params['yii2-html-url'],
                            [
                                'class' => 'btn btn-lg btn-success btn-block text-white',
                            ]) ?>
                    </div>
                    <div class="col-xs-7">
                        <?= Html::a(
                            Yii::t('app', 'or {n} version', ['n' => \Yii::$app->params['yii1-tag-name']]),
                            \Yii::$app->params['yii1-html-url'],
                            [
                                'class' => 'btn btn-lg btn-success btn-link',
                            ]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-dark-gray">
    <div class="container">
        <h1 class="text-center">Быстрый, безопасный и профессиональный PHP Framework</h1>

        <div class="row">
            <div class="col-xs-4 text-center">
                <h1><span class="flaticon-rocketship4 flaticon-2x"></span></h1>

                <h2>Быстрый</h2>
            </div>
            <div class="col-xs-4 text-center">
                <h1><span class="flaticon-savings6 flaticon-2x"></span></h1>

                <h2>Безопасный</h2>
            </div>
            <div class="col-xs-4 text-center">
                <h1><span class="flaticon-connection87 flaticon-2x"></span></h1>

                <h2>Профессиональный</h2>
            </div>
        </div>
    </div>
</div>


<div class="box box-gray">
    <div class="container">
        <form>
            <div class="input-group">
                        <span class="input-group-addon" id="basic-addon1"><span
                                class="flaticon-magnifier58"></span></span>
                <input type="text" class="form-control" placeholder="<?= Yii::t('app', 'Search') ?>"
                       aria-describedby="basic-addon1">
            </div>
        </form>

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
