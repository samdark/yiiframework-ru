<?php

namespace frontend\widgets;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;
use common\models\QuestionTag;

/**
 * Class QaTags
 * @package frontend\widgets
 */
class QaTags extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $query = QuestionTag::find()
            ->orderBy('frequency DESC')
            ->all();

        if (!$query) {
            echo Yii::t('qa', 'Tags are missing');
        }

        /* @var $tag \common\models\QuestionTag */
        foreach ($query as $tag) {
            echo Html::a($tag->name, ['qa/tag/', 'name' => $tag->name], ['class' => 'btn btn-default btn-sm']) . ' ';
        }
    }
}