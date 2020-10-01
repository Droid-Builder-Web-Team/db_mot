<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
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
          ->addColumn('pli', function(User $user) {
                $pli = $user->validPLI() ? "Valid" : "Expired";
                return $pli;
            })
          ->addColumn('droid_count', function(User $user) {
                return $user->droids()->count();
            })
          ->addColumn('roles', function(User $user) {
                $roles = "";
                foreach($user->roles as $role)
                {
                    $roles .= "<span class=\"badge badge-info\">".$role->name."</span>";
                }
                return $roles;
            })
          ->addColumn('action', '')
          ->editColumn('action', function($row) {
            $crudRoutePart = "user";
            $parts = array('view', 'edit', 'delete');
            return view('partials.datatablesActions', compact('row', 'crudRoutePart', 'parts'));
          })
          ->rawColumns(['action', 'roles']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
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
                    ->setTableId('users-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->lengthMenu([15,25,50])
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
            Column::make('forename'),
            Column::make('surname'),
            Column::make('pli'),
            Column::make('droid_count'),
            Column::make('roles'),
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
        return 'Users_' . date('YmdHis');
    }
}
