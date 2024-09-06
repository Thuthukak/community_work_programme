@extends('layouts.master')
@section('title', $post->title)
@section('style')
    <link rel="stylesheet" type="text/css" media="screen" href="{{ asset($publicPath.'/css/custom.css') }}">
@endsection

@section('content')

<div class="container mt-5" id="kbv">
	<!-- breadcrumb -->
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb">
		    <li class="breadcrumb-item">
		    	<a href="{{ route('KnowledgeBaseIndex') }}"> <i class="fa fa-graduation-cap"></i> {{ __('theme.knowledge_base') }}</a>
		    </li>
		    <li class="breadcrumb-item active" aria-current="page">
		    	<i class="fa fa-angle-double-right"></i>
		   		{{ $post->title }}
		   	</li>
		</ol>
	</nav>
	@if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
	<!-- end breadcrumb -->
	<div class="row">
       <div class="col-md-12 col-sm-12">
			<div class="row">
				<div class="col-md-8">
					<div class="card mb-3">
						<div class="card-header">
							<div class="row"> 
								<div class="col-md-12">
									<h1 class="m-0">
										{{ $post->title}}
										<span class="kn-like pull-right">
											<span class="text-success">
												<i class="fa fa-thumbs-up "></i>
												<span class="kn-like-counter-3">{{ $post->satisfied_vote_count }}</span>
											</span>
											<span class="text-danger">
												<i class="fa fa-thumbs-down"></i>
												<span class="kn-dislike-counter-3">{{ $post->dis_satisfied_vote_count }}</span>
											</span>
										</span>
									</h1>
								</div>
								<div class="kn-details post-details col-md-12">
									<div class="row">
										<div class="col-md-9 col-sm-8">{{ __('theme.last_updated_on') }} {{ date('M d Y', strtotime($post->created_at)) }}</div>
										<div class="col-md-3 col-sm-4 text-right author-detail">
											{{ __('theme.posted_by') }} <a href="javascript:void(0)" class="popupform author-name apopf">{{ $post->user->name }}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
									  
					  	<div class="card-body kn-details-container">

				      	   {!! clean($post->content) !!}
					  		
				      	</div>

		  			  	<div class="card-footer text-muted">
						  	<div class="row">
						  		<div class="col-md-8">
						  			<span class="app-helpful-msg" id="ld-msg-3">{{ __('theme.is_it_helpful') }}</span>
						  			@php
					  					$yesKey = false;
						  				$noKey = false;

						  				if(session('vote_yes')){
											$voteYes = session('vote_yes');
							  				$yesKey = array_search('yes_'.$post->id,$voteYes);
						  				}
						  				if(session('vote_no')){
							  				$voteNo = session('vote_no');
							  				$noKey = array_search('no_'.$post->id,$voteNo);
						  				}
						  			@endphp
						  			
						  			@if(!is_numeric($yesKey))
						  			<form method="post" action="{{ route('KBvoteYes',$post->id )}}" class="d-inline">
						  				@csrf
						  				<input type="hidden" name="satisfaction" value="yes">
						  				<button class="kn-like-btn btn btn-xs btn-success added-ripples">
					  						<i class="fa fa-thumbs-up "></i>
					  					</button>
						  			</form>
						  			@endif
						  			@if(!is_numeric($noKey))
				  					<form method="post" action="{{ route('KBvoteYes',$post->id )}}" class="d-inline">
						  				@csrf
						  				<input type="hidden" name="disatisfaction" value="no">
					  					<button class="kn-dislike-btn btn btn-xs btn-danger added-ripples">
					  						<i class="fa fa-thumbs-down"></i>
					  					</button>
				  					</form>
				  					@endif
						  		</div>
						  		<div class="col-md-4 text-right">
						  			<span class="view-count"> {{ __('theme.views') }}: {{ $post->view_count }}</span>
						  		</div>
						  	</div>
					  	</div>
			 		</div>
				</div>

				<div class="col-md-4 md-p-l-0">
					<!-- categories -->
					@widget('categories')

					<!-- sidebar popular articles -->
					@widget('sidebarPopularArticles')

				</div>
			</div>
		</div>
	</div>
</div>

@endsection