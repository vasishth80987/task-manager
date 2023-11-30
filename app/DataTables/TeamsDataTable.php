<?php

namespace App\DataTables;

use App\Models\Team;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TeamsDataTable extends DataTable
{
    public $table_query = null;
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('team_role', function ($team) {
                return $team->team_lead_id==auth()->id() ? 'Manager':'Developer';
            })
            ->addColumn('action', function ($team) {
                return view('team.datatables_actions', ['id' => $team->id])->render();
            })
            ->editColumn('created_at', function($model){
                $formatDate = date('Y-m-d H:i:s',strtotime($model->created_at));
                return $formatDate;
            })
            ->editColumn('updated_at', function($model){
                $formatDate = date('Y-m-d H:i:s',strtotime($model->updated_at));
                return $formatDate;
            })
            ->setRowId('id');
    }

    /**
     * Modify query to filters display results
     */
    public function setQuery(array $ids)
    {
        $query = Team::whereIn('id',$ids);
        $this->table_query = $query;

    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Team $model): QueryBuilder
    {
        return $this->table_query ?? $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('task-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                'excel',
                'csv',
                'print',
                'reload'
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::computed('team_role'),
            Column::make('created_at'),
            Column::make('updated_at'),
            Column::computed('action')
                  ->exportable(false)
                  ->printable(false)
                  ->width(60)
                  ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Teams_' . date('YmdHis');
    }
}
