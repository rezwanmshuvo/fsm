<?php

namespace App\DataTables;

use App\Model\Tank;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TankDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $qry = Tank::where('delete_status', '0');
        return datatables()
            ->eloquent($qry)
            ->addColumn('action', '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                    <a href="{{ route(\'tank.edit\', $id) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                    <a href="#"  class="dropdown-item" onclick="confirmDelete({{$id}})"><i class="icon-bin"></i> Delete</a>
                    <form id="delete-form{{$id}}" action="{{ route(\'tank.destroy\', $id) }}" method="POST" style="display: none;">
                        @csrf
                        @method(\'DELETE\')
                    </form>
                </div>
            </div>
        </div>');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Shift $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Tank $model)
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
                    ->setTableId('tank-table')
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
            Column::make('capacity'),
            Column::make('dip_min'),
            Column::make('dip_max'),
            Column::make('dip_in_mm'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'tank_' . date('YmdHis');
    }
}
