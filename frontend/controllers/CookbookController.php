<?php


namespace frontend\controllers;


use Yii;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CookbookController handlers rendering of the old 1.1 unofficial cookbook articles
  */
class CookbookController extends Controller
{
    private $_toc;

    /**
     * @param string $topic
     * @return string document path for a topic
     */
    private function getDocumentPath($topic)
    {
        return \Yii::getAlias('@webroot') . '/cookbook/ru/' . $topic . '.txt';
    }

    public function actionView()
    {
        $topic = $this->getTopic();
        $file = $this->getDocumentPath($topic);

        if (strcasecmp($topic, 'toc') === 0 || !is_file($file)) {
            throw new NotFoundHttpException();
        }

        $content = file_get_contents($file);
        $content = HtmlPurifier::process(Markdown::process($content, 'gfm-comment'));

        $content = preg_replace_callback(
            '~<p>\s*<img(.*?)src="(.*?)"\s+alt="(.*?)"\s*/>\s*</p>~',
            [$this, 'replaceImgLink'],
            $content
        );

        $content = preg_replace_callback('/href="\/doc\/cookbook\/(.*?)\/?"/',
            [$this, 'replaceDocLink'], $content);
        $content = preg_replace('/href="(\/doc\/api\/.*?)"/', 'href="http://www.yiiframework.com$1"', $content);

        Yii::$app->view->title = 'Рецепты';
        if ($topic !== 'index' && preg_match('/<h1[^>]*>(.*?)</', $content, $matches)) {
            Yii::$app->view->title = $matches[1] . ' - ' . Yii::$app->view->title;
        }

        return $this->render('view', [
            'content' => $content,
            'toc' => $this->getTOC(),
            'topic' => $topic,
        ]);
    }

    /**
     * @param array $matches
     * @return string
     */
    private function replaceImgLink($matches)
    {
        $imageUrl = Yii::getAlias('@web') . '/cookbook/ru/images/' . $matches[2];
        return '<div class="image"><p>' . $matches[3] . '</p><img' . $matches[1] . 'src="' . $imageUrl . '" alt="' . $matches[3] . '" /></div>';
    }

    /**
     * @param array $matches
     * @return string
     */
    private function replaceDocLink($matches)
    {
        if (($pos = strpos($matches[1], '#')) !== false) {
            $anchor = substr($matches[1], $pos);
            $matches[1] = substr($matches[1], 0, $pos);
        } else {
            $anchor = '';
        }
        return 'href="' . Url::toRoute(['cookbook/view', 'page' => $matches[1]]) . $anchor . '"';
    }

    /**
     * @return string
     */
    private function getTopic()
    {
        $topic = Yii::$app->request->get('page', 'index');
        return str_replace(['/', '\\'], '', trim($topic));
    }

    /**
     * @return array
     */
    private function getTOC()
    {
        if ($this->_toc === null) {
            $file = $this->getDocumentPath('toc');
            $lines = file($file);
            $chapter = '';
            foreach ($lines as $line) {
                if (($line = trim($line)) === '') {
                    continue;
                }
                if ($line[0] === '*') {
                    $chapter = trim($line, '* ');
                } else if ($line[0] === '-' && preg_match('/\[(.*?)\]\((.*?)\)/', $line, $matches)) {
                    $this->_toc[$chapter][$matches[2]] = $matches[1];
                }
            }
        }
        return $this->_toc;
    }
}