{{-- VIEW HOME: edit tampilan halaman utama di file ini. Isi teks/variabel diedit di HalamanController.php (method home) --}}
@extends('layouts.app')

@section('judul', 'Home')

@section('konten')
{{-- PANEL 1: Perkenalan (profil singkat + foto) --}}
<section class="lebar">
    <div class="panel hero">
        <div class="hero-teks">
            <h1>{{ $nama }}</h1>
            <p class="peran">{{ $peran }}</p>
            <p class="lead">{{ $sapaan }}</p>
            <p>{{ $deskripsi }}</p>
            <p class="aksi">
                <a class="pil emas" href="{{ route('data-diri') }}">Lihat data diri</a>
                <a class="pil" href="{{ route('galeri') }}">Buka galeri</a>
            </p>
        </div>

        <figure class="bingkai">
            {{-- FOTO PROFIL: ganti file di public/images (atau ubah $fotoProfil di controller) --}}
            <img src="{{ asset($fotoProfil) }}" alt="Foto {{ $nama }}">
        </figure>

        <div class="titik" aria-hidden="true"><span></span><span></span><span></span><span class="on"></span></div>
    </div>
</section>

{{-- PANEL 2: Hobi. Klik nama hobi di kiri, isi di kanan berganti dengan animasi (js/tab.js) --}}
<section class="lebar grid2" id="hobi" data-tabs>
    <aside class="panel samping">
        <h3 class="judul-kecil">Hobi saya</h3>
        <ul class="daftar" role="tablist" aria-label="Pilih hobi">
            @foreach ($hobi as $h)
                <li>
                    <button type="button" role="tab" class="tab-btn @if($loop->first) aktif @endif"
                            data-tab-target="hobi-{{ $loop->index }}"
                            aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                            @if(!$loop->first) tabindex="-1" @endif>{{ $h['nama'] }}</button>
                </li>
            @endforeach
        </ul>
        <a class="pil emas" href="{{ route('data-diri') }}">Data diri</a>
    </aside>

    <div class="panel utama">
        <h2>Tentang hobi</h2>
        @foreach ($hobi as $h)
            <div class="panel-tab @if($loop->first) masuk @endif" id="hobi-{{ $loop->index }}" role="tabpanel" data-tab-panel @if(!$loop->first) hidden @endif>
                <h3>{{ $h['nama'] }}</h3>
                <p>{{ $h['isi'] }}</p>
                <div class="hobi-foto">
                    @foreach ($h['gambar'] as $g)
                        <img src="{{ asset('images/' . $g['file']) }}" alt="{{ $g['judul'] }}" title="{{ $g['judul'] }}" @class(['logo' => !empty($g['logo'])]) loading="lazy">
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</section>

<div class="lebar meta">
    <span><b>Status:</b> {{ $peran }}</span>
    <span><b>Instagram:</b> &#64;{{ $instagram }}</span>
    <a class="pil kecil" href="{{ route('data-diri') }}">selengkapnya</a>
</div>

{{-- PANEL 3: Galeri. Klik nama album di kiri, cuplikan foto di kanan berganti dengan animasi --}}
<section class="lebar">
    <div class="panel layanan" data-tabs>
        <aside class="tab-kiri">
            <h3 class="judul-kecil">Album</h3>
            <ul role="tablist" aria-label="Pilih album">
                @foreach ($album as $a)
                    <li>
                        <button type="button" role="tab" class="tab-btn @if($loop->first) aktif @endif"
                                data-tab-target="album-{{ $loop->index }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                @if(!$loop->first) tabindex="-1" @endif>{{ $a['judul'] }}</button>
                    </li>
                @endforeach
            </ul>
        </aside>
        <div class="tab-isi">
            <h2>Galeri foto</h2>
            @foreach ($album as $a)
                <div class="panel-tab @if($loop->first) masuk @endif" id="album-{{ $loop->index }}" role="tabpanel" data-tab-panel @if(!$loop->first) hidden @endif>
                    <p class="lead-kecil">{{ $a['ket'] }}</p>
                    <div class="cuplikan">
                        @foreach ($a['foto'] as $f)
                            <a href="{{ route('galeri') }}#{{ $a['id'] }}">
                                <img src="{{ asset('images/galeri/' . $f['file']) }}" alt="{{ $f['judul'] }}" title="{{ $f['judul'] }}" loading="lazy">
                            </a>
                        @endforeach
                    </div>
                    <a class="pil emas" href="{{ route('galeri') }}#{{ $a['id'] }}">Buka album {{ $a['judul'] }}</a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- PANEL 4: Film & serial favorit --}}
<section class="lebar" id="film">
    <h2 class="judul-bagian">Film &amp; Serial Favorit</h2>
    <div class="hobi-grid">
        @foreach ($film as $f)
            <article class="panel hobi anggota">
                <h3>{{ $f['judul'] }}</h3>
                <p><b>{{ $f['jenis'] }}</b> &middot; {{ $f['asal'] }}</p>
                <p>{{ $f['genre'] }}</p>
            </article>
        @endforeach
    </div>
</section>
@endsection

@push('skrip')
    <script src="{{ asset('js/tab.js') }}" defer></script>
@endpush
