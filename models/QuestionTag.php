<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question_tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 *
 * @property QuestionTagAssn[] $questionTagAssns
 */
class QuestionTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('qa', 'ID'),
            'name' => Yii::t('qa', 'Name'),
            'frequency' => Yii::t('qa', 'Frequency')
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionTagAssns()
    {
        return $this->hasMany(QuestionTagAssn::className(), ['tag_id' => 'id']);
    }
}
