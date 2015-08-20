<?php

namespace common\helpers;

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
}