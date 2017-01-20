<?php

use app\models\Post;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var $this \yii\web\View */
/** @var $post \app\models\Post */
/** @var $canEditStatus bool */

\app\assets\MarkdownEditorAsset::register($this);
?>

<?php $form = ActiveForm::begin([
        'id' => 'post-form',
]) ?>

<?= $form->field($post, 'title')->textInput(['class'=>'form-control input-lg']) ?>

<?= $form->field($post, 'body', [
    'template' => "{label}\n{error}\n{input}\n{hint}"
])->textarea(['class' => 'markdown-editor']) ?>

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
