<div class="card mb-3">
	<div class="card-header text-nb">{{ __('theme.categories') }}</div>
  	<div class="card-body p-0">
  		<ul class="kn-list ctg-list">
  			@foreach($categories as $category)
      	    <li class="p-10">
	      	    <h5 class="m-0">    			
		      	    <a href="{{ route('Knowledge.categoryPost',$category->id) }}">
		      	    <i class="fa fa-angle-double-right"></i> {{ $category->title }}
		      	    <span class="pull-right">( <i class="fa fa-file-text-o"></i> {{ $category->knowledgeBase->count()}} )</span>
		      	    </a>   				
	      	    </h5>		      	    
      	    </li>
      	    @endforeach
      	</ul>	
  	</div>
</div>