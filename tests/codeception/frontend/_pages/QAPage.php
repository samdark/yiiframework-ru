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
     * @param array $tags
     */
    public function submit($title, $body, $tags)
    {
        $this->actor->fillField('input[name="QuestionForm[title]"]', $title);
        $this->actor->fillField('textarea[name="QuestionForm[body]"]', $body);
        $this->actor->selectOption('select[name="QuestionForm[tags][]"]', $tags);
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

