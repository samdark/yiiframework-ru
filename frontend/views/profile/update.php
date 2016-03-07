<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $user \common\models\User */
/* @var $changePassword frontend\models\ChangePassword */

$formatter = \Yii::$app->formatter;
$this->title = Yii::t('app', 'Edit profile');
?>

<div class="container page-wrapper page-cont-col">
    <div class="row">
        <div class="col-md-9">
            <h3>Основная информация</h3>
            <?php $form = ActiveForm::begin(['id' => 'form-user-update']); ?>
            <?= $form->field($user, 'email')->textInput(['class' => 'form-control input-lg']) ?>
            <?php if ($user->email_verified) : ?>
                <p><small class="text-muted bg-success"><?= Yii::t('user', 'The email address is confirmed.') ?></small></p>
            <?php else : ?>
                <?php if ($user->resend_at + Yii::$app->params['user.resendVerified'] < time()) : ?>
                    <p><small class="text-muted bg-warning"><?= Yii::t('user', 'The email address is not confirmed, {resend}', [
                                'resend' => Html::a(Yii::t('user', 'resend the confirmation.'), ['/user/resend'], ['data-method' => 'post'])
                            ]) ?></small></p>
                <?php else : ?>
                    <p><small class="text-muted bg-warning"><?= Yii::t('user', 'The email address is not confirmed.') ?></small></p>
                    <p><small class="text-muted bg-warning"><?= Yii::t('user', 'Resend letters will be possible {time}.', [
                                'time' => $formatter->asDatetime($user->resend_at + Yii::$app->params['user.resendVerified'], 'short')
                            ]) ?></small></p>
                <?php endif; ?>
            <?php endif; ?>

            <?= $form->field($user, 'last_name')->textInput(['class' => 'form-control input-lg']) ?>
            <?= $form->field($user, 'first_name')->textInput(['class' => 'form-control input-lg']) ?>
            <?= $form->field($user, 'site')->textInput(['class' => 'form-control input-lg']) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Update'), ['class' => 'btn btn-primary', 'name' => 'update-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>

        <div class="col-md-3">
            <div class="upe-right-col">
                <div class="big-user-avatar">
                    <?= \common\widgets\Gravatar::widget([
                        'email' => Html::encode($user->email),
                        'size' => 160,
                        'options' => [
                            'title' => Html::encode($user->username),
                            'alt' => Html::encode($user->username)
                        ]
                    ]) ?>
                </div>

                <?= Html::a(Yii::t('user', 'Change picture'), 'https://gravatar.com/', ['target' => '_blank', 'class' => 'btn btn-default btn-sm upe-avatar']) ?>

                <div class="well">
                    <h3><?= Yii::t('user', 'Change password') ?></h3>

                    <?php $form = ActiveForm::begin(['id' => 'form-change-password']); ?>

                    <?= $form->field($changePassword, 'passwordCurrent')->passwordInput(['class' => 'form-control input-lg']) ?>
                    <?= $form->field($changePassword, 'password')->passwordInput(['class' => 'form-control input-lg']) ?>
                    <?= $form->field($changePassword, 'passwordRepeat')->passwordInput(['class' => 'form-control input-lg']) ?>

                    <div class="form-group">
                        <?= Html::submitButton(Yii::t('user', 'Change password'), ['class' => 'btn btn-warning', 'name' => 'change-password-button']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>

                <h3>Социальные сети</h3>
                <?= yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['site/auth']
                ]); ?>
            </div>
        </div>
    </div>
</div>
