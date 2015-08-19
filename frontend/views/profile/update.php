<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $profile common\models\User */
/* @var $modelChangePassword frontend\models\ChangePasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Edit profile');
$this->params['breadcrumbs'][] = Yii::t('app', 'My profile');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="profile-update">
    <h1><?= Html::encode($this->title) ?> : <?= Html::encode($profile->username) ?></h1>

    <div class="row">

        <div class="col-md-6">
            <h2><?= Yii::t('app', 'Basic information') ?></h2>
            <?php $form = ActiveForm::begin(['id' => 'form-profile-update']); ?>

            <?= $form->field($profile, 'email') ?>
            <?= $form->field($profile, 'site') ?>

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
