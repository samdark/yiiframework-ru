<?php
/**
 * https://ru.gravatar.com/site/implement/images/php/
 */
namespace common\widgets;

use yii\helpers\Html;
use yii\base\Widget;
use yii\base\InvalidConfigException;

/**
 * Gravatar widget renders gravatar image given email address
 */
class Gravatar extends Widget
{
    /** @var string $gravatarUrl */
    public $gravatarUrl = 'https://www.gravatar.com/avatar/';

    /** @var array $options - options attr images */
    public $options = [];

    /** @var string $email */
    public $email;

    /** @var int $size - Size in pixels, defaults to 80px [ 1 - 2048 ] */
    public $size = 80;

    /** @var string $default - Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ] */
    public $default = 'monsterid';

    /** @var string $rating - Maximum rating (inclusive) [ g | pg | r | x ] */
    public $rating = 'g';

    /**
     * @inheritdoc
     */
    public function run()
    {
        echo Html::img($this->getUrl(), $this->options);
    }

    /**
     * @inheritdoc
     */
    public function getUrl()
    {
        $params = [
            's' => $this->size,
            'd' => $this->default,
            'r' => $this->rating
        ];

        $url = $this->gravatarUrl . md5(strtolower(trim($this->email ? $this->email : $this->options['alt']))) . '?' . http_build_query($params);

        return $url;
    }
}