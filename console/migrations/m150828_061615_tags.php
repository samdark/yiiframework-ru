<?php

use common\components\Migration;

class m150828_061615_tags extends Migration
{
    public function up()
    {
        $this->createTable(
            'tag',
            [
                'id' => $this->primaryKey(),
                'name' => $this->string(100)->notNull(),
                'description' => $this->string(),
                'color' => $this->string(7),
                'parent_id' => $this->integer(),
                'position' => $this->integer(),
                'created_at' => $this->integer()->notNull(),
                'updated_at' => $this->integer()->notNull(),
            ]
        );

        $this->addForeignKey('fk-tag-parent_id-tag-id', 'tag', 'parent_id', 'tag', 'id', 'SET NULL', 'CASCADE');

        $this->createTable(
            'questions_tags',
            [
                'question_id' => $this->integer()->notNull(),
                'tag_id' => $this->integer()->notNull(),
            ]
        );

        $this->addForeignKey(
            'fk-questions_tags-tag_id-tag-id',
            'questions_tags',
            'tag_id',
            'tag',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-questions_tags-question_id-question-id',
            'questions_tags',
            'question_id',
            'question',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->batchInsert(
            'tag',
            ['name', 'description', 'color', 'created_at', 'updated_at'],
            [
                ['yii1', 'Common Yii 1.x question', '#4e89da', time(), time()],
                ['yii2', 'Common Yii 2.x question', '#e7652e', time(), time()],
            ]
        );
    }

    public function down()
    {
        $this->dropTable('questions_tags');
        $this->dropTable('tag');
    }
}
