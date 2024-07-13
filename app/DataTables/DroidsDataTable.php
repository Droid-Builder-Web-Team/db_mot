<?php

namespace App\DataTables;

use App\Droid;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DroidsDataTable extends DataTable
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
                'owner',
                function (Droid $droid) {
                    $owner = $droid->users()->first();
                    $name = $owner->forename.' '.$owner->surname;
                    //return '<a class="btn-link btn-sml" href="/user/'.$owner->id.'">'.$name.'</a>';
                    return $name;
                }
            )
            ->addColumn(
                'mot',
                function (Droid $droid) {
                    if ($droid->club->hasOption('mot')) {
                        return "<button class=\"btn-sm alert ".$droid->displayMOT()['state']." actions-buttons\">".$droid->displayMOT()['status']."</button>";
                    } else {
                        return "";
                    }
                }
            )
            ->addColumn('action', '')
            ->editColumn(
                'action',
                function ($row) {
                    $crudRoutePart = "droid";
                    $parts = array('view', 'edit', 'delete');
                    return view('partials.datatablesActions', compact('row', 'crudRoutePart', 'parts'));
                }
            )
            ->rawColumns(['mot', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param  \App\Droid $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Droid $model)
    {
        return $model->newQuery()->where('active', 'on');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('droids-table')
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
          Column::make('name'),
          Column::make('top_speed'),
          Column::make('weight'),
          Column::make('owner'),
          Column::make('topps_id'),
          Column::make('date_added'),
          Column::make('last_updated'),
          Column::computed('mot'),
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
        return 'Droids_' . date('YmdHis');
    }
}
