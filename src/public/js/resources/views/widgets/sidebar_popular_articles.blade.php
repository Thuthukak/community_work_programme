<div class="card mb-5">
	<div class="card-header text-nb"> {{ __('theme.popular_knowledge') }}</div>
	<div class="card-body p-0">
		<ul class="kn-list ctg-list">
			@foreach($posts as $post)    	    
      		<li class=" p-10  ">
	      	    <h5 class="m-0">    			
	      	    	<a href="{{ route('Knowledge.viewArticle', $post->id) }}">
		      	     <i class="fa fa-angle-double-right"></i> {{ $post->title }}
		      	     <span class="pull-right">( <i class="fa fa-eye"></i> {{ $post->view_count }} )</span>
		      	 	</a>
	      	    </h5>    
      	    </li>
      	    @endforeach
      	</ul>
  	</div>
</div>