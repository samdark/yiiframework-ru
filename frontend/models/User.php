<?php
namespace frontend\models;

use Yii;

class User extends \common\models\User
{
    const PAGE_COUNT = 25;
    const SCENARIO_UPDATE = 'update';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['site', 'filter', 'filter' => 'trim'],
            ['site', 'required'],
            ['site', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        return array_merge(
            $scenarios,
            [
                self::SCENARIO_UPDATE => ['email', 'site']
            ]
        );
    }
}
