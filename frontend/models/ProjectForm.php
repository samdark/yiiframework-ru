<?php

namespace frontend\models;

use common\helpers\Generator;
use common\models\Project;
use common\models\ProjectImage;
use Yii;
use yii\base\Exception;
use yii\base\Model;
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
    public $Project;

    public function init()
    {
        parent::init();

        $Project = $this->Project;

        $this->title = $Project->title;
        $this->link = $Project->link;
        $this->body = $Project->body;
    }

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
        $this->Project->setAttributes([
            'title' => $this->title,
            'body' => $this->body,
            'link' => $this->link,
        ]);

        $this->Project->save(false);

        $this->saveImages();
    }

    /**
     * @throws Exception
     */
    public function saveImages()
    {
        if (!empty($this->imageFiles)) {
            $path = rtrim(Yii::getAlias(Yii::$app->params['path.to.project.images']), '/');

            foreach ($this->imageFiles as $file) {
                $fileName = Generator::fileName($file->extension, $path);

                if ($file->saveAs($path . DIRECTORY_SEPARATOR . $fileName)) {
                    $ProjectImage = new ProjectImage;
                    $ProjectImage->setAttributes([
                        'project_id' => $this->Project->id,
                        'name' => $fileName,
                    ]);

                    $ProjectImage->validate() && $ProjectImage->save();
                } else {
                    throw new Exception('Image could not be saved');
                };
            }
        }
    }
}
