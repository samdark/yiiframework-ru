<?php
namespace frontend\controllers;

use yii;
use common\models\post\Post;
use yii\web\Controller;
use yii\filters\VerbFilter;
use common\models\user\User;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use common\components\UserMailer;
use yii\web\NotFoundHttpException;
use frontend\models\user\form\ChangePasswordForm;

/**
 * Class UserController
 * @package frontend\controllers
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
    public function actionView($id)
    {
        $model = User::find()
            ->where(['id' => $id])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
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
            'model' => $model,
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
