<?php
class StreakConfig extends DataObject implements StreakConfigInterface {

    private static $db = array(
        'Title' => 'Varchar(64)',
        'Active' => 'Boolean'
    );

    private static $singular_name = 'Configuration';

    private static $summary_fields = array(
        'Title',
        'Active'
    );

    /**
     * Returns the first active config or the first one founf if none active.
     *
     * @return DataObject
     */
    public static function streak_config() {
        if (!$config = self::get()->filter('Active', true)->first()) {
            $config = self::get()->first();
        }
        return $config;
    }



    /**
     * Don't let current or active config be deleted.
     *
     * @throws ValidationException
     */
    public function onBeforeDelete() {
        parent::onBeforeDelete();

        $currentConfig = self::streak_config();
        if ($this->isInDB() && $currentConfig && $currentConfig->ID == $this->ID) {
            throw new ValidationException("Can't delete only or active config, please make another active config before deleting this one.");
        }
    }
    /**
     * If we are going to be the only config then set to be Active.
     */
    public function onBeforeWrite() {
        if (!$this->isInDB()) {
            if (!StreakConfig::get()->count()) {
                $this->Active = true;
            }
        }
        parent::onBeforeWrite();
    }

    /**
     * Update other configs to not be Active.
     *
     * @throws ValidationException
     * @throws null
     */
    public function onAfterWrite() {
        if ($this->Active) {
            foreach (StreakConfig::get()->exclude('ID', $this->ID) as $otherConfig) {
                $otherConfig->Active = false;
                $otherConfig->write();
            }
        }
    }
    public function requireDefaultRecords() {
        if (!self::streak_config()) {
            self::create_default_config();
        }
    }

    protected function create_default_config() {
        $data = array();

        $fields = singleton('StreakConfig')->getConfigFields();

        foreach ($fields as $field) {
            // check as sometimes fields don't have a name (e.g. composite fields?)
            if ($field->hasMethod('getName')) {
                $data[$field->getName()] = $field->Value();
            }
        }

        $config = self::create($data);
        $config->Title = 'Default Config';
        $config->Active = true;
        $config->write();
        return $config;
    }



    public function updateEditForm(FieldList $fields) {
        $fields->removeByName('StreakConfig');
        $fields->merge(
            $this->getConfigFields()
        );
    }

    public function provideStreakConfig(FieldList $fields) {
        // add any Streak 'global' configuration options here
    }
    protected function getConfigFields() {
        $fields = new FieldList();

        self::invokeWithExtensions('provideStreakConfig', $fields);

        return $fields;
    }
}