<?php

namespace frontend\models;

use common\helpers\Generator;
use common\models\Project;
use common\models\ProjectImage;
use Yii;
use yii\base\Exception;
use yii\base\Model;
use yii\db\Query;
use yii\web\UploadedFile;

/**
 * ProjectForm is the model behind the Project form with images form.
 */
class ProjectForm extends Model
{
    /**
     * @var string
     */
    public $title;
    /**
     * @varstring
     */
    public $link;
    /**
     * @var string
     */
    public $body;
    /**
     * @var UploadedFile[]
     */
    public $imageFiles;

    /**
     * @var Project
     */
    protected $project;

    /**
     * @var ProjectImage
     */
    protected $image;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'link', 'body',], 'required'],
            [['body'], 'string'],
            [['title', 'link'], 'string', 'max' => 255],
            [['link'], 'url'],
            [
                ['imageFiles'],
                'file',
                'skipOnEmpty' => true,
                'extensions' => 'png, jpg',
                'mimeTypes' => 'image/jpeg, image/png',
                'maxFiles' => 7
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', 'Title'),
            'link' => Yii::t('app', 'Link'),
            'body' => Yii::t('app', 'Body'),
            'imageFiles' => Yii::t('app', 'Image files'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return [
            'imageFiles' => Yii::t('app', 'Allow to upload JPEG/PNG files.'),
        ];
    }

    /**
     * @return bool
     */
    public function save()
    {
        $project = new Project(
            ['title' => $this->title, 'body' => $this->body, 'link' => $this->link]
        );

        $project->save(false);

        if (!empty($this->imageFiles)) {
            $this->saveImages($project->id);
        }
    }

    /**
     * @param integer $projectID
     * @throws Exception
     */
    public function saveImages($projectID)
    {
        $query = new Query();
        $command = $query->createCommand();

        foreach ($this->imageFiles as $file) {

            $fileName = Generator::fileName($file->extension, Yii::$app->params['path.to.project.images']);

            if ($file->saveAs(Yii::$app->params['path.to.project.images'] . $fileName)) {
                $command->insert(ProjectImage::tableName(), [
                    'project_id' => $projectID,
                    'name' => $fileName,
                ])->execute();
            } else {
                throw new Exception('Image could not be saved');
            };

        }
    }
}
