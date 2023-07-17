<?php

namespace imarc\regexfield\models;

use Craft;
use craft\base\Model;

/**
 * Regex Field settings
 */
class Settings extends Model
{

    public $pattern = '';
    public $placeholderText = '';

    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            [['pattern', 'placeholderText'], 'string'],
        ];
    }
}
