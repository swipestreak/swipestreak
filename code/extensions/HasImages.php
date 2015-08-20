<?php

class StreakHasImagesExtension extends CrackerJackDataExtension {
    const FieldName = 'StreakImages';
    const RelationshipName = self::FieldName;
    const DefaultTabName = 'Root.Images';

    private static $many_many = array(
        self::RelationshipName => 'Image'
    );

    private static $tab_name = self::DefaultTabName;

    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab(
            CrackerjackModule::get_config_setting(__CLASS__, 'tab_name'),
            $uploadField = new UploadField(
                self::FieldName,
                $this->fieldLabel(self::FieldName, $this()->i18n_singular_name() . ' images')
            )
        );
        $uploadField->setAllowedFileCategories(array('image'));
    }
}