@extends('layouts.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                <div class="card-header">
                    <div class="float-right">
                        <a href="#" class="btn btn-success btn-sm" id="BtnShowModalAddTask" role="button"><i class="fa fa-plus"></i> Add Task</a>
                    </div>
                    <h5 class="mt-1">Task List</h5>
                </div>
                <div class="card-body">
                    <div class="pb-2 pt-2">
                      <table class="table" id="TableTask">
                          <tbody>
                          @forelse($tasks as $item)
                            <tr id="{{ $item->id }}">
                                <td>{{ $item->created_at->format('m/d/Y') }}</td>
                                <td id="task-name">{{ $item->name }}</td>
                                <td><button class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></button></td>
                            </tr>
                          @empty
                          <tr><td colspan="3">No running task found.</td></tr>
                          @endforelse
                          </tbody>
                      </table>
                      <div class="justify-content-center">
                        <span style="font-size:12px;">{!! $tasks->render() !!}</span>
                      </div>
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
<script>
  $('document').ready(function() {
    $(document).keypress(
      function(e){
        if (e.which == '13') {
          e.preventDefault();
        }
    });

    $('#BtnShowModalAddTask').click(function() {
        $('#Modal_AddTask').modal('show');
    });

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