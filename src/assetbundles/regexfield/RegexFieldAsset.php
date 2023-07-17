<?php
/**
 * Regex Field plugin for Craft CMS 4.x
 *
 * A field type for Craft CMS that validates input values against a regular expression.
 *
 * @link     https://www.imarc.com
 * @copyright Copyright (c) 2023 Linnea Hartsuyker
 */

namespace imarc\regexfield\assetbundles\regexfield;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class RegexFieldAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = "@imarc/regexfield/assetbundles/regexfield/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/RegexField.js',
        ];

        $this->css = [
            'css/RegexField.css',
        ];

        parent::init();
    }
}
