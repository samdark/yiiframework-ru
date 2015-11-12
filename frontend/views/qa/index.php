<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Menu;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('qa', 'Questions');
?>
<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

    <symbol id="ico_like" viewBox="0 0 29 26">
        <path d="M24.8513339,4.11991813 C21.9944483,1.30038188 17.3660135,1.29337806 14.500125,4.09890668 C11.6342366,1.29337806 7.00480149,1.30038188 4.14791585,4.11991813 C1.28402805,6.9464582 1.28402805,11.5299556 4.14791585,14.3564956 C4.28695896,14.4945709 11.0840661,21.1702082 13.5868419,23.6285476 C14.0919985,24.1238175 14.9072512,24.1238175 15.4124078,23.6285476 C17.9151837,21.1702082 24.7122908,14.4945709 24.8513339,14.3564956 C27.716222,11.5299556 27.716222,6.9464582 24.8513339,4.11991813 L24.8513339,4.11991813 Z"></path>
    </symbol>

    <symbol id="ico_view" viewBox="0 0 25 15">
        <path d="M12.500,-0.000 C7.048,-0.000 2.322,3.048 -0.000,7.500 C2.322,11.952 7.048,15.000 12.500,15.000 C17.952,15.000 22.678,11.952 25.000,7.500 C22.678,3.048 17.952,-0.000 12.500,-0.000 ZM18.663,3.977 C20.132,4.877 21.377,6.081 22.312,7.500 C21.377,8.918 20.132,10.123 18.663,11.023 C16.818,12.153 14.686,12.750 12.500,12.750 C10.313,12.750 8.182,12.153 6.337,11.023 C4.868,10.123 3.623,8.918 2.688,7.500 C3.623,6.081 4.868,4.877 6.337,3.977 C6.432,3.919 6.529,3.862 6.626,3.806 C6.383,4.447 6.250,5.138 6.250,5.859 C6.250,9.173 9.048,11.859 12.500,11.859 C15.952,11.859 18.750,9.173 18.750,5.859 C18.750,5.138 18.617,4.447 18.374,3.806 C18.471,3.862 18.568,3.919 18.663,3.977 ZM12.500,5.109 C12.500,6.352 11.451,7.359 10.156,7.359 C8.862,7.359 7.812,6.352 7.812,5.109 C7.812,3.867 8.862,2.859 10.156,2.859 C11.451,2.859 12.500,3.867 12.500,5.109 Z"/>
    </symbol>

    <symbol id="ico_true" viewBox="0 0 18 14">
        <path d="M16.5575,4.8180749 L8.6465,13.5180255 C8.0595,14.1616582 7.1095,14.1616582 6.5235,13.5180255 L2.4395,9.02568736 C1.8535,8.38205465 1.8535,7.33587878 2.4395,6.69224607 C3.0255,6.04752246 3.9755,6.04752246 4.5615,6.69115517 L7.5845,10.0162272 L14.4345,2.48354271 C15.0205,1.8388191 15.9715,1.8388191 16.5575,2.48354271 C17.1435,3.12717541 17.1435,4.17226039 16.5575,4.8180749 L16.5575,4.8180749 Z" />
    </symbol>

</svg>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">

        <?= Menu::widget([
            'options' => [
                'class' => 'nav nav-tabs'
            ],
            'linkTemplate' => '<a role="presentation" href="{url}">{label}</a>',
            'items' => [
                ['label' => Yii::t('qa', 'All questions'), 'url' => ['qa/index']],
                ['label' => Yii::t('qa', 'Unanswered'), 'url' => ['qa/without-answer']],
                ['label' => Yii::t('qa', 'Solved questions'), 'url' => ['qa/solved']],
                ['label' => Yii::t('qa', 'My questions'), 'url' => ['qa/my'], 'visible' => !Yii::$app->user->isGuest],
                ['label' => Yii::t('qa', 'Favorites'), 'url' => ['qa/favorite'], 'visible' => !Yii::$app->user->isGuest]
            ],
        ]); ?>

        <div class="questions-list">
            <?php if ($dataProvider->getModels()) : ?>

                <?php foreach ($dataProvider->getModels() as $question): ?>
                    <?= $this->render('_question', [
                        'question' => $question
                    ]) ?>
                <?php endforeach; ?>

            <?php else : ?>
                <div class="text-center"><?= Yii::t('qa', 'Questions are missing.') ?></div>
            <?php endif ; ?>
        </div>

        <?= LinkPager::widget(
            [
                'maxButtonCount' => 6,
                'lastPageLabel' => true,
                'firstPageLabel' => true,
                'options' => ['class' => 'pagination pagination-sm'],
                'pagination' => $dataProvider->getPagination()
            ]
        ) ?>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

        <?= Html::a(Yii::t('qa', 'Add Question'), ['create'], ['class' => 'btn btn-lg btn-border-success btn-block']) ?>

        <div class="tabbable tabs-right">
            <div class="title"><?= Yii::t('qa', 'Sort by') ?>:</div>
            <ul class="nav nav-tabs">
                <li class="active"><?= Html::a(Yii::t('qa', '---'), '#') ?></li>
                <li><?= Html::a(Yii::t('qa', '---'), '#') ?></li>
                <li><?= Html::a(Yii::t('qa', '---'), '#') ?></li>
            </ul>
        </div>

        <div class="q-tags">
            <div class="title"><?= Yii::t('qa', 'Tags') ?>:</div>
            <?= Html::a(Yii::t('qa', '---'), '#', ['class' => 'btn btn-default btn-sm']) ?>
            <?= Html::a(Yii::t('qa', '---'), '#', ['class' => 'btn btn-default btn-sm']) ?>
            <?= Html::a(Yii::t('qa', '---'), '#', ['class' => 'btn btn-default btn-sm']) ?>
            <?= Html::a(Yii::t('qa', '---'), '#', ['class' => 'btn btn-default btn-sm']) ?>
        </div>

    </div>
</div>
