@extends('layouts.app')
@section('title')
Departments
@endsection
@section('content')

    <div class="page-wrapper">

        @include('partials.navbar')

                  <!-- Page Content-->
                  <div class="page-content">
                    <div class="container-fluid"> 
                       
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
        
                                        <h4 class="mt-0 header-title">Departments</h4>
                                        <p class="text-muted mb-4" >
                                            @if (!empty($permissionsAdd))
                                              <a href="{{ route('department.create') }}" class="btn btn-info px-4 align-self-center report-btn float-right">Create New</a>
                                            @endif
                                        </p>
        
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Department Name</th>
                                                    <th>Department Code</th>
                                                    <th>Created By</th>
                                                    <th>Created Date</th>
                                                    @if (!empty($permissionsEdit) || !empty($permissionDelete))
                                                      <th>Action</th>
                                                    @endif
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse ($departments as $department)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $department->name }}</td>
                                                    <td>{{ $department->department_code }}</td>
                                                    <td>{{ $department->users->fname }}</td>
                                                    <td>{{ $department->created_at }}</td>
                                                    <td>  
                                                        @if (!empty($permissionsEdit))
                                                           <a href="{{ route('department.edit', $department->id) }}" class=""><i class="fas fa-edit text-success"></i></a>
                                                        @endif
                                                        @if(!empty($permissionDelete))
                                                           <a href="{{ route('department.destroy', $department->id) }}" class=""><i class="fas fa-trash-alt text-danger ml-2"></i></a> 
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                   <tr>
                                                      <td colspan="100%">Record not Found</td>
                                                   </tr>
                                                @endforelse
                                                
                                                </tbody>
                                            </table><!--end /table-->
                                        </div><!--end /tableresponsive-->
                                    </div><!--end card-body-->
                                </div><!--end card-->
                            </div> <!-- end col -->
                        </div> <!-- end row -->
    
                    </div><!-- container -->
    
                    @include('partials.footer')
                </div>
                <!-- end page content -->

    </div>
    <!-- end page-wrapper -->

@endsection