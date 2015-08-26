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
?>

<div class="page-header">
    <h1><?= Html::encode($question->title) ?></h1>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="question-view">

            <article class="post">

                <div class="body">
                    <?= HtmlPurifier::process(Markdown::process($question->body, 'gfm-comment')) ?>
                </div>

                <?= Html::a(
                    Yii::t('app', 'Update'),
                    ['update-question', 'id' => $question->id],
                    ['class' => 'btn btn-link btn-xs']
                ) ?>

                <?= Html::a(
                    Yii::t('app', 'Delete'),
                    ['delete-question', 'id' => $question->id],
                    [
                        'class' => 'btn btn-link btn-xs',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]
                ) ?>

                <div class="text-right">
                    <?= \common\widgets\Gravatar::widget(
                        [
                            'email' => Html::encode($question->user->email),
                            'size' => 64,
                            'options' => [
                                'class' => 'img-thumbnail',
                                'title' => Html::encode($question->user->username),
                                'alt' => Html::encode($question->user->username)
                            ]
                        ]
                    ) ?>
                    <?= Html::a(
                        Html::encode($question->user->username),
                        ['profile/view', 'id' => $question->user->id]
                    ); ?>
                </div>

            </article>

        </div>

        <div class="page-header">
            <h3><?= \Yii::t(
                    'app',
                    '{n, plural, =0{No answers} =1{One answer} other{# answers}}',
                    array(
                        'n' => count($question->answers),
                    )
                ) ?>:</h3>
        </div>

        <div class="answers">

            <?php foreach ($question->answers as $answer) : ?>

                <div class="body">
                    <?= HtmlPurifier::process(Markdown::process($answer->body, 'gfm-comment')) ?>
                </div>

                <small class="text-muted">
                    <?= Yii::$app->formatter->asDatetime($answer->updated_at); ?>
                </small>

                <?= Html::a(
                Yii::t('app', 'Update'),
                ['update-answer', 'id' => $answer->id],
                ['class' => 'btn btn-link btn-xs']
            ) ?>

                <?= Html::a(
                Yii::t('app', 'Delete'),
                ['delete-answer', 'id' => $answer->id],
                [
                    'class' => 'btn btn-link btn-xs',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]
            ) ?>

                <div class="text-right">
                    <?= \common\widgets\Gravatar::widget(
                        [
                            'email' => Html::encode($answer->user->email),
                            'size' => 48,
                            'options' => [
                                'class' => 'img-thumbnail',
                                'title' => Html::encode($answer->user->username),
                                'alt' => Html::encode($answer->user->username)
                            ]
                        ]
                    ) ?>
                    <?= Html::a(
                        Html::encode($answer->user->username),
                        ['profile/view', 'id' => $answer->user->id]
                    ); ?>
                </div>

                <hr>

            <?php endforeach ?>

        </div>

        <h3><?= Yii::t('app', 'Your Answer'); ?></h3>

        <div class="answer">

            <?php $form = ActiveForm::begin(); ?>

            <?= Markdowneditor::widget(['name' => 'answer',]) ?>

            <div class="form-group">
                <div>
                    <?= Html::submitButton(Yii::t('app', 'Post Your Answer'), ['class' => 'btn btn-success']) ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

    </div>

    <div class="col-md-4">
        <p>
            <i class="glyphicon glyphicon-calendar"></i> создан
            <?= Yii::$app->formatter->asDatetime($question->created_at); ?>
        </p>

        <?php if ($question->updated_at !== $question->created_at) : ?>
            <p>
                <i class="glyphicon glyphicon-calendar"></i> изменён
                <?= Yii::$app->formatter->asDatetime($question->updated_at); ?>
            </p>
        <?php endif; ?>

    </div>

</div>

