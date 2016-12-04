<?php

use app\util\Migration;

class m150824_110742_qa extends Migration
{
    public function up()
    {
        $this->createTable(
            'question',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'title' => $this->string()->notNull(),
                'body' => 'MEDIUMTEXT NOT NULL',
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->createTable(
            'answer',
            [
                'id' => $this->primaryKey(),
                'user_id' => $this->integer()->notNull(),
                'question_id' => $this->integer()->notNull(),
                'body' => 'MEDIUMTEXT NOT NULL',
                'status' => $this->smallInteger()->notNull()->defaultValue(10),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->addForeignKey('fk-question-user_id-user-id', 'question', 'user_id', 'user', 'id');
        $this->addForeignKey('fk-answer-user_id-user-id', 'answer', 'user_id', 'user', 'id');
        $this->addForeignKey(
            'fk-answer-question_id-question-id',
            'answer',
            'question_id',
            'question',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('answer');
        $this->dropTable('question');
    }
}
