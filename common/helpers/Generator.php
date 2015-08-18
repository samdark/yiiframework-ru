<?php
namespace common\helpers;

class Generator {

    /**
     * Generate filename
     * @param string $ext extension
     * @param string $path to folder
     * @param int $length
     * @return string filename (with extension)
     */
    public static function fileName($ext, $path, $length = 28)
    {
        $name = \Yii::$app->security->generateRandomString($length);
        while (is_file($path . $name . '.' . $ext)) {
            $name = \Yii::$app->security->generateRandomString($length);
        }
        return $name . '.' . $ext;
    }
}