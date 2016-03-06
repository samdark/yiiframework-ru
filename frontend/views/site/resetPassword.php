<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

$this->title = Yii::t('app', 'Reset password');
$this->blocks['body-class'] = "bg-textured";
?>
<div class="container-fluid login-reg">
    <div class="container cont-border">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="p-login-title"><?= $this->title ?></div>
                <div class="p-login-win">
                    <?php $form = ActiveForm::begin(['id' => 'password-reset-form']); ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput([
                            'class' => 'form-control input-lg',
                            'placeholder' => $model->getAttributeLabel('password')
                        ])
                        ->label(false) ?>

                    <?= $form->field($model, 'passwordRepeat')
                        ->passwordInput([
                            'class' => 'form-control input-lg',
                            'placeholder' => $model->getAttributeLabel('passwordRepeat')
                        ])
                        ->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Change password'), ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'reset-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>