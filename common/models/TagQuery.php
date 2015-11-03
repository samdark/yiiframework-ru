<?php

namespace common\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Tag]].
 *
 * @see Tag
 */
class TagQuery extends ActiveQuery
{
    /**
     * @inheritdoc
     * @return Tag[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Tag|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param $exclude integer|array of integer ID
     * @return $this
     */
    public function canBeParent($exclude = null)
    {
        $this->andWhere('parent_id IS NULL');

        if (!empty($exclude)) {
            $this->andWhere(['NOT IN', 'id', $exclude]);
        }

        return $this;
    }
}