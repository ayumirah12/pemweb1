{{-- Pemutar Spotify + teks bergerak. Variabel: $uri, $baris ([[detik, teks], ...]), $judul --}}
<div class="sorot" data-uri="{{ $uri }}" @if(!empty($auto)) data-auto @endif>
    <div class="sorot-player" aria-label="Pemutar {{ $judul }}"></div>
    <ul class="sorot-baris" aria-label="Teks yang bergerak mengikuti lagu {{ $judul }}">
        @foreach ($baris as $b)
            <li data-t="{{ (int) $b[0] }}" tabindex="0" role="button">{{ $b[1] }}</li>
        @endforeach
    </ul>
    <p class="catatan">Putar lagunya, teks akan menyorot mengikuti detiknya. Klik satu baris untuk loncat ke bagian itu.</p>
</div>
