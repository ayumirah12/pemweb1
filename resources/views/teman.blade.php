{{-- VIEW TEMAN: tampilan di file ini. Daftar teman, foto, dan playlist diisi di HalamanController.php (method daftarTeman) --}}
@extends('layouts.app')

@section('judul', 'Teman')

@section('konten')
<div class="lebar halaman">
    <div class="panel kotak">
        <h1>Teman-Temanku</h1>
        <p class="lead">Orang-orang yang bikin hari-hariku lebih seru. Klik nama untuk lihat foto dan playlist masing-masing.</p>
    </div>

    <div class="panel kotak">
        <img src="{{ asset('images/teman/gendok.jpeg') }}" alt="Foto bareng teman-teman" loading="lazy"
             style="display:block;width:100%;max-width:480px;margin:0 auto;border-radius:16px">
    </div>

    <div class="panel layanan" data-tabs>
        <aside class="tab-kiri">
            <h3 class="judul-kecil">Pilih teman</h3>
            <ul role="tablist" aria-label="Pilih teman">
                @foreach ($teman as $t)
                    <li>
                        <button type="button" role="tab" class="tab-btn @if($loop->first) aktif @endif"
                                data-tab-target="teman-{{ $t['id'] }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                @if(!$loop->first) tabindex="-1" @endif>{{ $t['nama'] }}</button>
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class="tab-isi">
            @foreach ($teman as $t)
                <div class="panel-tab @if($loop->first) masuk @endif" id="teman-{{ $t['id'] }}" role="tabpanel" data-tab-panel @if(!$loop->first) hidden @endif>
                    <h2>{{ $t['nama'] }}</h2>
                    <p class="lead-kecil">{{ $t['peran'] }}
                        @if (!empty($t['ig']))
                            &middot; <a href="https://www.instagram.com/{{ $t['ig'] }}/" target="_blank" rel="noopener">&#64;{{ $t['ig'] }}</a>
                        @endif
                    </p>

                    <div class="hobi-foto">
                        <img class="logo" style="width:180px;height:180px;object-position:center {{ $t['posisi'] }}" src="{{ asset('images/' . $t['foto']) }}" alt="Foto {{ $t['nama'] }}" title="{{ $t['nama'] }}" loading="lazy">
                    </div>

                    @if ($t['embed'])
                        <iframe class="spotify" src="{{ $t['embed'] }}" title="Playlist {{ $t['nama'] }}"
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"></iframe>
                    @else
                        <div class="kosong">
                            <p><strong>Playlist {{ $t['nama'] }} belum diisi.</strong></p>
                            <p>Isi link playlist-nya (Spotify / Apple Music / YouTube Music) di kolom <code>'playlist'</code> pada <code>daftarTeman()</code> di HalamanController.php.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('skrip')
    <script src="{{ asset('js/tab.js') }}" defer></script>
@endpush
