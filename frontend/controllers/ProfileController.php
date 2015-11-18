<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use frontend\models\UserForm;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use frontend\models\ChangePasswordForm;

/**
 * ProfileController handles user profile
 */
class ProfileController extends Controller
{
    /**
     * number user on page
     */
    const PAGE_SIZE = 25;

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
                'only' => ['update'],
                'rules' => [
                    [
                        'actions' => ['update'],
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

    /**
     * @inheritdoc
     */
    public function actionUpdate()
    {
        $userForm = new UserForm();

        if ($userForm->load(Yii::$app->request->post()) && $userForm->save()) {
            return $this->redirect(['index']);
        }

        $modelChangePassword = new ChangePasswordForm();

        if ($modelChangePassword->load(Yii::$app->request->post()) && $modelChangePassword->change()) {
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'userForm' => $userForm,
            'modelChangePassword' => $modelChangePassword
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
                'pageSize' => $this::PAGE_SIZE,
            ],
        ]);

        return $this->render('list', [
            'provider' => $provider
        ]);
    }
}