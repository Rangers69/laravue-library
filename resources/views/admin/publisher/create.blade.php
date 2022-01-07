@extends('layouts.admin')
@section('header','Publisher')

@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Publisher</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('publishers') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="catalog">Name</label>
                                <input type="text" class="form-control" name="name"
                                    placeholder="New Catalog" required>
                            </div>
                            <div class="form-group">
                                <label for="catalog">Email</label>
                                <input type="email" class="form-control" name="email"
                                    placeholder="New Catalog" required>
                            </div>
                            <div class="form-group">
                                <label for="catalog">Phone</label>
                                <input type="text" class="form-control" name="phone_number"
                                    placeholder="New Catalog" required>
                            </div>
                            <div class="form-group">
                                <label for="catalog">Address</label>
                                <input type="text" class="form-control" name="address"
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
