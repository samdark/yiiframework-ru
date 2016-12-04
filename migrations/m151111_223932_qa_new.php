<?php

use app\util\Migration;

class m151111_223932_qa_new extends Migration
{
    public function up()
    {
        $this->dropColumn('question', 'vote_count');
        $this->addColumn('question', 'favorite_count', $this->integer()->notNull()->defaultValue(0) . ' AFTER  body');
        $this->addColumn('question', 'solved', $this->smallInteger()->notNull()->defaultValue(0) . ' AFTER  body');

        $this->dropColumn('answer', 'parent_id');
        $this->renameTable('answer', 'question_answer');
        $this->addColumn('question_answer', 'solved', $this->smallInteger()->notNull()->defaultValue(0) . ' AFTER  body');

        $this->createTable('question_favorite', [
            'user_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull()
        ]);

        $this->dropColumn('tag', 'description');
        $this->dropColumn('tag', 'color');
        $this->dropColumn('tag', 'position');
        $this->dropForeignKey('fk-tag-parent_id-tag-id', 'tag');
        $this->dropColumn('tag', 'parent_id');
        $this->dropColumn('tag', 'created_at');
        $this->dropColumn('tag', 'updated_at');
        $this->renameTable('tag', 'question_tag');
        $this->addColumn('question_tag', 'frequency', $this->smallInteger()->notNull()->defaultValue(0) . ' AFTER  name');

        $this->renameTable('questions_tags', 'question_tag_assn');

        $this->addForeignKey('fk-question_favorite-user_id-user-id', 'question_favorite', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_favorite-question_id-question-id', 'question_favorite', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        return false;
    }
}
