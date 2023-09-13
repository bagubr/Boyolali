@extends('layouts')

@push('css')

{{-- <style>
    body, html, #app{
        margin:0;
        width: 100%;
        height: 100%;
    }
    #app {
        overflow: hidden;
        touch-action: pan-up;
        color: #ffffff;
        text-align: center;
        text-shadow: 0 0 5px #ffffff, 0 0 20px 30px #000;
    }
</style> --}}
    
@endpush

@section('content')
    {{-- <div id="app">
        <div id="hero">

        </div>
    </div> --}}
    <!-- ======= Services Section ======= -->
    <section id="services" class="services section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Layanan</h2>
                <p>{{ config('app.name') }}</p>
            </div>

            <div class="row">

                @foreach (\App\Models\MenuApplication::where('slug', 'users')->get() as $item)
                    <a href="{{ url($item->url) }}">
                        <div class="col-xl-3 col-md-6 d-flex align-items-stretch mt-4 mt-xl-0" data-aos="zoom-in"
                            data-aos-delay="400">
                            <div class="icon-box">
                                <div class="icon">
                                    <img src="{{ asset('uploads/' . $item->file) }}" width="200px" alt="">
                                </div>
                                <h4><a href="{{ url($item->url) }}">{{ $item->title }}</a></h4>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

        </div>
    </section><!-- End Services Section -->
@endsection

@push('js')
{{-- <script>
    import {} from 'https://unpkg.com/threejs-toys@0.0.8/build/threejs-toys.module.cdn.'
</script> --}}
@endpush
