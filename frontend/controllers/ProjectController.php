<?php

namespace frontend\controllers;

use frontend\models\ProjectForm;
use Yii;
use common\models\Project;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class ProjectController extends Controller
{
    const PAGE_SIZE = 10;

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
     * Lists all Project models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = Project::find()
            ->with(['user'])
            ->andWhere([
                'project.status' => Project::STATUS_ACTIVE,
            ])
            ->orderBy('project.created_at DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => self::PAGE_SIZE,
            ],
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Project model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $project = Project::find()
            ->with(['user', 'images'])
            ->where([
                'project.id' => $id,
                'project.status' => Project::STATUS_ACTIVE
            ])
            ->one();

        if ($project === null) {
            throw new NotFoundHttpException();
        }

        return $this->render('view', ['project' => $project]);
    }

    /**
     * Creates a new Project model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $project = new ProjectForm();

        if ($project->load(Yii::$app->request->post())) {

            $project->imageFiles = UploadedFile::getInstances($project, 'imageFiles');

            if ($project->validate()) {
                $project->save();
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['project' => $project,]);
    }

    /**
     * Updates an existing Project model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $project = Project::find()
            ->with(['images'])
            ->where([
                'project.id' => $id,
                'project.status' => Project::STATUS_ACTIVE
            ])
            ->one();

        if ($project === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($project->load(Yii::$app->request->post()) && $project->save()) {
            return $this->redirect(['view', 'id' => $project->id]);
        }

        return $this->render('update', ['project' => $project,]);
    }
}
