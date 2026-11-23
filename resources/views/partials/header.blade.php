@php
    // MENU: tambah/ubah menu di sini. Tiap menu mengarah ke nama route di routes/web.php
    $menu = [
        ['label' => 'Home',      'route' => 'home'],
        ['label' => 'Data Diri', 'route' => 'data-diri'],
        ['label' => 'Galeri',    'route' => 'galeri'],
        ['label' => 'Playlist',  'route' => 'playlist'],
        ['label' => 'Teman',     'route' => 'teman'],
    ];
@endphp
<header class="header">
    <div class="lebar">
        <a class="logo" href="{{ route('home') }}">
            <span class="logo-nama">{{ $nama }}</span>
        </a>
        <p class="sambutan"><span aria-hidden="true">&#9664;</span> selamat datang di website {{ $nama }} <span aria-hidden="true">&#9654;</span></p>

        <nav class="panel navbar" aria-label="Menu utama">
            <ul class="menu">
                @foreach ($menu as $m)
                    <li>
                        <a href="{{ route($m['route']) }}" @class(['aktif' => request()->routeIs($m['route'])])>{{ $m['label'] }}</a>
                    </li>
                @endforeach
            </ul>
            <a class="ig-pil" href="https://www.instagram.com/{{ $instagram }}/" target="_blank" rel="noopener">&#64;{{ $instagram }}</a>
        </nav>
    </div>
</header>
