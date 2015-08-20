<?php

/**
 * Class that handles restructuring the CMS UI to best suit client needs.
 */
class StreakCMSExtension extends CrackerJackDataExtension {
    // map of extended class to fields to the intended tab where they should show.
    private static $field_tabs = [
        'Product' => [
            'StreakImages' => 'Root.Main',
            'Attributes' => 'Root.Main',
            'Variations' => 'Root.Main'
        ],
        'Variation' => [                        // NB: no artisan on Variation
            'StreakImages' => 'Root.Main',
        ]
    ];

    /**
     * Checks through config.field_tabs for the extended class and moves fields from existing
     * tab to designated tab by field name.
     *
     * @param FieldList $fields
     */
    public function updateProductCMSFields(FieldList $fields) {
        $extendedClass = get_class($this->owner);
        if ($fieldTabs = CrackerJackModule::get_config_setting(__CLASS__, 'field_tabs', $extendedClass)) {
            foreach ($fieldTabs as $fieldName => $tabName) {
                /** @var FormField $field */
                if ($field = $fields->dataFieldByName($fieldName)) {
                    $containerFieldList = $field->getContainerFieldList();

                    // TODO add check so we don't do this if already in correct tab
                    $containerFieldList->removeByName($fieldName);

                    if (0 === $containerFieldList->count()) {
                        $fields->removeByName($fieldName, false);
                    }
                    $fields->addFieldToTab(
                        $tabName,
                        $field
                    );

                }
            }
        }
    }
}