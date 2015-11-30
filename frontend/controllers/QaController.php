<?php

namespace frontend\controllers;

use common\models\QuestionAnswer;
use frontend\models\QuestionAnswerForm;
use frontend\models\QuestionForm;
use Yii;
use yii\web\Controller;
use common\models\Question;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\data\Sort;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-question' => ['post'],
                    'delete-answer' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actionIndex()
    {
        $sort = new Sort([
            'defaultOrder' => [
                'created_at' => SORT_ASC,
                'view_count' => SORT_ASC,
                'favorite_count' => SORT_ASC
            ],
            'attributes' => [
                'created_at', 'view_count', 'favorite_count'
            ]
        ]);

        $query = Question::find()
            ->with(['user', 'questionTags', 'questionFavorites'])
            ->andWhere([
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'sort' => $sort,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        /** @var $question \common\models\Question */
        $question = Question::find()
            ->with(['user', 'questionTags', 'questionFavorites'
            ])
            ->andWhere([
                'question.id' => $id,
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->one();

        if ($question === null) {
            throw new NotFoundHttpException();
        }

        $answerForm = new QuestionAnswerForm([
            'question_id' => $question->id
        ]);

        if ($answerForm->load(Yii::$app->request->post())) {
            /** @var $answer \common\models\QuestionAnswer */
            if ($answer = $answerForm->save()) {
                $question->updateCounters(['answer_count' => 1]);
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your answer published'));
                return $this->refresh();
            }
        }

        $answers = QuestionAnswer::find()
            ->with(['user'])
            ->andWhere([
                'question_id' => $id,
                'status' => QuestionAnswer::STATUS_PUBLISHED
            ])
            ->all();

        $question->updateCounters(['view_count' => 1]);

        return $this->render('view', [
            'question' => $question,
            'answers' => $answers,
            'answerForm' => $answerForm
        ]);
    }

    /**
     * @param integer $id
     * @return string|\yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdateAnswer($id)
    {
        $answer = $this->findModelAnswer($id);

        if (Yii::$app->user->getId() !== $answer->user_id) {
            throw new ForbiddenHttpException();
        }

        $answerForm = new QuestionAnswerForm([
            'answer' => $answer
        ]);

        if ($answerForm->load(Yii::$app->request->post())) {
            /** @var $answer \common\models\QuestionAnswer */
            if ($answer = $answerForm->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your answer update'));
                return $this->redirect(['view', 'id' => $answer->question_id]);
            }
        }

        return $this->render('update-answer', [
            'answerForm' => $answerForm
        ]);
    }

    /**
     * Creates a new Question model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $questionModel = new Question();

        /** @var $questionForm \frontend\models\QuestionForm */
        $questionForm = new QuestionForm([
            'question' => $questionModel
        ]);

        if ($questionForm->load(Yii::$app->request->post())) {
            /** @var $question \common\models\Question */
            if ($question = $questionForm->save()) {
                return $this->redirect(['view', 'id' => $question->id]);
            }
        }

        return $this->render('create', [
            'questionForm' => $questionForm
        ]);
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
        $sort = new Sort([
            'defaultOrder' => [
                'created_at' => SORT_ASC,
                'view_count' => SORT_ASC,
                'favorite_count' => SORT_ASC
            ],
            'attributes' => [
                'created_at', 'view_count', 'favorite_count'
            ]
        ]);

        $query = Question::find()
            ->with(['user', 'questionTags', 'questionFavorites'])
            ->andWhere([
                'question.answer_count' => 0,
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'sort' => $sort,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionSolved()
    {
        $sort = new Sort([
            'defaultOrder' => [
                'created_at' => SORT_ASC,
                'view_count' => SORT_ASC,
                'favorite_count' => SORT_ASC
            ],
            'attributes' => [
                'created_at', 'view_count', 'favorite_count'
            ]
        ]);

        $query = Question::find()
            ->with(['user', 'questionTags', 'questionFavorites'])
            ->andWhere([
                'question.solved' => Question::STATUS_SOLVED,
                'question.status' => Question::STATUS_PUBLISHED
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'sort' => $sort,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @inheritdoc
     */
    public function actionMy()
    {
        $sort = new Sort([
            'defaultOrder' => [
                'created_at' => SORT_ASC,
                'view_count' => SORT_ASC,
                'favorite_count' => SORT_ASC
            ],
            'attributes' => [
                'created_at', 'view_count', 'favorite_count'
            ]
        ]);

        $query = Question::find()
            ->with(['user', 'questionTags', 'questionFavorites'])
            ->andWhere([
                'question.user_id' => Yii::$app->user->getId()
            ])
            ->orderBy('question.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => $sort,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'sort' => $sort,
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
     * Change of status of the issue to delete
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDeleteQuestion($id)
    {
        $question = $this->findModel($id);
        if (Yii::$app->user->getId() !== $question->user_id) {
            throw new ForbiddenHttpException();
        }

        $question->status = $question::STATUS_DELETED;

        $question->save();

        return $this->redirect(['index']);
    }

    /**
     * Change of status of the answer to delete
     * @param $id
     * @return \yii\web\Response
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionDeleteAnswer($id)
    {
        $answer = $this->findModelAnswer($id);
        if (Yii::$app->user->getId() !== $answer->user_id) {
            throw new ForbiddenHttpException();
        }

        $answer->status = $answer::STATUS_DELETED;

        if ($answer->save()) {
            $answer->question->updateCounters(['answer_count' => -1]);
        }

        return $this->redirect(['view', 'id' => $answer->question_id]);
    }

    /**
     * Finds the QuestionAnswer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return QuestionAnswer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAnswer($id)
    {
        if (($model = QuestionAnswer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
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
