<?php

namespace frontend\widgets;

use Yii;
use yii\helpers\Html;
use yii\base\Widget;

/**
 * Class TagsWidget
 * @package frontend\widgets
 */
class TagsWidget extends Widget
{
    /**
     * String the class name.
     * @var string $tagsClass
     */
    public $tagsClass;

    /**
     * Url to controller/action by tag-name.
     * @var string $action
     */
    public $action;

    /**
     * The style for display of tags.
     * @var string $styleTags
     */
    public $styleTags;

    /**
     * @inheritdoc
     */
    public function run()
    {
        /** @var $model \yii\db\ActiveRecord*/
        $model = $this->tagsClass;

        $query = $model::find()
            ->orderBy('frequency DESC')
            ->all();

        if ($query) {
            foreach ($query as $tag) {
                echo Html::a(Html::encode($tag->name), [$this->action, 'name' => $tag->name], ['class' => $this->styleTags ? $this->styleTags : 'btn btn-default btn-sm']);
            }
        }
    }
}
