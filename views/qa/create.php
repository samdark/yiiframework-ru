<?php

/* @var $this yii\web\View */
/* @var $questionForm \app\models\QuestionForm */

$this->title = Yii::t('qa', 'Create Question');
?>
<?= $this->render('_form', [
    'questionForm' => $questionForm,
]) ?>