<?php

use common\components\Migration;

class m151111_223932_qa_new extends Migration
{
    public function up()
    {
        $this->addColumn('question', 'favorite_count', $this->integer()->defaultValue(0)->notNull());
        $this->addColumn('question', 'solution', $this->smallInteger()->notNull()->defaultValue(0));

        $this->renameTable('answer', 'question_answer');
        $this->addColumn('question_answer', 'solution', $this->smallInteger()->notNull()->defaultValue(0));

        $this->createTable('question_favorite', [
            'user_id' => $this->integer()->notNull(),
            'question_id' => $this->integer()->notNull()
        ]);

        $this->renameTable('tag', 'question_tag');
        $this->addColumn('question_tag', 'frequency', $this->smallInteger()->notNull()->defaultValue(0));

        $this->renameTable('questions_tags', 'question_tag_assn');

        $this->addForeignKey('fk-question_favorite-user_id-user-id', 'question_favorite', 'user_id', 'user', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk-question_favorite-question_id-question-id', 'question_favorite', 'question_id', 'question', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        return false;
    }
}
