@extends('admin/layouts.app')

@section('custom_css')
    @include('includes/partials.imports_css')
@endsection

@section('content')
<div class="card">
    <div class="card-header">Politicians - View All <a href="{{ route('blogs.trashedData') }}" class="btn btn-danger float-right btn-sm"> <i class="fas fa-trash"></i> Trashed Items <span class="badge badge-light">{{ $trashed_items_count }}</span></a> <a href="{{ route('politicians.create') }}" class="btn btn-primary float-right btn-sm mr-2"><i class="fas fa-plus"></i> Add</a></div>

    <div class="card-body">
        <div class="table-responsive">
            <table id="dataTable" class="table table-striped table-hover table-bordered" width="100%">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="bulk_selector"></th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Party</th>
                        <th>Role</th>
                        <th>Published</th>
                        <th>Created on</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                     <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<form action="#" method="post" id="deletItemForm" display: none;>
    @csrf
    {{ method_field('DELETE') }}
</form>
@endsection

@section('custom_js')

@include('includes/partials.imports_js')

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        processing: true,
        "language": {
            "processing": '<i class="text-primary fas fa-circle-notch fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> ',
            "emptyTable": "No politicians found. =(",
            "oPaginate": {
                sFirst: '<i class="fas fa-step-backward"></i> First',
                sPrevious: '<i class="fas fa-chevron-left"></i> Previous',
                sNext: 'Next <i class="fas fa-chevron-right"></i>',
                sLast: 'Last <i class="fas fa-step-forward"></i>'
            },
        },
        serverSide: true,
        ajax: '{!! route('politicians.datatable') !!}',
        columns: [
            { data: 'bulkAction'},
            { data: 'politician.id'},
            { data: 'persona.shortName'},
            { data: 'party.shortName'},
            { data: 'politicianRole.name'},
            { data: 'politician.isActive'},
            { data: 'politician.createdAt'},
            { data: 'actions'}
        ],
        "order": [[ 4, "desc" ]],
        "columnDefs": [
            { orderable: false, targets: [6,0] }
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        initComplete: function () {
            this.api().columns().every(function () {
                var column = this;
                if (column[0][0] !== 0 && column[0][0] !== 6) {
                    var input = document.createElement("input");
                    input.className = 'form-control form-control-sm';
                    $(input).appendTo($(column.footer()).empty())
                    .on('change', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());
                        column.search(val ? val : '', true, false).draw();
                    });
                }
            });
        },
        "pagingType": "full_numbers",
        "deferRender": true,
        buttons: [
            {
                text: '<i class="fas fa-trash"></i> Bulk Trash <span class="badge badge-light" id="bulk_count">0</span>',
                className: 'btn btn-sm btn-danger disabled',
                action: function ( e, dt, node, config ) {
                    if (confirm('Are you sure?')) {
                        var bulkValuesStr = '';
                        $('[name="selected_ids[]"]:checked').each(function(){
                            bulkValuesStr += $(this).val()+',';
                        });
                        var selectedIds = bulkValuesStr.slice(0,-1);
                        window.location.href = '{{ route("blogs.bulkTrash") }}?ids=' + selectedIds;
                    }
                },
                init: function (dt, node, config) {
                    $(node).attr('id', 'bulkDeleteButton');
                }
            },
            {
                extend: 'copy',
                text: '<i class="fas fa-copy"></i> Copy All',
                className: 'btn btn-sm btn-secondary',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'collection',
                text: '<i class="fas fa-download"></i> Export Data',
                className: 'btn btn-sm btn-secondary',
                buttons: [
                    {
                        extend: 'csv',
                        text: 'As CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'As Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: 'As PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                ]
            },
            {
                extend: 'print',
                text: '<i class="fas fa-print"></i> Print all',
                className: 'btn btn-sm btn-secondary',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'colvis',
                text: '<i class="far fa-eye-slash"></i> Show/Hide Columns',
                className: 'btn btn-sm btn-secondary',
                columnText: function ( dt, idx, title ) {
                    if (idx == 0) {
                        return 'Bulk Action';
                    } else if (idx == 6) {
                        return 'Actions';
                    } else {
                        return title;
                    }
                }
            },
        ],
        dom: 'lBfrtip',
    });
    $('.dt-buttons button, .dt-button-collection button').removeClass('dt-button');

    // Bulk Selector
    $('#bulk_selector').click(function() {
        $('[name="selected_ids[]"]').prop('checked', $(this).is(':checked'));
        toggleBulkBtnClass();
    });

    // Bulk Button Handler
    $(document).on('click', '[name="selected_ids[]"]', function() {
       toggleBulkBtnClass();
    });
});

// Admin helpers
function callDeletItem(id, model) {
    if (confirm('Are you sure?')) {
        $("#deletItemForm").attr('action', base_url + '/admin/'+ model + '/' + id);
        $("#deletItemForm").submit();
    }
}

// Toggle Bulk Delet Button Class
function toggleBulkBtnClass() {
    if ($('[name="selected_ids[]"]').is(':checked')) {
        $('#bulkDeleteButton').removeClass('disabled');
    } else {
        $('#bulkDeleteButton').addClass('disabled');
    }
    countBulk();
}

// Count Bulk Selected Items and show
function countBulk() {
    $("#bulk_count").html( $('[name="selected_ids[]"]:checked').length );
}
</script>
@endsection
