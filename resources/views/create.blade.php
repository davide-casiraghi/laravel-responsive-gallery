@extends('vendor.laravel-responsive-gallery.layout')

@section('content')

    <div class="container">
            <div class="row mb-4">
                <div class="col-12">
                    <h4>Add new photo datas</h4>
                </div>
            </div>

            @include('partials.forms.error-management', [
                  'style' => 'alert-danger',
            ])

            <form action="{{ route('responsive-gallery.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-12">
                        @include('vendor.laravel-responsive-gallery.partials.input', [
                            'title' => 'Image file name',
                            'name' => 'file_name',
                            'placeholder' => '', 
                            'value' => old('file_name')
                        ])
                    </div>
                    <div class="col-12">
                        @include('vendor.laravel-responsive-gallery.partials.textarea-plain', [
                            'title' =>  'Description',
                            'name' => 'description',
                            'value' => old('description')
                        ])
                    </div>
                    <div class="col-12">
                        @include('vendor.laravel-responsive-gallery.partials.input', [
                            'title' => 'Alt text',
                            'name' => 'alt',
                            'placeholder' => '', 
                            'value' => old('alt')
                        ])
                    </div>
                    <div class="col-12">
                        @include('vendor.laravel-responsive-gallery.partials.input', [
                            'title' => 'Video link',
                            'name' => 'video_link',
                            'placeholder' => '', 
                            'value' => old('video_link')
                        ])
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
