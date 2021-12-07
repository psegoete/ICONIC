@extends('account.layouts.default')

@section('content')
<div class="clearfix">
    <div class="col-lg">
        <div class="card">
            <div class="card-header">
                <i class="fa fa-align-justify"></i> Packages
                <a href="{{ route('packages.create') }}" class="float-right"><i class="fas fa-plus-square"></i> Package</a>
                
            </div>
            <div class="card-body">

                <div class="row">
                    <div class="col-12">
                        <form method="get" action="{{ route('packages.index') }}" class="form-inline float-right">
                            {{ csrf_field() }}
                                    <div class="form-group mb-2">
                                        <input type="text" placeholder="Search.." name="search" class="form-control">
                                
                                    </div>
    
                                    <button type="submit" class="btn btn-primary mb-2"><i class="fa fa-search"></i></button>
                        
                        </form>
                    </div>
                    
                </div>
                    
                  
        
                <table class="table table-responsive-sm table-striped">
                    <thead>
                        <tr>
                            <th>Package Name</th>
                            <th>Package Description</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($packages as $package)
                        <tr>
                            <td>{{ $package->package_name }}</td>
                            <td>{{ $package->package_description }}</td>
                            <td>{{ $package->price }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="User Actions">
                                    <a href="{{ URL::to('packages/' . $package->id . '/edit') }}" data-toggle="tooltip" data-placement="top" title="" class="btn btn-primary mb-2" data-original-title="Edit"><i class="fa fa-edit "></i></a>
                                    <form action="{{ route('packages.destroy', $package->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger mb-2" type="submit"><i class="fas fa-trash"></i></b>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    
                    
                </table>
                <div class="row">
                    <div class="col-12">
                        <div class="float-right" >
                            {{ $packages->links() }}
                        </div>
                    </div>
                 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection