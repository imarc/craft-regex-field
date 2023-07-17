<?php

namespace imarc\regexfield;

use Craft;
use craft\base\Model;
use craft\base\Plugin;
use craft\services\Fields;
use craft\events\RegisterComponentTypesEvent;

use imarc\regexfield\models\Settings;
use imarc\regexfield\fields\RegexField as RegexCraftField;
use yii\base\Event;

/**
 * Regex Field plugin
 *
 * @method static RegexField getInstance()
 * @method Settings getSettings()
 * @author Linnea Hartsuyker <engineering@imarc.com>
 * @copyright Linnea Hartsuyker
 * @license MIT
 */
class RegexField extends Plugin
{
    public string $schemaVersion = '1.0.0';
    //public bool $hasCpSettings = true;

    public static function config(): array
    {
        return [
            'components' => [
                // Define component configs here...
            ],
        ];
    }

    public function init(): void
    {
        parent::init();

        // Defer most setup tasks until Craft is fully initialized
        Craft::$app->onInit(function() {
            $this->attachEventHandlers();
            // ...
        });
    }

    protected function createSettingsModel(): ?Model
    {
        return Craft::createObject(Settings::class);
    }

    protected function settingsHtml(): ?string
    {
        return Craft::$app->view->renderTemplate('regex-field/_settings.twig', [
            'plugin' => $this,
            'settings' => $this->getSettings(),
        ]);
    }

    private function attachEventHandlers(): void
    {
        // Register our fields
        Event::on(
            Fields::class,
            Fields::EVENT_REGISTER_FIELD_TYPES,
            function (RegisterComponentTypesEvent $event) {
                $event->types[] = RegexCraftField::class;
            }
        );
    }
}
