<section id="bg-count" class="parallax-section small-par ppb">
    <div class="bg par-elem " data-bg="{{ asset('/images/bg/counter.jpg') }}" data-scrollax="properties: { translateY: '30%' }" style="background-image: url({{ asset('/images/bg/counter.jpg') }}); transform: translateZ(0px) translateY(-7.77057%);"></div>
    <div class="overlay  op7"></div>
    <div class="container">
        <div class=" single-facts single-facts_2 fl-wrap">
            <!-- inline-facts -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num">
                                <span class="counter-value" data-count="{{ $gs->ticket_counter }}"></span>
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <h6>{{ __('theme.total_tickets') }}</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num">
                                <span class="counter-value" data-count="{{ $gs->ticket_solved }}"></span>
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <h6>{{ __('theme.ticket_solved') }}</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num">
                                <span class="counter-value" data-count="{{ $gs->kb_counter }}"></span>
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <h6>{{ __('theme.knowledge_base') }}</h6>
                </div>
            </div>
            <!-- inline-facts end -->
            <!-- inline-facts  -->
            <div class="inline-facts-wrap">
                <div class="inline-facts">
                    <div class="milestone-counter">
                        <div class="stats animaper">
                            <div class="num">
                                <span class="counter-value" data-count="{{ $gs->client_counter }}"></span>
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <h6>{{ __('theme.happy_clients') }}</h6>
                </div>
            </div>
            <!-- inline-facts end -->
        </div>
    </div>
</section>