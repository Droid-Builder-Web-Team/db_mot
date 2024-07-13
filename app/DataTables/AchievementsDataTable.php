<?php

namespace App\DataTables;

use App\Achievement;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class AchievementsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param  mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', '')
            ->editColumn(
                'action', function ($row) {
                    $crudRoutePart = "achievement";
                    $parts = array( 'edit', 'delete');
                    return view('partials.datatablesActions', compact('row', 'crudRoutePart', 'parts'));
                }
            )
          ->rawColumns(['action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Achievement $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Achievement $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('achievements-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtipl')
            ->orderBy(0, 'asc')
            ->lengthMenu([15,25,50])
            ->buttons(
                Button::make('create'),
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
          Column::make('name'),
          Column::make('description'),
          Column::computed('action')
              ->exportable(false)
              ->printable(false)
              ->width(85)
              ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Achievements_' . date('YmdHis');
    }
}
