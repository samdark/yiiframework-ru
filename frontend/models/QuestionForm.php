<?php

namespace frontend\models;

use common\models\Question;
use common\models\QuestionTag;
use yii\base\Model;
use yii\helpers\ArrayHelper;

/**
 * Class QuestionForm is the model behind the Question/tags form.
 *
 * @property array listTags
 * @property Question question
 */
class QuestionForm extends Model
{
    /* @var array */
    public $tags;

    /* @var string */
    public $title;

    /* @var string */
    public $body;

    /* @var Question */
    private $questionModel = null;


    /**
     * @inheritdoc
     */
    public function __construct(Question $questionModel, $config = [])
    {
        $this->questionModel = $questionModel;
        $this->setAttributes($this->questionModel->getAttributes(['title', 'body']));
        $this->tags = ArrayHelper::map($questionModel->questionTags, 'name', 'name');
        parent::__construct($config);
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'body', 'tags'], 'required'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['tags'], 'in', 'range' => array_keys($this->listTags), 'allowArray' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => \Yii::t('qa', 'Title'),
            'body' => \Yii::t('qa', 'Body'),
            'tags' => \Yii::t('qa', 'Tags')
        ];
    }

    /**
     * @return bool|Question
     */
    public function save()
    {
        if ($this->validate()) {
            $this->question->title = $this->title;
            $this->question->body = $this->body;
            if ($this->question->questionTags) {
                $this->question->removeAllTagValues();
            }
            $this->question->addTagValues($this->tags);
            if ($this->question->save()) {
                return $this->question;
            }
        };

        return false;
    }

    /**
     * Return Tag list as ['id'=>'name']
     * @return array
     */
    public function getListTags()
    {
        return ArrayHelper::map(QuestionTag::find()->all(), 'name', 'name');
    }

    /**
     * Getter to Question model
     * @return Question
     */
    public function getQuestion()
    {
        return $this->questionModel;
    }
}