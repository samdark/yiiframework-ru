<?php

use common\components\Migration;

class m150813_202825_post extends Migration
{
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'body' => 'MEDIUMTEXT NOT NULL',
            'link' => $this->string(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey('fk-post-user_id-user-id', 'post', 'user_id', 'user', 'id');
    }

    public function down()
    {
        $this->dropTable('post');
    }
}
