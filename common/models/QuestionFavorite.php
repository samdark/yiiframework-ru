<?php

namespace common\models;

use Yii;
use common\models\user\User;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "question_favorite".
 *
 * @property integer $user_id
 * @property integer $question_id
 *
 * @property Question $question
 * @property User $user
 */
class QuestionFavorite extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'question_favorite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'question_id'], 'required'],
            ['user_id', 'exist', 'targetClass' => User::className(), 'targetAttribute' => 'id'],
            ['question_id', 'exist', 'targetClass' => Question::className(), 'targetAttribute' => 'id'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('qa', 'User ID'),
            'question_id' => Yii::t('qa', 'Question ID')
        ];
    }

    /**
     * The method add or remove the favorite question to the user.
     * @return false|int (+1 or -1)- added or removed. False - wrong validation.
     * @throws \Exception
     * @throws \yii\db\Exception
     */
    public function impact()
    {
        if (!$this->validate()) {
            return false;
        }

        $condition = ['user_id' => $this->user_id, 'question_id' => $this->question_id];

        $isExistRow = QuestionFavorite::find()
            ->where($condition)
            ->exists();

        $transaction = $this->getDb()->beginTransaction();

        if ($isExistRow) {
            QuestionFavorite::deleteAll($condition);
            $status = -1;
        } else {
            $this->insert(false, array_keys($condition));
            $status = +1;
        }

        Question::updateAllCounters(['favorite_count' => $status], ['id' => $this->question_id]);
        $transaction->commit();
        return $status;
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
