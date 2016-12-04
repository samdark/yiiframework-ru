<?php
namespace app\controllers;

use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;

/**
 * PostController handles news
 * Both individual articles and a front page
 */
class PostController extends Controller
{
    const PAGE_SIZE = 10;

    public $layout = "common";

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

        $this->layout = 'front';
        return $this->render('index', [
            'provider' => $provider,
        ]);
    }

    public function actionCreate()
    {
        $post = new Post();
        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            Yii::$app->session->setFlash('success', Yii::t('post', 'Your post was successfully added. Therefore your post will be published as it will be verified by the Administrator.'));
            return $this->redirect(['/']);
        }

        return $this->render('create', [
            'post' => $post,
        ]);
    }

    public function actionUpdate($id)
    {
        /** @var Post $post */
        $post = Post::find()
            ->where(['id' => $id])
            ->andFilterWhere(['NOT IN', 'status', Post::STATUS_ACTIVE])
            ->andFilterWhere(['NOT IN', 'status', Post::STATUS_DELETED])
            ->one();

        if (!$post) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested article does not exist.'));
        }

        if (Yii::$app->user->getId() != $post->user_id) {
            throw new ForbiddenHttpException(Yii::t('post', 'You are not allowed to perform this action.'));
        }

        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            Yii::$app->session->setFlash('success', Yii::t('post', 'Your post was successfully updated.'));
            return $this->redirect(['view', 'id' => $post->id, 'slug' => $post->slug]);
        }

        return $this->render('update', [
            'post' => $post,
        ]);
    }

    public function actionView($id = null, $slug = null)
    {
        if ($id === null && $slug === null) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested article does not exist.'));
        }

        $postQuery = Post::find()->with(['user'])->andWhere(['post.status' => Post::STATUS_ACTIVE]);
        if ($id !== null) {
            $postQuery->andWhere(['post.id' => $id]);
        }

        if ($slug !== null) {
            $postQuery->andWhere(['post.slug' => $slug]);
        }

        /** @var Post $post */
        $post = $postQuery->one();

        if (!$post) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested article does not exist.'));
        }

        if ($id === null || $slug === null) {
            return $this->redirect(['/post/view', 'id' => $post->id, 'slug' => $post->slug], 301);
        }

        return $this->render('view', [
            'post' => $post,
        ]);
    }
}