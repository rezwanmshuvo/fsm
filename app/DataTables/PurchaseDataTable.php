<?php

namespace App\DataTables;

use App\Model\Purchase;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;


class PurchaseDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $qry = Purchase::where('delete_status', '0');
        return datatables()
            ->eloquent($qry)
            ->addColumn('action', '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                    <a href="{{ route(\'purchase.show\', $id) }}" class="dropdown-item"><i class="icon-file-text3"></i> View</a>
                    <a href="{{ route(\'purchase.edit\', $id) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                    <a href="#"  class="dropdown-item" onclick="confirmDelete({{$id}})"><i class="icon-bin"></i> Delete</a>
                    <form id="delete-form{{$id}}" action="{{ route(\'purchase.destroy\', $id) }}" method="POST" style="display: none;">
                        @csrf
                        @method(\'DELETE\')
                    </form>
                </div>
            </div>
        </div>')
            ->addColumn('supplier', function (Purchase $purchase) {
                return $purchase->party->name;
            });

//            ->addColumn('item', function (Purchase $purchase) {
//                return $purchase->item->name;
//            });

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Nozzle $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Purchase $model)
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
            ->setTableId('purchase-table')
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
            Column::make('purchase_date'),
            Column::make('supplier'),
            Column::make('total_discount'),
            Column::make('total_amount'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'purchase_' . date('YmdHis');
    }
}
