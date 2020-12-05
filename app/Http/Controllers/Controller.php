<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Get calendar query
     * ex. display: 4/1 - 4/30
     *
     * @param mixed $query
     * @return \Illuminate\Database\Query\Builder
     */
    protected function getCalendarQuery($model, $start, $end, $target_start_column)
    {
        // filter startDate
        // ex. 4/1 - startDate - 4/30
        $model->where(function ($model) use ($target_start_column, $start, $end) {
            if ($start != null) {
                $model->where($target_start_column, '>=', $start);
            }
            if ($end != null) {
                $model->where($target_start_column, '<', $end);
            }
        });
        return $model;
    }
}
