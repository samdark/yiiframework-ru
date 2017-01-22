<?php

namespace app\controllers;

use app\components\feed\Feed;
use app\components\feed\Item;
use app\helpers\Text;
use app\permissions\UserPermissions;
use Yii;
use app\models\Post;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

/**
 * PostController handles news
 * Both individual articles and a front page
 */
class PostController extends Controller
{
    const PAGE_SIZE = 10;

    public $layout = 'common';

    /**
     * @return UserPermissions
     */
    protected function getPermissions()
    {
        return new UserPermissions(Yii::$app->getUser());
    }

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

    /**
     * List posts
     *
     * @return string
     */
    public function actionIndex()
    {
        $query = Post::find()
            ->with(['user'])
            ->orderBy('post.created_at DESC');

        if (!$this->getPermissions()->canManagePosts()) {
            $query->andWhere([
                'post.status' => Post::STATUS_ACTIVE,
            ]);
        }

        $provider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
                'defaultPageSize' => self::PAGE_SIZE, // Hide "per-page" GET-parameter
            ],
        ]);

        if (Yii::$app->request->getQueryParam('page') < 2) {
            $this->layout = 'front';
        }

        return $this->render('index', [
            'provider' => $provider,
        ]);
    }

    /**
     * Create post
     *
     * @return string|\yii\web\Response
     */
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

    /**
     * Update post
     *
     * @param int $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        /** @var Post $post */
        $post = Post::find()->where(['id' => $id])->one();

        if (!$post) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested article does not exist.'));
        }

        if ($this->getPermissions()->canManagePosts()) {
            $post->scenario = Post::SCENARIO_UPDATE_BY_MANAGER;
            $canEditStatus = true;
        } else {
            if (!$this->getPermissions()->canEditPost($post)) {
                throw new ForbiddenHttpException(Yii::t('post', 'You are not allowed to perform this action.'));
            }

            $canEditStatus = false;
        }

        if ($post->load(Yii::$app->request->post()) && $post->save()) {
            Yii::$app->session->setFlash('success', Yii::t('post', 'Your post was successfully updated.'));
            return $this->redirect(['view', 'id' => $post->id, 'slug' => $post->slug]);
        }

        return $this->render('update', [
            'post' => $post,
            'canEditStatus' => $canEditStatus,
        ]);
    }

    /**
     * View post
     *
     * @param int $id
     * @param string $slug
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionView($id = null, $slug = null)
    {
        if ($id === null && $slug === null) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested article does not exist.'));
        }

        $postQuery = Post::find()->with(['user']);

        if ($id !== null) {
            $postQuery->andWhere(['post.id' => $id]);
        }

        if ($slug !== null) {
            $postQuery->andWhere(['post.slug' => $slug]);
        }

        /** @var Post $post */
        $post = $postQuery->one();

        if (!$post || !$this->getPermissions()->canViewPost($post)) {
            throw new NotFoundHttpException(Yii::t('post', 'The requested article does not exist.'));
        }

        if ($id === null || $slug === null) {
            return $this->redirect(['/post/view', 'id' => $post->id, 'slug' => $post->slug], 301);
        }

        return $this->render('view', [
            'post' => $post,
            'canEditPost' => $this->getPermissions()->canEditPost($post),
        ]);
    }

    /**
     * Posts RSS
     */
    public function actionRss()
    {
        /** @var Post[] $posts */
        $posts = Post::find()->where(['status' => Post::STATUS_ACTIVE])->orderBy('created_at DESC')->limit(50)->all();

        $feed = new Feed();
        $feed->title = 'yiiframework.ru';
        $feed->link = Url::to('');
        $feed->selfLink = Url::to(['post/rss'], true);
        $feed->description = 'Новости Yii';
        $feed->language = 'ru';
        $feed->setWebMaster('sam@rmcreative.ru', 'Alexander Makarov');
        $feed->setManagingEditor('sam@rmcreative.ru', 'Alexander Makarov');

        foreach ($posts as $post) {
            $item = new Item();
            $item->title = $post->title;
            $item->link = Url::to(['post/view', 'id' => $post->id, 'slug' => $post->slug], true);
            $item->guid = Url::to(['post/view', 'id' => $post->id, 'slug' => $post->slug], true);
            $item->description = Text::cut(HtmlPurifier::process(Markdown::process($post->body, 'gfm')));

            $item->pubDate = $post->created_at;
            $item->setAuthor('noreply@yiiframework.ru', $post->user->username);
            $feed->addItem($item);
        }

        $feed->render();
    }
}