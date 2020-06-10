@extends('layouts.app')
@section('content')

 <!-- Main content -->
 <section class="content">
      <div class="container-fluid">
        <div class="row justify-content-center">

          <!-- PROFILE IMAGE
          ==================================== -->          
          <div class="col-md-3">
            <div class="card">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="{{ asset('dist/img/avatar.png') }}"
                       alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                <p class="text-muted text-center">{{ Auth::user()->email }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">ID Number<span class="float-right text-muted">{{ Auth::user()->employee_id }}</span></li>
                    <li class="list-group-item">Job Title<span class="float-right text-muted">{{ Auth::user()->position }}</span></li>
                </ul>
              </div><!-- /.card-body -->
            </div> <!-- / .card -->
          </div> <!-- / .col-md-3 -->
          <!-- END OF PROFILE IMAGE
          ==================================== -->        

           <!-- ATTENDANCE
          ================================================ -->
          <div class="col-md-3 text-center">
            <div class="card">
              <div class="card-header p-2">
                <h5 class="pt-1">Attendance ({{ date('m/d/Y') }})</h5>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content"  style="max-height:350px; overflow:auto">
                  <div class="active tab-pane" id="activity">
                    <!-- Post -->
                    <div class="post">
                      <table class="table">
                        <thead>
                            <th>Time-In</th>
                            <th>Time-Out</th>
                        </thead>
                        <tbody>
                          @foreach($log as $time)
                            <tr>
                                <td>{{ $timein = ($time->timein) ? $time->timein->format('h:i A'): "" }}</td>
                                <td>{{ $timeout = ($time->timeout) ? $time->timeout->format('h:i A'): "" }} </td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                      @if(empty($timeout) && empty($timeout))
                          <a href="#" class="btn {{ (@$log[0]->timein == null) ? 'btn-success' : 'btn-danger'}} btn-block"  
                            data-toggle="modal" data-target="#Modal_TimeInOut" id="">
                            <i class="fa fa-user-clock"></i> <b>{{ ( @$log[0]->timein == null) ? 'Time-In' : 'Time-Out'}}</b>
                          </a>
                      @endif

                     
                    </div>
                  </div>
                </div>
              </div><!-- /.card-body -->
            </div>
          </div><!-- /.col -->
          <!-- END OF ATTENDANCE
          ================================================ -->

          <!-- TASK ALERTS
          ================================================ -->
           
          <!-- END OF TASK ALERTS
          ================================================ -->


        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </section><!-- /.content -->

  <!-- MODAL
  =============================================== -->
  <div class="modal" tabindex="-1" role="dialog" id="Modal_TimeInOut">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Time In/Out</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
          <form method="post" id="FrmTimeInOut">
            <div class="form-group">
              <input type="text" name="comp_num" class="form-control" placeholder="enter your company id number" /> 
              <input type="hidden" name="action" value=""/>
                @csrf
            </div>
          </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" id="BtnVerifyLogin">Verify</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    /* EVENTS HERE */
    $('#BtnVerifyLogin').on('click', function (e) { 
      e.preventDefault();
      var data = $('#FrmTimeInOut').serialize();
      $.post('log/timein', data)
        .done(function(e){
          if(e==1){
            alert('Success: Verified');
            location.reload();
          }
          else{
            alert(e);
          }
        })
        .fail(function(xhr, textStatus, errorThrown){
          alert(xhr.status + ": " + xhr.statusText + " - " + " Please signout to start a new session." );
      });
    });

  });
</script>
@endsection
