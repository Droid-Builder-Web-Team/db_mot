<?php

namespace App\DataTables;

use App\PartsRunAd;
use App\PartsRunData;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Services\DataTable;

class PartsRunDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $query = PartsRunData::query();
        return DataTables::eloquent($query)
            ->withQuery(
                'count',
                function () use ($query) {
                    return $query->count();
                }
            )
          ->toJson();
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\PartsRunData $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(PartsRunData $model)
    {
        return $model->newQuery()->where('status', 'Active' || 'Gathering_Interest' || 'Inactive');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('parts-run-data-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->lengthMenu([15,25,50])
            ->orderBy(0)
            ->buttons(
                Button::make('export'),
                Button::make('print'),
                Button::make('reload')
            );

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
          Column::make('title'),
          Column::make('droid'),
          Column::make('status')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Droids_' . date('YmdHis');
    }
}
