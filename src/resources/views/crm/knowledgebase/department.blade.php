@extends('layouts.home')
@section('title', __('theme.knowledge_base'))

@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset(env('APP_URL').'/css/custom.css') }}">
@endsection
@section('content')

<section id="kb-welcome">
    <div class="container" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000">
        <div class="text-white">
            <h2 align="center">{{ $gs->header_title }}</h2>
            <p align="center">{{ $gs->header_subtitle }}</p>
        </div>
    </div>

    <div class="container pb-5" data-aos="fade-down" data-aos-offset="200" data-aos-delay="20" data-aos-duration="1000">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8">
                <form id="btnSearch" class="card card-sm">
                    <div class="card-body row no-gutters align-items-center">
                        <!--end of col-->
                        <div class="col">
                            <input class="form-control form-control-lg form-control-borderless" type="search" name="search" placeholder="{{ __('theme.search_topics_keywords') }}">
                        </div>
                        <!--end of col-->
                        <div class="col-auto pl-1">
                            <button class="btn btn-lg btn-success theme-btn" type="submit">{{ __('theme.search') }}</button>
                        </div>
                        <!--end of col-->
                    </div>
                </form>
            </div>
            <!--end of col-->
        </div>
    </div>
</section>

<div class="text-center bg-light">
    <div class="p-5">
        <h2 class="text-nb">{{ __('theme.still_need_support') }}
            <a class="btn btn-primary" href="{{ route('submit-new-ticket.create') }}">
                <i class="fa fa-ticket"></i> {{ __('theme.open_ticket') }}
            </a>
        </h2>
    </div>
</div>

<div class="app-content p-t-15">            
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <div class="" id="showSearch">

                    <!-- Pinned Articles -->
                    @widget('pinnedArticles')

                    <div class="row">
                        <div class="col-md-4 mt-4">
                            <h3 class="art-box-title text-nb">{{ __('theme.recent_articles') }}</h3>
                            <div class="art-box-content">
                                <ul class="art-kn-list">
                                    @foreach($posts as $post)
                                    <li class="">
                                        <a class=" " href="{{ route('Knowledge.viewArticle',$post->id) }}">
                                            <i class="fa fa-file-text-o"></i> {{ $post->title }}
                                            <span class="view-counter pull-right">
                                                <i class="fa fa-eye"></i> {{ $post->view_count }}
                                            </span>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>

                        <!-- popular articles 10-->
                        @widget('popularArticles')

                        <!-- Most Helpful Articles 10-->
                        @widget('mostHelpfulArticles')

                        <!-- category -->
                        @widget('categoryCard')

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="pt-5 bg-light">

    @include('tickets.needSupport')
</div>
@endsection