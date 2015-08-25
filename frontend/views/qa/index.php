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


    <section class="list">
        <div class="question-items">

            <?php foreach ($dataProvider->getModels() as $question): ?>

                <div class="row marginbot20">

                    <div class="col-xs-1">

                        <h4 class="text-center text-orange">
                            <?= $countAnswers = $question->getAnswers()->count() ?><br>
                            <?= \Yii::t(
                                'app',
                                '{n, plural, =0{answers} =1{answer} other{answers}}',
                                array(
                                    'n' => $countAnswers,
                                )
                            ) ?>
                        </h4>

                    </div>

                    <div class="col-xs-11">

                        <strong>
                            <?= Html::a(Html::encode($question->title), ['/qa/view', 'id' => $question->id]); ?>
                        </strong>

                        <section class="body">
                            <?= HtmlPurifier::process(
                                Markdown::process(Generator::limitWords($question->body, 40), 'gfm-comment')
                            ) ?>
                        </section>

                        <div class="bottom-article">
                            <ul class="meta-post">

                                <li>
                                    <i class="glyphicon glyphicon-calendar"></i><?= Yii::$app->formatter->asDate(
                                        $question->created_at
                                    ); ?>
                                </li>

                                <li>
                                    <i class="glyphicon glyphicon-user"></i>
                                    <?= Html::a(
                                        Html::encode($question->user->username),
                                        ['profile/view', 'id' => $question->user->id]
                                    ); ?>
                                </li>

                            </ul>
                        </div>

                    </div>

                </div>

            <?php endforeach ?>
        </div>

        <?= LinkPager::widget(
            [
                'pagination' => $dataProvider->getPagination(),
            ]
        ) ?>
    </section>

</div>