@extends('layouts.app')
@section('title')
 Create
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
        
                                        <h4 class="mt-0 header-title">Users</h4>
                                        <p class="text-muted mb-4" >
                                            <a href="{{ route('user.create') }}" class="btn btn-info px-4 align-self-center report-btn float-right">Create New</a>
                                        </p>
        
                                        <div class="table-responsive">
                                            <table class="table table-striped mb-0">
                                                <thead>
                                                <tr>
                                                    <th>S/N</th>
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                    {{-- <th>Department</th> --}}
                                                    <th>Role</th>
                                                    <th>Contact Number</th>
                                                    <th>Created Date</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse ($users as $user)
                                                <tr>
                                                    <th scope="row">{{ $loop->iteration }}</th>
                                                    <td>{{ $user->fname }}</td>
                                                    <td>{{ $user->lname }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    {{-- <td>{{ $user->departments->name }}</td> --}}
                                                    <td>{{ $user->user_roles->name }}</td>
                                                    <td>{{ $user->phone }}</td>
                                                
                                                    <td>{{ $user->created_at }}</td>

                                                    <td>  
                                                        <a href="{{ route('user.edit', $user->id) }}" class=""><i class="fas fa-edit text-success"></i></a>
                                                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-link" style="padding: 0; border: none; background: none;" onclick="return confirm('Are you sure you want to delete this user?');">
                                                                <i class="fas fa-trash-alt text-danger ml-2"></i>
                                                            </button>
                                                        </form> 
                                                        {{-- <a href="{{ route('user.destroy', $user->id) }}" class=""><i class="fas fa-trash-alt text-danger ml-2"></i></a>  --}}
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