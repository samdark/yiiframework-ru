<?php

use common\components\Migration;

class m160309_175259_update_post extends Migration
{
    public function up()
    {
        $this->dropColumn('{{%post}}', 'body');
        $this->addColumn('{{%post}}', 'short_content', 'MEDIUMTEXT NOT NULL AFTER  title');
        $this->addColumn('{{%post}}', 'full_content', 'MEDIUMTEXT NOT NULL AFTER  title');
        $this->renameColumn('{{%post}}', 'link', 'slug');
        $this->alterColumn('{{%post}}', 'status', $this->smallInteger()->notNull()->defaultValue(0));
    }

    public function down()
    {
        $this->addColumn('{{%post}}', 'body', 'MEDIUMTEXT NOT NULL AFTER  title');
        $this->renameColumn('{{%post}}', 'slug', 'link');
        $this->dropColumn('{{%post}}', 'short_content');
        $this->dropColumn('{{%post}}', 'full_content');
        $this->alterColumn('{{%post}}', 'status', $this->smallInteger()->notNull()->defaultValue(10));
    }
}
