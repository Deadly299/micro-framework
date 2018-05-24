<?php

namespace widgets\sortingPanel;

use app\Widget;
use helpers\Request;

class SortingField extends Widget
{
    const PREFIX_SORT_DESC = '-';

    public $field;
    public $fieldName;
    public $sortParam = 'sort';

    public function run()
    {
        $field = Request::get($this->sortParam);

        if ($field && ($field === $this->field || self::PREFIX_SORT_DESC . $field === $this->field)) {
            $field = $this->reverseTypeSort($field);
        } else {
            $field = $this->field;
        }

        $this->render('view/index', ['fieldName' => $this->fieldName, 'field' => $field]);
    }

    private function reverseTypeSort($typeSort)
    {
        if ($typeSort === self::PREFIX_SORT_DESC . $this->field) {
            $reverseType = mb_substr($typeSort, 1);
        } else {
            $reverseType = self::PREFIX_SORT_DESC . $typeSort;
        }

        return $reverseType;
    }
}