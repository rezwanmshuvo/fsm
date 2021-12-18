<?php

namespace App\DataTables;

use App\Model\Deposit;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class DepositDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $qry = Deposit::where('delete_status', '0')
                        ->whereNotIn('account_id', [1,2]);

        return datatables()
            ->eloquent($qry)
            ->addColumn('action', '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                    <a href="{{ route(\'deposit.show\', $id) }}" class="dropdown-item"><i class="icon-file-text3"></i> View</a>
                    <a href="{{ route(\'deposit.edit\', $id) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                    <a href="#"  class="dropdown-item" onclick="confirmDelete({{$id}})"><i class="icon-bin"></i> Delete</a>
                    <form id="delete-form{{$id}}" action="{{ route(\'deposit.destroy\', $id) }}" method="POST" style="display: none;">
                        @csrf
                        @method(\'DELETE\')
                    </form>
                </div>
            </div>
            </div>')
            ->addColumn('deposit_date', function (Deposit $deposit) {
                return \Carbon\Carbon::parse($deposit->deposit_date)->format('Y-m-d h:i:s A');
            })
            ->addColumn('customer', function (Deposit $deposit) {
                return $deposit->customer_id ? $deposit->customer->name : '';
            })
            ->addColumn('bank', function (Deposit $deposit) {
                return $deposit->account->bank_name;
            })
            ->addColumn('purpose', function (Deposit $deposit) {
                return $deposit->purpose->name;
            })
            ->addColumn('sale_id', function (Deposit $deposit) {
                return $deposit->sale_id ? $deposit->sale_id : '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Deposit $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Deposit $model)
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
                    ->setTableId('deposit-table')
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
            Column::make('id'),
            Column::make('deposit_date'),
            Column::make('voucher_number'),
            Column::make('customer'),
            Column::make('bank'),
            Column::make('purpose'),
            Column::make('note'),
            Column::make('sale_id'),
            Column::make('total_amount'),
            Column::make('deposit_type'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'deposit_' . date('YmdHis');
    }
}
