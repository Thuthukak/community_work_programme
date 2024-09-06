<div class="row m-b-15">
    <div class="col-md-12 art-box m-b-0">
        <h3 class="art-box-title text-nb">{{ __('theme.pinned_articles') }}</h3>
    </div>
    @foreach($posts as $post)
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
    @endforeach
</div>