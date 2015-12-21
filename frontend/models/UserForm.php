<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;

/**
 * Class User
 * @package frontend\models
 *
 * @property User $user
 */
class UserForm extends Model
{
    /**
     * @var string
     */
    public $email;
    /**
     * @var string
     */
    public $site;
    /**
     * @var string
     */
    public $github;
    /**
     * @var string
     */
    public $city;
    /**
     * @var string
     */
    public $first_name;
    /**
     * @var string
     */
    public $last_name;
    /**
     * @var User
     */
    private $currentUser;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if (\Yii::$app->has('user') && !\Yii::$app->user->isGuest) {
            $this->currentUser = User::findOne(\Yii::$app->user->identity->getId());
            $this->setAttributes($this->currentUser->attributes);
        } else {
            throw new \LogicException('This class works only a with current user');
        }

        parent::init();
    }

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
            ['email', 'unique', 'targetClass' => '\common\models\User',
                'message' => 'This email address has already been taken.',
                'when' => function($model){
                    return $model->email !== $this->currentUser->getOldAttribute('email');
                }
            ],

            ['site', 'filter', 'filter' => 'trim'],
            ['site', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],

            ['github', 'filter', 'filter' =>'trim'],
            ['github', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],
            ['github', 'match', 'pattern' => '(github\.com/[a-z0-9A-Z]+/?$)',
                'message' => \Yii::t('user','This is not a link to the Github profile.')
            ],

            ['city', 'filter', 'filter' => 'trim'],
            [['first_name', 'last_name'], 'filter', 'filter' => 'ucfirst'],
        ];
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->currentUser;
    }

    /**
     * Update information about current user
     * @return bool|int
     * @throws \Exception
     */
    public function save()
    {
        if ($this->validate()) {
            $this->user->setAttributes([
                'email' => $this->email,
                'site' => $this->site,
                'github' => $this->github,
                'city' => $this->city,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
            ]);

            if ($this->user->validate()) {
                $this->user->save(true, ['email', 'site', 'github', 'city', 'first_name', 'last_name']);
                return true;
            }

            $this->addErrors($this->user->getErrors());
        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('profile', 'E-Mail'),
            'site' => \Yii::t('profile', 'Site'),
            'github' => \Yii::t('profile', 'GitHub'),
            'city' => \Yii::t('profile', 'City'),
            'first_name' => \Yii::t('profile', 'First Name'),
            'last_name' => \Yii::t('profile', 'Last Name'),
        ];
    }
}
