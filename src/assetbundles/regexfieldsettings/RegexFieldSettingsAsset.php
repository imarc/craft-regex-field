<?php
/**
 * Regex Field plugin for Craft CMS 4.x
 *
 * A field type for Craft CMS that validates input values against a regular expression.
 *
 * @link     https://www.imarc.com
 * @copyright Copyright (c) 2023 Linnea Hartsuyker
 */

namespace imarc\regexfield\assetbundles\regexfieldsettings;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class RegexFieldSettingsAsset extends AssetBundle
{
    public function init()
    {
        $this->sourcePath = "@imarc/regexfield/assetbundles/regexfieldsettings/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/RegexFieldSettings.js',
        ];

        $this->css = [
            'css/RegexFieldSettings.css',
        ];

        parent::init();
    }
}
