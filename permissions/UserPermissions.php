<?php
namespace app\permissions;

use app\models\Post;
use yii\web\User;

class UserPermissions
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function canManagePosts()
    {
        return $this->user->can('manage_posts');
    }

    public function canViewPost(Post $post)
    {
        return (int)$post->status === Post::STATUS_ACTIVE || $this->canEditPost($post);
    }

    public function canEditPost(Post $post)
    {
        return ($this->isPostOwner($post) && (int)$post->status === Post::STATUS_INACTIVE) || $this->canManagePosts();
    }

    public function isPostOwner(Post $post)
    {
        return (int)$post->user_id === (int) $this->user->getId();
    }
}
