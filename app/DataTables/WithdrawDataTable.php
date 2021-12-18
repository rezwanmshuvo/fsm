<?php

namespace App\DataTables;

use App\Model\Withdraw;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class WithdrawDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $qry = Withdraw::where('delete_status', '0')
                         ->whereNotIn('account_id', [1,2]);
        return datatables()
            ->eloquent($qry)
            ->addColumn('action', '<div class="list-icons">
            <div class="dropdown">
                <a href="#" class="list-icons-item" data-toggle="dropdown">
                    <i class="icon-menu9"></i>
                </a>

                <div class="dropdown-menu dropdown-menu-right custom-dropdown-menu-right">
                    <a href="{{ route(\'withdraw.show\', $id) }}" class="dropdown-item" target="_blank"><i class="icon-file-text3"></i> View</a>
                    <a href="{{ route(\'withdraw.edit\', $id) }}" class="dropdown-item"><i class="icon-pencil7"></i> Edit</a>
                    <a href="#"  class="dropdown-item" onclick="confirmDelete({{$id}})"><i class="icon-bin"></i> Delete</a>
                    <form id="delete-form{{$id}}" action="{{ route(\'withdraw.destroy\', $id) }}" method="POST" style="display: none;">
                        @csrf
                        @method(\'DELETE\')
                    </form>
                </div>
            </div>
            </div>')
            ->addColumn('withdraw_date', function (Withdraw $withdraw) {
                return \Carbon\Carbon::parse($withdraw->withdraw_date)->format('Y-m-d h:i:s A');
            })
            ->addColumn('supplier', function (Withdraw $withdraw) {
                return $withdraw->party_id ? $withdraw->party->name : '';
            })
            ->addColumn('bank', function (Withdraw $withdraw) {
                return $withdraw->account->bank_name;
            })
            ->addColumn('purpose', function (Withdraw $withdraw) {
                return $withdraw->purpose->name;
            })
            ->addColumn('sale_id', function (Withdraw $withdraw) {
                return $withdraw->sale_id ? $withdraw->sale_id : '';
            });
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\App\Withdraw $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Withdraw $model)
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
                    ->setTableId('withdraw-table')
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
            Column::make('withdraw_date'),
            Column::make('voucher_number'),
            Column::make('supplier'),
            Column::make('bank'),
            Column::make('purpose'),
            Column::make('note'),
            Column::make('purchase_id'),
            Column::make('total_amount'),
            Column::make('withdraw_type'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Withdraw_' . date('YmdHis');
    }
}
