<?php

namespace App\DataTables;

use App\Club;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ClubsDataTable extends DataTable
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
            ->addColumn(
                'links', function (Club $club) {
                    $output = "";
                    if(isset($club->facebook)) {
                        $output .="<a class=\"btn-sm btn-link\" style='color:white;' href=\"".$club->facebook."\">Facebook</a>";
                    }
                    if(isset($club->website)) {
                        $output .="<a class=\"btn-sm btn-link\" style='color:white;' href=\"".$club->website."\">Website</a>";
                    }
                    if(isset($club->forum)) {
                        $output .="<a class=\"btn-sm btn-link\" style='color:white;' href=\"".$club->forum."\">Forum</a>";
                    }
                    return $output;
                }
            )
          ->addColumn('action', '')
        ->editColumn(
            'action', function ($row) {
                $crudRoutePart = "club";
                $parts = array( 'edit', 'delete');
                return view('partials.datatablesActions', compact('row', 'crudRoutePart', 'parts'));
            }
        )
          ->rawColumns(['action', 'links']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Club $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Club $model)
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
            ->setTableId('clubs-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(0, 'asc')
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
          Column::make('id'),
          Column::make('name'),
          Column::computed('links'),
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
    protected function filename()
    {
        return 'Clubs_' . date('YmdHis');
    }
}
