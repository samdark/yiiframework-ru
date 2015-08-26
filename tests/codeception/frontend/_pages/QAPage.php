<?php

namespace tests\codeception\frontend\_pages;

use yii\codeception\BasePage;

/**
 * Represents Create & update Question page
 * @property \tests\codeception\frontend\FunctionalTester $actor
 */
class QAPage extends BasePage
{
    /**
     * @inheritdoc
     */
    public $route = 'qa/create';

    /**
     * @param string $title
     * @param string $body
     */
    public function submit($title, $body)
    {
        $this->actor->fillField('input[name="Question[title]"]', $title);
        $this->actor->fillField('textarea[name="Question[body]"]', $body);
        $this->actor->click('submit-question');
    }

    public function submitAnswer($body)
    {
        $this->actor->fillField('textarea[name="answer"]', $body);
        $this->actor->click('submit-answer');
    }

    public function updateAnswer($body)
    {
        $this->actor->fillField('textarea[name="Answer[body]"]', $body);
        $this->actor->click('submit-answer');
    }
}

