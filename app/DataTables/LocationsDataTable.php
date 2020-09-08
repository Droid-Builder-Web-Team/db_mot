<?php

namespace App\DataTables;

use App\Location;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class LocationsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
      return datatables()
          ->eloquent($query)
          ->addColumn('map', function(Location $location) {
                return "<a class=\"btn btn-primary\" target=\"_blank\" href=\"https://www.google.com/maps/search/?api=1&query=".$location->postcode.">Map</a></td>";
            })
          ->addColumn('action', '')
          ->editColumn('action', function($row) {
            $crudRoutePart = "location";
            $parts = array( 'view', 'edit', 'delete');
            return view('partials.datatablesActions', compact('row', 'crudRoutePart', 'parts'));
          })
          ->rawColumns(['action', 'map']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Location $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Location $model)
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
                    ->setTableId('locations-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->lengthMenu([15,25,50])
                    ->orderBy(1)
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
            Column::make('town'),
            Column::make('county'),
            Column::make('postcode'),
            Column::computed('map'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(200)
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
        return 'Locations_' . date('YmdHis');
    }
}
