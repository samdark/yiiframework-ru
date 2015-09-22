<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use common\helpers\Generator;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Questions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="question-index">
    <div class="row">
        <div class="col-xs-6">
            <h1><?= Html::encode($this->title) ?></h1>
        </div>
        <div class="col-xs-6 text-right">
            <h1>
                <?= Html::a(Yii::t('app', 'Add Question'), ['create'], ['class' => 'btn btn-success btn-lg']) ?>
            </h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9">
            <?php foreach ($dataProvider->getModels() as $question): ?>
                <?php /* @var $question \common\models\Question */ ?>
                <div class="row question">
                    <div class="col-md-12">
                        <strong><?= Html::a(Html::encode($question->title), ['/qa/view', 'id' => $question->id]); ?></strong>
                        <p>
                            <small><i class="glyphicon glyphicon-calendar"></i> <?= Yii::$app->formatter->asDate($question->created_at); ?></small>
                            <small><i class="glyphicon glyphicon-user"></i> <?= Html::a(Html::encode($question->user->username), ['profile/view', 'id' => $question->user->id]); ?></small>
                        </p>

                        <?= HtmlPurifier::process(
                            Markdown::process(Generator::limitWords($question->body, 40), 'gfm-comment')
                        ) ?>
                    </div>

                    <div class="col-md-12">
                        <?php foreach ($question->tags as $tag) : ?>
                            <span class="label label-default" style="background-color: <?= $tag->color ?>"><?= Html::encode($tag->name) ?></span>&nbsp;
                        <?php endforeach ?>
                    </div>

                    <div class="col-md-4 text-center text-blue">
                        <div><span class="glyphicon glyphicon-triangle-top" aria-hidden="true"></span> <?= $countVote = $question->vote_count ?> <span class="glyphicon glyphicon-triangle-bottom" aria-hidden="true"></span></div>
                        <?= \Yii::t(
                            'app',
                            '{n, plural, =0{votes} =1{vote} other{votes}}',
                            [
                                'n' => $countVote
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-4 text-center text-orange">
                        <div><?= $countAnswers = $question->answer_count ?></div>
                        <?= \Yii::t(
                            'app',
                            '{n, plural, =0{answers} =1{answer} other{answers}}',
                            [
                                'n' => $countAnswers
                            ]
                        ) ?>
                    </div>

                    <div class="col-md-4 text-center text-green">
                        <div><?= $countView = $question->view_count ?></div>
                        <?= \Yii::t(
                            'app',
                            '{n, plural, =0{views} =1{view} other{views}}',
                            [
                                'n' => $countView
                            ]
                        ) ?>
                    </div>
                </div>

                <hr class="separator" />
            <?php endforeach; ?>
        </div>

        <div class="col-md-3"></div>
    </div>

    <?= LinkPager::widget(
        [
            'maxButtonCount' => 6,
            'options' => ['class' => 'pagination pagination-sm'],
            'lastPageLabel' => true,
            'firstPageLabel' => true,
            'pagination' => $dataProvider->getPagination(),
        ]
    ) ?>
</div>