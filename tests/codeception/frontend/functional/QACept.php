<?php
use tests\codeception\common\_pages\LoginPage;
use tests\codeception\frontend\_pages\QAPage;
use tests\codeception\frontend\FunctionalTester;

/* @var $scenario Codeception\Scenario */

$I = new FunctionalTester($scenario);
$I->wantTo('ensure qa page works');

$loginPage = LoginPage::openBy($I);
$I->amGoingTo('try to login with correct credentials');
$loginPage->login('erau', 'password_0');
$I->expectTo('see that user is logged');
$I->seeLink('My profile');

$I->expectTo('question create page works');
$qaPage = QAPage::openBy($I);
$I->seeInTitle('Create Question');
$qaPage->submit('Title answer', 'My answer is good!');
$I->see('Title answer');
$I->see('My answer is good!');

$I->expectTo('question update page works');
$I->click('Update');
$I->seeInTitle('Update Question');
$qaPage->submit('Changed title answer', 'I am feel good!');
$I->see('Changed title answer');
$I->see('I am feel good');

$I->expectTo('answer create page works');
$qaPage->submitAnswer('My answer: Have fun!');
$I->see('One answer:');
$I->see('My answer: Have fun!');

$I->expectTo('answer update page works');
$I->click('Update', '.answers');
$qaPage->updateAnswer('My answer updated!');
$I->see('One answer:');
$I->see('My answer updated!');