@extends('vendor.laravel-responsive-gallery.layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Edit photo datas</h4>
                </div>
            </div>

            @include('partials.forms.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('responsive-gallery.update', $galleryImage->id) }}" method="POST">
                {{--<form action="responsive-gallery/{{$galleryImage->id}}" method="POST">--}}
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-12">
                        <div class="form-group file_name">
                            <label for="file_name">Image file name</label>
                            <input type="text" name="file_name" class="form-control{{ $errors->has($galleryImage->file_name) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->file_name)) value="{{ $galleryImage->file_name }}" @endif
                            >
                            @if ($errors->has($galleryImage->file_name))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first($galleryImage->file_name) }}</strong></span>
                            @endif
                        </div>
                        
                        {{--@include('vendor.laravel-responsive-gallery.partials.input', [
                            'title' => 'Image file name',
                            'name' => 'file_name',
                            'placeholder' => '', 
                            'value' => $galleryImage->file_name
                        ])--}}
                    </div>
                    <div class="col-12">
                        @include('vendor.laravel-responsive-gallery.partials.textarea-plain', [
                            'title' =>  'Description',
                            'name' => 'description',
                            'value' => $galleryImage->description
                        ])
                    </div>
                    <div class="col-12">
                        {{--@include('vendor.laravel-responsive-gallery.partials.input', [
                            'title' => 'Alt text',
                            'name' => 'alt',
                            'placeholder' => '', 
                            'value' => $galleryImage->alt
                        ])--}}
                        <div class="form-group alt">
                            <label for="alt">Alt text</label>
                            <input type="text" name="alt" class="form-control{{ $errors->has($galleryImage->alt) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->alt)) value="{{ $galleryImage->alt }}" @endif
                            >
                            @if ($errors->has($galleryImage->alt))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first($galleryImage->alt) }}</strong></span>
                            @endif
                        </div>
                    </div>
                    <div class="col-12">
                        {{--@include('vendor.laravel-responsive-gallery.partials.input', [
                            'title' => 'Video link',
                            'name' => 'video_link',
                            'placeholder' => '', 
                            'value' => $galleryImage->video_link
                        ])--}}
                        <div class="form-group video_link">
                            <label for="video_link">Video link</label>
                            <input type="text" name="video_link" class="form-control{{ $errors->has($galleryImage->video_link) ? ' is-invalid' : '' }}"
                                @if(!empty($galleryImage->video_link)) value="{{ $galleryImage->video_link }}" @endif
                            >
                            @if ($errors->has($galleryImage->video_link))
                                <span class="invalid-feedback" role="alert"><strong>{{ $errors->first($galleryImage->video_link) }}</strong></span>
                            @endif
                        </div>
                        
                    </div>
                    
                    
                    <div class="col-12">
                        @include('vendor.laravel-responsive-gallery.partials.buttons-back-submit', [
                            'route' => 'responsive-gallery.index'  
                        ])
                    </div>
                    
                    
                </div>
                
            </form>
    
    </div>
    
@endsection
