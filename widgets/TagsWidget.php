<?php

namespace app\widgets;

use yii\base\InvalidParamException;
use yii\helpers\Html;
use yii\base\Widget;

/**
 * Class TagsWidget
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
    public function init()
    {
        if (!$this->tagsClass) {
            throw new InvalidParamException('not specified variable "className"');
        }

        if (!$this->action) {
            throw new InvalidParamException('not specified variable "action"');
        }

        $this->styleTags = $this->styleTags ? $this->styleTags : 'btn btn-default btn-sm';
    }

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
                echo Html::a(Html::encode($tag->name), [$this->action, 'name' => $tag->name], ['class' => $this->styleTags]);
            }
        }
    }
}
