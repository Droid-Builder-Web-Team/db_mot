<?php

namespace App\DataTables;

use App\Droid;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use DataTables;

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
            ->addColumn('PLI', function(Droid $droid) {
                if ($droid->club->hasOption('mot'))
                  return "<div class=\"alert ".$droid->displayMOT()['state']."\">".$droid->displayMOT()['status']."</div>";
                else
                  return "";
            })
            ->addColumn('Actions', function($droid) {
                return "<a class=\"btn btn-primary\" href=\"{{ route('admin.droids.edit',$droid->droid_uid) }}\">Edit</a>";
            })
            ->rawColumns(['PLI', 'Actions']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\DroidsDataTable $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(DroidsDataTable $model)
    {
        $droids = Droid::orderBy('droid_uid', 'asc');
        return $droids;
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
                      'droid_uid' => [ 'title' => 'ID'],
                      'name' => [ 'title' => 'Name'],
                      'PLI' => [ 'title' => 'PLI'],
                      'Actions' => [ 'title' => 'Actions']
                    ]);

    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('droid_uid'),
            Column::make('name'),

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
