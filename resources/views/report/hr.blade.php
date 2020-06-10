@extends('layouts.app')

@section('style')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.20/datatables.min.js"></script>
@endsection

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
                    <h5 class="card-title mt-1"> Users</h5>
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
                    <div class="pb-2 pt-2" style="max-height:400px; overflow:auto">
                    <table class="table" id="users">
                        <tbody>
                            @forelse($users as $user)
                            <tr>
                                <td>{{ $user->employee_id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->position }}</td>
                            </tr>
                            @empty
                            <tr><td colspan=2>No users.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                   </div>
                   <div class="card-tools mt-3">
                    <span style="font-size:12px;">{!! $users->render() !!}</span>
                    </div>
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