<?php

namespace frontend\controllers;

use common\models\User;
use Yii;
use yii\web\Controller;
use common\models\Question;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;

/**
 * Class QaController
 * @package frontend\controllers
 */
class QaController extends Controller
{
    /**
     * @inheritdoc
     */
    const PAGE_SIZE = 15;

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
                'only' => ['my', 'favorite'],
                'rules' => [
                    [
                        'actions' => ['my', 'favorite'],
                        'allow' => true,
                        'roles' => ['@']
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
        $query = Question::find()
            ->with(['user', 'questionTags'])
            ->andWhere([
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionWithoutAnswer()
    {
        $query = Question::find()
            ->with(['user', 'questionTags'])
            ->andWhere([
                'question.answer_count' => 0,
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionSolved()
    {
        $query = Question::find()
            ->with(['user', 'questionTags'])
            ->andWhere([
                'question.solution' => Question::STATUS_SOLVED,
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionMy()
    {
        $query = Question::find()
            ->with(['user', 'questionTags'])
            ->andWhere([
                'question.user_id' => Yii::$app->user->getId()
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionFavorite()
    {
        // action code ...
    }
}
