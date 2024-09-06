@extends('layouts.master')
@section('title', __('theme.knowledge_base'))
@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/custom.css') }}">
@endsection
@section('content')

<div class="text-center bg-light">
    <div class="p-3">
        <h2>{{ __('theme.still_need_support') }}
            <a class="btn btn-primary" href="{{ route('submit-new-ticket.create') }}">
                <i class="fa fa-ticket"></i> {{ __('theme.open_ticket') }}
            </a>
        </h2>
    </div>
</div>

<div class="">            
    <div class="container mt-4">
        <div class="">
            <div class="col-md-12 col-sm-12">
                <div class="row">
                    <!-- category Articles -->
                    <div class="row m-b-15">
                        <div class="col-md-12 art-box m-b-0">
                            <h5 class="art-box-title">{{ __('theme.category') }}: {{ $category->title }}</h5>
                            <hr>
                        </div>
                        @forelse($posts as $post)
                        <div class="col-md-4 art-box m-b-0">
                            <div class="art-box-content">
                                <ul class="art-kn-list mb-0">
                                    <li class="is-stick">
                                        <a class=" " href="{{ route('Knowledge.viewArticle', $post->id) }}">
                                            <i class="fa fa-file-text-o"></i> {{ $post->title }}
                                            <span class="view-counter pull-right">
                                                <i class="fa fa-eye"></i> {{ $post->view_count }}
                                            </span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @empty
                        <div class="container bg-light my-2">
                          <div class="row justify-content-center align-items-center">
                            <h5>{{ __('theme.post_not_found') }}</h5>
                          </div>
                        </div>
                        @endforelse
                    </div>

                    <div class="text-center mt-4">
                        {{ $posts->links() }}
                    </div>

                    <div class="row">
                        <!-- category -->
                        @widget('categoryCard')

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection