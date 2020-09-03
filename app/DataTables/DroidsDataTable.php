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
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('mot', function(Droid $droid) {
                if ($droid->club->hasOption('mot'))
                  return "<button class=\"btn-sm alert ".$droid->displayMOT()['state']."\">".$droid->displayMOT()['status']."</button>";
                else
                  return "";
            })
            ->addColumn('action', '')
            ->editColumn('action', function($row) {
              $crudRoutePart = "droid";
              return view('partials.datatablesActions', compact('row', 'crudRoutePart'));
            })
            ->rawColumns(['mot', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\DroidsDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Droid $model)
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
                  ->setTableId('droids-table')
                  ->columns($this->getColumns())
                  ->minifiedAjax()
                  ->dom('Bfrtip')
                  ->orderBy(0)
                  ->buttons(
                      Button::make('create'),
                      Button::make('export'),
                      Button::make('print'),
                      Button::make('reset'),
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
          Column::computed('mot'),
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
        return 'Droids_' . date('YmdHis');
    }
}
