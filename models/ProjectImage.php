<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "project_image".
 *
 * @property integer $id
 * @property integer $project_id
 * @property string $name
 * @property string $filename
 * @property string $path
 *
 * @property Project $project
 */
class ProjectImage extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project_image';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'name'], 'required'],
            [['project_id'], 'integer'],
            [['name'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'project_id' => Yii::t('app', 'Project ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            if (unlink($this->path)) {
                return true;
            } else {
                throw new \Exception('Cannot delete a file ' . $this->path);
            }
        } else {
            return false;
        }
    }

    /**
     * Get url to image file
     * @return null|string
     */
    public function getFilename()
    {
        if ($this->name) {
            return Yii::$app->params['url.to.project.images'] . $this->name;
        }
        return null;
    }

    /**
     * Get full path to image file
     * @return null|string
     */
    public function getPath()
    {
        if ($this->name) {
            return Yii::$app->params['path.to.project.images'] . $this->name;
        }
        return null;
    }
}
