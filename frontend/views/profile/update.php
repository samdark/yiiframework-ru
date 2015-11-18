<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $userForm \frontend\models\UserForm */
/* @var $modelChangePassword frontend\models\ChangePasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Edit profile');
?>

<div class="container page-wrapper page-cont-col">
    <div class="row">
        <div class="col-md-9">
            <?php $form = ActiveForm::begin(['id' => 'form-profile-update']); ?>

            <?= $form->field($userForm, 'email')->textInput(['class' => 'form-control input-lg']) ?>
            <?= $form->field($userForm, 'site')->textInput(['class' => 'form-control input-lg']) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-3">
            <div class="upe-right-col">
                <div class="big-user-avatar">
                    <?= \common\widgets\Gravatar::widget([
                        'email' => Html::encode($userForm->user->email),
                        'size' => 160,
                        'options' => [
                            'title' => Html::encode($userForm->user->username),
                            'alt' => Html::encode($userForm->user->username)
                        ]
                    ]) ?>
                </div>

                <?= Html::a(Yii::t('app', 'Change picture'), 'https://gravatar.com/', ['target' => '_blank', 'class' => 'btn btn-default btn-sm upe-avatar']) ?>

                <div class="well">
                    <h3><?= Yii::t('app', 'Change password') ?></h3>

                    <?php $form = ActiveForm::begin(['id' => 'form-change-password']); ?>

                    <?= $form->field($modelChangePassword, 'passwordCurrent')->passwordInput(['class' => 'form-control input-lg']) ?>
                    <?= $form->field($modelChangePassword, 'password')->passwordInput(['class' => 'form-control input-lg']) ?>
                    <?= $form->field($modelChangePassword, 'passwordRepeat')->passwordInput(['class' => 'form-control input-lg']) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-warning', 'name' => 'change-password-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>