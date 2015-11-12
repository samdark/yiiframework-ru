<?php

use common\components\Migration;

class m151111_223932_qa_new extends Migration
{
    public function up()
    {
        $this->dropTable('questions_tags');
        $this->dropTable('tag');
        $this->dropTable('answer');
        $this->dropTable('question');

        $this->createTable('question', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'title' => $this->string()->notNull(),
            'body' => 'MEDIUMTEXT NOT NULL',
            'view_count' => $this->integer()->defaultValue(0)->notNull(),
            'answer_count' => $this->integer()->defaultValue(0)->notNull(),
            'favorite_count' => $this->integer()->defaultValue(0)->notNull(),
            'solution' => $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->createTable('question_answer', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull(),
            'body' => 'MEDIUMTEXT NOT NULL',
            'solution' => $this->smallInteger()->notNull()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->createTable('question_favorite', [
            'user_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull()
        ]);

        $this->createTable('question_tag', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'frequency' => $this->smallInteger()->notNull()->defaultValue(0)
        ]);

        $this->createTable('question_tag_assn', [
            'question_id' => $this->integer()->notNull(),
            'tag_id' => $this->integer()->notNull()
        ]);

        $this->addForeignKey('fk-question-user_id-user-id', 'question', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_answer-user_id-user-id', 'question_answer', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_answer-question_id-question-id', 'question_answer', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_favorite-user_id-user-id', 'question_favorite', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_favorite-question_id-question-id', 'question_favorite', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_tag_assn-question_id-question-id', 'question_tag_assn', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_tag_assn-tag_id-question_tag-id', 'question_tag_assn', 'tag_id', 'question_tag', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('question_tag_assn');
        $this->dropTable('question_tag');
        $this->dropTable('question_favorite');
        $this->dropTable('question_answer');
        $this->dropTable('question');
    }
}
