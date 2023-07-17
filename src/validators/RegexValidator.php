<?php
/**
 * @link https://craftcms.com/
 * @copyright Copyright (c) Pixel & Tonic, Inc.
 * @license https://craftcms.github.io/license/
 */

namespace imarc\regexfield\validators;

use Craft;
use craft\helpers\App;
use yii\validators\Validator;

use imarc\regexfield\fields\RegexField;
/**
 * Class UrlValidator.
 *
 * @author Pixel & Tonic, Inc. <support@pixelandtonic.com>
 * @since 3.0.0
 */
class RegexValidator extends Validator
{
    public RegexField $field;

    /**
     * @inheritdoc
     */
    protected function validateValue(mixed $value): ?array
    {
        $field = $this->field;
        Craft::info('RegexFieldValidator::validateRegularExpression', "In method");

        Craft::info('RegexFieldValidator::validateRegularExpression', "Value: $value->regexField");

        $customPattern = $field->pattern;
        $customPattern = '`'.$customPattern.'`';

        Craft::info('RegexFieldValidator::validateRegularExpression', "Pattern: $customPattern");

        Craft::info('RegexFieldValidator::validateRegularExpression', "Pregmatch: " . preg_match($customPattern, $value->regexField));


        if (!empty($customPattern)) {
            if (!preg_match($customPattern, $value->regexField)) {
                return ["Value must match " . $customPattern, []];
            }
        }

        return null;
    }

}
