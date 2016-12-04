<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $color
 * @property integer $parent_id
 * @property integer $position
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Question[] $questions
 * @property Tag $parent
 * @property Tag[] $childs
 * @property QuestionsTags[] $tagQuestions
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name',], 'required'],
            [['parent_id', 'position',], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['color'], 'string', 'max' => 7],
            [['color'], 'match', 'pattern' => '/^#?((?:[\dA-F]{6})|(?:[\dA-F]{3}))$/i'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'description' => Yii::t('app', 'Description'),
            'color' => Yii::t('app', 'Color'),
            'parent_id' => Yii::t('app', 'Parent ID'),
            'position' => Yii::t('app', 'Position'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['id' => 'question_id'])
            ->viaTable(QuestionsTags::tableName(), ['tag_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Tag::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChilds()
    {
        return $this->hasMany(Tag::className(), ['parent_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return TagQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TagQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTagQuestions()
    {
        return $this->hasMany(QuestionsTags::className(), ['tag_id' => 'id']);
    }
}
