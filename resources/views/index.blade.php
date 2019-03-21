{{--@extends('vendor.laravel-responsive-gallery.layout')--}}

@section('content')
    
    <div class="row">
        <div class="col-12 col-sm-6">
            <h4>Galleries photos</h4>
        </div>
        <div class="col-12 col-sm-6 mt-4 mt-sm-0 text-right">
            <a class="btn btn-success create-new" href="{{ route('responsive-gallery.create') }}">Add new photo datas</a>
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success mt-4">
            <p>{{ $message }}</p>
        </div>
    @endif
    
    
    {{-- List all the photos --}}
    <div class="photoList my-4">
        
        @foreach ($galleryImages as $galleryImage)
            <div class="row bg-white shadow-1 rounded mb-3 pb-2 pt-3 mx-1">
                <div class="col-12 py-1">
                    <h5>{{ $galleryImage->file_name }}</h5>
                </div>
                
                <div class="col-12 pb-2">
                    <form action="{{ route('responsive-gallery.destroy',$galleryImage->id) }}" method="POST">
                        <a class="btn btn-primary float-right" href="{{ route('responsive-gallery.edit',$galleryImage->id) }}">Edit</a>
                        
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-link pl-0">Delete</button>
                    </form>
                </div>    
            </div>
        @endforeach            
    </div>

@endsection
