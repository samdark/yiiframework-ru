<div class="cookbook-view container-fluid">
    <div class="container">
        <div class="row">
            <div class="col-xs-10 col-sm-11 col-md-9 col-lg-9 container page-wrapper page-cont-col">
                <?= $content ?>
            </div>
            <div class="col-xs-2 col-sm-1 col-md-3 col-lg-3">
                <form action="http://www.google.com/cse" id="cse-search-box">
                    <div>
                        <input type="hidden" name="cx" value="006237035567373325440:sm9smqhhp9u"/>
                        <input type="hidden" name="ie" value="UTF-8"/>
                        <input type="text" name="q" size="14"/>
                        <input type="submit" name="sa" value="Поиск"/>
                    </div>
                </form>

                <ul class="toc">
                    <?php
                    use yii\helpers\Html;

                    foreach ($toc as $title => $topics) {
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
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=ru"></script>
</div>