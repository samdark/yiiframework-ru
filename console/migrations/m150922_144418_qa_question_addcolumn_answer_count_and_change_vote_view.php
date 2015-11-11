<?php

use common\components\Migration;

class m150922_144418_qa_question_addcolumn_answer_count_and_change_vote_view extends Migration
{
    public function up()
    {
        $this->renameColumn('question', 'view', 'view_count');
        $this->renameColumn('question', 'vote', 'vote_count');
        $this->addColumn('question', 'answer_count', $this->integer()->defaultValue(0)->notNull() . ' AFTER  body');
    }

    public function down()
    {
        $this->renameColumn('question', 'view_count', 'view');
        $this->renameColumn('question', 'vote_count', 'vote');
        $this->dropColumn('question', 'answer_count');
    }
}
