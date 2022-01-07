@extends('layouts.admin')
@section('header','Catalog')

@section('content')
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create New Catalog</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{ url('catalogs') }}" method="post">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="catalog">Name</label>
                                <input type="text" class="form-control" name="name"
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
