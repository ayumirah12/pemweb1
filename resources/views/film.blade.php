{{-- VIEW FILM FAVORIT: tampilan di file ini. Daftar film diedit di HalamanController.php (method daftarFilm) --}}
@extends('layouts.app')

@section('judul', 'Film Favorit')

@section('konten')
<div class="lebar halaman">
    <div class="panel kotak">
        <h1>Film Favorit</h1>
        <p class="lead">Klik film untuk menonton trailernya, lalu tonton filmnya lewat platform resmi.</p>
    </div>

    <div class="film-grid">
        @foreach ($film as $f)
            <button type="button" class="panel kartu-film" data-modal="fm-{{ $loop->index }}"
                    aria-haspopup="dialog" aria-label="Buka film {{ $f['judul'] }}">
                @if (!empty($f['poster']))
                    <img src="{{ asset('images/film/' . $f['poster']) }}" alt="Poster {{ $f['judul'] }}" loading="lazy">
                @else
                    <span class="foto-kosong poster" aria-hidden="true">{{ strtoupper(substr($f['judul'], 0, 1)) }}</span>
                @endif
                <h3>{{ $f['judul'] }}</h3>
                <p class="hub-teman">{{ $f['tahun'] }} &middot; {{ $f['genre'] }}</p>
                <p class="bintang" role="img" aria-label="Rating {{ $f['rating'] }} dari 5">
                    @for ($i = 1; $i <= 5; $i++){!! $i <= $f['rating'] ? '&#9733;' : '&#9734;' !!}@endfor
                </p>
                <span class="ikon-lagu" aria-hidden="true">&#9654; Putar trailer</span>
            </button>
        @endforeach
    </div>
</div>

{{-- Satu pop-up per film. YouTube baru dimuat saat pop-up dibuka dan dihentikan saat ditutup. --}}
@foreach ($film as $f)
    @php($mid = 'fm-' . $loop->index)
    <div class="tm-modal" id="{{ $mid }}" role="dialog" aria-modal="true" aria-labelledby="{{ $mid }}-judul" hidden>
        <div class="tm-kartu panel fm-kartu">
            <button type="button" class="tm-tutup" aria-label="Tutup">&times;</button>

            <h2 id="{{ $mid }}-judul">{{ $f['judul'] }}</h2>
            <p class="lead-kecil">{{ $f['tahun'] }} &middot; {{ $f['genre'] }}
                <span class="bintang" aria-label="Rating {{ $f['rating'] }} dari 5">@for ($i = 1; $i <= 5; $i++){!! $i <= $f['rating'] ? '&#9733;' : '&#9734;' !!}@endfor</span>
            </p>

            @if ($f['embed'])
                <div class="fm-video">
                    <iframe class="fm-embed" data-src="{{ $f['embed'] }}" title="Trailer {{ $f['judul'] }}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; fullscreen"
                            allowfullscreen></iframe>
                </div>
            @else
                <div class="kosong">
                    <p><strong>Trailer belum diisi.</strong></p>
                    <p>Isi kolom <code>'trailer'</code> film ini di <code>daftarFilm()</code> pada HalamanController.php dengan link YouTube.</p>
                </div>
            @endif

            <blockquote class="tm-alasan">{{ $f['alasan'] }}</blockquote>

            @if (!empty($f['tonton']))
                <a class="pil emas" href="{{ $f['tonton'] }}" target="_blank" rel="noopener">&#9654; Tonton di {{ $f['platform'] ?: 'platform resmi' }}</a>
            @endif
        </div>
    </div>
@endforeach
@endsection

@push('skrip')
    <script src="{{ asset('js/film.js') }}" defer></script>
@endpush
