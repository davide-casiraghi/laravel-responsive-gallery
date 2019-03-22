@extends('laravel-responsive-gallery::layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Edit photo datas</h4>
                </div>
            </div>

            @if ($errors->any())
                <div class="alert {{ $style }}">
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('responsive-gallery.update', $galleryImage->id) }}" method="POST">
                {{--<form action="responsive-gallery/{{$galleryImage->id}}" method="POST">--}}
                @csrf
                @method('PUT')
                
                <div class="row">
                    
                    {{-- Image file name --}}
                    <div class="col-12">
                        <div class="form-group file_name">
                            <label for="file_name">Image file name</label>
                            <input type="text" name="file_name" class="form-control{{ $errors->has($galleryImage->file_name) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->file_name)) value="{{ $galleryImage->file_name }}" @endif
                            >
                            @if ($errors->has("file_name"))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first("file_name") }}</strong></span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Description --}}
                    <div class="col-12">
                        <div class="form-group description">
                            <label for="description">Description</label>
                            <textarea class="form-control{{ $errors->has("description") ? ' is-invalid' : '' }}" style="height: '9rem'" name="description" id="description" >@if(!empty($galleryImage->description)){!! $galleryImage->description !!} @endif</textarea>
                            @if ($errors->has("description"))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first("description") }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Alt text --}}
                    <div class="col-12">
                        <div class="form-group alt">
                            <label for="alt">Alt text</label>
                            <input type="text" name="alt" class="form-control{{ $errors->has($galleryImage->alt) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->alt)) value="{{ $galleryImage->alt }}" @endif
                            >
                            @if ($errors->has("alt"))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first("alt") }}</strong></span>
                            @endif
                        </div>
                    </div>
                    
                    {{-- Video Link --}}
                    <div class="col-12">
                        <div class="form-group video_link">
                            <label for="video_link">Video link</label>
                            <input type="text" name="video_link" class="form-control{{ $errors->has($galleryImage->video_link) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->video_link)) value="{{ $galleryImage->video_link }}" @endif
                            >
                            @if ($errors->has("video_link"))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first("video_link") }}</strong></span>
                            @endif
                        </div>
                    </div>
                    
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary float-right">Submit</button>
                        <a class="btn btn-outline-primary mr-2 float-right" href="{{ route("responsive-gallery.index") }}">Back</a>
                    </div>
                    
                    
                </div>
                
            </form>
    
    </div>
    
@endsection
