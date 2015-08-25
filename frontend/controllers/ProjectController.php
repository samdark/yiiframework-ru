<?php

namespace frontend\controllers;

use common\models\Project;
use common\models\ProjectImage;
use frontend\models\ProjectForm;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
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
                        'actions' => ['create', 'update', 'delete-image', 'add-image'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete-image' => ['DELETE'],
                    'add-image' => ['POST'],
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
            ->andWhere(
                [
                    'project.status' => Project::STATUS_ACTIVE,
                ]
            )
            ->orderBy('project.created_at DESC');

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => self::PAGE_SIZE,
                ],
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

    /**
     * Delete image file and model
     * @return int id image
     * @throws NotFoundHttpException
     * @throws \Exception
     * @internal param $id
     */
    public function actionDeleteImage()
    {
        /** @var ProjectImage $imageModel */
        $imageModel = ProjectImage::findOne(Yii::$app->request->post('key'));

        if ($imageModel === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if ($imageModel->delete()) {
            return $imageModel->id;
        } else {
            throw new \Exception('Cannot delete a image');
        }
    }

    /**
     * Add image file and model to project
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionAddImage($id)
    {
        /** @var Project $Project */
        $projectModel = Project::findOne($id);

        if ($projectModel === null) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        $projectForm = new ProjectForm(['Project' => $projectModel]);

        $projectForm->imageFiles = UploadedFile::getInstancesByName('imageFiles');

        Yii::$app->response->format = Response::FORMAT_JSON;

        if ($projectForm->validate(['imageFiles'])) {
            $projectForm->saveImages();
            return [];
        }

        return ['error' => $projectForm->getFirstError('imageFiles')];
    }

}
