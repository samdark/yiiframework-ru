<?php

use common\components\Migration;

class m160306_175420_update_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'email_token', $this->string()->unique() . ' AFTER  email_verified');
        $this->addColumn('user', 'first_name', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'last_name', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'resend_at', $this->integer() . ' AFTER  status');
    }

    public function down()
    {
        $this->dropColumn('user', 'email_token');
        $this->dropColumn('user', 'first_name');
        $this->dropColumn('user', 'last_name');
        $this->dropColumn('user', 'resend_at');
    }
}
