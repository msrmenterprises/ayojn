@extends('adminlte::page')
<!--Add title-->
@section('title',  'Ayojn')
<!--Main Body content-->
@section('content')
    <!-- //banner-top -->
    <!-- banner -->
    <!-- Content Header (Page header) -->

    <section class="content-header">
        <h1>
            Vouch Code
            <small>List</small>

        </h1>


        <ol class="breadcrumb">


            <li><a href="{{ url('admin/dashboard') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Vouch Code List</li>

        </ol>
    </section>
    <style type="text/css">
        .mb20 {
            margin-bottom: 20px;
        }

        .checkbox {
            margin-top: 0px;
        }
    </style>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-12">
                            @if(session()->has('success'))
                                <div class="alert alert-success">
                                    {{ session()->get('success') }}
                                </div>
                            @endif
                            @if(session()->has('error'))
                                <div class="alert alert-danger alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session()->get('error') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session('true'))
                                <div class="alert alert-success alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('true') }}
                                </div>
                            @endif
                            @if (session('false'))
                                <div class="alert alert-danger alert-dismissable">
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                    {{ session('false') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-12">
                            <a href="{{ route('vouch-create') }}" class="btn btn-primary ladda-button"
                               data-style="zoom-in">
                                <span class="ladda-label"><i class="fa fa-plus"></i> Add Vouch Code</span>
                            </a>
                        </div>
                    </div>

                    <div class="box-body table-responsive">
                        <table id="data-table" class="table table-bordered table-striped last-child-sm" width="100%"
                               data-page-length='100'>
                            <thead>
                            <tr>
                                <th width="2%">Id</th>
                                <th width="3%">Vouch Code</th>
                                <th width="3%">Vouch Amount</th>
                                <th width="3%">Status</th>
                                <th width="3%">Share</th>
                                <th width="5%">Action</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                            <th width="2%">Id</th>
                                <th width="3%">Vouch Code</th>
                                <th width="3%">Vouch Amount</th>
                                <th width="3%">Status</th>
                                <th width="3%">Share</th>
                                <th width="5%">Action</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- form start -->
                    <div class="box-footer clearfix text-right">

                    </div>
                </div>
                <!-- /.box -->
            </div>
            <!--/.col (left) -->
        </div>
    </section>

<link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.min.js"></script>

    <script type="text/javascript">
        var oTable;


        $(function () {
            var url = "{{ url('controlpanel/list-code')}}";
            var oTable = $('#data-table').DataTable({
                order:[['0','desc']],
                bFilter: true,
                bLengthChange: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: "POST",
                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                    data: function (d) {

                    }
                },
                columns: [
                    {"data": "id"},
                    {"data": "vouch_code"},
                    {"data": "vouch_amount"},
                    {"data": "status"},
                    {"data" : "share"},
                    {"data": "action", orderable: false}
                ], "fnRowCallback": function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                    $(nRow).attr("data-id", aData['id']);
                    return nRow;
                },
            });

            $('#moveprofile').on('submit', function (e) {
                if ($('#admin_from').val() != '' && $('#admin_to').val() != '') {
                    oTable.draw();
                } else {
                    toastr.error("Admin From And To Is Required", "Error");
                }
                e.preventDefault();
            });
        });
        $('#selected_users').change(function () {
            ///$('.groupCheckBox').not(this).prop('checked', this.checked);
            // var rows = users.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]').prop('checked', this.checked);
        });
        $('#data-table tbody').on('change', 'input[type="checkbox"]', function () {
            // If checkbox is not checked
            if (!this.checked) {
                var el = $('#data-table').get(0);
                // If "Select all" control is checked and has 'indeterminate' property
                if (el && el.checked) {

                }
            }
        });

        function getallcheck() {
            var tbl = $('#data-table').DataTable();
            var data = new Array();
            $.each(tbl.rows().nodes().to$().find("input[name='selected_users[]']:checked"), function () {
                //alert($(this).val());
                data.push($(this).val());
            });
            if (data.length == "0") {
                console.log("123", data.length);
                swal("warning", "Please select atleast One user", "error");
            } else if ($("#status_type").val() == '') {
                swal("warning", "Please select status type", "error");
            } else {
                if ($("#status_type").val() == 2) {
                    swal({
                        title: 'Are you sure?',
                        text: 'Are you sure that you want to delete selected user?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.value) {
                            var url = "{{ route('delete-users') }}";
                            $('#spinner').show();
                            $.ajax({
                                url: url,
                                method: "POST",
                                data: {userIds: data},
                                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                success: function (data) {
                                    obj = jQuery.parseJSON(data);
                                    if (obj.msg) {
                                        $("#status_type").prop("selectedIndex", 0);
                                        $('#spinner').hide();
                                        $('input[type="checkbox"]').prop('checked', false);
                                        swal("Delete", obj.msg, "success");
                                        $('#data-table').DataTable().draw(false)

                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    $('#spinner').hide();
                                    swal("warning", "Please try again", "error");
                                }
                            });
                        }
                    })
                } else {


                    swal({
                        title: 'Are you sure?',
                        text: 'Are you sure that you want to change status of selected users?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, change it!'
                    }).then((result) => {
                        if (result.value) {
                            var url = "{{ route('users-change-status') }}";
                            $('#spinner').show();
                            $.ajax({
                                url: url,
                                method: "POST",
                                data: {userIds: data, status: $("#status_type").val()},
                                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                success: function (data) {
                                    obj = jQuery.parseJSON(data);
                                    if (obj.msg) {
                                        $("#status_type").prop("selectedIndex", 0);
                                        $('input[type="checkbox"]').prop('checked', false);
                                        $('#spinner').hide();
                                        swal("success", obj.msg, "success");
                                        $('#data-table').DataTable().draw(false)

                                    }
                                },
                                error: function (xhr, ajaxOptions, thrownError) {
                                    $('#spinner').hide();
                                    swal("warning", "Please try again", "error");
                                }
                            });
                        }
                    })
                }
            }
        }

        function deleteCode(id) {
            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to delete this code?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
               
                    var url = "{{ route('delete-code') }}";
                    $('#spinner').show();
                    $.ajax({
                        url: url,
                        method: "POST",
                        data: {user_id: id},
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        success: function (data) {
                            console.log(data);
                            obj = jQuery.parseJSON(data);
                            if (obj.msg) {
                                $('#spinner').hide();
                                swal("Success", obj.msg, "success");
                                $('#data-table').DataTable().draw(false)

                            }
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#spinner').hide();
                            swal("warning", "Please try again", "error");
                        }
                    });
            
            })
        }

        function changeStatus(id) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to change status?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    var url = "{{ route('user-change-status') }}";
                    $('#spinner').show();
                    $.ajax({
                        url: url,
                        method: "POST",
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        data: {user_id: id},
                        success: function (data) {
                            obj = jQuery.parseJSON(data);
                            $('#spinner').hide();
                            if (obj.status == 1) {
                                $('#cust_id' + id).addClass("label-success");
                                $('#cust_id' + id).removeClass("label-danger");
                                $('#cust_id' + id).html("Approved");
                            } else {
                                $('#cust_id' + id).removeClass("label-success");
                                $('#cust_id' + id).addClass("label-danger");
                                $('#cust_id' + id).html("Disapproved");
                            }
                            swal("Updated", obj.msg, "success");
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#spinner').hide();
                            swal("warning", "Please try again", "error");
                        }
                    });
                }
            })
        }

        function changeType(id) {

            swal({
                title: 'Are you sure?',
                text: 'Are you sure that you want to change sponsorr type?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, change it!'
            }).then((result) => {
                if (result.value) {
                    var url = "{{ route('user-change-type') }}";
                    $('#spinner').show();
                    $.ajax({
                        url: url,
                        method: "POST",
                        headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                        data: {user_id: id},
                        success: function (data) {
                            obj = jQuery.parseJSON(data);
                            $('#spinner').hide();
                            if (obj.sponsor_type == 1) {
                                $('#user_id' + id).addClass("label-warning");
                                $('#user_id' + id).removeClass("label-info");
                                $('#user_id' + id).html("Offer Sponsorship");
                            } else {
                                $('#user_id' + id).removeClass("label-warning");
                                $('#user_id' + id).addClass("label-info");
                                $('#user_id' + id).html("Manage Or Receive Sponsorship");
                            }
                            swal("Updated", obj.msg, "success");
                        },
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#spinner').hide();
                            swal("warning", "Please try again", "error");
                        }
                    });
                }
            })
        }

        function EditUser(id) {
            $.ajax({
                type: 'POST',
                url: '{{ route('editusers') }}',
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                data: {id: id},
                success: function (response) {
                    var data = JSON.parse(response);
                    console.log(data);

                    $('#user_email').attr('value', data.email);
                    //$('#edit_package').html(response);
                    $('#exampleModal').modal('toggle');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    toastr.error("Something went wrong", "Error");
                },
            });
        }







        function share(id) {
            swal({
                        title: "Enter Email ID",
                        text: "Voucher code will be send in this email",
                        type: 'success',
                        input: 'text',
                        inputValue: '',
                        showCancelButton: true,        
                        preConfirm: function (email) {
                        return new Promise(function (resolve, reject) {
                          
                            if (email === '') {
                                reject('Email is required')
                            } else {
                                
                                $.ajax({
                                    type: 'POST',
                                    url: '{{ route('voucher-share') }}',
                                    headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}"},
                                    data: {email: email, id: id},
                                    success: function (response) {
                                        console.log(response);
                                    },
                                    error: function (jqXHR, textStatus, errorThrown) {
                                        $('#spinner').hide();
                                        swal("warning", "Please try again", "error");
                                    },
                                });



                                resolve()
                            }
                          
                        })
                    }
                    })
                }
        </script>
@endsection
