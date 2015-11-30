<?php
/* @var $this yii\web\View */
/* @var $questionForm \frontend\models\QuestionForm */

$this->title = Yii::t('qa', 'Create Question');
?>
<?= $this->render(
    '_form',
    [
        'questionForm' => $questionForm,
    ]
) ?>