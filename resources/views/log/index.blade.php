@extends('layouts.app')

@section('style')
  <!-- DataTables -->
  <link rel="stylesheet" href=" {{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.cs') }}">
  <!-- daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                <div class="card-header">
                    <div class="float-right">
                       
                    </div>
                    <h5 class="mt-1">Time Logs</h5>
                </div>
                <div class="card-body">
                    <div class="pb-2 pt-2">

                      <form action="{{ url('log') }} " method="get">
                        <div class="row mb-4">
                          <div class="col-md-3"> 
                            
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <span class="input-group-text">
                                <i class="far fa-calendar-alt"></i>
                              </span>
                            </div>
                            <input type="text" class="form-control float-right" value="{{ (isset($range)) ? $range : '' }}" name="range" id="range">
                          </div>


                          </div>
                          <div class="col">
                          @csrf
                            <button class="btn btn-primary" type="submit">Generate</button>
                          </div>
                        </div>
                      </form>

                      @if(isset($logs))
                      <table class="table" id="TableLogs">
                          <thead>
                            <th>Date</th>
                            <th>In</th>
                            <th>Out</th>
                          </thead>
                          <tbody>
                          @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->date }}</td>
                                <td>{{ ($log->timein) ? $log->timein->format('h:i:s A') : "00:00"}}</td>
                                <td>{{ ($log->timeout) ? $log->timeout->format('h:i:s A') : "00:00" }}</td>
                            </tr>
                          @empty
                          <tr><td colspan="3">Error: No record(s) found.</td></tr>
                          @endforelse
                          </tbody>
                      </table>
                      @else
                      <p></p>
                      @endif
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Add Task Modal
  =================================== -->
  <div class="modal" tabindex="-1" role="dialog" id="Modal_AddTask">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Add Task</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
      <form method="post" id="FrmAddTask">
        <div class="form-group">
          <input type="text" name="task" id="txtTask" class="form-control" placeholder="Enter the task name here" /> 
          <input type="hidden" name="current_row" id="current_row" value=""/>
          <input type="hidden" name="action" id="action" value=""/>
            @csrf
        </div>
      </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="BtnSaveTask"><i class="fa fa-save"></i > Save</button>
        <button type="button" class="btn btn-secondary" id="BtnDismissModalAddTask"><i class="fa fa-times"></i > Close</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('page-js')
<!-- datatables picker -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- InputMask -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<!-- date-range-picker -->
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>


<script>
  $('document').ready(function() {

    $('#TableLogs').DataTable();

    $(document).keypress(
      function(e){
        if (e.which == '13') {
          e.preventDefault();
        }
    });

    $('#BtnShowModalAddTask').click(function() {
        $('#Modal_AddTask').modal('show');
    });

    $('#range').daterangepicker();

    $('#BtnDismissModalAddTask').click(function() {
        $('#current_row').val('');
        $('#action').val('');
        $('#txtTask').val('');
        $('#Modal_AddTask').modal('hide');
    });

    $('#BtnSaveTask').on('click', function(e){
      e.preventDefault();
      var data = $('#FrmAddTask').serialize();
      $.post('task/add', data)
        .done(function(res){
          if(res==1){
            $('#current_row').val('');
            $('#action').val('');
            $('#txtTask').val('');
            location.reload();
          }
          else{
            alert(res);
          }
        })
        .fail(function(xhr, textStatus, errorThrown){
          alert(xhr.statusText);
      });
    });

    $('#TableTask button').click(function(){
        var taskname = $(this).closest('tr').children('td:eq(1)').text();
        var id = $(this).closest('tr').attr('id');
        $('#action').val('edit');
        $('#current_row').val(id);
        $('#txtTask').val(taskname);
        $('#Modal_AddTask').modal('show');
        //alert(id);
    });
  });
</script>
@endsection