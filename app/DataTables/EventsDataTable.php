<?php

namespace App\DataTables;

use App\Event;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class EventsDataTable extends DataTable
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
          ->addColumn('location', function(Event $event) {
              $location_name = $event->location->name;
              return $location_name;
            })
          ->addColumn('actions', '')
          ->editColumn('actions', function($row) {
            $crudRoutePart = "event";
            return view('partials.datatablesActions', compact('row', 'crudRoutePart'));
          })
          ->rawColumns(['actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Event $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Event $model)
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
                    ->columns([
                      'date' => [ 'title' => 'Date'],
                      'name' => [ 'title' => 'Name'],
                      'location' => [ 'title' => 'Location'],
                      'actions' => [ 'title' => 'Actions']
                    ])
                    ->parameters([
                        'dom'          => 'Bfrtip',
                    ])
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
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center'),
            Column::make('id'),
            Column::make('add your columns'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Events_' . date('YmdHis');
    }
}
