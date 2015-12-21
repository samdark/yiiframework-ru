<?php

namespace frontend\models;

use common\models\Question;
use common\models\QuestionAnswer;
use yii\base\InvalidCallException;
use yii\base\InvalidConfigException;
use Yii;
use yii\base\Model;

/**
 * Class QuestionAnswerForm
 * @package frontend\models
 *
 * @property QuestionAnswer answer
 */
class QuestionAnswerForm extends Model
{
    /* @var integer $question_id */
    public $question_id;

    /* @var string $body */
    public $body;

    /** @var QuestionAnswer  */
    private $answerModel = null;

    /**
     * @throws InvalidConfigException
     */
    public function init()
    {
        if ($this->answer === null AND $this->question_id === null) {
            throw new InvalidConfigException('Attribute question should be configured');
        }

        parent::init();
    }

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['body', 'question_id'], 'required'],
            [['body'], 'string'],
            [['question_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'body' => Yii::t('qa', 'Body')
        ];
    }

    /**
     * @return bool|Question
     */
    public function save()
    {
        if ($this->validate()) {
            if ($this->answer !== null) {
                $this->answer->body = $this->body;
                if ($this->answer->save()) {
                    return $this->answer;
                }
            }

            $answer = new QuestionAnswer();
            $answer->question_id = $this->question_id;
            $answer->body = $this->body;
            if ($answer->save()) {
                return $answer;
            }

        };

        return false;
    }

    /**
     * Getter to QuestionAnswer model
     * @return QuestionAnswer
     */
    public function getAnswer()
    {
        return $this->answerModel;
    }

    /**
     * Setter to QuestionAnswer model.
     * Note: It may be used once at initialization.
     * @param QuestionAnswer $value
     */
    public function setAnswer(QuestionAnswer $value)
    {
        if ($this->answerModel === null) {
            $this->answerModel = $value;
            $this->setAttributes($this->answerModel->attributes);
        } else {
            throw new InvalidCallException('Attribute question was set earlier');
        }
    }
}