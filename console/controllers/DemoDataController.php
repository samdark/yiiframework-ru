<?php

namespace console\controllers;

use common\models\Question;
use common\models\QuestionAnswer;
use common\models\QuestionTag;
use common\models\QuestionTagAssn;
use Faker;
use yii\console\Controller;
use yii\db\Query;

/**
 * DemoDataController seeds database with demo data
 */
class DemoDataController extends Controller
{
    /**
     * Генерация новых демо данных для QA, текущие данные будут удалены.
     * Примечание: Должен быть создан пользователь с id=1
     * @param $countData
     * @throws \yii\db\Exception
     */
    public function actionQa($countData)
    {
        $faker = Faker\Factory::create();

        Question::deleteAll();
        (new Query())->createCommand()->setSql('ALTER TABLE ' . Question::tableName() . ' AUTO_INCREMENT = 1')->execute();
        $data = [];
        $meta = ['user_id', 'title', 'body'];
        for ($i = 1; $i < $countData; $i++) {
            $data[] = array_combine($meta, [
                1, $faker->realText(rand(10, 200)), $faker->realText(rand(100, 1000))
            ]);
        }
        (new Query())->createCommand()->batchInsert(Question::tableName(), $meta, $data)->execute();

        // ---------- Answers --------------
        $data = [];
        $meta = ['user_id', 'question_id', 'body'];
        for ($i = 1; $i < $countData * 2; $i++) {
            $data[] = array_combine($meta, [
                1, rand(1, $countData - 1), $faker->text(rand(50, 200))
            ]);
        }
        (new Query())->createCommand()->batchInsert(QuestionAnswer::tableName(), $meta, $data)->execute();

        // ---------- TAG --------------
        QuestionTag::deleteAll();
        (new Query())->createCommand()->setSql('ALTER TABLE ' . QuestionTag::tableName() . ' AUTO_INCREMENT = 1')->execute();
        $data = [];
        $meta = ['name'];
        for ($i = 1; $i < 30; $i++) {
            $data[] = array_combine($meta, [$faker->word]);
        }
        (new Query())->createCommand()->batchInsert(QuestionTag::tableName(), $meta, $data)->execute();

        $tagsCount = [];
        QuestionTagAssn::deleteAll();
        $data = [];
        $meta = ['question_id', 'tag_id'];
        for ($i = 1; $i < $countData; $i++) {
            for ($j = 1; $j <= rand(1, 5); $j++) {
                $tagId = rand(1, 29);
                $data[] = array_combine($meta, [$i, $tagId]);
                !isset($tagsCount[$tagId]) ? $tagsCount[$tagId] = 0 : $tagsCount[$tagId]++;
            }
        }
        foreach ($tagsCount as $pk => $frequency) {
            (new Query())->createCommand()->update(QuestionTag::tableName(), ['frequency' => $frequency], ['id' => $pk])->execute();
        }

        (new Query())->createCommand()->batchInsert(QuestionTagAssn::tableName(), $meta, $data)->execute();
    }
}