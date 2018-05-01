<?php

namespace app\controllers;

use app\models\Post;
use app\permissions\UserPermissions;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\User;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\components\UserMailer;
use yii\web\NotFoundHttpException;
use app\forms\ChangePasswordForm;

/**
 * Class UserController
 */
class UserController extends Controller
{
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
                'only' => ['edit', 'password', 'resend'],
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles' => ['?']
                    ],
                    [
                        'actions' => ['edit', 'password', 'resend'],
                        'allow' => true,
                        'roles' => ['@']
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

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $query = User::find()
            ->where([
                'status' => User::STATUS_ACTIVE
            ])
            ->orderBy(['created_at' => SORT_DESC]);

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
                'defaultPageSize' => self::PAGE_SIZE, // Hide "per-page" GET-parameter
            ]
        ]);

        return $this->render('index', [
            'provider' => $provider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionView($id = null, $username = null)
    {
        if ($id === null && $username === null) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested user does not exist.'));
        }

        $userQuery = User::find()->andWhere(['status' => User::STATUS_ACTIVE]);
        if ($id !== null) {
            $userQuery->andWhere(['id' => $id]);
        }

        if ($username !== null) {
            $userQuery->andWhere(['username' => $username]);
        }

        /** @var User $user */
        $user = $userQuery->one();

        if (!$user) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested user does not exist.'));
        }

        if ($id === null || $username === null) {
            return $this->redirect(['/user/view', 'id' => $user->id, 'username' => $user->username], 301);
        }

        $queryPost = Post::find()
            ->where([
                'user_id' => $id
            ])
            ->orderBy(['created_at' => SORT_DESC]);

        if (Yii::$app->user->id != $id) {
            $queryPost->andWhere(['status' => 10]);
        }

        $providerPost = new ActiveDataProvider([
            'query' => $queryPost,
            'pagination' => [
                'pageSize' => 500
            ],
        ]);

        return $this->render('view', [
            'model' => $user,
            'providerPost' => $providerPost,
            'userPermissions' => new UserPermissions(Yii::$app->user)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionEdit()
    {
        $model = User::find()
            ->where([
                'id' => Yii::$app->user->identity->getId(),
                'status' => User::STATUS_ACTIVE
            ])
            ->one();

        $model->scenario = User::SCENARIO_PROFILE;

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            \Yii::$app->session->setFlash('success', Yii::t('user', 'The profile was successfully changed.'));

            return $this->redirect(['edit']);
        }

        return $this->render('edit', [
            'model' => $model
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionPassword()
    {
        $model = new ChangePasswordForm();

        if ($model->load(Yii::$app->request->post()) && $model->updatePassword()) {
            \Yii::$app->session->setFlash('success', Yii::t('user', 'The password was successfully changed.'));
            return $this->redirect(['edit']);
        }

        return $this->render('password', [
            'model' => $model
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionResend()
    {
        $user = Yii::$app->user->identity;

        if ($user->email_verified) {
            Yii::$app->getSession()->setFlash('error', 'Ваша почта подтверждена.');
        } elseif ($user->isResendTimeVerified() === false) {
            Yii::$app->getSession()->setFlash('error', 'Повторно отправить письмо возможно будет ' . $user->getResendTimeNextAttempt());
        } else {
            if (!User::isEmailTokenValid($user->email_token)) {
                $user->generateEmailToken();
            }

            if ($user->save()) {
                if ((new UserMailer($user))->sendConfirmationEmail()) {
                    Yii::$app->session->setFlash('success', 'Вам было отправлено письмо с напоминанием с инструкциями.');
                } else {
                    Yii::$app->session->setFlash('warning', 'Не удалось отправить письмо.');
                }

            }
        }

        $this->redirect(['edit']);
    }
}
