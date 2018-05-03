<?php

use app\components\MetaTagsRegistrar;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\forms\SignupForm */

(new MetaTagsRegistrar($this))
    ->setTitle(Yii::t('app', 'Signup'))
    ->setDescription('Регистрация в русскоязычном сообществе Yii')
    ->register();

$this->blocks['body-class'] = 'bg-textured';
?>

<div class="container-fluid login-reg">
    <div class="container cont-border">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="p-login-title"><?= Yii::t('app', 'Registration') ?></div>
                <div class="p-reg-win">

                    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

                    <?= $form->field($model, 'username')
                        ->textInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('username')])
                        ->label(false) ?>

                    <?= $form->field($model, 'email')
                        ->textInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('email')])
                        ->label(false) ?>

                    <?= $form->field($model, 'fullname')
                        ->textInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('fullname')])
                        ->label(false) ?>

                    <?= $form->field($model, 'site')
                        ->textInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('site')])
                        ->label(false) ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('password')])
                        ->label(false) ?>

                    <?= $form->field($model, 'passwordRepeat')
                        ->passwordInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('passwordRepeat')])
                        ->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <div class="p-login-social">
                    <div class="login-social">
                        <?php $authAuthChoice = AuthChoice::begin([
                            'baseAuthUrl' => ['site/auth'],
                        ]); ?>

                        <?php foreach ($authAuthChoice->getClients() as $client): ?>
                            <?= $authAuthChoice->clientLink($client, '') ?>
                        <?php endforeach; ?>

                        <?php AuthChoice::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>