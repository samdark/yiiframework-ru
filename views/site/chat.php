<?php

use app\components\MetaTagsRegistrar;

/* @var $this yii\web\View */

(new MetaTagsRegistrar($this))
    ->setTitle('Чаты')
    ->setDescription('Чаты сообщества Yii')
    ->register();
?>
<div class="site-chat">
    <h2>Русскоязычные чаты в Telegram</h2>
    
    <ul>
        <li><a href="tg://resolve?domain=yii1ru">Yii 1.1</a></li>
        <li><a href="tg://resolve?domain=yii2ru">Yii 2</a></li>
        <li><a href="tg://resolve?domain=yii3ru">Yii 3</a></li>
    </ul>

    <h2>Slack, IRC</h2>

    <ul>
        <li><a href="https://www.yiiframework.com/chat">Официальный Slack, IRC</a></li>
    </ul>

    <p>В Slack есть русскоязычный канал #russian.</p>
</div>
