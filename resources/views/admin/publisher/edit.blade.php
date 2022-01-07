@extends('layouts.admin')
@section('header','Publisher')

@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Publisher</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('publishers/'.$publisher->id) }}" method="post">
                        @csrf
                        {{ method_field('PUT') }}
                        <div class="card-body">
                            <div class="form-group">
                                <label for="publisher">Name</label> 
                                <input type="text" class="form-control" name="name" value="{{$publisher->name}}"
                                    placeholder="New Catalog" required>
                            </div>
                            <div class="form-group">
                                <label for="publisher">Email</label> 
                                <input type="text" class="form-control" name="email" value="{{$publisher->email}}"
                                    placeholder="New Catalog" required>
                            </div>
                            <div class="form-group">
                                <label for="publisher">Phone</label> 
                                <input type="text" class="form-control" name="phone_number" value="{{$publisher->phone_number}}"
                                    placeholder="New Catalog" required>
                            </div>
                            <div class="form-group">
                                <label for="publisher">Address</label> 
                                <input type="text" class="form-control" name="address" value="{{$publisher->address}}"
                                    placeholder="New Catalog" required>
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
@endsection
