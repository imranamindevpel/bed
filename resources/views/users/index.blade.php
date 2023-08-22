@extends('layouts.master')
@section('content')
<style>
td {
    padding: 2px 10px;
}

.sorting {
    text-transform: uppercase;
}
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$pageName}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">{{$pageName}}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="modal fade" id="view-create-edit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form enctype="multipart/form-data" method="post" id="form1">
                        <input type="hidden" id="id" value="0">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                            <div class="invalid-feedback">Please enter a valid name.</div>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Phone">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                            <div class="invalid-feedback">Please enter a valid email address.</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                        </div>
                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth</label>
                            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth">
                        </div>
                        <div class="form-group">
                            <label for="cnic">CNIC</label>
                            <input type="text" class="form-control" id="cnic" name="cnic" placeholder="Enter CNIC">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select class="form-control" id="role" name="role">
                                <option value="admin">Admin</option>
                                <option value="tenant">Tenant</option>
                                <option value="agent">Agent</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="percentage">Percentage</label>
                            <input type="number" step="0.01" class="form-control" id="percentage" name="percentage"
                                placeholder="Enter Percentage">
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>               
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-primary" onclick="save(event)">Save</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-success" data-toggle="modal" data-target="#view-create-edit"
                                onclick=create()>Create</button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">

                            <table id="table1" class="display">
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    list();
});

function list() {
    $.ajax({
        url: "/get_users_data",
        type: "get",
        dataType: "json",
        success: function(response) {
            var columns = [];
            for (var key in response.data[0]) {
                var header = key.replace(/_/g, ' '); // Replace underscores with spaces
                columns.push({
                    "title": header,
                    "data": key
                });
            }
            $('#table1').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "/get_users_data",
                    "type": "get"
                },
                "columns": columns
            });
        }
    });
}

function save(event) {
  var form = document.getElementById('form1');
    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    event.preventDefault();
    var name = $('#name').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var address = $('#address').val();
    var dateOfBirth = $('#date_of_birth').val();
    var cnic = $('#cnic').val();
    var role = $('#role').val();
    var percentage = $('#percentage').val();
    var status = $('#status').val();
    // Create a new FormData object
    var formData = new FormData($('#form1')[0]);
    // Append form data to the FormData object
    formData.append('name', name);
    formData.append('phone', phone);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('address', address);
    formData.append('date_of_birth', dateOfBirth);
    formData.append('cnic', cnic);
    formData.append('role', role);
    formData.append('percentage', percentage);
    formData.append('status', status);
    
    $.ajax({
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        url: '/users',
        success: function(data) {
            if (data.success) {
                alert(data.success);
                $('#view-create-edit').modal('hide');
                var dataTable = $('#table1').DataTable();
                dataTable.ajax.reload();
            }
        }
    });
}


function create(id) {
    $('.modal-footer').show();
    document.getElementById('form1').reset();
}

function view($id) {
  $('.modal-footer').hide();
    var id = $id;
    $.ajax({
        type: 'get',
        data: {
            id: id,
        },
        url: '/users/' + id,
        success: function(data) {
            document.getElementById('name').value = data.name;
            document.getElementById('price').value = data.price;
            document.getElementById('quantity').value = data.quantity;
            document.getElementById('detail').value = data.detail;
        }
    })
}

function edit(id) {
  $('.modal-footer').show();
    $.ajax({
        type: 'get',
        data: {
            id: id,
        },
        url: '/users/' + id,
        success: function(data) {
            document.getElementById('id').value = data.id;
            document.getElementById('name').value = data.name;
            document.getElementById('price').value = data.price;
            document.getElementById('quantity').value = data.quantity;
            document.getElementById('detail').value = data.detail;
        }
    })
}

function destroy(id) {
  var confirmed = confirm("Are you sure you want to delete this user?");
  if (confirmed) {
    $.ajax({
        type: 'delete',
        url: "/users/" + id,
        success: function(data) {
            if (data.success) {
                alert("Data Delete Successfully.");
                var dataTable = $('#table1').DataTable();
                dataTable.ajax.reload();
            }
        }
    });
  }
}

</script>
@endsection