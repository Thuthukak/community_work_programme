
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
                                <span class="counter-value" data-count="{{ $gs->ticket_counter }}" >{{ $gs->ticket_counter }}</span>
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
                                <span class="counter-value" data-count="{{ $gs->ticket_solved }}"> {{ $gs->ticket_solved }}</span>
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
                                <span class="counter-value" data-count="{{ $gs->kb_counter }}" >{{ $gs->kb_counter }}</span>
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
                                <span class="counter-value" data-count="{{ $gs->client_counter }}"> {{ $gs->client_counter }}</span>
                                <span>+</span>
                            </div>
                        </div>
                    </div>
                    <h6>{{ __('theme.smart_partners') }}</h6>
                </div>
            </div>
            <!-- inline-facts end -->
        </div>
    </div>
</section>

<!-- add jquery script -->
<script src="{{ asset('/js/jquery.min.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Function to animate the counters
    function animateCounters() {
        const counters = document.querySelectorAll('.counter-value');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const current = +counter.innerText;
                const increment = target / 200; // Adjust the increment speed

                if (current < target) {
                    counter.innerText = Math.ceil(current + increment);
                    setTimeout(updateCount, 10); // Adjust the timing for smoother counting
                } else {
                    counter.innerText = target;
                }
            };

            updateCount();
        });
    }

    // Use IntersectionObserver to trigger the animation when the section enters the viewport
    const section = document.querySelector('#bg-count');
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                animateCounters();
                observer.unobserve(entry.target); // Stop observing after animation is triggered
            }
        });
    }, { threshold: 0.5 }); // Trigger when 50% of the section is visible

    observer.observe(section);
});

</script>