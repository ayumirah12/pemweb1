# Website Laravel 12 - Tema biru kaca (font nama Y2K)

Salin isi folder ini (app, public, resources, routes) ke proyek Laravel 12, timpa file yang sama.

## Mau edit apa, buka file apa

| Yang diedit | File |
|---|---|
| Nama, Instagram, foto profil | app/Http/Controllers/HalamanController.php (properti paling atas) |
| Teks Home (peran, sapaan, deskripsi) | HalamanController.php, method home() |
| Hobi | HalamanController.php, method daftarHobi() |
| Data diri (TTL, alamat, email, dst) | HalamanController.php, method dataDiri() |
| Album, judul & foto galeri | HalamanController.php, method daftarAlbum() |
| File foto galeri | public/images/galeri/<album>/ |
| Foto profil | public/images/profil.jpg |
| Playlist Spotify (link playlist) | HalamanController.php, method daftarPlaylist() |
| Tampilan Playlist | resources/views/playlist.blade.php |
| Tampilan Home | resources/views/home.blade.php |
| Tampilan Data Diri | resources/views/data-diri.blade.php |
| Tampilan Galeri | resources/views/galeri.blade.php |
| Menu atas | resources/views/partials/header.blade.php |
| Footer | resources/views/partials/footer.blade.php |
| Warna, gaya, font nama | public/css/style.css |
| Daftar halaman (route) | routes/web.php |
