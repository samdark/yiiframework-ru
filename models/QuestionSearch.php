<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * Class QuestionSearch is the filter/sort model behind the Questions models.
 */
class QuestionSearch extends Model
{
    /**
     * @var string|null
     */
    public $create_at;
    /**
     * @var string|null
     */
    public $view_count;
    /**
     * @var string|null
     */
    public $favorite_count;
    /**
     * @var boolean|null
     */
    public $solved;
    /**
     * @var true|null
     */
    public $individual;


    /**
     * @return array
     */
    public function rules()
    {
        return [
            ['favorite_count', 'in', 'range' => ['favorite_count', '-favorite_count'], 'strict' => true],
            ['created_at', 'in', 'range' => ['created_at', '-created_at'], 'strict' => true],
            ['view_count', 'in', 'range' => ['view_count', '-view_count'], 'strict' => true],
            ['solved', 'boolean'],
            ['individual', 'safe'],
        ];
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $this->load($params, '');

        $query = Question::find()
            ->select(['{{question}}.*', '{{user}}.[[username]]'])
            ->joinWith(['user'])
            ->andFilterWhere([
                'question.solved' => $this->solved,
            ]);

        if ($this->individual) {
            $query->andWhere([
                'question.user_id' => \Yii::$app->user->id,
            ]);
        } else {
            $query->andWhere([
                'question.status' => Question::STATUS_PUBLISHED,
            ]);
        }

        return new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_ASC,
                    'view_count' => SORT_ASC,
                    'favorite_count' => SORT_ASC
                ],
                'attributes' => [
                    'created_at',
                    'view_count',
                    'favorite_count'
                ]
            ],
        ]);
    }
}