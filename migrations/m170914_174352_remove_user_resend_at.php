<?php

use yii\db\Migration;

/**
 * Class m170914_174352_remove_user_resend_at
 */
class m170914_174352_remove_user_resend_at extends Migration
{
    private $table = '{{%user}}';

    /**
     * Move last time request from confirm email to email_token,
     * remove column resend_at in user table
     */
    public function up()
    {
        if (!empty($this->db->getTableSchema($this->table)->getColumn('resend_at'))) {
            $users = Yii::$app->db
                ->createCommand("SELECT * FROM {$this->table} WHERE `email_verified` = 0 AND resend_at != ''");

            foreach ($users->queryAll() as $user) {
                Yii::$app->db->createCommand()->update('user', [
                    'email_token' => $user['email_token'] . '_' . $user['resend_at']
                ], [
                    'id' => $user['id']
                ])->execute();
            }

            $this->dropColumn($this->table, 'resend_at');
        }
    }

    /**
     * Revert changes
     */
    public function down()
    {
        if (empty($this->db->getTableSchema($this->table)->getColumn('resend_at'))) {
            $this->addColumn($this->table, 'resend_at', $this->integer() . ' AFTER  status');
        }
    }
}
