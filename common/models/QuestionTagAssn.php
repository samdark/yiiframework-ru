<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question_tag_assn".
 *
 * @property integer $question_id
 * @property integer $tag_id
 *
 * @property QuestionTag $questionTag
 * @property Question $question
 */
class QuestionTagAssn extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_tag_assn';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'tag_id'], 'required'],
            [['question_id', 'tag_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question_id' => Yii::t('qa', 'Question ID'),
            'tag_id' => Yii::t('qa', 'Tag ID')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTag()
    {
        return $this->hasOne(QuestionTag::className(), ['id' => 'tag_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }
}
