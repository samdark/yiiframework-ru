<?php

use yii\db\Migration;

class m161205_190035_init_rbac extends Migration
{
    public function up()
    {
        /** @var \yii\rbac\ManagerInterface $auth */
        $auth = Yii::$app->authManager;

        $managePosts = $auth->createPermission('manage_posts');
        $managePosts->description = 'Manage posts';
        $auth->add($managePosts);

        $manageUsers = $auth->createPermission('manage_users');
        $manageUsers->description = 'Manage users';
        $auth->add($manageUsers);

        $manageProjects = $auth->createPermission('manage_projects');
        $manageProjects->description = 'Manage projects';
        $auth->add($manageProjects);

        $moderator = $auth->createRole('moderator');
        $moderator->description = 'Moderator';
        $auth->add($moderator);
        $auth->addChild($moderator, $manageProjects);
        $auth->addChild($moderator, $managePosts);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';
        $auth->add($admin);
        $auth->addChild($admin, $manageProjects);
        $auth->addChild($admin, $managePosts);
        $auth->addChild($admin, $manageUsers);
    }

    public function down()
    {
        /** @var \yii\rbac\ManagerInterface $auth */
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }
}
