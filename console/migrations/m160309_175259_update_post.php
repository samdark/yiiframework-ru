<?php

use common\components\Migration;

class m160309_175259_update_post extends Migration
{
    public function up()
    {
        $this->renameColumn('{{%post}}', 'link', 'slug');
        $this->alterColumn('{{%post}}', 'status', $this->smallInteger()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->renameColumn('{{%post}}', 'slug', 'link');
        $this->alterColumn('{{%post}}', 'status', $this->smallInteger()->notNull()->defaultValue(10));
    }
}
