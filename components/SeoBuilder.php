<?php

namespace app\components;

use Yii;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\View;

class SeoBuilder
{
    /** @var View */
    private $view;

    private $noindex = false;
    private $title;
    private $description;
    private $author;
    private $useOpenGraph = false;
    private $useTwitter = false;

    private function __construct() {}

    public static function createByWebController(Controller $controller)
    {
        $builder = new self;
        $builder->view = $controller->view;

        return $builder;
    }

    public function setNoindex($value = true)
    {
        $this->noindex = $value;

        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    public function useOpenGraph($value = true)
    {
        $this->useOpenGraph = $value;

        return $this;
    }

    public function useTwitter($value = true)
    {
        $this->useTwitter = $value;

        return $this;
    }

    public function build()
    {
        $this->buildTitle();

        if ($this->noindex) {
            $this->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex'
            ]);
        }

        if ($this->author !== null) {
            $this->view->registerMetaTag([
                'name' => 'author',
                'content' => Html::encode($this->author),
            ]);
        }

        if ($this->useTwitter) {
            $this->view->registerMetaTag([
                'name' => 'twitter:site',
                'content' => '@yiiframework_ru',
            ]);
        }

        $page = Yii::$app->request->getQueryParam('page');

        if ($page > 1) {
            $this->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex,follow'
            ]);
        } else {
            $this->buildDescription();
        }
    }

    private function buildTitle()
    {
        if ($this->title !== null) {
            $encodedTitle = Html::encode($this->title);
            $this->view->title = $encodedTitle;

            if ($this->useOpenGraph) {
                $this->view->registerMetaTag([
                    'property' => 'og:title',
                    'content' => $encodedTitle,
                ]);
            }

            if ($this->useTwitter) {
                $this->view->registerMetaTag([
                    'name' => 'twitter:title',
                    'content' => $encodedTitle,
                ]);
            }
        }
    }

    private function buildDescription()
    {
        if ($this->description !== null) {
            $encodedDescription = Html::encode($this->description);

            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $encodedDescription,
            ]);

            if ($this->useOpenGraph) {
                $this->view->registerMetaTag([
                    'property' => 'og:description',
                    'content' => $encodedDescription,
                ]);
            }

            if ($this->useTwitter) {
                $this->view->registerMetaTag([
                    'name' => 'twitter:description',
                    'content' => $encodedDescription,
                ]);
            }
        }
    }
}