<?php

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginContent('@app/views/layouts/main.php') ?>

<div class="container-fluid promo">
    <div class="container">
        <div class="row">
            <div class="hidden-xs col-sm-5 col-md-5 col-lg-5">
                <img src="/i/yii_user.png" class="promo-img">
            </div>

            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7 promo-inf">
                <div class="promo-title">Русскоязычное сообщество Yii</div>
                <div class="promo-description">
                    Yii — это высокоэффективный основанный на компонентной структуре PHP-фреймворк для разработки
                    масштабных веб-приложений. Он позволяет максимально применить концепцию повторного использования
                    кода и может существенно ускорить процесс веб-разработки. Название Yii (произносится как Yee или
                    [ji:]) означает простой (easy), эффективный (efficient) и расширяемый (extensible).
                </div>
                <?= Html::a(
                    ' <svg width="32" height="32" viewBox="0 0 32 32" class="ico-github">
                        <path d="M29.856,7.912 C28.425,5.477 26.484,3.549 24.032,2.129 C21.580,0.708 18.903,-0.003 16.000,-0.003 C13.097,-0.003 10.419,0.708 7.967,2.129 C5.516,3.549 3.575,5.477 2.144,7.912 C0.713,10.347 -0.003,13.006 -0.003,15.888 C-0.003,19.351 1.015,22.465 3.050,25.231 C5.085,27.996 7.714,29.910 10.936,30.972 C11.312,31.041 11.589,30.993 11.770,30.828 C11.950,30.662 12.041,30.455 12.041,30.207 C12.041,30.166 12.037,29.793 12.030,29.090 C12.023,28.386 12.020,27.772 12.020,27.248 L11.540,27.331 C11.235,27.386 10.849,27.410 10.384,27.403 C9.919,27.397 9.436,27.348 8.936,27.258 C8.436,27.169 7.970,26.962 7.540,26.638 C7.109,26.314 6.804,25.890 6.623,25.366 L6.415,24.889 C6.276,24.572 6.057,24.220 5.759,23.834 C5.460,23.448 5.158,23.186 4.852,23.048 L4.706,22.945 C4.609,22.876 4.519,22.793 4.436,22.696 C4.352,22.600 4.290,22.503 4.248,22.406 C4.206,22.310 4.241,22.230 4.352,22.168 C4.463,22.106 4.665,22.075 4.957,22.075 L5.373,22.137 C5.651,22.193 5.995,22.358 6.405,22.634 C6.814,22.910 7.151,23.268 7.415,23.710 C7.735,24.275 8.120,24.706 8.571,25.003 C9.023,25.299 9.478,25.448 9.936,25.448 C10.394,25.448 10.790,25.413 11.124,25.344 C11.457,25.276 11.770,25.172 12.061,25.034 C12.186,24.110 12.527,23.399 13.082,22.903 C12.291,22.820 11.579,22.696 10.947,22.530 C10.315,22.365 9.662,22.096 8.988,21.723 C8.314,21.351 7.755,20.888 7.311,20.337 C6.866,19.785 6.501,19.061 6.217,18.164 C5.932,17.267 5.790,16.233 5.790,15.060 C5.790,13.391 6.339,11.970 7.436,10.798 C6.922,9.542 6.971,8.135 7.582,6.577 C7.985,6.452 8.582,6.546 9.374,6.856 C10.166,7.166 10.745,7.432 11.114,7.653 C11.482,7.873 11.777,8.060 11.999,8.211 C13.291,7.853 14.625,7.673 16.000,7.673 C17.375,7.673 18.709,7.853 20.001,8.211 L20.793,7.715 C21.334,7.384 21.974,7.080 22.709,6.804 C23.446,6.529 24.009,6.453 24.397,6.577 C25.023,8.136 25.078,9.543 24.564,10.798 C25.661,11.970 26.210,13.391 26.210,15.060 C26.210,16.233 26.068,17.271 25.783,18.174 C25.498,19.078 25.130,19.802 24.679,20.347 C24.227,20.892 23.665,21.351 22.991,21.723 C22.317,22.096 21.664,22.365 21.032,22.530 C20.400,22.696 19.688,22.820 18.897,22.903 C19.619,23.524 19.980,24.503 19.980,25.841 L19.980,30.207 C19.980,30.455 20.067,30.662 20.241,30.827 C20.414,30.992 20.688,31.041 21.064,30.972 C24.286,29.910 26.915,27.996 28.950,25.230 C30.985,22.464 32.003,19.351 32.003,15.887 C32.002,13.005 31.286,10.347 29.856,7.912 Z"/>
                    </svg>
                    <span class="btn-promo-title">' . \Yii::$app->params['yii2-tag-name'] . '</span>',
                    \Yii::$app->params['yii2-html-url'], ['class' => 'btn btn-success btn-lg pull-left btn-promo']
                ) ?>
                <div class="promo-or"><?= Html::a(
                        Yii::t('app', 'or {n} version', ['n' => \Yii::$app->params['yii1-tag-name']]),
                        \Yii::$app->params['yii1-html-url']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid yii-features">
    <div class="ico-f-close"></div>
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="f-title-big">Быстрый, безопасный и профессиональный PHP Framework</div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="ico-fast"><img src="/i/ico_f_fast.svg" alt=""></div>
                <div class="f-title fast">Быстрый</div>
                <div class="f-descr">
                    Yii запускает только то, что используется, имеет мощную систему кэширирования и изначально нацелен на
                    отличную работу с AJAX.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="ico-secure"><img src="/i/ico_f_secure.svg" alt=""></div>
                <div class="f-title secure">Безопасный</div>
                <div class="f-descr">
                    В Yii есть всё для обеспечения безопасности: валидация, фильтрация, защита от SQL-инъекций и XSS.
                </div>
            </div>
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                <div class="ico-professional"><img src="/i/ico_f_professional.svg" alt=""></div>
                <div class="f-title professional">Профессиональный</div>
                <div class="f-descr">
                    Yii помогает писать чистый гибкий код. Фреймворк следует MVC и чётко отделяет логику от отображения.
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid index-search">
    <div class="container">
        <form action="http://www.google.com/cse" id="cse-search-box" target="_blank" rel="noopener noreferrer">
            <input type="hidden" name="cx" value="006237035567373325440:sm9smqhhp9u" />
            <input type="hidden" name="ie" value="UTF-8" />
            <input type="text" class="form-control input-lg" name="q" size="14" placeholder="<?= Yii::t('app', 'Search') ?>" />
        </form>
    </div>
</div>

<div class="container">
    <?= $content ?>
</div>
<?php $this->endContent() ?>
