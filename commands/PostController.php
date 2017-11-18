<?php

namespace app\commands;

use Yii;
use app\models\Post;
use yii\console\Controller;

class PostController extends Controller
{
    /**
     * Delete posts marked as deleted.
     */
    public function actionDelete()
    {
        $postsQuery = Post::find()->andWhere(['status' => Post::STATUS_DELETED]);
        
        /** @var Post $post */
        foreach ($postsQuery->each() as $post) {
            $this->stdout("id: {$post->id}\n");

            $post->delete();
        }
    }
}
