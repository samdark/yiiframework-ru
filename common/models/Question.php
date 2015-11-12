<?php

namespace common\models;

use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use creocoder\taggable\TaggableBehavior;

/**
 * This is the model class for table "{{%question}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $body
 * @property integer $view_count
 * @property integer $answer_count
 * @property integer $favorite_count
 * @property integer $solved
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property string $tagValues
 *
 * @property User $user
 * @property QuestionAnswer[] $questionAnswers
 * @property QuestionTagAssn[] $questionTags
 */
class Question extends ActiveRecord
{
    /** Status published */
    const STATUS_PUBLISHED = 10;

    /** Status published */
    const STATUS_UNPUBLISHED = 20;

    /** Not solved status */
    const STATUS_NOT_SOLVED = 0;

    /** Solved status */
    const STATUS_SOLVED = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'questionTags' => [
                'class' => TaggableBehavior::className(),
                'tagRelation' => 'questionTags'
            ],
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
            [['title', 'body',], 'required'],
            [['status'], 'default', 'value' => self::STATUS_PUBLISHED],
            [['solved'], 'default', 'value' => self::STATUS_NOT_SOLVED],
            [['status'], 'integer'],
            [['body'], 'string'],
            [['title'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function transactions()
    {
        return [
            self::SCENARIO_DEFAULT => self::OP_ALL
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
            'title' => Yii::t('qa', 'Title'),
            'body' => Yii::t('qa', 'Body'),
            'view_count' => Yii::t('qa', 'View Count'),
            'answer_count' => Yii::t('qa', 'Answer Count'),
            'favorite_count' => Yii::t('qa', 'Favorite Count'),
            'solved' => Yii::t('qa', 'Solved'),
            'status' => Yii::t('qa', 'Status'),
            'created_at' => Yii::t('qa', 'Created At'),
            'updated_at' => Yii::t('qa', 'Updated At')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswers()
    {
        return $this->hasMany(QuestionAnswer::className(), ['question_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTags()
    {
        return $this->hasMany(QuestionTag::className(), ['id' => 'tag_id'])
            ->viaTable(QuestionTagAssn::tableName(), ['question_id' => 'id']);
    }
}
