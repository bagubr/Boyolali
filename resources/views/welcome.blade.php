@extends('layouts')

@section('content')
    <!-- ======= Team Section ======= -->
    <section id="team" class="team section-bg">
        <div class="container" data-aos="fade-up">

            <div class="section-title">
                <h2>Dinas Pekerjaan Umum dan Penataan Ruang (DPUPR) <br> Kab. Boyolali</h2>
            </div>

            <div class="row">
                @foreach (\App\Models\MenuApplication::where('slug', 'admin')->get() as $item)
                    <div class="col-lg-4" style="height:200px; width: 200px" data-aos="zoom-in" data-aos-delay="100">
                        <a href="{{ $item->url }}">
                            <div class="p-10 member d-flex align-items-start">
                                <div class="member-info p-0"><img src="{{ asset('uploads/' . $item->file) }}"
                                        class="img-fluid" alt="">
                                    <center>
                                        <h4>{{ $item->title }}</h4>
                                    </center>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </section><!-- End Team Section -->
@endsection
