<?php
namespace frontend\models;

use common\models\User;
use yii\base\Model;
use Yii;

/**
 * Signup form
 */
class SignupForm extends Model
{
    /** @var string $username */
    public $username;

    /** @var string $email */
    public $email;

    /** @var string $firstName */
    public $firstName;

    /** @var string $lastName */
    public $lastName;

    /** @var string $site */
    public $site;

    /** @var string $password */
    public $password;

    /** @var string $passwordRepeat */
    public $passwordRepeat;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('user', 'This username has already been taken.')],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => Yii::t('user', 'This email address has already been taken.')],

            [['firstName', 'lastName', 'site'], 'string', 'max' => 255],

            ['site', 'filter', 'filter' => 'trim'],
            ['site', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],

            [['password', 'passwordRepeat'], 'required'],
            [['password'], 'filter', 'filter' => 'trim'],
            ['password', 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('user', 'Username'),
            'email' => Yii::t('user', 'Email'),
            'firstName' => Yii::t('user', 'First name'),
            'lastName' => Yii::t('user', 'Last name'),
            'site' => Yii::t('user', 'Site'),
            'password' => Yii::t('user', 'Password'),
            'passwordRepeat' => Yii::t('user', 'Repeat password')
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->site = $this->site;
        $user->resend_at = time();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailToken();

        return $user->save() ? $user : null;
    }
}
