<?php

use common\components\Migration;

class m160306_175420_update_user extends Migration
{
    public function up()
    {
        $this->addColumn('user', 'verified_token', $this->string()->unique() . ' AFTER  email_verified');
        $this->addColumn('user', 'firstName', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'lastName', $this->string()->notNull() . ' AFTER  github');
        $this->addColumn('user', 'resend_at', $this->integer() . ' AFTER  status');
    }

    public function down()
    {
        return false;
    }
}
