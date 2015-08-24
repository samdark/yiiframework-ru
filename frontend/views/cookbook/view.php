<div class="cookbook-view">
    <div class="row">
        <div class="col-xs-9">
            <?= $content ?>
        </div>
        <div class="col-xs-3">
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

    <script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">google.load("elements", "1", {packages: "transliteration"});</script>
    <script type="text/javascript" src="http://www.google.com/cse/t13n?form=cse-search-box&t13n_langs=ru"></script>
    <script type="text/javascript" src="http://www.google.com/cse/brand?form=cse-search-box&lang=ru"></script>
</div>