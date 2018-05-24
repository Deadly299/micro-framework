<?php

namespace widgets\gridView;

use app\Widget;
use helpers\Request;

class GridView extends Widget
{
    const PREFIX_SORT_DESC = '-';

    public $query;
    public $limit = 3;

    public function run()
    {
        Request::get('page') ? $page = Request::get('page') : $page = 1;
        $totalResults = $this->query->count();
        $totalPages = ceil($totalResults / $this->limit);
        $startingLimit = ($page - 1) * $this->limit;

        $models = $this->query->limit($this->limit)->offset($startingLimit)->all();

        $this->render('view/index', [
            'totalPages' => $totalPages,
            'models' => $models,
            'page' => $page,
        ]);
    }
}