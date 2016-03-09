<?php
/** @var $this \yii\web\View */
/** @var $post \common\models\Post */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;

$form = ActiveForm::begin([
    'id' => 'post-form',
]) ?>

<?= $form->field($post, 'title')->textInput(['class'=>'form-control input-lg']) ?>

<?= $form->field($post, 'short_content', [
    'template' => "{label}\n{error}\n{input}\n{hint}"
])->widget(Markdowneditor::className()) ?>

<?= $form->field($post, 'full_content', [
    'template' => "{label}\n{error}\n{input}\n{hint}"
])->widget(Markdowneditor::className()) ?>

<div class="form-group">
    <div>
        <?= Html::submitButton(Yii::t('post', 'Publish'), ['class' => 'btn btn-success btn-lg']) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
