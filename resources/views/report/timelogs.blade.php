@extends('layouts.app')

@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                <div class="card-header">
                    <div class="float-right">
                        <!--<a href="#" class="btn btn-primary" role="button"><i class="fa fa-file-export"></i> Export</a>
                        <a href="#" class="btn btn-success" role="button"><i class="fa fa-print"></i> Print</a>
                        -->
                    </div>
                    <h5 class="card-title mt-1"> Time Logs</h5>
                    <div class="card-tools">
                        <span style="font-size:12px;">{!! $logs->render() !!}</span>
                    </div>
                </div>
                <div class="card-body">
                    <!--
                    <div class="float-right">
                        <form class="form-inline">
                            <div class="custom-control custom-checkbox my-1 mr-sm-2">
                                <input type="text" class="form-control" placeholder="search...">
                            </div>
                        </form>
                    </div>
                   
                    <form class="form-inline">
                        <label class="my-1 mr-2" for="inlineFormCustomSelectPref">Month: </label>
                        <select class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                            <option selected>May</option>
                            <option value="1">One</option>
                            <option value="2">Two</option>
                            <option value="3">Three</option>
                        </select>

                        <button type="submit" class="btn btn-primary my-1"><i class="fa fa-filter"></i> Filter</button>
                    </form> -->
                    
                    <table class="table">
                        <thead>
                            <th>Date</th>
                            <th>TimeIn</th>
                            <th>TimeOut</th>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)

                            @if(!empty($log->timein))
                            <tr>
                                <td>{{ ($log->created_at) ? $log->created_at->format('m/d/Y') : "" }}</td>
                                <td>{{ ($log->timein) ? $log->timein->format('h:i A') : "" }}</td>
                                <td>{{ ($log->timeout) ? $log->timeout->format('h:i A'): "" }}</td>
                            </tr>
                            @endif
                            
                            @empty
                            <tr><td colspan=4>No logs</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('page-js')
<script>
    $(document).ready(function() {
      
    } );
</script>
@endsection