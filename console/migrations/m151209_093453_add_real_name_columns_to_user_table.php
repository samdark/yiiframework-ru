<?php

use common\components\Migration;

class m151209_093453_add_real_name_columns_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', '[[first_name]]', $this->string(64) . 'NULL AFTER [[email_verified]]');
        $this->addColumn('{{%user}}', '[[last_name]]', $this->string(64) . 'NULL AFTER [[first_name]]');
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', '[[first_name]]');
        $this->dropColumn('{{%user}}', '[[last_name]]');
    }
}
