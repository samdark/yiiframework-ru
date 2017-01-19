<?php

use app\components\MetaTagsRegistrar;
use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

(new MetaTagsRegistrar($this))
    ->setTitle(Yii::t('app', 'Projects based on Yii framework'))
    ->setDescription('Список проектов, которые были созданы с помощью фреймворка Yii')
    ->useOpenGraphMetaTags()
    ->useTwitterMetaTags()
    ->register();
?>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

    <symbol id="ico_like" viewBox="0 0 29 26">
        <path
            d="M24.8513339,4.11991813 C21.9944483,1.30038188 17.3660135,1.29337806 14.500125,4.09890668 C11.6342366,1.29337806 7.00480149,1.30038188 4.14791585,4.11991813 C1.28402805,6.9464582 1.28402805,11.5299556 4.14791585,14.3564956 C4.28695896,14.4945709 11.0840661,21.1702082 13.5868419,23.6285476 C14.0919985,24.1238175 14.9072512,24.1238175 15.4124078,23.6285476 C17.9151837,21.1702082 24.7122908,14.4945709 24.8513339,14.3564956 C27.716222,11.5299556 27.716222,6.9464582 24.8513339,4.11991813 L24.8513339,4.11991813 Z"></path>
    </symbol>

    <symbol id="ico_view" viewBox="0 0 25 15">
        <path
            d="M12.500,-0.000 C7.048,-0.000 2.322,3.048 -0.000,7.500 C2.322,11.952 7.048,15.000 12.500,15.000 C17.952,15.000 22.678,11.952 25.000,7.500 C22.678,3.048 17.952,-0.000 12.500,-0.000 ZM18.663,3.977 C20.132,4.877 21.377,6.081 22.312,7.500 C21.377,8.918 20.132,10.123 18.663,11.023 C16.818,12.153 14.686,12.750 12.500,12.750 C10.313,12.750 8.182,12.153 6.337,11.023 C4.868,10.123 3.623,8.918 2.688,7.500 C3.623,6.081 4.868,4.877 6.337,3.977 C6.432,3.919 6.529,3.862 6.626,3.806 C6.383,4.447 6.250,5.138 6.250,5.859 C6.250,9.173 9.048,11.859 12.500,11.859 C15.952,11.859 18.750,9.173 18.750,5.859 C18.750,5.138 18.617,4.447 18.374,3.806 C18.471,3.862 18.568,3.919 18.663,3.977 ZM12.500,5.109 C12.500,6.352 11.451,7.359 10.156,7.359 C8.862,7.359 7.812,6.352 7.812,5.109 C7.812,3.867 8.862,2.859 10.156,2.859 C11.451,2.859 12.500,3.867 12.500,5.109 Z"></path>
    </symbol>

    <symbol id="ico_comment" viewBox="0 0 443 443">
        <path
            d="M76.579,433.451V335.26C27.8,300.038,0,249.409,0,195.254C0,93.155,99.486,10.09,221.771,10.09 s221.771,83.065,221.771,185.164s-99.486,185.164-221.771,185.164c-14.488,0-29.077-1.211-43.445-3.604L76.579,433.451z"></path>
    </symbol>

</svg>

<div class="row">
    <div class="col-md-9">

        <div class="projects-list">

            <div class="row">
                <?php foreach ($dataProvider->getModels() as $project): ?>
                    <div class="col-md-4">
                        <?= $this->render('_project', ['project' => $project]) ?>
                    </div>
                <?php endforeach ?>
            </div>

            <?= LinkPager::widget(
                [
                    'pagination' => $dataProvider->getPagination(),
                ]
            ) ?>

        </div>
    </div>

    <div class="col-md-3">
        <?= Html::a(Yii::t('app', 'Add Project'), ['create'], ['class' => 'btn btn-lg btn-border-success btn-block']) ?>

        <div class="tabbable tabs-right">
            <div class="title">Сортировать по:</div>
            <ul class="nav nav-tabs">
                <li class="active"><a href="">Дате добавления</a></li>
                <li><a href="">Популярности</a></li>
                <li><a href="">Просмотрам</a></li>
                <li><a href="">Количеству комментариев</a></li>
            </ul>
        </div>

        <div class="q-tags">
            <div class="title">Теги:</div>
            <a href="" class="btn btn-default btn-sm">Yii framework</a>
            <a href="" class="btn btn-default btn-sm">jQuery</a>
            <a href="" class="btn btn-default btn-sm">Yii 2.x</a>
            <a href="" class="btn btn-default btn-sm">Общие вопросы</a>
            <a href="" class="btn btn-default btn-sm">Безопасность</a>
        </div>

        <div class="q-info" style="margin-top: 50px;">
            <div class="q-info-like active">
                <svg>
                    <use xlink:href="#ico_like"/>
                </svg>
                <a href="" class="c-red"><span>Избранные проекты</span></a>
            </div>
        </div>
    </div>

</div>



