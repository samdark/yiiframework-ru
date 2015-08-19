<?php

namespace frontend\controllers;

use common\models\Project;
use frontend\models\ProjectForm;
use Yii;
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
        $ProjectForm = new ProjectForm(['Project' => new Project()]);

        if ($ProjectForm->load(Yii::$app->request->post())) {

            $ProjectForm->imageFiles = UploadedFile::getInstances($ProjectForm, 'imageFiles');

            $ProjectForm->validate() && $ProjectForm->save();

            if (!$ProjectForm->hasErrors()) {
                return $this->redirect(['index']);
            }
        }

        return $this->render('create', ['project' => $ProjectForm]);
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
        /** @var Project $Project */
        $Project = Project::find()
            ->with(['images'])
            ->where([
                'project.id' => $id,
                'project.status' => Project::STATUS_ACTIVE
            ])
            ->one();

        if ($Project === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $ProjectForm = new ProjectForm(['Project' => $Project]);

        if ($ProjectForm->load(Yii::$app->request->post())) {

            $ProjectForm->imageFiles = UploadedFile::getInstances($ProjectForm, 'imageFiles');

            $ProjectForm->validate() && $ProjectForm->save();

            if (!$ProjectForm->hasErrors()) {
                return $this->redirect(['view', 'id' => $ProjectForm->Project->id]);
            }
        }

        return $this->render('update', ['project' => $ProjectForm]);
    }
}
