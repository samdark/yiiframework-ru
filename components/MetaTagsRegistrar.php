<?php

namespace app\components;

use Yii;
use yii\web\View;

class MetaTagsRegistrar
{
    private $view;

    private $noindex = false;
    private $title;
    private $description;
    private $author;
    private $useOpenGraph = false;
    private $useTwitter = false;

    public function __construct(View $view)
    {
        $this->view = $view;
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

    public function useOpenGraphMetaTags($value = true)
    {
        $this->useOpenGraph = $value;

        return $this;
    }

    public function useTwitterMetaTags($value = true)
    {
        $this->useTwitter = $value;

        return $this;
    }

    public function register()
    {
        $this->registerTitle();

        if ($this->noindex) {
            $this->view->registerMetaTag([
                'name' => 'robots',
                'content' => 'noindex'
            ]);
        }

        if ($this->author !== null) {
            $this->view->registerMetaTag([
                'name' => 'author',
                'content' => $this->author,
            ]);
        }

        if ($this->useTwitter) {
            $this->view->registerMetaTag([
                'name' => 'twitter:card',
                'content' => 'summary',
            ]);

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
            $this->registerDescription();
        }
    }

    private function registerTitle()
    {
        if ($this->title !== null) {
            $this->view->title = $this->title;

            if ($this->useOpenGraph) {
                $this->view->registerMetaTag([
                    'property' => 'og:title',
                    'content' => $this->title,
                ]);
            }

            if ($this->useTwitter) {
                $this->view->registerMetaTag([
                    'name' => 'twitter:title',
                    'content' => $this->title,
                ]);
            }
        }
    }

    private function registerDescription()
    {
        if ($this->description !== null) {
            $this->view->registerMetaTag([
                'name' => 'description',
                'content' => $this->description,
            ]);

            if ($this->useOpenGraph) {
                $this->view->registerMetaTag([
                    'property' => 'og:description',
                    'content' => $this->description,
                ]);
            }

            if ($this->useTwitter) {
                $this->view->registerMetaTag([
                    'name' => 'twitter:description',
                    'content' => $this->description,
                ]);
            }
        }
    }
}