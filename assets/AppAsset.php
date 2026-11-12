<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle for Brewly.
 *
 * @author Your Name
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/brewly.css',
    ];
    
    public $js = [
        'js/main.js',
    ];
    
    public $depends = [
        'yii\web\YiiAsset', // Только базовый Yii, БЕЗ Bootstrap
    ];
}