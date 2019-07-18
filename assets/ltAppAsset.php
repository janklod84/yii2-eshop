<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class ltAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $js = [
        'js/html5shiv.js',
        'respond.min.js'
    ];

    public $jsOptions = [
        # подключение по условию
        # то есть все эти js файлы прописаны высше будут подключаться по условию
        'condition' => 'lte IE9',

        # позиция подключения скрипты [ указываем где мы хотили подключать скрипты ]
        # POS_HEAD значит где шапка
        'position' => \yii\web\View::POS_HEAD

    ];
}
