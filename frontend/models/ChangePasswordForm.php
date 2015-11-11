<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    /** @var string $password */
    public $password;

    /** @var string $passwordCurrent */
    public $passwordCurrent;

    /** @var string $passwordRepeat */
    public $passwordRepeat;

    /** @var array $_user */
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password', 'passwordCurrent'], 'filter', 'filter' => 'trim'],
            ['passwordCurrent', 'validatePasswordCurrent'],
            [['password', 'passwordCurrent', 'passwordRepeat'], 'required'],
            [['password', 'passwordCurrent'], 'string', 'min' => 6],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'passwordCurrent' => Yii::t('app', 'Current Password'),
            'password' => Yii::t('app', 'Password'),
            'passwordRepeat' => Yii::t('app', 'Repeat Password')
        ];
    }

    /**
     * @inheritdoc
     */
    public function validatePasswordCurrent($attribute, $params)
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'The current password is incorrect.'));
        }
    }

    /**
     * @inheritdoc
     */
    public function change()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->generateAuthKey();
            $user->setPassword($this->password);
            if ($user->save()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findOne(Yii::$app->user->identity->getId());
        }

        return $this->_user;
    }
}
