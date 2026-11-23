{{-- VIEW PLAYLIST: tampilan di file ini. Link playlist Spotify diisi di HalamanController.php (method daftarPlaylist).
     File ini berdiri sendiri: CSS dan JS untuk tab playlist ada di bawah, tidak perlu mengubah style.css atau tab.js. --}}
@extends('layouts.app')

@section('judul', 'Playlist')

@section('konten')
<div class="lebar halaman">
    <div class="panel kotak">
        <h1>Playlist</h1>
        <p class="lead">Lagu favoritku, langsung dari Spotify. Klik nama playlist di kiri untuk berganti.</p>
    </div>

    <div class="panel layanan" id="pl-grup">
        <aside class="tab-kiri">
            <h3 class="judul-kecil">Pilih playlist</h3>
            <ul role="tablist" aria-label="Pilih playlist">
                @foreach ($playlist as $p)
                    <li>
                        <button type="button" role="tab" class="tab-btn pl-tombol @if($loop->first) aktif @endif"
                                data-pl="pl-{{ $loop->index }}"
                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">{{ $p['nama'] }}</button>
                    </li>
                @endforeach
            </ul>
        </aside>

        <div class="tab-isi pl-isi">
            @foreach ($playlist as $p)
                <div class="pl-panel" id="pl-{{ $loop->index }}" role="tabpanel">
                    <h2>{{ $p['nama'] }}</h2>
                    <p class="lead-kecil">{{ $p['ket'] }}</p>

                    @if ($p['embed'])
                        <iframe class="spotify" src="{{ $p['embed'] }}" title="{{ $p['judul'] }}"
                                allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                        <p class="catatan"><a href="{{ $p['url'] }}" target="_blank" rel="noopener">Buka {{ $p['nama'] }} di Spotify</a></p>
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

@verbatim
<style>
    .pl-isi{position:relative}
    /* Panel yang tidak aktif hanya disembunyikan secara visual (bukan display:none),
       supaya iframe Spotify tetap punya ukuran dan termuat dengan benar. */
    .pl-panel.pl-off{position:absolute;left:-9999px;top:0;width:560px;visibility:hidden;pointer-events:none}
    .pl-panel.pl-on{animation:plMuncul .35s ease both}
    .pl-panel iframe.spotify{display:block;width:100%;height:380px;border:0;border-radius:14px}
    @keyframes plMuncul{from{opacity:0}to{opacity:1}}
</style>
<script>
(function () {
    var grup = document.getElementById('pl-grup');
    if (!grup) return;
    var tombol = Array.prototype.slice.call(grup.querySelectorAll('.pl-tombol'));
    var panel  = Array.prototype.slice.call(grup.querySelectorAll('.pl-panel'));

    function pilih(btn) {
        tombol.forEach(function (b) {
            var aktif = (b === btn);
            b.classList.toggle('aktif', aktif);
            b.setAttribute('aria-selected', aktif ? 'true' : 'false');
        });
        panel.forEach(function (p) {
            var tampil = (p.id === btn.getAttribute('data-pl'));
            p.classList.toggle('pl-off', !tampil);
            p.classList.toggle('pl-on', tampil);
        });
    }

    tombol.forEach(function (b) {
        b.addEventListener('click', function () { pilih(b); });
    });

    // Tampilkan playlist pertama. Kalau JS gagal, semua panel tetap terlihat (tidak ada yang hilang).
    if (tombol.length) pilih(tombol[0]);
})();
</script>
@endverbatim
@endsection