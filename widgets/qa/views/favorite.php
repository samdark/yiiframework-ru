<?php

/** @var boolean $isActive */
/** @var integer $favoriteCount */
/** @var null|integer $questionID */

$svgIcon = '<svg><use xlink:href="#ico_like"></use></svg>';
if ($questionID !== null) {
    $icon = \yii\bootstrap\Html::a($svgIcon, ['/qa/favorite'], ['data-question-id' => $questionID]);
} else {
    $icon = $svgIcon;
}

?>
<svg class="hidden">
    <symbol id="ico_like" viewBox="0 0 29 26">
        <path d="M24.8513339,4.11991813 C21.9944483,1.30038188 17.3660135,1.29337806 14.500125,
        4.09890668 C11.6342366,1.29337806 7.00480149,1.30038188 4.14791585,4.11991813 C1.28402805,
        6.9464582 1.28402805,11.5299556 4.14791585,14.3564956 C4.28695896,14.4945709 11.0840661,
        21.1702082 13.5868419,23.6285476 C14.0919985,24.1238175 14.9072512,24.1238175 15.4124078,
        23.6285476 C17.9151837,21.1702082 24.7122908,14.4945709 24.8513339,14.3564956 C27.716222,
        11.5299556 27.716222,6.9464582 24.8513339,4.11991813 L24.8513339,4.11991813 Z"></path>
    </symbol>
</svg>

<div class="q-info-like <?= $isActive ? 'active' : '' ?>">
    <?= $icon ?>
    <span><?= $favoriteCount ?></span>
</div>