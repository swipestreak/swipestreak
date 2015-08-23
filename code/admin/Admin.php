<?php

/**
 * Shop admin area for managing orders, customers and shop settings.
 *
 * @author     Frank Mullenger <frankmullenger@gmail.com>
 * @copyright  Copyright (c) 2011, Frank Mullenger
 * @package    swipestreak
 * @subpackage admin
 */
class StreakAdmin extends GridSheetModelAdmin {

    private static $url_segment = 'products';

    private static $url_priority = 50;

    private static $menu_title = 'Products';

    public $showImportForm = false;

    private static $managed_models = array();

    private static $url_handlers = array(
        '$ModelClass/$Action' => 'handleAction',
        '$ModelClass/$Action/$ID' => 'handleAction',
    );

    public static $hidden_sections = array();

    private static $allowed_actions = array(
        'EditForm',
        'SettingsContent',
        'SettingsForm'
    );

    public function init() {

        // set reading lang
        // if(Object::has_extension('SiteTree', 'Translatable') && !$this->request->isAjax()) {
        // 	Translatable::choose_site_locale(array_keys(Translatable::get_existing_content_languages('SiteTree')));
        // }

        parent::init();

        Requirements::css(CMS_DIR . '/css/screen.css');
        Requirements::css('swipestreak/css/StreakAdmin.css');

        Requirements::combine_files(
            'cmsmain.js',
            array_merge(
                array(
                    CMS_DIR . '/javascript/CMSMain.js',
                    CMS_DIR . '/javascript/CMSMain.EditForm.js',
                    CMS_DIR . '/javascript/CMSMain.AddForm.js',
                    CMS_DIR . '/javascript/CMSPageHistoryController.js',
                    CMS_DIR . '/javascript/CMSMain.Tree.js',
                    CMS_DIR . '/javascript/SilverStripeNavigator.js',
                    CMS_DIR . '/javascript/SiteTreeURLSegmentField.js'
                ),
                Requirements::add_i18n_javascript(CMS_DIR . '/javascript/lang', true, true)
            )
        );
    }

    protected function getManagedModelTabs() {
        $models = $this->getManagedModels();

        $tabs = array();

        $max = $sequence = 0;
        // add tabs first with a positive order
        foreach($models as $class => $options) {
            if (isset($options['order'])) {

                $sequence = (int)$options['order'];

                if ($sequence > 0) {
                    $max = max($sequence, $max);

                    $tabs[$sequence] = new ArrayData(array(
                        'Title' => $options['title'],
                        'ClassName' => $class,
                        'Link' => $this->Link($this->sanitiseClassName($class)),
                        'LinkOrCurrent' => ($class == $this->modelClass) ? 'current' : 'link'
                    ));
                    unset($models[$class]);

                }
            }
        }
        // add tabs with no order
        foreach($models as $class => $options) {
            if (!isset($options['order'])) {
                $tabs[++$max] = new ArrayData(array(
                    'Title'     => $options['title'],
                    'ClassName' => $class,
                    'Link' => $this->Link($this->sanitiseClassName($class)),
                    'LinkOrCurrent' => ($class == $this->modelClass) ? 'current' : 'link'
                ));
                unset($models[$class]);
            }
        }
        // add tabs with a negative order in reverse negative order
        foreach($models as $class => $options) {
            if (isset($options['order'])) {

                $sequence = (int)abs($options['order']) + $max;

                $tabs[$sequence] = new ArrayData(array(
                    'Title' => $options['title'],
                    'ClassName' => $class,
                    'Link' => $this->Link($this->sanitiseClassName($class)),
                    'LinkOrCurrent' => ($class == $this->modelClass) ? 'current' : 'link'
                ));
            }
        }
        return new ArrayList($tabs);
    }

    public function getEditForm($id = null, $fields = null) {

        $form = parent::getEditForm($id, $fields);

        $this->owner->extend('updateStreakAdminForm', $form);

        return $form;

    }

    public function Tools() {
        if ($this->modelClass == 'ShopConfig') {
            return false;
        } else {
            return parent::Tools();
        }
    }

    public function Content() {
        return $this->renderWith($this->getTemplatesWithSuffix('_Content'));
    }

    public function EditForm($request = null) {
        return $this->getEditForm($request);
    }


    public function SettingsContent() {
        return $this->renderWith('StreakAdminSettings_Content');
    }

    public function SettingsForm($request = null) {
        return;
    }

    public function Snippets() {

        $snippets = new ArrayList();
        $subClasses = ClassInfo::subclassesFor('StreakAdmin');

        $classes = array();
        foreach ($subClasses as $className) {
            $classes[$className] = Config::inst()->get($className, 'url_priority');
        }
        asort($classes);

        foreach ($classes as $className => $order) {
            $obj = new $className();
            $snippet = $obj->getSnippet();

            if ($snippet && !in_array($className, self::$hidden_sections)) {
                $snippets->push(new ArrayData(array(
                    'Content' => $snippet
                )));
            }
        }
        return $snippets;
    }

    public function getSnippet() {
        return false;
    }

}