<?php

use app\util\Migration;

class m150830_154736_qa_question_addcolums_vote_view extends Migration
{
    public function up()
    {
        $this->addColumn('question', 'vote', $this->integer()->defaultValue(0)->notNull() . ' AFTER  body');
        $this->addColumn('question', 'view', $this->integer()->defaultValue(0)->notNull() . ' AFTER  body');
    }

    public function down()
    {
        $this->dropColumn('question', 'vote');
        $this->dropColumn('question', 'view');
    }
}
