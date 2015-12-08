<?php

use common\components\Migration;

class m151208_215342_add_city_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', '[[city]]', $this->string(64) . 'NULL AFTER `site`');
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', '[[city]]');
    }
}
