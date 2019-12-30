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
    const REMEMBER_ME_DURATION = 3600 * 24 * 30;
    /**
     * @inheritdoc
     */
    public $layout = 'common';

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id === 'hooks') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

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
            'hooks' => [
                'class' => \app\actions\GitHubHookAction::class,
                'fileName' => '@app/config/system/versions.php',
            ]
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
        }

        return $this->render('login', [
            'model' => $model,
        ]);
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
                if (Yii::$app->getUser()->login($user, self::REMEMBER_ME_DURATION)) {
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
                Yii::$app->session->setFlash('success', 'Для получения дальнейших инструкций проверьте почту.');

                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'К сожалению, мы не можем сбросить пароль для указанного адреса почты.');
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
            Yii::$app->session->setFlash('success', 'Новый пароль успешно установлен.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionConfirmed($token)
    {
        if (empty($token) || !is_string($token)) {
            throw new BadRequestHttpException('Неправильный токен.');
        }

        /** @var $model User */
        $model = User::findByEmailToken($token);

        if ($model) {
            $model->removeVerifiedToken();

            if ($model->save()) {
                \Yii::$app->session->setFlash('success', 'Спасибо, ваша почта успешно подтверждена.');
                return $this->goHome();
            }
        }

        \Yii::$app->session->setFlash('error', 'Неправильный токен.');

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

    /**
     * @return string
     */
    public function actionChat()
    {
        return $this->render('chat');
    }
}
