@extends('layouts.app')

@section('header')
    <link  href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" defer></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" defer></script>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row" >
                            <div class="col-md-6">
                                {{ __('Articles') }}
                            </div>
                            <div class="col-md-6 text-md-right">
                                <a href="javascript:void(0)" class="btn btn-info btn-sm" id="create-new">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-success col-md-12 d-none" role="alert" id="table-alert"></div>
                        <table class="table table-bordered table-striped" id="laravel_datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Created at</th>
                                    <th>Created by</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ajax-modal" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="crudModal"></h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger col-md-12 d-none" role="alert" id="modal-alert"></div>
                        <form id="laraveForm" name="laraveForm" class="form-horizontal">
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="title" class="col-md-2 control-label">Title</label>
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="title" name="title" placeholder="Enter Tilte" value="" maxlength="255" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="body" class="col-md-2 control-label">Body</label>
                                <div class="col-md-12">
                                    <textarea class="form-control"  id="body" name="body" placeholder="Enter Body" maxlength="2550" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-offset-2 col-md-10">
                                <button type="submit" class="btn btn-primary" id="btn-save" value="create">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="text/javascript">
        var SITEURL = '{{URL::to('/')}}';
        $(document).ready( function () {
            function hideAlert() {
                setTimeout(function() {
                    $(".alert").addClass('d-none');
                }, 7000);
            }
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /*  display table view with actions */
            $('#laravel_datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: SITEURL + "/articles",
                    type: 'GET',
                },
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title' },
                    {data: 'created_at', name: 'created_at' },
                    {data: 'user_email', name: 'user_email' },
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ],
                order: [[0, 'desc']]
            });
            /*  When user click add new button */
            $('#create-new').click(function () {
                $(".alert").addClass('d-none');
                $('#btn-save').val("create");
                $('#id').val('');
                $('#laraveForm').trigger("reset");
                $('#crudModal').html("Add New");
                $('#ajax-modal').modal('show');
            });
            /*  When user click save change button */
            if ($("#laraveForm").length > 0) {
                $("#laraveForm").validate({
                    submitHandler: function(form) {
                        var actionType = $('#btn-save').val();
                        $('#btn-save').html('Sending..');
                        $.ajax({
                            data: $('#laraveForm').serialize(),
                            url: SITEURL + "/articles",
                            type: "POST",
                            dataType: 'json',
                            success: function (data) {
                                $('#laraveForm').trigger("reset");
                                $('#ajax-modal').modal('hide');
                                $('#btn-save').html('Save Changes');
                                var oTable = $('#laravel_datatable').dataTable();
                                oTable.fnDraw(false);
                                $('#table-alert').html(data.success);
                                $('#table-alert').removeClass('d-none');
                                console.log('Success:', data);
                                hideAlert();
                            },
                            error: function (data) {
                                $('#btn-save').html('Save Changes');
                                $('#modal-alert').html(data.responseJSON.message);
                                $('#modal-alert').removeClass('d-none');
                                console.log('Error:', data);
                                hideAlert();
                            }
                        });
                    }
                })
            }
            /*  When user click delete  button */
            $('body').on('click', '#delete', function () {
                var id = $(this).data("id");
                if(confirm("Are You sure want to delete !")){
                    $.ajax({
                        type: "DELETE",
                        url: SITEURL + "/articles/"+id,
                        success: function (data) {
                            var oTable = $('#laravel_datatable').dataTable();
                            oTable.fnDraw(false);
                            $('#table-alert').html(data.success);
                            $('#table-alert').removeClass('d-none');
                            hideAlert();
                            console.log('Success:', data);
                        },
                        error: function (data) {
                            console.log('Error:', data.statusText);
                        }
                    });
                }
            });
            /* When user click edit button */
            $('body').on('click', '.edit', function () {
                var id = $(this).data('id');
                $.get('articles/' + id +'/edit', function (data) {
                    $(".alert").addClass('d-none');
                    $('#crudModal').html("Edit");
                    $('#btn-save').val("edit");
                    $('#ajax-modal').modal('show');
                    $('#id').val(data.id);
                    $('#title').val(data.title);
                    $('#body').val(data.body);
                })
            });
        });
    </script>
@endsection


