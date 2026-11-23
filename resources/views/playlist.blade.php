{{-- VIEW PLAYLIST: tampilan di file ini. Link playlist Spotify diisi di HalamanController.php (method daftarPlaylist) --}}
@extends('layouts.app')

@section('judul', 'Playlist')

@section('konten')
<div class="lebar halaman">
    <div class="panel kotak">
        <h1>Playlist</h1>
        <p class="lead">Lagu favoritku, langsung dari Spotify. Klik Healing atau Gaming untuk ganti playlist.</p>
    </div>

    <div class="panel layanan" data-tabs>
        <aside class="tab-kiri">
            <h3 class="judul-kecil">Pilih playlist</h3>
            <ul role="tablist" aria-label="Pilih playlist">
                @foreach ($playlist as $p)
                    <li>
                        <button type="button" role="tab" class="tab-btn @if($loop->first) aktif @endif"
                                data-tab-target="playlist-{{ $p['id'] }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}"
                                @if(!$loop->first) tabindex="-1" @endif>{{ $p['nama'] }}</button>
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class="tab-isi">
            @foreach ($playlist as $p)
                <div class="panel-tab @if($loop->first) masuk @endif" id="playlist-{{ $p['id'] }}" role="tabpanel" data-tab-panel @if(!$loop->first) hidden @endif>
                    <h2>{{ $p['nama'] }}</h2>
                    <p class="lead-kecil">{{ $p['ket'] }}</p>

                    @if ($p['embed'])
                        <iframe class="spotify" src="{{ $p['embed'] }}" title="{{ $p['judul'] }}"
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                                loading="lazy"></iframe>
                    @else
                        <div class="kosong">
                            <p><strong>Playlist {{ $p['nama'] }} belum diisi.</strong></p>
                            <ol>
                                <li>Buka Spotify, pilih playlist-mu (harus public).</li>
                                <li>Klik titik tiga, lalu Share, lalu Copy link to playlist.</li>
                                <li>Tempel link-nya di kolom <code>'url'</code> pada <code>daftarPlaylist()</code> di HalamanController.php.</li>
                            </ol>
                        </div>
                    @endif
                </div>
            @endforeach
            <p class="catatan">Perlu internet. Kalau belum login Spotify di browser, lagu hanya diputar cuplikan 30 detik.</p>
        </div>
    </div>
</div>
@endsection

@push('skrip')
    <script src="{{ asset('js/tab.js') }}" defer></script>
@endpush
