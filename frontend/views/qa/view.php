<?php

use ijackua\lepture\Markdowneditor;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $newAnswer common\models\Answer */

$this->title = $question->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Questions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="row">
    <div class="col-md-8">
        <div class="question-view">

            <h1><?= Html::encode($question->title) ?></h1>

            <article class="post">

                <div class="body">
                    <?= HtmlPurifier::process(Markdown::process($question->body, 'gfm-comment')) ?>
                </div>

                <div class="bottom-article">
                    <ul class="meta-post">
                        <li><i class="glyphicon glyphicon-calendar"></i><?= Yii::$app->formatter->asDate(
                                $question->updated_at
                            ); ?></li>
                        <li>
                            <i class="glyphicon glyphicon-user"></i>
                            <?= Html::a(
                                Html::encode($question->user->username),
                                ['profile/view', 'id' => $question->user->id]
                            ); ?>
                        </li>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Update'),
                                ['update', 'id' => $question->id],
                                ['class' => 'btn btn-primary btn-xs']
                            ) ?>
                        </li>
                        <li>
                            <?= Html::a(
                                Yii::t('app', 'Delete'),
                                ['delete', 'id' => $question->id],
                                [
                                    'class' => 'btn btn-danger btn-xs',
                                    'data' => [
                                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]
                            ) ?>
                        </li>
                    </ul>
                </div>

            </article>

        </div>

        <div class="answers">

            <h2><?= \Yii::t(
                    'app',
                    '{n, plural, =0{No answers} =1{One answer} other{# answers}}',
                    array(
                        'n' => count($question->answers),
                    )
                ) ?></h2>

            <?php foreach ($question->answers as $answer) : ?>

                <article class="post">

                    <div class="body">
                        <?= HtmlPurifier::process(Markdown::process($answer->body, 'gfm-comment')) ?>
                    </div>

                    <div class="bottom-article">
                        <ul class="meta-post">
                            <li><i class="glyphicon glyphicon-calendar"></i><?= Yii::$app->formatter->asDate(
                                    $answer->updated_at
                                ); ?></li>
                            <li>
                                <i class="glyphicon glyphicon-user"></i>
                                <?= Html::a(
                                    Html::encode($answer->user->username),
                                    ['profile/view', 'id' => $answer->user->id]
                                ); ?>
                            </li>
                        </ul>
                    </div>

                </article>

            <?php endforeach ?>

        </div>

        <hr>

        <div class="answer">

            <h3><?= Yii::t('app', 'Your Answer'); ?></h3>

            <?php $form = ActiveForm::begin(); ?>

            <?= Markdowneditor::widget(
                [
                    'model' => $newAnswer,
                    'attribute' => 'body',
                ]
            ) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton(Yii::t('app', 'Post Your Answer'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>


    </div>

    <div class="col-md-4">

    </div>

</div>

