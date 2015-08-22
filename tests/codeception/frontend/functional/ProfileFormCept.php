<?php
use tests\codeception\frontend\_pages\ProfileFormPage;
use tests\codeception\frontend\FunctionalTester;
use tests\codeception\common\_pages\LoginPage;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure profile-update page works');

$loginPage = LoginPage::openBy($I);

$I->amGoingTo('try to login with correct credentials');
$loginPage->login('erau', 'password_0');
$I->expectTo('see that user is logged');
$I->seeLink('My profile');

$profilePage = ProfileFormPage::openBy($I);
$I->expectTo('see that user information is loaded correctly');
$I->seeInField('input[name="UserForm[email]"]', 'sfriesen@jenkins.info');
$I->seeInField('input[name="UserForm[site]"]', '');

$I->amGoingTo('submit basic form with wrong credentials');
$profilePage->update('asd','asdasd');
$I->expectTo('see validations errors');
$I->see('Email is not a valid email address.', '.help-block');
$I->see('Site is not a valid URL.', '.help-block');

$I->amGoingTo('submit basic form with duplicate email');
$profilePage->update('jojo@jenkins.info','');
$I->see('This email address has already been taken.', '.help-block');

$I->amGoingTo('submit basic form with correct data');
$profilePage->update('second@email.ru','https://get.org');
$I->see('My Profile : erau');
$I->see('Email: second@email.ru (Not verified)');
$I->see('https://get.org');
