@extends('laravel-responsive-gallery::layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Add new photo datas</h4>
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

            <form action="{{ route('responsive-gallery.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    {{-- Image file name --}}
                    <div class="col-12">
                        <div class="form-group file_name">
                            <label for="file_name">Image file name</label>
                            <input type="text" name="file_name" class="form-control{{ $errors->has("file_name") ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->file_name)) value="{{ old('file_name') }}" @endif
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
                            <textarea class="form-control{{ $errors->has("description") ? ' is-invalid' : '' }}" style="height: '9rem'" name="description" id="description" >{{old('description')}}</textarea>
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
                            <input type="text" name="alt" class="form-control{{ $errors->has('alt') ? ' is-invalid' : '' }}"
                                value="{{ old('alt') }}"
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
                            <input type="text" name="video_link" class="form-control{{ $errors->has(old('video_link')) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->video_link)) value="{{ old('video_link') }}" @endif
                            >
                            @if ($errors->has(old('video_link')))
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
