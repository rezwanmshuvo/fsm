<?php

namespace App\DataTables;

use App\Model\Machine;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class MachineDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $qry = Machine::where('delete_status', '0');
        return datatables()
            ->eloquent($qry)
            ->addColumn('action', '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                    <a href="{{ route(\'machine.edit\', $id) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                    <a href="#"  class="dropdown-item" onclick="confirmDelete({{$id}})"><i class="icon-bin"></i> Delete</a>
                    <form id="delete-form{{$id}}" action="{{ route(\'machine.destroy\', $id) }}" method="POST" style="display: none;">
                        @csrf
                        @method(\'DELETE\')
                    </form>
                </div>
            </div>
        </div>')
        ->addColumn('tank_id', function (Machine $machine) {
            return $machine->tank->name;
        });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Machine $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Machine $model)
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
                    ->setTableId('machine-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    ->dom('Bfrtip')
                    ->orderBy(1)
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
            Column::computed('action'),
                //   ->exportable(false)
                //   ->printable(false)
                //   ->width(60)
                //   ->addClass('text-center'),
            Column::make('id'),
            Column::make('name'),
            Column::make('tank_id'),
            Column::make('model'),
            Column::make('no_of_nozzle'),
            Column::make('serial_no'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'machine_' . date('YmdHis');
    }
}
