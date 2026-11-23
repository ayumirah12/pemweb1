<footer class="footer">
    <div class="lebar footer-isi">
        <div class="footer-merek">
            <span class="logo-nama">{{ $nama }}</span>
        </div>

        <div class="footer-kolom">
            <h4>Home</h4>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('home') }}#hobi">Hobi</a>
        </div>
        <div class="footer-kolom">
            <h4>Profil</h4>
            <a href="{{ route('data-diri') }}">Data Diri</a>
            <a href="{{ route('galeri') }}">Galeri</a>
            <a href="{{ route('playlist') }}">Playlist</a>
            <a href="{{ route('teman') }}">Teman</a>
        </div>
        <div class="footer-kolom">
            <h4>Contact</h4>
            <a href="https://www.instagram.com/{{ $instagram }}/" target="_blank" rel="noopener">Instagram &#64;{{ $instagram }}</a>
        </div>
    </div>
    <p class="lebar hak">&copy; {{ date('Y') }} {{ $nama }}. Dibuat dengan Laravel 12.</p>
</footer>
