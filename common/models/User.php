<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $email_verified
 * @property string $email_token
 * @property string $github
 * @property string $last_name
 * @property string $first_name
 * @property string $site
 * @property integer $status
 * @property integer $resend_at
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Auth[] $auths
 * @property Post[] $posts
 * @property Project[] $projects
 * @property Question[] $questions
 * @property QuestionAnswer[] $questionAnswers
 * @property QuestionFavorite[] $questionFavorites
 */
class User extends ActiveRecord implements IdentityInterface
{
    /** Inactive status */
    const STATUS_INACTIVE = 0;

    /** Active status */
    const STATUS_ACTIVE = 10;

    /** Banned status */
    const STATUS_BANNED = 20;

    /** Deleted status */
    const STATUS_DELETED = 30;

    /** Scenario edit profile */
    const SCENARIO_PROFILE = 'update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'required'],
            ['username', 'unique'],

            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'unique'],

            ['email_verified', 'boolean'],
            ['email_verified', 'default', 'value' => false],

            ['email_token', 'unique'],
            ['email_token', 'string', 'max' => 255],

            [['first_name', 'last_name', 'site', 'github'], 'string', 'max' => 255],

            ['site', 'filter', 'filter' => 'trim'],
            ['site', 'url', 'defaultScheme' => 'http', 'validSchemes' => ['http', 'https']],

            ['resend_at', 'integer'],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => array_keys(self::getStatuses())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('user', 'ID'),
            'username' => Yii::t('user', 'Username'),
            'auth_key' => Yii::t('user', 'Auth Key'),
            'password_hash' => Yii::t('user', 'Password Hash'),
            'password_reset_token' => Yii::t('user', 'Password Reset Token'),
            'email' => Yii::t('user', 'Email'),
            'email_verified' => Yii::t('user', 'Email Verified'),
            'email_token' => Yii::t('user', 'Email verification token'),
            'github' => Yii::t('user', 'Github'),
            'last_name' => Yii::t('user', 'Last name'),
            'first_name' => Yii::t('user', 'First name'),
            'site' => Yii::t('user', 'Site'),
            'status' => Yii::t('user', 'Status'),
            'resend_at' => Yii::t('user', 'Resend At'),
            'created_at' => Yii::t('user', 'Created At'),
            'updated_at' => Yii::t('user', 'Updated At'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return ArrayHelper::merge(parent::scenarios(), [
            self::SCENARIO_PROFILE => ['email', 'first_name', 'last_name', 'site']
        ]);
    }

    /**
     * @return string status label
     */
    public function getStatusLabel()
    {
        return ArrayHelper::getValue(static::getStatuses(), $this->status);
    }

    /**
     * @return array status labels indexed by status values
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_INACTIVE => Yii::t('user', 'Inactivated'),
            self::STATUS_ACTIVE => Yii::t('user', 'Activated'),
            self::STATUS_BANNED => Yii::t('user', 'Blocked'),
            self::STATUS_DELETED => Yii::t('user', 'Deleted')
        ];
    }

    /**
     * @return string full user name
     */
    public function getFullname()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProjects()
    {
        return $this->hasMany(Project::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Question::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionAnswers()
    {
        return $this->hasMany(QuestionAnswer::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionFavorites()
    {
        return $this->hasMany(QuestionFavorite::className(), ['user_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * Finds user by email verification token
     * @param string $token
     * @return self
     */
    public static function findByEmailToken($token)
    {
        return static::findOne(['email_token' => $token, 'email_verified' => false, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Generates new verified token
     */
    public function generateEmailToken()
    {
        $this->email_token = Yii::$app->security->generateRandomString();
    }

    /**
     * Removes verified token
     */
    public function removeVerifiedToken()
    {
        $this->email_token = null;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->scenario === self::SCENARIO_PROFILE && $this->isAttributeChanged('email')){
                $this->resend_at = time();
                $this->email_verified = false;
                $this->generateEmailToken();
            }

            return true;
        }
        return false;
    }
}
