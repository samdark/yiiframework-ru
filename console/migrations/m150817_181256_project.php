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
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('project_image', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer()->notNull(),
            'name'=>$this->string()->notNull(),
        ]);

        $this->addForeignKey('fk-project-user_id-user-id', 'project', 'user_id', 'user', 'id');
        $this->addForeignKey('fk-image-project_id-project-id', 'project_image', 'project_id', 'project', 'id');
    }

    public function down()
    {
        $this->dropTable('project_image');
        $this->dropTable('project');
    }
}