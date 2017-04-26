<?php


namespace app\notifier;


use app\models\Post;
use app\models\User;
use yii\helpers\Url;

/**
 * NewPostNotification represents new post notificaiton
 */
class NewPostNotification implements NotificationInterface
{
    private $post;

    /**
     * @param Post $post
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return User
     */
    public function getToUser()
    {
        return User::findByUsername('samdark');
    }

    /**
     * @return string
     */
    public function getSubject()
    {
        return 'Новый пост на yiiframework.ru!';
    }

    /**
     * @return string
     */
    public function getText()
    {
        $link = Url::to(['post/view', 'id' => $this->post->id, 'slug' => $this->post->slug], true);

        return <<<TEXT
На yiiframework.ru новый пост:

$link
TEXT;

    }
}
