<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "answer".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $question_id
 * @property string $body
 * @property integer $solved
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Question $question
 * @property User $user
 */
class QuestionAnswer extends ActiveRecord
{
    /** Status published */
    const STATUS_PUBLISHED = 10;

    /** Status deleted */
    const STATUS_DELETED = 30;

    /** Not solved status */
    const STATUS_NOT_SOLVED = 0;

    /** Solved status */
    const STATUS_SOLVED = 1;


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
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'user_id',
                'updatedByAttribute' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_id', 'body'], 'required'],
            [['question_id',], 'exist', 'targetClass' => Question::className(), 'targetAttribute' => 'id'],
            [['status'], 'default', 'value' => self::STATUS_PUBLISHED],
            [['solved'], 'default', 'value' => self::STATUS_NOT_SOLVED],
            [['status'], 'integer'],
            [['body'], 'string'],
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
            'solved' => Yii::t('qa', 'Solved'),
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
