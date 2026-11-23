<?php

namespace App\Http\Controllers;

class HalamanController extends Controller
{
    // Nama singkat yang tampil di header, footer, dan judul Home.
    private string $nama = 'Mirah Dhinata';

    // Username Instagram (tanpa @). Dipakai di Home, Data Diri, dan footer.
    private string $instagram = '0nlymirah';

    // Foto profil (file ada di public/images). Ganti file-nya atau ubah nama file di sini.
    private string $fotoProfil = 'images/profil.jpg';

    // GANTI daftar hobi ini dengan hobi kamu. Tambah atau hapus baris sesukamu.
    // 'gambar' = foto yang tampil di bawah hobi (path relatif terhadap public/images/).
    // Untuk logo game asli: taruh file logo (png/jpg) di public/images/hobi/ lalu ganti nama file-nya di sini.
    private function daftarHobi(): array
    {
        return [
            [
                'nama'   => 'Healing',
                'isi'    => 'Menjelajah alam dan mendaki gunung untuk menenangkan pikiran.',
                'gambar' => [
                    ['file' => 'galeri/mendaki/foto1.jpg', 'judul' => 'Menatap pegunungan'],
                    ['file' => 'galeri/mendaki/foto3.jpg', 'judul' => 'Di puncak Batur'],
                    ['file' => 'galeri/mendaki/foto2.jpg', 'judul' => 'Papan Mt. Batur 1717 mdpl'],
                ],
            ],
            [
                'nama'   => 'Gaming',
                'isi'    => 'Bermain Mobile Legends dan Free Fire untuk bersantai dan melepas penat.',
                'gambar' => [
                    ['file' => 'hobi/mobile-legends.png', 'judul' => 'Mobile Legends', 'logo' => true],
                    ['file' => 'hobi/free-fire.png',      'judul' => 'Free Fire',      'logo' => true],
                ],
            ],
        ];
    }

    // FILM & SERIAL FAVORIT. Tambah/hapus baris sesukamu.
    // 'jenis' = Film / Serial / Anime, 'asal' = negara, 'genre' = genre singkat.
    private function daftarFilm(): array
    {
        return [
            ['judul' => 'Alice in Borderland', 'jenis' => 'Serial',  'asal' => 'Jepang',      'genre' => 'Thriller, survival game'],
            ['judul' => 'Jujutsu Kaisen',      'jenis' => 'Anime',   'asal' => 'Jepang',      'genre' => 'Aksi, supernatural'],
            ['judul' => 'Sweet Home',          'jenis' => 'Serial',  'asal' => 'Korea Selatan', 'genre' => 'Horor, monster'],
            ['judul' => 'Train to Busan',      'jenis' => 'Film',    'asal' => 'Korea Selatan', 'genre' => 'Zombie, thriller'],
            ['judul' => 'World War Z',         'jenis' => 'Film',    'asal' => 'Amerika Serikat', 'genre' => 'Zombie, aksi'],
        ];
    }

    // DAFTAR TEMAN.
    // 'ig'       = username Instagram tanpa @ (boleh kosong '').
    // 'playlist' = link playlist temanmu: Spotify, Apple Music, atau YouTube Music (harus PUBLIC). Kosongkan ('') kalau belum ada.
    // 'posisi'   = (opsional) fokus potongan foto kotak, mis. '15%' kalau wajah ada di atas foto.
    // FOTO: taruh file public/images/teman/<nama-huruf-kecil>.jpg / .jpeg / .png / .webp (contoh: selza.jpeg).
    //       Kalau fotonya belum ada, otomatis dipakai gambar inisial (.svg).
    private function daftarTeman(): array
    {
        $data = [
            ['nama' => 'Selza', 'ig' => '', 'playlist' => 'https://open.spotify.com/playlist/4JZVQn1JFZUMwQADXR7AbL?si=00e643da933e49bc', 'posisi' => '15%'],
            ['nama' => 'Angel', 'ig' => '', 'playlist' => 'https://music.youtube.com/playlist?list=PLZGldZN7Hlo0hsnce_COX0-RTl89GkqqS'],
            ['nama' => 'Messi', 'ig' => '', 'playlist' => 'https://music.apple.com/id/playlist/night/pl.u-GgA5kZRioW8r7xG', 'posisi' => '40%'],
            ['nama' => 'Naya', 'ig' => '', 'playlist' => 'https://open.spotify.com/playlist/7mfi9pwf8oqoU3zhD1pRBK?si=rOTxPr_MR0WhnU9qRhqVEA&utm_source=whatsapp', 'posisi' => '45%'],
            ['nama' => 'Divtria', 'ig' => '', 'playlist' => ''],
            ['nama' => 'Sintya', 'ig' => '', 'playlist' => ''],
            ['nama' => 'Daniaz', 'ig' => '', 'playlist' => ''],
            ['nama' => 'Justine', 'ig' => '', 'playlist' => 'https://open.spotify.com/playlist/7e7P8G6nQklyL5Y11Jctge?si=20db6ccd44814bec', 'posisi' => '60%'],
            ['nama' => 'Yoga', 'ig' => '', 'playlist' => ''],
            ['nama' => 'Dewa', 'ig' => '', 'playlist' => ''],
            ['nama' => 'Wotu', 'ig' => '', 'playlist' => ''],
        ];

        return array_map(function ($t) {
            $slug = strtolower($t['nama']);
            // Cari foto asli dengan beberapa ekstensi; kalau tidak ada, pakai gambar inisial (.svg)
            $foto = 'teman/' . $slug . '.svg';
            foreach (['jpg', 'jpeg', 'png', 'webp', 'JPG', 'JPEG', 'PNG'] as $ext) {
                if (file_exists(public_path('images/teman/' . $slug . '.' . $ext))) {
                    $foto = 'teman/' . $slug . '.' . $ext;
                    break;
                }
            }
            $t['id']       = $slug;
            $t['peran']    = $t['peran'] ?? 'Teman';
            $t['foto']     = $foto;
            $t['posisi']   = $t['posisi'] ?? '35%'; // geser fokus foto: 0% = atas, 100% = bawah
            $t['embed']    = $t['playlist'] !== '' ? $this->embedSpotify($t['playlist']) : null;
            return $t;
        }, $data);
    }

    // Album galeri. File foto ada di public/images/galeri/<nama-folder>/
    // Tambah foto: taruh file di folder album, lalu tambah satu baris ['file' => ..., 'judul' => ...].
    private function daftarAlbum(): array
    {
        return [
            [
                'id'    => 'mendaki',
                'judul' => 'Mendaki',
                'ket'   => 'Langit biru, jalur tanah, dan pemandangan dari Gunung Batur.',
                'foto'  => [
                    ['file' => 'mendaki/foto1.jpg', 'judul' => 'Menatap pegunungan'],
                    ['file' => 'mendaki/foto2.jpg', 'judul' => 'Papan Mt. Batur 1717 mdpl'],
                    ['file' => 'mendaki/foto3.jpg', 'judul' => 'Di puncak Batur'],
                    ['file' => 'mendaki/foto4.jpg', 'judul' => 'Langit sebelum matahari terbit'],
                ],
            ],
            [
                'id'    => 'nongkrong',
                'judul' => 'Nongkrong',
                'ket'   => 'Kopi, obrolan panjang, dan tempat favorit.',
                'foto'  => [
                    ['file' => 'nongkrong/foto1.jpg', 'judul' => 'Pastry, matcha, dan photobooth'],
                ],
            ],
            [
                'id'    => 'teman',
                'judul' => 'Me n My Friends',
                'ket'   => 'Orang-orang yang bikin hari-hariku lebih seru.',
                'foto'  => [
                    ['file' => 'teman/foto1.jpg', 'judul' => 'Mirror selfie bertiga'],
                    ['file' => 'teman/foto2.jpg', 'judul' => 'Mirror selfie berempat'],
                ],
            ],
        ];
    }

    // PLAYLIST SPOTIFY. Isi 'url' dengan link playlist Spotify-mu (harus PUBLIC).
    // Cara ambil link: Spotify > buka playlist > titik tiga (...) > Share > Copy link to playlist.
    // Boleh juga link album / lagu. Kosongkan ('') kalau belum punya, nanti tampil petunjuk.
    private function daftarPlaylist(): array
    {
        return [
            [
                'id'    => 'Riding',
                'nama'  => 'Riding',
                'ket'   => 'Riding',
                'judul' => 'Riding PLAYLIST',
                'url'   => 'https://open.spotify.com/playlist/2lrYETfOCZ4iYiMxgiAilU?si=3bee37a7120742a5',
            ],
            [
                'id'    => 'Hindia',
                'nama'  => 'Hindia',
                'ket'   => 'Hindia',
                'judul' => 'Hindia PLAYLIST',
                'url'   => 'https://open.spotify.com/playlist/25hLKJ0mV5OMSYfWUNuPtX?si=9e9611ba20274644',
            ],
        ];
    }

    // Ubah link playlist jadi link embed. Diterima: Spotify, Apple Music, YouTube / YouTube Music.
    private function embedSpotify(string $url): ?string
    {
        // Spotify
        if (preg_match('#open\.spotify\.com/(?:intl-[a-z-]+/)?(playlist|album|track|artist|show|episode)/([A-Za-z0-9]+)#', $url, $m)) {
            return 'https://open.spotify.com/embed/' . $m[1] . '/' . $m[2] . '?utm_source=generator';
        }
        // Apple Music (link music.apple.com/... jadi embed.music.apple.com/...)
        if (preg_match('#^https://music\.apple\.com/([^?\s]+)#', $url, $m)) {
            return 'https://embed.music.apple.com/' . $m[1];
        }
        // YouTube / YouTube Music playlist (ambil parameter list=...)
        if (preg_match('#^https://(?:music|www)\.youtube\.com/.*[?&]list=([A-Za-z0-9_-]+)#', $url, $m)) {
            return 'https://www.youtube.com/embed/videoseries?list=' . $m[1];
        }
        return null;
    }

    // ===== HALAMAN 1: HOME (memakai VARIABEL) =====
    public function home()
    {
        $nama       = $this->nama;
        $instagram  = $this->instagram;
        $fotoProfil = $this->fotoProfil;
        $peran      = 'Mahasiswa INSTIKI';
        $sapaan     = 'Selamat datang di website pribadi saya!';
        $deskripsi  = 'Saya sedang belajar membuat website dengan Laravel 12. Silakan lihat data diri dan galeri foto saya lewat menu di atas.';
        $hobi       = $this->daftarHobi();
        $album      = $this->daftarAlbum();
        $film       = $this->daftarFilm();

        return view('home', compact('nama', 'instagram', 'fotoProfil', 'peran', 'sapaan', 'deskripsi', 'hobi', 'album', 'film'));
    }

    // ===== HALAMAN 2: DATA DIRI (memakai LOOPING WHILE) + HOBI =====
    public function dataDiri()
    {
        $nama      = $this->nama;
        $instagram = $this->instagram;
        $hobi      = $this->daftarHobi();
        $film      = $this->daftarFilm();

        $dataDiri = [
            ['label' => 'Nama lengkap', 'isi' => 'I Gusti Ayu Mirah Dhinata Sukadana'],
            ['label' => 'Tempat, tanggal lahir', 'isi' => 'Denpasar, 29 November 2007'],
            ['label' => 'Alamat', 'isi' => 'Jln. Gunung Batu No. 74'],
            ['label' => 'Pendidikan', 'isi' => 'Institut Bisnis dan Teknologi Indonesia (INSTIKI)'],
            ['label' => 'Hobi', 'isi' => implode(', ', array_column($hobi, 'nama'))],
            ['label' => 'Film favorit', 'isi' => implode(', ', array_column($film, 'judul'))],
            ['label' => 'Email', 'isi' => 'mirahhsukadana@gmail.com'],
            ['label' => 'Instagram', 'isi' => '@' . $instagram, 'link' => 'https://www.instagram.com/' . $instagram . '/'],
        ];

        return view('data-diri', compact('nama', 'instagram', 'dataDiri', 'hobi', 'film'));
    }

    // ===== HALAMAN 3: GALERI FOTO (dipisah per album) =====
    public function galeri()
    {
        $nama      = $this->nama;
        $instagram = $this->instagram;
        $album     = $this->daftarAlbum();

        return view('galeri', compact('nama', 'instagram', 'album'));
    }

    // ===== HALAMAN 4: PLAYLIST SPOTIFY =====
    public function playlist()
    {
        $nama      = $this->nama;
        $instagram = $this->instagram;
        $playlist  = array_map(function ($p) {
            $p['embed'] = $this->embedSpotify($p['url']);
            return $p;
        }, $this->daftarPlaylist());

        return view('playlist', compact('nama', 'instagram', 'playlist'));
    }

    // ===== HALAMAN 5: TEMAN =====
    public function teman()
    {
        $nama      = $this->nama;
        $instagram = $this->instagram;
        $teman     = $this->daftarTeman();

        return view('teman', compact('nama', 'instagram', 'teman'));
    }
}
