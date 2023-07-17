<?php
/**
 * Regex Field plugin for Craft CMS 4.x
 *
 * A field type for Craft CMS that validates input values against a regular expression.
 *
 * @link https://www.imarc.com
 * @copyright Copyright (c) 2023 Linnea Hartsuyker
 *
 */

namespace imarc\regexfield\fields;

use Craft;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use yii\db\Schema;
use craft\base\ElementInterface;
use craft\helpers\Json;
use Exception;

use imarc\regexfield\models\RegexFieldModel;
use imarc\regexfield\assetbundles\regexfield\RegexFieldAsset;
use imarc\regexfield\validators\RegexValidator;

class RegexField extends Field implements PreviewableFieldInterface
{

    //public int $length = 255;
    public string $pattern = '';
    public string $placeholderText = '';

    /**
     * Returns the display name of this class.
     *
     * @return string The display name of this class.
     */
    public static function displayName(): string
    {
        return Craft::t('regex-field', 'Regex Field');
    }

     /**
     * Returns the validation rules for attributes.
     **
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();
        $rules = array_merge($rules, [
            [['pattern', 'placeholderText'], 'string']]);
        return $rules;
    }

    /**
     * Returns the column type that this field should get within the content table.
     */
    public function getContentColumnType(): string
    {
        return Schema::TYPE_STRING;
    }

    /**
     * Normalizes the field’s value for use.
     *
     * @param mixed                 $value   The raw field value
     * @param ElementInterface|null $element The element the field is associated with, if there is one
     *
     * @return mixed The prepared field value
     */
    public function normalizeValue($value, ElementInterface $element = null): mixed
    {
        if ($value instanceof RegexFieldModel) {
            return $value;
        }

        $attr = [];
        if (is_string($value)) {
            // If value is a string we are loading the data from the database
            try {
                $decodedValue = Json::decode($value, true);
                if (is_array($decodedValue)) {
                  $attr += $decodedValue;
                }
              } catch (Exception) {}
        } else if (is_array($value) && isset($value['isCpFormData'])) {
            // If it is an array and the field `isCpFormData` is set, we are saving a cp form
            $attr += [
                'pattern' => $this->pattern && isset($value['pattern']) ? $value['pattern'] : null,
            ];
        } else if (is_array($value)) {
            // Finally, if it is an array it is a serialized value
            $attr += $value;
        }

        return new RegexFieldModel($attr);
    }

    public function serializeValue($value, ElementInterface $element = null): mixed
    {
        return parent::serializeValue($value, $element);
    }

    /**
     * Returns the field's settings HTML
     *
     * @return string|null
     */
    public function getSettingsHtml(): ?string
    {
        // Render the settings template
        return Craft::$app->getView()->renderTemplate(
            'regex-field/_settings',
            [
                'field' => $this,
                'settings' => $this->getSettings()
            ]
        );
    }

    /**
     * @inheritdoc
     */
    public function getElementValidationRules(): array
    {
        $rules = parent::getElementValidationRules();
        $rules[] = [RegexValidator::class, 'field' => $this];

        return $rules;
    }

    /**
     * Validates our fields submitted value beyond the checks
     * that were assumed based on the content attribute.
     *
     *
     * @param Element|ElementInterface $element
     *
     * @return void
     */
    public function validateRegularExpression(ElementInterface $element)
    {

        Craft::info('RegexField::validateRegularExpression',"In method");
        $value = $element->getFieldValue($this->handle)->regexField;

        Craft::info('RegexField::validateRegularExpression',"Value: $value");

        $customPattern = $this->pattern;
        $customPattern = '`'.$customPattern.'`';

        Craft::info('RegexField::validateRegularExpression',"Pattern: $customPattern");

        Craft::info('RegexField::validateRegularExpression',"Pregmatch: " . preg_match($customPattern, $value));

        if (!empty($customPattern)) {
            // Use backtick as delimiters
            //$customPattern = '`'.$customPattern.'`';

            if (!preg_match($customPattern, $value)) {

                $this->addError($this->handle, "Value must match $customPattern.");
                Craft::info('RegexField::validateRegularExpression', json_encode($this->getErrors()));
                return false;
            }
        }

        return true;

    }

    public function getErrorMessage($field): string
    {
        if ($field->customPattern && $field->customPatternErrorMessage) {
            return Craft::t('sprout-base-fields', $field->customPatternErrorMessage);
        }

        return Craft::t('sprout-base-fields', $field->name.' must be a valid pattern.');
    }

    /**
     * Returns the field’s input HTML.
     *
     * @param mixed                 $value           The field’s value. This will either be the [[normalizeValue() normalized value]],
     *                                               raw POST data (i.e. if there was a validation error), or null
     * @param ElementInterface|null $element         The element the field is associated with, if there is one
     *
     * @return string The input HTML.
     */
    public function getInputHtml($value, ElementInterface $element = null): string
    {
        // Register our asset bundle
        Craft::$app->getView()->registerAssetBundle(RegexFieldAsset::class);

        // Get our id and namespace
        $id = Craft::$app->getView()->formatInputId($this->handle);
        $namespacedId = Craft::$app->getView()->namespaceInputId($id);

        // Variables to pass down to our field JavaScript to let it namespace properly
        $jsonVars = [
            'id' => $id,
            'name' => $this->handle,
            'label' => $this->name,
            'instructions' => $this->instructions,
            'namespace' => $namespacedId,
            'pattern' => $this->pattern,
            'prefix' => Craft::$app->getView()->namespaceInputId(''),
            ];
        $jsonVars = Json::encode($jsonVars);
        Craft::$app->getView()->registerJs("$('#{$namespacedId}-field').RegexFieldElement(" . $jsonVars . ");");

        // Add redactor field
        $config = ['handle' => $this->handle . '[thankyouMessage]'];

        // Render the input template
        return Craft::$app->getView()->renderTemplate(
            'regex-field/_input',
            [
                'name' => $this->handle,
                'value' => $value,
                'field' => $this,
                'id' => $id,
                'label' => $this->name,
                'pattern' => $this->pattern,
                'instructions' => $this->instructions,
                'namespacedId' => $namespacedId,
                'settings' => $this->getSettings()
            ]
        );
    }

}
