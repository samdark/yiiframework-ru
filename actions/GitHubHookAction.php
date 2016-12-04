<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\actions;

use yii\base\Action;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\MethodNotAllowedHttpException;

/**
 * Action handles GitHub hooks. Currently it's getting release info from Yii 1 and Yii 2 repositories.
 * You can use it in any controller as:
 *
 *  public function actions()
 *  {
 *      return [
 *        'hooks' => [
 *          'class'=>'app\actions\GitHubHookAction',
 *          'fileName'=>'@app/config/versions.php',
 *         ]
 *      ];
 *  }
 *
 * In Webhooks/Manage on Github you should configure:
 *
 *      Payload URL - https://yiiframework.ru/site/hooks&version=yii2 or https://yiiframework.ru/site/hooks&version=yii1
 *      Content type - application/json
 *      Secret - configure in /config/params.php as "hook-hub-secret"
 *      Which events would you like to trigger this webhook? - only "Release"
 *
 * Later releases may be obtained as \Yii::$app->params['yii2-tag-name']
 *
 * @author Evgeniy Tkachenko <et.coder@gmail.com>
 * @since 2.0
 */
class GitHubHookAction extends Action
{
    /**
     * @var string the alias or path to file config where saved release key
     * Should have:
     *
     * <?php
     *   return [
     *      'yii1-tag-name' => '',
     *      'yii1-html-url' => '',
     *      'yii2-tag-name' => '',
     *      'yii2-html-url' => '',
     *  ];
     */
    public $fileName = '@app/config/versions.php';

    /**
     * Runs the action
     *
     * @param string $version should be as pretext in file ($fileName). Default "yii1" or "yii2"
     * @return string result content
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     * @throws MethodNotAllowedHttpException
     */
    public function run($version)
    {
        if (\Yii::$app->request->isPost) {

            if (\Yii::$app->request->headers->get('x-github-event') !== 'release') {
                return 'Hello ping!';
            }

            $this->checkHeaders();
            $this->save($version);
            return 'Yii-ii-i!';

        } else {
            \Yii::$app->getResponse()->getHeaders()->set('Allow', 'POST');
            throw new MethodNotAllowedHttpException(
                'Method Not Allowed. This url can only handle the following POST request method'
            );
        }
    }

    /**
     * Check delivery headers
     * See more info https://developer.github.com/webhooks/#payloads
     * @throws BadRequestHttpException
     * @throws ForbiddenHttpException
     */
    protected function checkHeaders()
    {
        if (\Yii::$app->request->headers->get('x-github-event') !== 'release') {
            throw new BadRequestHttpException('Bad event header');
        }

        if (!empty(\Yii::$app->params['hook-hub-secret']) && \Yii::$app->request->headers->get('x-hub-signature')) {

            list($algorithm, $hash) = explode('=', \Yii::$app->request->headers->get('x-hub-signature'), 2);

            $payloadHash = hash_hmac(
                $algorithm,
                file_get_contents('php://input'),
                \Yii::$app->params['hook-hub-secret']
            );

            if ($hash !== $payloadHash) {
                throw new ForbiddenHttpException('Bad signature header');
            }
        }
    }

    /**
     * Save information of release into file ($fileName)
     * @param $version
     * @throws Exception
     */
    protected function save($version)
    {
        $config = \Yii::getAlias($this->fileName);

        if (is_file($config)) {

            \Yii::$app->request->parsers = [
                'application/json' => 'yii\web\JsonParser',
            ];
            $release = \Yii::$app->request->post('release');

            if ($version === 'yii1' || $version === 'yii2') {
                $content = preg_replace(
                    '/(("|\')' . $version . '-tag-name("|\')\s*=>\s*)(""|\'.*\')/',
                    "\\1'{$release['tag_name']}'",
                    file_get_contents($config)
                );

                $content = preg_replace(
                    '/(("|\')' . $version . '-html-url("|\')\s*=>\s*)(""|\'.*\')/',
                    "\\1'{$release['html_url']}'",
                    $content
                );

                file_put_contents($config, $content);
            }

        } else {
            throw new Exception('File config not founded');
        }

    }
}
