<?php

/**
 * DataTable for Contacts
 * php version 7.4
 *
 * @category DataTable
 * @package  DataTables
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */

namespace App\DataTables;

use App\Contact;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

/**
 * ContactDataTable
 *
 * @category Class
 * @package  DataTables
 * @author   Darren Poulson <darren.poulson@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://portal.droidbuilders.uk/
 */
class ContactDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     *
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('action', '')
            ->editColumn(
                'action',
                function ($row) {
                    $crudRoutePart = "contact";
                    $parts = array( 'edit', 'delete');
                    return view(
                        'partials.datatablesActions',
                        compact(
                            'row',
                            'crudRoutePart',
                            'parts'
                        )
                    );
                }
            )
          ->rawColumns(['action', 'map']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Contact $model Contact model
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Contact $model)
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
            ->setTableId('contact-table')
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
            Column::make('email'),
            Column::make('phone'),
            Column::make('notes'),
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
        return 'Venue_Contacts' . date('YmdHis');
    }
}
