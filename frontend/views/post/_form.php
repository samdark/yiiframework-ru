<?php
/** @var $this \yii\web\View */
/** @var $post \common\models\Post */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;

$form = ActiveForm::begin([
    'id' => 'post-form',
]) ?>

    <?= $form->errorSummary($post)?>

    <?= $form->field($post, 'title')->textInput(['class'=>'form-control input-lg']) ?>

    <?= Html::activeLabel($post, 'body') ?>
    <?= Markdowneditor::widget([
        'model' => $post,
        'attribute' => 'body',
    ]) ?>

    <div class="form-group">
        <div>
            <?= Html::submitButton(Yii::t('app', 'Publish'), ['class' => 'btn btn-success btn-lg']) ?>
        </div>
    </div>
<?php ActiveForm::end() ?>
