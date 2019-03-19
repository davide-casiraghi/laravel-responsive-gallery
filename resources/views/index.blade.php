@extends('vendor.laravel-responsive-gallery.layout')

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h4>Galleries photos</h4>
        </div>
        <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success create-new" href="{{ route('responsive-gallery.create') }}">Add new photo datas</a>
        </div>
    </div>

@endsection
