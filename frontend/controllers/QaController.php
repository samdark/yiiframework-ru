<?php

namespace frontend\controllers;

use common\models\QuestionAnswer;
use common\models\User;
use frontend\models\QuestionForm;
use Yii;
use yii\web\Controller;
use common\models\Question;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['my', 'favorite','create', 'update-question', 'delete-question', 'update-answer', 'delete-answer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
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
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $question = $this->findModel($id);
        $newAnswer = new QuestionAnswer(['question_id' => $question->id]);

        $question->updateCounters(['view_count' => 1]);

        return $this->render(
            'view',
            [
                'question' => $question,
                'newAnswer' => $newAnswer,
            ]
        );
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $questionModel = new Question();

        $questionForm = new QuestionForm(
            [
                'question' => $questionModel
            ]
        );

        if ($questionForm->load(Yii::$app->request->post()) && $questionForm->save()) {
            return $this->redirect(['view', 'id' => $questionForm->question->id]);
        } else {
            return $this->render(
                'create',
                [
                    'questionForm' => $questionForm,
                ]
            );
        }
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * @throws \Exception
     */
    public function actionUpdateQuestion($id)
    {
        $question = $this->findModel($id);

        if (Yii::$app->user->getId() !== $question->user_id) {
            throw new ForbiddenHttpException();
        }

        $questionForm = new QuestionForm(
            [
                'question' => $question
            ]
        );

        if ($questionForm->load(Yii::$app->request->post()) && $questionForm->save()) {
            return $this->redirect(['view', 'id' => $questionForm->question->id]);
        } else {
            return $this->render(
                'update',
                [
                    'questionForm' => $questionForm,
                ]
            );
        }
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

    /**
     * Finds the Question model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Question the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Question::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
