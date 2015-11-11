<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Signup');
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

                    <?= $form->field($model, 'password')
                        ->passwordInput(['class' => 'form-control input-lg', 'placeholder' => $model->getAttributeLabel('password')])
                        ->label(false) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('app', 'Signup'), ['class' => 'btn btn-primary btn-lg btn-block', 'name' => 'signup-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
                <div class="p-login-social">
                    <div class="login-social">
                        <a href="https://github.com/yiisoft/yii2" class="github" target="_blank"></a>
                        <a href="https://twitter.com/yiiframework_ru" class="twitter" target="_blank"></a>
                        <a href="https://www.facebook.com/groups/yiitalk/" class="facebook" target="_blank"></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>