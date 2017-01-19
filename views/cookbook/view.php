<?php

use app\components\MetaTagsRegistrar;
use yii\helpers\Html;

/* @var $content string */
/* @var $this \yii\web\View */
/* @var $toc array */
/* @var $topic string */

if ($topic !== 'index' && preg_match('/<h1[^>]*>(.*?)</', $content, $matches)) {
    $recipeTitle = $matches[1];

    $metaTitle = "{$recipeTitle} - рецепт Yii 1.1";
    $metaDescription = "Рецепт для фреймворка Yii 1.1: «{$recipeTitle}»";
} else {
    $metaTitle = 'Рецепты Yii 1.1';
    $metaDescription = 'Рецепты для фреймворка Yii 1.1 (cookbook) на сайте русскоязычного сообщества Yii';
}

(new MetaTagsRegistrar($this))
    ->setTitle($metaTitle)
    ->setDescription($metaDescription)
    ->useOpenGraphMetaTags()
    ->useTwitterMetaTags()
    ->register();
?>
<div class="cookbook-view container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-11 col-md-9 col-lg-9 container page-wrapper page-cont-col">
                <?= $content ?>
            </div>
            <div class="col-xs-2 col-sm-1 col-md-3 col-lg-3">
                <br>
                <ul class="toc">
                    <?php foreach ($toc as $title => $topics) {
                        echo '<li><b>' . $title . "</b>\n\t<div class=\"topics\"><ul>\n";
                        foreach ($topics as $path => $text) {
                            if ($path === $topic) {
                                echo "\t<li class=\"active\">";
                            } else {
                                echo "\t<li>";
                            }
                            echo Html::a(Html::encode($text), ['view', 'page' => $path]);
                            echo "</li>\n";
                        }
                        echo "\t</ul></div>\n</li>\n";
                    } ?>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=ru"></script>
</div>