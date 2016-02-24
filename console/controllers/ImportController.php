<?php

namespace console\controllers;

use yii\console\Controller;
use yii\db\Connection;
use yii\db\Query;

/**
 * DumperController take from old site Posts table to new site
 */
class ImportController extends Controller
{

    /**
     * Заполняет таблицу новостей со старой базы данных
     * @param $tablePost string Имя старой таблицы
     * @param $dbName string Имя базы данных
     * @param $userName string Имя пользователя базы данных
     * @param $password string Пароль пользователя базы данных
     * @param $userId integer user_id кто написал новость
     * @return int Код выхода
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\db\Exception
     */
    public function actionDump($tablePost, $dbName, $userName, $password, $userId)
    {
        $oldDb = new Connection([
            'dsn' => 'mysql:host=localhost;dbname=' . $dbName,
            'username' => $userName,
            'password' => $password,
            'charset' => 'utf8',
        ]);

        $rows = (new Query())->from($tablePost)->all($oldDb);

        foreach ($rows as $post) {
            \Yii::$app->db->createCommand()->insert(
                'post',
                [
                    'id' => $post['id'],
                    'title' => $post['title'],
                    'body' => $post['content'],
                    'user_id' => $userId,
                    'created_at' => $post['createdOn'],
                ]
            )->execute();
        }

        echo "Success!\n";
        return Controller::EXIT_CODE_NORMAL;
    }
}