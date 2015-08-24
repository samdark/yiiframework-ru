<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $userForm \frontend\models\UserForm */
/* @var $modelChangePassword frontend\models\ChangePasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Edit profile');
$this->params['breadcrumbs'][] = Yii::t('app', 'My profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-update">
    <h1><?= Html::encode($this->title) ?> : <?= Html::encode($userForm->user->username) ?></h1>

    <div class="row">

        <div class="col-md-2">
            <?= \common\widgets\Gravatar::widget([
                'email' => Html::encode($userForm->user->email),
                'size' => 150,
                'options' => [
                    'class' => 'img-thumbnail',
                    'title' => Html::encode($userForm->user->username),
                    'alt' => Html::encode($userForm->user->username)
                ]
            ]) ?>
            <?= Html::a(Yii::t('app', 'Change picture'), 'https://gravatar.com/', ['target' => '_blank']) ?>
        </div>

        <div class="col-md-4">
            <h2><?= Yii::t('app', 'Basic information') ?></h2>
            <?php $form = ActiveForm::begin(['id' => 'form-profile-update']); ?>

            <?= $form->field($userForm, 'email') ?>
            <?= $form->field($userForm, 'site') ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-6">
            <h2><?= Yii::t('app', 'Change password') ?></h2>
            <?php $form = ActiveForm::begin(['id' => 'form-change-password']); ?>

            <?= $form->field($modelChangePassword, 'passwordCurrent')->passwordInput() ?>
            <?= $form->field($modelChangePassword, 'password')->passwordInput() ?>
            <?= $form->field($modelChangePassword, 'passwordRepeat')->passwordInput() ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Change'), ['class' => 'btn btn-warning', 'name' => 'change-password-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
