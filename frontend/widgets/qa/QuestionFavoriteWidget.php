<?php

namespace frontend\widgets\qa;

use common\models\Question;
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
            return $this->render(false, 0);
        }

        if (\Yii::$app->user->isGuest) {
            $isActive = false;
        } else {
            $isActive = $this->question
                ->getQuestionFavorites()
                ->where(['user_id' => \Yii::$app->user->id])
                ->exists();
        }

        return $this->renderView($isActive, $this->question->favorite_count);
    }

    /**
     * @param boolean $isActive
     * @param integer $favoriteCount
     * @return string
     */
    protected function renderView($isActive, $favoriteCount)
    {
        return $this->render('favorite', ['isActive' => $isActive, 'favoriteCount' => $favoriteCount]);
    }
}
