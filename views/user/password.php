<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\forms\ChangePasswordForm */

$formatter = \Yii::$app->formatter;
$this->title = Yii::t('user', 'Change password');
?>

<div class="container page-wrapper page-cont-col">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'form-change-password']); ?>

            <?= $form->field($model, 'passwordCurrent')->passwordInput(['class' => 'form-control input-lg']) ?>
            <?= $form->field($model, 'password')->passwordInput(['class' => 'form-control input-lg']) ?>
            <?= $form->field($model, 'passwordRepeat')->passwordInput(['class' => 'form-control input-lg']) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('user', 'Change password'), ['class' => 'btn btn-success', 'name' => 'change-password-button']) ?>
                <?= Html::a(Yii::t('user', 'Cancel'), ['user/edit'], ['class' => 'btn btn-danger']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
