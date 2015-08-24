<?php

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
<div class="row">
    <div class="col-md-6">
        <?= $content ?>
    </div>
    <div class="col-md-6">

        <h1>Что такое Yii?</h1>

        <p>Yii — это высокоэффективный основанный на компонентной структуре PHP-фреймворк
        для разработки масштабных веб-приложений. Он позволяет максимально применить концепцию повторного
        использования кода и может существенно ускорить процесс веб-разработки.
        Название Yii (произносится как Yee или [ji:]) означает простой (easy),
        эффективный (efficient) и расширяемый (extensible).</p>

        <br>

        <a class="twitter-timeline"
           data-tweet-limit="3"
           data-link-color="#306495"
           data-dnt="true"
           href="https://twitter.com/yiiframework_ru"
           data-widget-id="344811392374820865">
        </a>

        <script>
            !function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                if (!d.getElementById(id)) {
                    js = d.createElement(s);
                    js.id = id;
                    js.src = p + "://platform.twitter.com/widgets.js";
                    fjs.parentNode.insertBefore(js, fjs);
                }
            }(document, "script", "twitter-wjs");
        </script>
    </div>
</div>
<?php $this->endContent() ?>
