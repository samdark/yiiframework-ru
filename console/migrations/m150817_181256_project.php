<?php

use common\components\Migration;

class m150817_181256_project extends Migration
{

    public function up()
    {
        $this->createTable('project', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'link' => $this->string()->notNull(),
            'body' => 'MEDIUMTEXT NOT NULL',
            'user_id' => $this->integer(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('project_image', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'name' => $this->string(32)->notNull(),
        ]);

        $this->addForeignKey('fk-project-user_id-user-id', 'project', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-image-project_id-project-id', 'project_image', 'project_id', 'project', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('fk-image-project_id-project-id', 'project_image');
        $this->dropForeignKey('fk-project-user_id-user-id', 'project');

        $this->dropTable('project_image');
        $this->dropTable('project');
    }
}