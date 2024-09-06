<div class="col-md-4 mt-4">
   <h3 class="art-box-title text-nb">{{ __('theme.popular_articles') }}</h3>
       <div class="art-box-content">
        <ul class="art-kn-list">
            @foreach($posts as $post)
            <li class="">
                <a class=" " href="{{ route('Knowledge.viewArticle', $post->id) }}">
                    <i class="fa fa-file-text-o"></i>
                    {{ $post->title }}
                    <span class="view-counter pull-right">
                        <i class="fa fa-eye"></i> {{ $post->view_count }}
                    </span>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
</div>