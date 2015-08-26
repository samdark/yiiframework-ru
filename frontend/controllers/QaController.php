<?php

namespace frontend\controllers;

use common\models\Answer;
use Yii;
use common\models\Question;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * QuestionController implements the CRUD actions for Question model.
 */
class QaController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update'],
                'rules' => [
                    [
                        'actions' => ['create', 'update-question', 'delete-question', 'update-answer', 'delete-answer'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Question models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Question::find(),
            ]
        );

        return $this->render(
            'index',
            [
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Displays a single Question model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $question = $this->findModel($id);
        $newAnswer = new Answer(['question_id' => $question->id]);

        if (Yii::$app->request->isPost) {

            $newAnswer->body = Yii::$app->request->post('answer');

            if ($newAnswer->save()) {
                Yii::$app->session->setFlash('success', Yii::t('app', 'Your answer published'));
                return $this->refresh();
            }
        }

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
        $model = new Question();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'create',
                [
                    'question' => $model,
                ]
            );
        }
    }

    /**
     * Updates an existing Question model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateQuestion($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'update',
                [
                    'question' => $model,
                ]
            );
        }
    }

    /**
     * Updates an existing Answer model.
     * If update is successful, the browser will be redirected to the 'view' question page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdateAnswer($id)
    {
        /* @var $answer Answer */
        if (($answer = Answer::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($answer->load(Yii::$app->request->post()) && $answer->save(true, ['body'])) {
            return $this->redirect(['view', 'id' => $answer->question->id]);
        } else {
            return $this->render(
                'update-answer',
                ['answer' => $answer,]
            );
        }
    }

    /**
     * Deletes an existing Question model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDeleteQuestion($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Answer model.
     * If deletion is successful, the browser will be redirected to the 'Question' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionDeleteAnswer($id)
    {
        /* @var $answer Answer */
        if (($answer = Answer::findOne($id)) === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $answer->delete();

        return $this->redirect(['view', 'id' => $answer->question->id]);
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
