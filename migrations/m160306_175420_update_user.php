<?php

use app\util\Migration;

class m160306_175420_update_user extends Migration
{
    public function up()
    {
        $isMySQL = $this->getDb()->getDriverName() === 'mysql';

        $this->addColumn('user', 'email_token', $this->string() . ' AFTER  email_verified');
        $this->addColumn('user', 'first_name', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'last_name', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'resend_at', $this->integer() . ' AFTER  status');

        $this->createIndex('idx-user-email_token-unique', '{{%user}}', $isMySQL ? 'email_token(191)' : 'email_token', true);
    }

    public function down()
    {
        $this->dropColumn('user', 'email_token');
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'resend_at');
    }
}
