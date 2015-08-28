<?php

namespace console\controllers;

use common\models\Answer;
use common\models\Question;
use common\models\QuestionsTags;
use common\models\Tag;
use Faker;
use yii\console\Controller;
use yii\db\Query;

class DemoDataController extends Controller
{
    public function actionQa()
    {
        $faker = Faker\Factory::create();

        Question::deleteAll();
        (new Query())->createCommand()->setSql('ALTER TABLE question AUTO_INCREMENT = 1')->execute();
        $data = [];
        $meta = ['user_id', 'title', 'body'];
        for ($i = 1; $i < 500; $i++) {
            $data[] = array_combine($meta, [
                1, $faker->realText(rand(10,200)), $faker->realText(rand(100, 1000))
            ]);
        }
        (new Query())->createCommand()->batchInsert(Question::tableName(), $meta, $data)->execute();

        // ---------- Answers --------------
        $data = [];
        $meta = ['user_id', 'question_id', 'body'];
        for ($i = 1; $i < 1000; $i++) {
            $data[] = array_combine($meta, [
                1, rand(2, 250), $faker->text(rand(50, 200))
            ]);
        }
        (new Query())->createCommand()->batchInsert(Answer::tableName(), $meta, $data)->execute();

        // ---------- TAG --------------
        Tag::deleteAll();
        (new Query())->createCommand()->setSql('ALTER TABLE tag AUTO_INCREMENT = 1')->execute();
        $data = [];
        $meta = ['name', 'color', 'description'];
        for ($i = 1; $i < 30; $i++) {
            $data[] = array_combine($meta, [
                $faker->word, $faker->hexColor, $faker->text(rand(20, 200))
            ]);
        }
        (new Query())->createCommand()->batchInsert(Tag::tableName(), $meta, $data)->execute();

        QuestionsTags::deleteAll();
        $data = [];
        $meta = ['question_id', 'tag_id'];
        for ($i = 1; $i < 500; $i++) {
            for ($j = 1; $j <= rand(1,5);$j++) {
                $data[] = array_combine($meta, [$i, rand(1,29)]);
            }
        }

        (new Query())->createCommand()->batchInsert(QuestionsTags::tableName(), $meta, $data)->execute();
    }
}