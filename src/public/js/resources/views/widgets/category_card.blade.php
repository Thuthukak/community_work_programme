<section class="mt-5">
    <div class="container">
        <div class="row">
            @foreach($categories as $category)
            <div class="col-lg-4">
                <a href="{{ route('Knowledge.categoryPost', $category) }}">
                <div class="wrap">
                    <div class="ico-wrap">
                        <span class="mbr-iconfont fa-list fa"></span>
                    </div>
                    <div class="text-wrap vcenter">
                        <h2 class="mb-0 mbr-fonts-style mbr-bold mbr-section-title3 display-5 fs1em text-nb">{{ $category->title }}</h2>
                        <p class="mb-0 mbr-fonts-style text1 mbr-text display-6 fs75em">{{ Str::limit($category->description, 35) }}</p>
                    </div>
                </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>