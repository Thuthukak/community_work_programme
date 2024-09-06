<div class="row m-b-15">
    <div class="col-md-12 art-box m-b-0">
        <h4 class="art-box-title">{{ __('theme.search') }} <span class="text-info">{{ $search }}</span></h4>
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
    <div class="container h-100 bg-light mt-4">
      <div class="row h-100 justify-content-center align-items-center">
        <h5>{{ __('theme.post_not_found') }}</h5>
      </div>
    </div>
    @endforelse
</div>

<!-- category -->
@widget('categoryCard')