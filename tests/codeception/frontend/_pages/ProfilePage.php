<?php

namespace tests\codeception\frontend\_pages;

use yii\codeception\BasePage;

/**
 * Represents loging page
 * @property \tests\codeception\frontend\FunctionalTester $actor
 */
class ProfilePage extends BasePage
{
    public $route = 'profile/index';
}
