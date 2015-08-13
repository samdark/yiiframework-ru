<?php
namespace frontend\controllers;

use common\models\Post;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class PostController extends Controller
{
    const PAGE_SIZE = 10;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update'],
                'rules' => [
                    [
                        'actions' => ['create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $query = Post::find()
            ->with(['user'])
            ->andWhere([
                'post.status' => Post::STATUS_ACTIVE,
            ])
            ->orderBy('post.created_at DESC');

        $provider = new ActiveDataProvider([
             'query' => $query,
             'pagination' => [
                 'pageSize' => self::PAGE_SIZE,
             ],
         ]);

        return $this->render('index', [
            'provider' => $provider,
        ]);
    }

    public function actionCreate()
    {
        $post = new Post();
        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('create', [
            'post' => $post,
        ]);
    }

    public function actionUpdate($id)
    {
        /** @var Post $post */
        $post = Post::findOne(['status' => Post::STATUS_ACTIVE, 'id' => $id]);
        if (!$post) {
            throw new NotFoundHttpException();
        }

        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            $this->redirect(['view', 'id' => $post->id]);
        }

        return $this->render('update', [
            'post' => $post,
        ]);
    }

    public function actionView($id)
    {
        $post = Post::find()
            ->with(['user'])
            ->where([
                'post.id' => $id,
                'post.status' => Post::STATUS_ACTIVE
            ])
            ->one();
        if (!$post) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', [
            'post' => $post,
        ]);
    }
}