<?php
namespace app\controllers;

use app\components\UserMailer;
use app\models\User;
use app\components\AuthHandler;
use Yii;
use app\forms\LoginForm;
use app\forms\PasswordResetRequestForm;
use app\forms\ResetPasswordForm;
use app\forms\SignupForm;
use yii\authclient\ClientInterface;
use yii\base\InvalidParamException;
use yii\helpers\Url;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public $layout = "common";


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'login', 'signup', 'login', 'request-password-reset', 'reset-password'],
                'rules' => [
                    [
                        'actions' => ['signup', 'login', 'request-password-reset', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
                'successUrl' => Url::toRoute('user/edit'),
            ],
        ];
    }

    /**
     * @param ClientInterface $client
     */
    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        $this->layout = 'main';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $this->layout = 'main';

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user, 3600 * 24 * 30)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $this->layout = 'main';
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', \Yii::t('user', 'Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', \Yii::t('user', 'Sorry, we are unable to reset password for email provided.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
            $user = User::findByPasswordResetToken($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        $this->layout = 'main';

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            (new UserMailer($user))->sendPasswordResetSuccessEmail();
            Yii::$app->session->setFlash('success', \Yii::t('user', 'New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionConfirmed($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new BadRequestHttpException(Yii::t('user', 'Wrong confirmed token.'));
        }

        /** @var $model User */
        $model = User::findByEmailToken($token);

        if ($model) {
            $model->resend_at = null;
            $model->email_verified = true;
            $model->removeVerifiedToken();

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', Yii::t('user', 'Thank you, Your e-mail address was successfully confirmed.'));
                return $this->goHome();
            }
        }

        \Yii::$app->session->setFlash('error', Yii::t('user', 'Wrong confirmed token.'));

        return $this->goHome();
    }


    /**
     * @return mixed
     */
    public function actionLegacy()
    {
        return $this->render('legacy');
    }

    /**
     * @return mixed
     */
    public function actionTerms()
    {
        return $this->render('terms');
    }
}
