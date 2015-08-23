<?php
class StreakProductExtension extends GridSheetModelExtension
{
    const ModelClass = 'Product';

    const RelatedModelClass = 'Product';

    private static $many_many = array(
        'Accessories' => 'StreakAccessoryPage'
    );

    private static $enable_add_new = false;

    private static $enable_add_new_inline = false;

    public function provideGridSheetData($modelClass) {
        if (self::ModelClass == $modelClass) {
            return Product::get();
        }
    }

    public function provideEditableColumns(array &$fieldSpecs) {
        if (self::ModelClass == $this->owner->class) {
            $fieldSpecs += array(
                'ParentID' => array(
                    'title' => 'Category',
                    'callback' => function($record, $col) {
                        return new Select2Field(
                            'ParentID',
                            '',
                            StreakProductsPage::get()->map()->toArray()
                        );
                    }
                ),
                'Title' => array(
                    'title' => 'Product Name',
                    'field' => 'TextField'
                ),
                'Price' => array(
                    'title' => 'RRP',
                    'callback' => function ($record, $col) {
                        return new NumericField(
                            $col
                        );
                    }
                )

            );
            return true;
        }
        return false;
    }

    /**
     * Called when a grid sheet is displaying a model related to another model. e.g. as a grid for a models ItemEditForm
     * in ModelAdmin.
     *
     * @param $relatedModelClass
     * @param $relatedID
     * @param array $fieldSpecs
     * @return mixed
     */
    public function provideRelatedEditableColumns($relatedModelClass, $relatedID, array &$fieldSpecs) {
        // TODO: Implement provideRelatedEditableColumns() method.
    }

    /**
     * Called for each new row in a grid when it is saved.
     *
     * @param $record
     * @return bool
     */
    public function gridSheetHandleNewRow(array &$record) {
        $updateData = $this->getUpdateColumns($this->owner->class, $record);
        $this->owner->update($updateData);
    }

    /**
     * Called to each existing row in a grid when it is saved.
     *
     * @param $record
     * @return bool
     */
    public function gridSheetHandleExistingRow(array &$record) {
        $updateData = $this->getUpdateColumns($this->owner->class, $record);
        $this->owner->update($updateData);
    }
}