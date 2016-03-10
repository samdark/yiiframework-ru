<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\UserForm;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\filters\VerbFilter;
use frontend\models\ChangePasswordForm;

/**
 * ProfileController handles user profile
 */
class ProfileController extends Controller
{
    /**
     * Number of users per page
     */
    const PAGE_SIZE = 24;

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
                'only' => ['update', 'resend'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['update', 'resend'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'resend' => ['post']
                ]
            ]
        ];
    }

    public function actionView($id)
    {
        $profile = User::find()
            ->where(['user.id' => $id])
            ->one();

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'profile' => $profile
        ]);
    }

    public function actionUpdate()
    {
        $user = User::find()
            ->where([
                'id' => Yii::$app->user->identity->getId(),
                'status' => User::STATUS_ACTIVE
            ])
            ->one();

        $user->scenario = User::SCENARIO_PROFILE;

        if ($user === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        $changePassword = new ChangePasswordForm();

        if ($changePassword->load(Yii::$app->request->post()) && $changePassword->updatePassword()) {
            \Yii::$app->session->setFlash('success', Yii::t('user', 'The password was successfully changed.'));
            return $this->redirect(['update']);
        }

        if ($user->load(Yii::$app->request->post()) && $user->save()) {
            \Yii::$app->session->setFlash('success', Yii::t('user', 'The profile was successfully changed.'));
            return $this->redirect(['update']);
        }

        return $this->render('update', [
            'user' => $user,
            'changePassword' => $changePassword
        ]);
    }

    public function actionList()
    {
        $query = User::find()
            ->where([
                'user.status' => User::STATUS_ACTIVE
            ])
            ->orderBy('user.created_at DESC');

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this::PAGE_SIZE,
            ],
        ]);

        return $this->render('list', [
            'provider' => $provider
        ]);
    }

    public function actionResend()
    {
        /** @var $user \common\models\User */
        $user = User::find()
            ->where([
                'id' => Yii::$app->user->identity->getId(),
                'email_verified' => false,
                'status' => User::STATUS_ACTIVE
            ])
            ->one();

        if ($user === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if ($user->resend_at + Yii::$app->params['user.resendVerified'] < time()) {

            $user->resend_at = time();
            $user->generateEmailToken();

            if ($user->save()) {

                \Yii::$app->session->setFlash('success', Yii::t('user', 'A reminder letter with instructions was sent.'));

                $this->redirect(['update']);
            }
        }

        $this->redirect(['update']);
    }
}