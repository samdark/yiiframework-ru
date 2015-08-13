<?php

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php $this->beginContent('@frontend/views/layouts/main.php') ?>
    <div class="row">
        <div class="col-xs-6">
            <?= $content ?>
        </div>
        <div class="col-xs-6">
            <h1>Что такое Yii?</h1>

            Yii — это высокоэффективный основанный на компонентной структуре PHP-фреймворк для разработки масштабных веб-приложений. Он позволяет максимально применить концепцию повторного использования кода и может существенно ускорить процесс веб-разработки. Название Yii (произносится как Yee или [ji:]) означает простой (easy), эффективный (efficient) и расширяемый (extensible).
        </div>
    </div>
<?php $this->endContent() ?>
