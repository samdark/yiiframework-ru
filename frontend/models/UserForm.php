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
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

            ['site', 'filter', 'filter' => 'trim'],
            ['site', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']]
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
            $this->user->setAttributes(['email' => $this->email, 'site' => $this->site]);
            $this->user->save(false, ['email', 'site']);
            return true;
        }

        return false;
    }
}
