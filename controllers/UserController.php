<?php
namespace app\controllers;

use yii;
use app\models\Post;
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
                'pageSize' => User::PAGE_SIZE
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
                'pageSize' => 4
            ],
        ]);

        return $this->render('view', [
            'model' => $user,
            'providerPost' => $providerPost
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
        /** @var $model User */
        $model = User::find()
            ->where([
                'id' => Yii::$app->user->identity->getId(),
                'email_verified' => false,
                'status' => User::STATUS_ACTIVE
            ])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
        }

        if ($model->isResendTimeVerified()) {

            $model->resend_at = time();
            $model->generateEmailToken();

            if ($model->save()) {
                (new UserMailer($model))->sendConfirmationEmail();
                \Yii::$app->session->setFlash('success', Yii::t('user', 'A reminder letter with instructions was sent.'));

                $this->redirect(['edit']);
            }
        }

        $this->redirect(['edit']);
    }
}
