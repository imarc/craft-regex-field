<?php
/**
 * Regex Field plugin for Craft CMS 4.x
 *
 * A field type for Craft CMS that validates input values against a regular expression.
 *
 * @link     https://www.imarc.com
 * @copyright Copyright (c) 2023 Linnea Hartsuyker
 */

namespace imarc\regexfield\models;

use Craft;
use craft\base\Model;

class RegexFieldModel extends Model
{
    public $regexField = '';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['regexField', 'string'],
        ];
    }


}
