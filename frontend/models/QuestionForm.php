<?php

namespace frontend\models;


use common\models\Question;
use common\models\QuestionsTags;
use common\models\Tag;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use yii\base\Model;
use yii\db\Query;
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
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->question === null) {
            throw new InvalidConfigException('Attribute question should be configured');
        }

        $this->tags = $this->question->tags;

        parent::init();
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
     * @return bool
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function save()
    {
        if ($this->validate()) {

            $this->question->setAttributes(
                [
                    'title' => $this->title,
                    'body' => $this->body,
                ]
            );

            $transaction = \Yii::$app->db->beginTransaction();

            try {

                $this->question->save();

                QuestionsTags::deleteAll(['question_id' => $this->question->id]);

                $query = new Query();
                $questionsTags = [];

                foreach ($this->tags as $tag) {
                    $questionsTags[] = [
                        'question_id' => (int)$this->question->id,
                        'tag_id' => (int)$tag,
                    ];
                }

                $query->createCommand()->batchInsert(
                    QuestionsTags::tableName(),
                    ['question_id', 'tag_id'],
                    $questionsTags
                )->execute();

                $transaction->commit();

                return true;

            } catch (\Exception $e) {
                $transaction->rollBack();
                throw new \Exception($e, $e->getCode());
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
        return ArrayHelper::map(Tag::find()->all(), 'id', 'name');
    }

    /**
     * Getter to Question model
     * @return Question
     */
    public function getQuestion()
    {
        return $this->questionModel;
    }

    /**
     * Setter to Question model.
     * Note: It may be used once at initialization.
     * @param Question $value
     */
    public function setQuestion(Question $value)
    {
        if ($this->questionModel === null) {

            $this->questionModel = $value;
            $this->setAttributes($this->questionModel->attributes);

        } else {
            throw new InvalidCallException('Attribute question was set earlier');
        }

    }
}