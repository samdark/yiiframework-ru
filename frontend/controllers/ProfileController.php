<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use frontend\models\User;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use frontend\models\ChangePasswordForm;

class ProfileController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $profile = User::find()
        ->where([
            'user.id' => Yii::$app->user->identity->getId(),
            'user.status' => User::STATUS_ACTIVE
        ])
        ->one();

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('index', [
            'profile' => $profile
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionUpdate()
    {
        $profile = User::find()
            ->where([
                'user.id' => Yii::$app->user->identity->getId(),
                'user.status' => User::STATUS_ACTIVE
            ])
            ->one();

        if ($profile === null) {
            throw new NotFoundHttpException();
        }

        $profile->scenario = User::SCENARIO_UPDATE;

        $modelChangePassword = new ChangePasswordForm();

        if ($profile->load(Yii::$app->request->post()) && $profile->save()) {
            return $this->redirect(['index']);
        }

        if ($modelChangePassword->load(Yii::$app->request->post()) && $modelChangePassword->change()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'profile' => $profile,
            'modelChangePassword' => $modelChangePassword
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionView($id)
    {
        $profile = User::find()
            ->where([
                'user.id' => $id,
                'user.status' => User::STATUS_ACTIVE
            ])
            ->one();

        if ($profile === null) {
            throw new NotFoundHttpException('User does not exist');
        }

        return $this->render('view', [
            'profile' => $profile
        ]);
    }

    /**
     * @inheritdoc
     */
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
                'pageSize' => User::PAGE_COUNT,
            ],
        ]);

        return $this->render('list', [
            'provider' => $provider
        ]);
    }
}