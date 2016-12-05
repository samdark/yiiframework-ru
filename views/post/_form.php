<?php
/** @var $this \yii\web\View */
/** @var $post \app\models\Post */
/** @var $canEditStatus bool */

use app\models\Post;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ijackua\lepture\Markdowneditor;

$form = ActiveForm::begin([
    'id' => 'post-form',
]) ?>

<?= $form->field($post, 'title')->textInput(['class'=>'form-control input-lg']) ?>

<?= $form->field($post, 'body', [
    'template' => "{label}\n{error}\n{input}\n{hint}"
])->widget(Markdowneditor::className()) ?>

<?php if ($canEditStatus): ?>
    <?= $form->field($post, 'status')->dropDownList(Post::getStatuses(), ['class'=>'form-control input-lg']) ?>
<?php endif ?>

<div class="form-group">
    <div>
        <?= Html::submitButton(
            $post->isNewRecord ? Yii::t('post', 'Create') : Yii::t('post', 'Edit post'),
            ['class' => $post->isNewRecord ? 'btn btn-success btn-lg' : 'btn btn-primary btn-lg']
        ) ?>
    </div>
</div>
<?php ActiveForm::end() ?>
