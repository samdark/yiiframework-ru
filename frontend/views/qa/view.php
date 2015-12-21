<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $question common\models\Question */
/* @var $answers \common\models\QuestionAnswer */
/* @var $answerForm \frontend\models\QuestionAnswerForm */

$this->title = Html::encode($question->title);
?>

<svg xmlns="http://www.w3.org/2000/svg" style="display: none;">

    <symbol id="ico_view" viewBox="0 0 25 15">
        <path
            d="M12.500,-0.000 C7.048,-0.000 2.322,3.048 -0.000,7.500 C2.322,11.952 7.048,15.000 12.500,15.000 C17.952,15.000 22.678,11.952 25.000,7.500 C22.678,3.048 17.952,-0.000 12.500,-0.000 ZM18.663,3.977 C20.132,4.877 21.377,6.081 22.312,7.500 C21.377,8.918 20.132,10.123 18.663,11.023 C16.818,12.153 14.686,12.750 12.500,12.750 C10.313,12.750 8.182,12.153 6.337,11.023 C4.868,10.123 3.623,8.918 2.688,7.500 C3.623,6.081 4.868,4.877 6.337,3.977 C6.432,3.919 6.529,3.862 6.626,3.806 C6.383,4.447 6.250,5.138 6.250,5.859 C6.250,9.173 9.048,11.859 12.500,11.859 C15.952,11.859 18.750,9.173 18.750,5.859 C18.750,5.138 18.617,4.447 18.374,3.806 C18.471,3.862 18.568,3.919 18.663,3.977 ZM12.500,5.109 C12.500,6.352 11.451,7.359 10.156,7.359 C8.862,7.359 7.812,6.352 7.812,5.109 C7.812,3.867 8.862,2.859 10.156,2.859 C11.451,2.859 12.500,3.867 12.500,5.109 Z"/>
    </symbol>

    <symbol id="ico_edit" viewBox="0 0 27 27">
        <path
            d="M14.979,5.199 C14.324,4.544 13.262,4.544 12.608,5.199 L12.015,5.792 L3.716,14.097 L3.718,14.099 L3.457,14.361 C3.457,14.361 2.623,15.200 0.740,21.276 C0.727,21.319 0.714,21.361 0.700,21.404 C0.667,21.513 0.633,21.624 0.599,21.736 C0.568,21.835 0.538,21.936 0.507,22.038 C0.481,22.123 0.455,22.208 0.429,22.296 C0.369,22.495 0.309,22.698 0.247,22.907 C0.112,23.365 -0.219,24.400 0.155,24.775 C0.515,25.135 1.561,24.818 2.019,24.683 C2.226,24.621 2.428,24.561 2.625,24.501 C2.716,24.474 2.805,24.447 2.894,24.419 C2.990,24.390 3.085,24.361 3.179,24.333 C3.297,24.296 3.413,24.261 3.527,24.225 C3.561,24.214 3.595,24.204 3.629,24.193 C9.412,22.393 10.450,21.549 10.537,21.471 C10.537,21.471 10.537,21.471 10.538,21.470 C10.541,21.467 10.544,21.465 10.544,21.465 L10.812,21.197 L10.830,21.214 L19.129,12.910 L19.128,12.910 L19.721,12.317 C20.376,11.662 20.376,10.600 19.721,9.945 L14.979,5.199 ZM9.589,20.392 C9.582,20.397 9.572,20.403 9.562,20.410 C9.556,20.414 9.549,20.418 9.542,20.422 C9.535,20.427 9.527,20.431 9.519,20.436 C9.512,20.441 9.505,20.445 9.497,20.450 C9.221,20.615 8.410,21.041 6.444,21.753 C6.214,21.836 5.964,21.924 5.702,22.015 L2.906,19.218 C2.998,18.954 3.086,18.702 3.169,18.470 C3.879,16.497 4.305,15.684 4.470,15.409 C4.474,15.402 4.477,15.396 4.481,15.390 C4.487,15.381 4.492,15.372 4.497,15.364 C4.501,15.357 4.505,15.351 4.509,15.345 C4.516,15.335 4.522,15.325 4.527,15.317 L4.731,15.113 L9.798,20.182 L9.589,20.392 ZM24.463,5.199 L19.721,0.454 C19.066,-0.201 18.005,-0.201 17.350,0.454 L16.164,1.640 C15.510,2.295 15.510,3.358 16.164,4.013 L20.907,8.758 C21.561,9.413 22.623,9.413 23.278,8.758 L24.463,7.572 C25.118,6.917 25.118,5.854 24.463,5.199 Z"/>
    </symbol>

    <symbol id="ico_del" viewBox="0 0 32 32">
        <path
            d="M28.494,27.764 L27.764,28.494 L16.000,16.730 L4.236,28.494 L3.506,27.764 L15.270,16.000 L3.506,4.236 L4.236,3.506 L16.000,15.270 L27.764,3.506 L28.494,4.236 L16.730,16.000 L28.494,27.764 Z"/>
    </symbol>

    <symbol id="ico_true" viewBox="0 0 18 14">
        <path
            d="M16.5575,4.8180749 L8.6465,13.5180255 C8.0595,14.1616582 7.1095,14.1616582 6.5235,13.5180255 L2.4395,9.02568736 C1.8535,8.38205465 1.8535,7.33587878 2.4395,6.69224607 C3.0255,6.04752246 3.9755,6.04752246 4.5615,6.69115517 L7.5845,10.0162272 L14.4345,2.48354271 C15.0205,1.8388191 15.9715,1.8388191 16.5575,2.48354271 C17.1435,3.12717541 17.1435,4.17226039 16.5575,4.8180749 L16.5575,4.8180749 Z"/>
    </symbol>

</svg>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 b-rel">

        <?php if (Yii::$app->user->getId() == $question->user_id) : ?>
            <div class="q-tools">
                <?= Html::a(
                    '<svg><use xlink:href="#ico_del"/></svg>',
                    ['delete-question', 'id' => $question->id],
                    [
                        'class' => 'btn btn-lg btn-border-danger btn-border-del pull-right',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]
                ) ?>

                <?= Html::a(
                    '<svg><use xlink:href="#ico_edit"/></svg>',
                    ['update-question', 'id' => $question->id],
                    ['class' => 'btn btn-lg btn-border-primary btn-border-edit pull-right']
                ) ?>
            </div>
        <?php endif ; ?>

        <h1 class="q-h1">
            <?= Html::encode($question->title) ?>
        </h1>

        <div class="post-info">
            <?= ($question->updated_at !== $question->created_at) ?
                Yii::$app->formatter->asDatetime($question->updated_at) :
                Yii::$app->formatter->asDatetime($question->created_at);
            ?>
            <span class="margin-line">|</span>
            <?= Html::a(
                Html::encode($question->user->username),
                ['profile/view', 'id' => $question->user->id]
            ); ?>
            <?= $question->solved ? '<span class="ico_true ico_true_green"><svg><use xlink:href="#ico_true" /></svg> ' . Yii::t('qa', 'Resolve') . '</span>' : '' ?>
        </div>

        <?= HtmlPurifier::process(Markdown::process($question->body, 'gfm-comment')) ?>

        <div class="q-view-info">
            <button id="add-comm-01" class="btn btn-primary btn-sm pull-left">Добавить комментарий</button>

            <div class="q-tags">
                <?php foreach ($question->questionTags as $tag) : ?>
                    <?php /* @var $tag \common\models\QuestionTag */ ?>
                    <?= Html::a(Html::encode($tag->name), ['qa/tag', 'name' => $tag->name], ['class' => 'btn btn-default btn-sm']) ?>
                <?php endforeach ?>
            </div>

            <div class="q-info">
                <?= \frontend\widgets\qa\QuestionFavoriteWidget::widget(['question' => $question]) ?>
                <div class="q-info-view">
                    <svg>
                        <use xlink:href="#ico_view"/>
                    </svg>
                    <span><?= $question->view_count ?></span>
                </div>
            </div>
        </div>

        <h2 class="q-b c-blue">
            <?= \Yii::t('qa', '{n, plural, =0{No answers} =1{One answer} other{# answers}}', ['n' => count($answers)]) ?>
        </h2>

        <div class="answers-list">
            <?php foreach ($answers as $answer) : ?>
                <?php /* @var $answer \common\models\QuestionAnswer */ ?>
                <div class="answer-item">
                    <div class="a-userpic">
                        <?= \common\widgets\Gravatar::widget(
                            [
                                'email' => Html::encode($answer->user->email),
                                'size' => 86,
                                'options' => [
                                    'title' => Html::encode($answer->user->username),
                                    'alt' => Html::encode($answer->user->username)
                                ]
                            ]
                        ) ?>
                    </div>

                    <div class="a-body">
                        <div class="post-info">
                            <?= Yii::$app->formatter->asDatetime($answer->updated_at); ?>
                            <span class="margin-line">|</span>
                            <?= Html::a(Html::encode($answer->user->username), ['profile/view', 'id' => $answer->user->id]); ?>
                            <?= $answer->solved ? '<span class="ico_true ico_true_green"><svg><use xlink:href="#ico_true" /></svg> ' . Yii::t('qa', 'Correct answer') . '</span>' : '' ?>

                            <?php if (Yii::$app->user->getId() == $answer->user_id) : ?>
                                <div class="q-comment-tools">
                                    <?= Html::a(
                                        Yii::t('app', 'Update'),
                                        ['update-answer', 'id' => $answer->id],
                                        ['class' => 'btn btn-link btn-xs']
                                    ) ?>

                                    <span class="margin-line"></span>

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
                                </div>
                            <?php endif ; ?>
                        </div>

                        <div class="answer">
                            <?= HtmlPurifier::process(Markdown::process($answer->body, 'gfm-comment')) ?>
                        </div>

                        <div class="form-group">
                            <?= Html::a(
                                Yii::t('qa', 'Comment'),
                                '#reply',
                                ['class' => 'btn btn-primary btn-sm', 'onclick' => 'answer_reply(' . $answer->id . ')']
                            ) ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            <h2 id="reply" class="q-b c-blue"><?= Yii::t('qa', 'Your Answer'); ?></h2>
            <?= $this->render('_formAnswer', [
                'answerForm' => $answerForm
            ]) ?>
        </div>

    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <?= Html::a(Yii::t('qa', 'Add Question'), ['create'], ['class' => 'btn btn-lg btn-border-success btn-block']) ?>

        <div class="q-similar">
            <h4><?= Yii::t('qa', 'Похожие вопросы') ?>:</h4>

            <div class="similar-item">
                <div class="post-info">
                    <?= Yii::$app->formatter->asDatetime(time()) ?> <span class="margin-line">|</span> <?= Html::a(Html::encode('Username'), '#') ?>
                </div>
                <?= Html::a(Html::encode('Duchess, as she came up to her great disappointment it was.'), '#') ?>

                <div class="q-info">
                    <?= \frontend\widgets\qa\QuestionFavoriteWidget::widget(['question' => null]) ?>
                    <div class="q-info-view">
                        <svg>
                            <use xlink:href="#ico_view"/>
                        </svg>
                        <span>-</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>