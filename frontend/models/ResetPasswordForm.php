<?php
namespace frontend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use yii\base\InvalidParamException;

/**
 * Class ResetPasswordForm
 * @package frontend\models\user
 */
class ResetPasswordForm extends Model
{
    /** @var string */
    public $password;

    /** @var string */
    public $passwordRepeat;

    /** @var \common\models\User */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException(Yii::t('user', 'Password reset token cannot be blank.'));
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException(Yii::t('user', 'Wrong password reset token.'));
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'password' => Yii::t('user', 'New password'),
            'passwordRepeat' => Yii::t('user', 'Repeat password')
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
