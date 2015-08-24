<?php

namespace tests\codeception\frontend\_pages;

use yii\codeception\BasePage;

/**
 * Represents Update profile page
 * @property \tests\codeception\frontend\FunctionalTester $actor
 */
class ProfileFormPage extends BasePage
{
    /**
     * @inheritdoc
     */
    public $route = 'profile/update';

    /**
     * @param string $email
     * @param string $site
     */
    public function update($email, $site)
    {
        $this->actor->fillField('input[name="UserForm[email]"]', $email);
        $this->actor->fillField('input[name="UserForm[site]"]', $site);
        $this->actor->click('update-button');
    }
}
