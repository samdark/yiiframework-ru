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
//            ['email', 'unique', 'targetClass' => '\common\models\User',
//                'message' => \Yii::t('user', 'This email address has already been taken.')
//            ],

            ['site', 'filter', 'filter' => 'trim'],
            ['site', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],

            ['github', 'filter', 'filter' =>'trim'],
            ['github', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],
            ['github', 'match', 'pattern' => '(github\.com/[a-z0-9A-Z]+/?$)',
                'message' => \Yii::t('user','This is not a link to the profile Github.')
            ],

            ['city', 'filter', 'filter' => 'trim'],
//            ['city', 'string', 'max' => 64],
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
                'city' => $this->city
            ]);
            $this->user->save(false, ['email', 'site', 'github', 'city',]);
            return true;
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
        ];
    }
}
