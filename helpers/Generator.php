<?php

namespace app\helpers;

/**
 * Class Generator
 * @package common\helpers
 */
class Generator
{

    /**
     * Generate filename
     * @param string $ext extension
     * @param string $path to folder
     * @param int $length new filename (without extension)
     * @return string filename (with extension)
     */
    public static function fileName($ext, $path, $length = 27)
    {
        $path = rtrim($path, '/');

        do {
            $filename = sprintf('%s.%s', \Yii::$app->security->generateRandomString($length), $ext);
        } while (is_file($path . DIRECTORY_SEPARATOR . $filename));

        return $filename;
    }

    /**
     * Generate short text.
     * @param string $str full text
     * @param int $limit Limits a phrase to a given number of words.
     * @param null $endChar Default ... (&#8230; html code)
     * @return null|string
     */
    public static function limitWords($str, $limit = 100, $endChar = NULL)
    {
        $limit = (int)$limit;
        $endChar = ($endChar === NULL) ? '&#8230;' : $endChar;

        if (trim($str) === '')
            return $str;

        if ($limit <= 0)
            return $endChar;

        preg_match('/^\s*+(?:\S++\s*+){1,' . $limit . '}/u', $str, $matches);

        return rtrim($matches[0]) . (strlen($matches[0]) === strlen($str) ? '' : $endChar);
    }

}