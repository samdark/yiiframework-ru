<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\user\form\PasswordResetRequestForm */

$this->title = Yii::t('app', 'Reset password');
$this->blocks['body-class'] = "bg-textured";
?>
<div class="container-fluid login-reg">
    <div class="container cont-border">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="p-login-title"><?= $this->title ?></div>
                <div class="p-login-win">
                    <?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

                    <?= $form->field($model, 'email')
                        ->textInput([
                            'class' => 'form-control input-lg',
                            'placeholder' => $model->getAttributeLabel('email')
                        ])
                        ->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Send'), ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'reset-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>