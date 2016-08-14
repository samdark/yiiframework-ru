<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\authclient\widgets\AuthChoice;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\user\User */

$formatter = \Yii::$app->formatter;
$this->title = Yii::t('app', 'Edit profile');
?>

<div class="container page-wrapper page-cont-col">
    <div class="row">
        <div class="col-md-9">
            <h3>Основная информация</h3>
            <?php $form = ActiveForm::begin(['id' => 'form-user-update']); ?>
            <?= $form->field($model, 'email')->textInput(['class' => 'form-control input-lg']) ?>
            <?php if ($model->email) : ?>
                <?php if ($model->email_verified) : ?>
                    <p><small class="text-muted bg-success"><?= Yii::t('user', 'The email address is confirmed.') ?></small></p>
                <?php else : ?>
                    <?php if ($model->isResendTimeVerified()) : ?>
                        <p><small class="text-muted bg-warning"><?= Yii::t('user', 'The email address is not confirmed, {resend}', [
                                    'resend' => Html::a(Yii::t('user', 'resend the confirmation.'), ['/user/resend'], ['data-method' => 'post'])
                                ]) ?></small></p>
                    <?php else : ?>
                        <p><small class="text-muted bg-warning"><?= Yii::t('user', 'The email address is not confirmed.') ?></small></p>
                        <p><small class="text-muted bg-warning"><?= Yii::t('user', 'Resend letters will be possible {time}.', [
                                    'time' => $model->getResendTimeNextAttempt()
                                ]) ?></small></p>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endif; ?>

            <?= $form->field($model, 'fullname')->textInput(['class' => 'form-control input-lg']) ?>
            <?= $form->field($model, 'site')->textInput(['class' => 'form-control input-lg']) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('user', 'Update'), ['class' => 'btn btn-success', 'name' => 'update-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            <!--Social-->
            <?php $authAuthChoice = AuthChoice::begin([
                'baseAuthUrl' => ['site/auth']
            ]); ?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    Привязка учетных записей социальных сетей
                </div>
                <table class="table table-hover">
                    <tbody>
                    <?php foreach ($authAuthChoice->getClients() as $client): ?>
                        <tr>
                            <th scope="row"><?php $authAuthChoice->clientLink($client, Html::tag('span', '', ['class' => 'auth-icon ' . $client->getName()])) ?></th>
                            <td>Чтобы привязать или отвязать свой профиль <?= $client->getTitle() ?>, кликните на иконку или на кнопку.</td>
                            <td><?php $authAuthChoice->clientLink($client, Html::tag('span', $model->{$client->getId()} ? 'Отключить' : 'Подключить',
                                    ['class' => $model->{$client->getId()} ? 'btn btn-xs btn-danger btn-block' : 'btn btn-xs btn-success btn-block'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php AuthChoice::end(); ?>
            <!--Social-->
        </div>

        <div class="col-md-3">
            <div class="upe-right-col">
                <div class="big-user-avatar">
                    <?= \common\widgets\Gravatar::widget([
                        'email' => Html::encode($model->email),
                        'size' => 160,
                        'options' => [
                            'title' => Html::encode($model->username),
                            'alt' => Html::encode($model->username)
                        ]
                    ]) ?>
                </div>
                <?= Html::a(Yii::t('user', 'Change picture'), 'https://gravatar.com/', ['target' => '_blank', 'class' => 'btn btn-default btn-sm upe-avatar']) ?>
                <?= Html::a(Yii::t('user', 'Change the password'), ['user/password'], ['class' => 'btn btn-danger btn-sm upe-password']) ?>
            </div>
        </div>
    </div>
</div>
