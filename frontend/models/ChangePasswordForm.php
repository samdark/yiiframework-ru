<?php
namespace frontend\models;

use common\models\User;
use Yii;
use yii\base\Model;

class ChangePasswordForm extends Model
{
    /** @var string */
    public $password;

    /** @var string */
    public $passwordCurrent;

    /** @var string */
    public $passwordRepeat;

    /** @var User */
    private $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['passwordCurrent', 'required'],
            ['passwordCurrent', 'filter', 'filter' => 'trim'],
            ['passwordCurrent', 'string', 'min' => 6],
            ['passwordCurrent', 'validateCurrentPassword'],

            ['password', 'required'],
            ['password', 'filter', 'filter' => 'trim'],
            ['password', 'string', 'min' => 6],

            ['passwordRepeat', 'required'],
            ['passwordRepeat', 'compare', 'compareAttribute' => 'password']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'password' => Yii::t('user', 'New password'),
            'passwordCurrent' => Yii::t('user', 'Current password'),
            'passwordRepeat' => Yii::t('user', 'Repeat password')
        ];
    }

    /**
     * Validates current password
     * @param string $attribute
     */
    public function validateCurrentPassword($attribute)
    {
        $user = $this->getUser();
        if (!$user || !$user->validatePassword($this->$attribute)) {
            $this->addError($attribute, Yii::t('app', 'It\'s not the correct current password.'));
        }
    }

    /**
     * Updates user password
     * @return boolean if password was updated successfuly
     */
    public function updatePassword()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = $this->getUser();
        $user->setPassword($this->password);

        return $user->save(false);
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

