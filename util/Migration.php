<?php
namespace app\util;

class Migration extends \yii\db\Migration
{
    public function createTable($table, $columns, $options = null)
    {
        if ($options === null) {
            $options = $this->getTableOptions();
        }
        parent::createTable($table, $columns, $options);
    }

    protected function getTableOptions()
    {
        switch ($this->getDb()->getDriverName()) {
            case 'mysql':
                return 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
            default:
                return null;
        }
    }
}
