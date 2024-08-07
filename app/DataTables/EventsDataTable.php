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
     * @param  mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn(
                'location',
                function (Event $event) {
                    $location_name = $event->location->name;
                    return $location_name;
                }
            )
            ->addColumn(
                'attendance',
                function (Event $event) {
                    $attendance = $event->attended->count();
                    $attendance .= "/";
                    $attendance .= $event->notattended->count();
                    return $attendance;
                }
            )
            ->addColumn(
                'approved',
                function (Event $event) {
                    $approved = $event->approved ? '<!--approved--><i class="fas fa-check">' : '<!--n--><i class="fas fa-times">';
                    return $approved;
                }
            )
          ->addColumn('action', '')
          ->orderColumns(['name', 'location', 'approved', 'date'], '+:column $1')
        ->editColumn(
            'action',
            function ($row) {
                $crudRoutePart = "event";
                $parts = array('view', 'edit', 'delete');
                return view('partials.datatablesActions', compact('row', 'crudRoutePart', 'parts'));
            }
        )
          ->rawColumns(['action', 'approved']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Event $model
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
            ->setTableId('events-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->lengthMenu([15,25,50])
            ->orderBy(0)
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
          Column::make('date'),
          Column::make('name'),
          Column::computed('location'),
          Column::computed('attendance'),
          Column::make('approved'),
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
        return 'Events_' . date('YmdHis');
    }
}
