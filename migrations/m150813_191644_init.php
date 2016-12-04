<?php

use app\util\Migration;

class m150813_191644_init extends Migration
{
    public function up()
    {
        $isMySQL = $this->getDb()->getDriverName() === 'mysql';

        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string(),
            'email' => $this->string(),
            'email_verified' => $this->boolean(),
            'github' => $this->string(),
            'site' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createIndex('idx-user-username-unique', '{{%user}}', $isMySQL ? 'username(191)' : 'username', true);
        $this->createIndex('idx-user-email-unique', '{{%user}}', $isMySQL ? 'email(191)' : 'email', true);

        $this->createTable('auth', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'source' => $this->string()->notNull(),
            'source_id' => $this->string()->notNull(),
        ]);
        $this->addForeignKey('fk-auth-user_id-user-id', 'auth', 'user_id', 'user', 'id');
    }

    public function down()
    {
        $this->dropTable('auth');
        $this->dropTable('user');
    }
}
