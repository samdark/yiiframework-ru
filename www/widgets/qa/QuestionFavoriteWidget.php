<?php

namespace app\widgets\qa;

use app\models\Question;
use yii\base\Widget;

/**
 * Class QuestionFavoriteWidget
 * The QuestionFavoriteWidget widget renders a favorite button and label of the number of users that
 * are added to favorites.
 */
class QuestionFavoriteWidget extends Widget
{
    /**
     * @var Question|null
     */
    public $question;

    /**
     * @inheritdoc
     */
    public function run()
    {
        if (!($this->question instanceof Question)) {
            return $this->renderView(false, 0);
        }

        if (\Yii::$app->user->isGuest) {
            $isActive = false;
        } else {
            $isActive = $this->question
                ->getQuestionFavorites()
                ->where(['user_id' => \Yii::$app->user->id])
                ->exists();
        }

        return $this->renderView($isActive, $this->question->favorite_count, $this->question->id);
    }

    /**
     * @param boolean $isActive
     * @param integer $favoriteCount
     * @param null|integer $questionID
     * @return string
     */
    protected function renderView($isActive, $favoriteCount, $questionID = null)
    {
        return $this->render(
            'favorite',
            [
                'isActive' => $isActive,
                'favoriteCount' => $favoriteCount,
                'questionID' => $questionID,
            ]);
    }
}
