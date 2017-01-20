<?php

use app\components\MetaTagsRegistrar;
use yii\authclient\widgets\AuthChoice;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\forms\LoginForm */

(new MetaTagsRegistrar($this))
    ->setTitle(Yii::t('app', 'Login'))
    ->setDescription('Вход в русскоязычное сообщество Yii')
    ->register();

$this->blocks['body-class'] = "bg-textured";
?>
<div class="container-fluid login-reg">
    <div class="container cont-border">
        <div class="row">
            <div class="col-xs-12 col-sm-8 col-sm-offset-2 col-md-6 col-md-offset-3 col-lg-4 col-lg-offset-4">
                <div class="p-login-title"><?= $this->title ?></div>
                <div class="p-login-win">
                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

                    <?= $form->field($model, 'username')
                        ->textInput([
                            'class' => 'form-control input-lg',
                            'placeholder' => $model->getAttributeLabel('username')
                        ])
                        ->label(false) ?>

                    <?= $form->field($model, 'password')
                        ->passwordInput([
                            'class' => 'form-control input-lg',
                            'placeholder' => $model->getAttributeLabel('password')
                        ])
                        ->label(false) ?>

                    <?= $form->field($model, 'rememberMe')->checkbox() ?>

                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="margin-bottom: 15px;">
                            <?= Html::submitButton(Yii::t('app', 'Login'),
                                ['class' => 'btn btn-success btn-lg btn-block', 'name' => 'login-button']) ?>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <?= Html::a(Yii::t('app', 'Registration'), ['/site/signup'],
                                ['class' => 'btn btn-primary btn-lg btn-block']) ?>
                        </div>
                    </div>

                    <div style="color:#999;margin:1em 0">
                        <?= Yii::t('app',
                            'If you forgot your password you can <a href="{link}" rel="nofollow">reset it</a>.',
                            ['link' => \yii\helpers\Url::to(['site/request-password-reset'])])
                        ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
                <div class="p-login-social">
                    <div class="login-social">
                        <?php $authAuthChoice = AuthChoice::begin([
                            'baseAuthUrl' => ['site/auth'],
                        ]); ?>

                        <?php foreach ($authAuthChoice->getClients() as $client): ?>
                            <?php $authAuthChoice->clientLink($client, '') ?>
                        <?php endforeach; ?>

                        <?php AuthChoice::end(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>