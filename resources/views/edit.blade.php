@extends('laravel-responsive-gallery::layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Edit photo datas</h4>
                </div>
            </div>

            @include('laravel-responsive-gallery::partials.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('responsive-gallery.update', $galleryImage->id) }}" method="POST">
                {{--<form action="responsive-gallery/{{$galleryImage->id}}" method="POST">--}}
                @csrf
                @method('PUT')
                
                <div class="row">
                    
                    <div class="col-12">
                        @include('laravel-responsive-gallery::partials.input', [
                            'title' => 'Image file name',
                            'name' => 'file_name',
                            'placeholder' => '', 
                            'value' => $galleryImage->file_name
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-responsive-gallery::partials.textarea-plain', [
                            'title' =>  'Description',
                            'name' => 'description',
                            'value' => $galleryImage->description
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-responsive-gallery::partials.input', [
                            'title' => 'Alt text',
                            'name' => 'alt',
                            'placeholder' => '', 
                            'value' => $galleryImage->alt
                        ])
                    </div>
                    
                    <div class="col-12">
                        @include('laravel-responsive-gallery::partials.input', [
                            'title' => 'Video link',
                            'name' => 'video_link',
                            'placeholder' => '', 
                            'value' => $galleryImage->video_link
                        ])
                    </div>
                    
                    
                    <div class="col-12">
                        @include('laravel-responsive-gallery::partials.buttons-back-submit', [
                            'route' => 'responsive-gallery.index'  
                        ])
                    </div>
                    
                    
                </div>
                
            </form>
    
    </div>
    
@endsection
