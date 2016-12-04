<?php
namespace app\helpers;

/**
 * Text helper
 * @author Alexander Makarov
 */
class Text
{
    /**
     * Cuts text after [cut] mark
     *
     * @param string $text
     * @param string $moreLink
     * @return string
     */
    public static function cut($text, $moreLink = null)
    {
        $text = explode('[cut]', $text, 2);
        return empty($text[1]) ? $text[0] : $moreLink === null ? $text[0] :  $text[0] . "\n$moreLink";
    }

    /**
     * Removes [cut] mark from the text
     *
     * @param string $text
     * @return string
     */
    public static function hideCut($text)
    {
        return str_replace('[cut]', '', $text);
    }
}
