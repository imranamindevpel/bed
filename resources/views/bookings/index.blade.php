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
                            <label for="user_id">Select User</label>
                            <select class="form-control" id="user_id" name="user_id">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>                        
                        <div class="form-group">
                            <input type="date" class="form-control" id="booking_date" placeholder="Enter Booking Date" required>
                            <div class="invalid-feedback">Please enter a valid booking date.</div>
                        </div>
                        <div class="form-group">
                            <input type="date" class="form-control" id="check_in_date" placeholder="Enter Check In Date" required>
                            <div class="invalid-feedback">Please enter a valid check-In date.</div>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="bed" required>
                                <option value="">Select Bed</option>
                                @foreach ($beds as $bed)
                                    <option value="{{ $bed->id }}"
                                            data-daily-price="{{ $bed->daily_price }}"
                                            data-weekly-price="{{ $bed->weekly_price }}"
                                            data-monthly-price="{{ $bed->monthly_price }}">
                                        {{ $bed->name }} - {{ $bed->type }} - {{ $bed->daily_price }}, {{ $bed->weekly_price }}, {{ $bed->monthly_price }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="radio" id="custom" name="booking_type" required>Custom
                            <input type="text" class="form-control" id="custom_day" placeholder="Enter Custom Day" style="display: none;">
                            <input type="radio" id="day" name="booking_type" required>Day
                            <input type="radio" id="weekly" name="booking_type" required>Weekly
                            <input type="radio" id="monthly" name="booking_type" required>Monthly
                        </div>
                        <div class="form-group">
                            <input type="checkbox" class="" id="mess_status">Mess
                            <input type="text" class="form-control" id="mess" placeholder="Enter Mess" style="display: none;">
                        </div>
                        <div class="row form-group">
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="rent" placeholder="Bed Rent" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="discount" placeholder="Discount" required>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" id="total" placeholder="Total" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="paid" placeholder="Paid" required>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" id="balance" placeholder="Balance" required>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="due" placeholder="Due" required>
                            </div>
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="next_due_date" placeholder="Next Due Date" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="detail" placeholder="Enter Detail">
                            <div class="invalid-feedback">Please enter a valid detail.</div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="save(event)">Save</button>
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
    $('#bed, input[name="booking_type"], #custom_day, #mess_status, #mess, #discount, #paid, #due').on('input change', function() {
        
        var selectedOption = $('#bed').find('option:selected');
        var daily_price = parseFloat(selectedOption.data('daily-price'));
        var weekly_price = parseFloat(selectedOption.data('weekly-price'));
        var monthly_price = parseFloat(selectedOption.data('monthly-price'));
        var daily_mess = parseFloat({!! json_encode(env('MESS_DAILY_PRICE')) !!});
        var weekly_mess = parseFloat({!! json_encode(env('MESS_WEEKLY_PRICE')) !!});
        var monthly_mess = parseFloat({!! json_encode(env('MESS_MONTHLY_PRICE')) !!});
        var bookingType = $('input[name="booking_type"]:checked').attr('id');
        var discount = parseFloat($('#discount').val()) || 0;
        var paid = parseFloat($('#paid').val()) || 0;
        var dueDate = $('#due').val();
        var currentDate = new Date(dueDate);
        var nextDueDate = new Date(currentDate);
        
        var mess = 0;
        if (bookingType === 'custom') {
            $('#custom_day').show();
            var customDays = $('#custom_day').val();
            if ($('#mess_status').is(':checked')) {
                // mess = parseFloat($('#mess').val()) || 0;
                // $('#mess').show();
                var subtotal = customDays * (daily_price + daily_mess);
                alert(subtotal);
            } else {
                var subtotal = customDays * (daily_price);
                $('#mess').hide();
            }
            $('#rent').val(subtotal);
            var total = subtotal - discount;
            $('#total').val(total);
            var balance = total - paid;
            if (paid > 0) {
                $('#balance').val(balance);
            } else {
                $('#balance').val('');
            }
            nextDueDate.setDate(currentDate.getDate() + parseInt(customDays));
            var nextDueDateString = nextDueDate.toISOString().substr(0, 10);
            $('#next_due_date').val(nextDueDateString);
        }else if (bookingType === 'day') {
            $('#custom_day').hide();
            if ($('#mess_status').is(':checked')) {
                // mess = parseFloat($('#mess').val()) || 0;
                // $('#mess').show();
                var subtotal = daily_price + daily_mess;
            } else {
                var subtotal = daily_price;
                $('#mess').hide();
            }
            $('#rent').val(subtotal);
            var total = subtotal - discount;
            $('#total').val(total);
            var balance = total - paid;
            if (paid > 0) {
                $('#balance').val(balance);
            } else {
                $('#balance').val('');
            }
            nextDueDate.setDate(currentDate.getDate() + 1);
            var nextDueDateString = nextDueDate.toISOString().substr(0, 10);
            $('#next_due_date').val(nextDueDateString);
        } else if (bookingType === 'weekly') {
            $('#custom_day').hide();
            if ($('#mess_status').is(':checked')) {
                // mess = parseFloat($('#mess').val()) || 0;
                // $('#mess').show();
                var subtotal = weekly_price + weekly_mess;
            } else {
                var subtotal = weekly_price;
                $('#mess').hide();
            }
            $('#rent').val(subtotal);
            var total = subtotal - discount;
            $('#total').val(total);
            var balance = total - paid;
            if (paid > 0) {
                $('#balance').val(balance);
            } else {
                $('#balance').val('');
            }
            nextDueDate.setDate(currentDate.getDate() + 7);
            var nextDueDateString = nextDueDate.toISOString().substr(0, 10);
            $('#next_due_date').val(nextDueDateString);
        } else if (bookingType === 'monthly') {
            $('#custom_day').hide();
            if ($('#mess_status').is(':checked')) {
                // mess = parseFloat($('#mess').val()) || 0;
                // $('#mess').show();
                var subtotal = monthly_price + monthly_mess;
            } else {
                var subtotal = monthly_price;
                $('#mess').hide();
            }
            $('#rent').val(subtotal);
            var total = subtotal - discount;
            $('#total').val(total);
            var balance = total - paid;
            if (paid > 0) {
                $('#balance').val(balance);
            } else {
                $('#balance').val('');
            }
            nextDueDate.setMonth(currentDate.getMonth() + 1);
            var nextDueDateString = nextDueDate.toISOString().substr(0, 10);
            $('#next_due_date').val(nextDueDateString);
        }
    });
});

function list() {
    $.ajax({
        url: "/get_bookings_data",
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
                    "url": "/get_bookings_data",
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
    var id = $('#id').val();
    var user_id = $('#user_id').val();
    var booking_date = $('#booking_date').val();
    var check_in_date = $('#check_in_date').val();
    var bed = $('#bed').val();
    var booking_type = $('#booking_type').val();
    var rent = $('#rent').val();
    var mess_status = $('#mess_status').val();
    var mess = $('#mess').val();
    var discount = $('#discount').val();
    var total = $('#total').val();
    var paid = $('#paid').val();
    var balance = $('#balance').val();
    var due = $('#due').val();
    var next_due_date = $('#next_due_date').val();
    var detail = $('#detail').val();

    // Create a new FormData object to include the image file
    var formData = new FormData($('#form1')[0]);
    formData.append('id', id);
    formData.append('name', name);
    formData.append('phone', phone);
    formData.append('booking_date', booking_date);
    formData.append('check_in_date', check_in_date);
    formData.append('bed', bed);
    formData.append('booking_type', booking_type);
    formData.append('rent', rent);
    formData.append('mess_status', mess_status);
    formData.append('mess', mess);
    formData.append('discount', discount);
    formData.append('total', total);
    formData.append('paid', paid);
    formData.append('balance', balance);
    formData.append('due', due);
    formData.append('next_due_date', next_due_date);
    formData.append('detail', detail);

    $.ajax({
        type: 'post',
        data: formData,
        processData: false,
        contentType: false,
        url: '/bookings',
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
        url: '/bookings/' + id,
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
        url: '/bookings/' + id,
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
  var confirmed = confirm("Are you sure you want to delete this booking?");
  if (confirmed) {
    $.ajax({
        type: 'delete',
        url: "/bookings/" + id,
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