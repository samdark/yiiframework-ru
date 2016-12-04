<?php

use app\util\Migration;

class m160307_154049_update_fields_user extends Migration
{
    public function up()
    {
        $this->dropIndex('email', '{{%user}}');
        $this->addColumn('{{%user}}', 'twitter', $this->string() . ' AFTER  github');
        $this->addColumn('{{%user}}', 'facebook', $this->string() . ' AFTER  github');
        $this->dropColumn('{{%user}}', 'first_name');
        $this->dropColumn('{{%user}}', 'last_name');
        $this->addColumn('{{%user}}', 'fullname', $this->string() . ' AFTER  twitter');
    }

    public function down()
    {
        $this->createIndex('email', '{{%user}}', 'email');
        $this->dropColumn('{{%user}}', 'twitter');
        $this->dropColumn('{{%user}}', 'fullname');
        $this->dropColumn('{{%user}}', 'facebook');
        $this->addColumn('user', 'first_name', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'last_name', $this->string()->notNull() . ' AFTER  github');
    }
}
