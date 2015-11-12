<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question_answer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $question_id
 * @property string $body
 * @property integer $solution
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Question $question
 * @property User $user
 */
class QuestionAnswer extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_answer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id', 'body', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'question_id', 'solution', 'status', 'created_at', 'updated_at'], 'integer'],
            [['body'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('qa', 'ID'),
            'user_id' => Yii::t('qa', 'User ID'),
            'question_id' => Yii::t('qa', 'Question ID'),
            'body' => Yii::t('qa', 'Body'),
            'solution' => Yii::t('qa', 'Solution'),
            'status' => Yii::t('qa', 'Status'),
            'created_at' => Yii::t('qa', 'Created At'),
            'updated_at' => Yii::t('qa', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Question::className(), ['id' => 'question_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
