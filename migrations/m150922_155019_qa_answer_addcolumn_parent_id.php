<?php

use app\util\Migration;

class m150922_155019_qa_answer_addcolumn_parent_id extends Migration
{
    public function up()
    {
        $this->addColumn('answer', 'parent_id', $this->integer()->defaultValue(0)->notNull() . ' AFTER  body');
    }

    public function down()
    {
        $this->dropColumn('answer', 'parent_id');
    }
}
