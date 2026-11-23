{{-- VIEW DATA DIRI: edit tampilan di file ini. Isi data (nama, TTL, alamat, dll) diedit di HalamanController.php (method dataDiri) --}}
@extends('layouts.app')

@section('judul', 'Data Diri')

@section('konten')
<div class="lebar halaman">
    <div class="panel kotak">
        <h1>Data Diri</h1>
        <p class="lead">Data diri saya ditampilkan dengan looping while.</p>

        @php
            $i = 0; // nomor awal
        @endphp

        <table class="tabel">
            <tbody>
                @while ($i < count($dataDiri))
                    <tr>
                        <th>{{ $dataDiri[$i]['label'] }}</th>
                        <td>
                            @if (!empty($dataDiri[$i]['link']))
                                <a href="{{ $dataDiri[$i]['link'] }}" target="_blank" rel="noopener">{{ $dataDiri[$i]['isi'] }}</a>
                            @else
                                {{ $dataDiri[$i]['isi'] }}
                            @endif
                        </td>
                    </tr>
                    @php
                        $i++; // naikkan nomor, kalau tidak looping tidak akan berhenti
                    @endphp
                @endwhile
            </tbody>
        </table>
    </div>

    <h2 class="judul-bagian">Hobi</h2>
    <div class="hobi-grid">
        @foreach ($hobi as $h)
            <article class="panel hobi">
                <h3>{{ $h['nama'] }}</h3>
                <p>{{ $h['isi'] }}</p>
                <div class="hobi-foto">
                    @foreach ($h['gambar'] as $g)
                        <img src="{{ asset('images/' . $g['file']) }}" alt="{{ $g['judul'] }}" title="{{ $g['judul'] }}" @class(['logo' => !empty($g['logo'])]) loading="lazy">
                    @endforeach
                </div>
            </article>
        @endforeach
    </div>

    <h2 class="judul-bagian" id="film">Film &amp; Serial Favorit</h2>
    <div class="hobi-grid">
        @foreach ($film as $f)
            <article class="panel hobi anggota">
                <h3>{{ $f['judul'] }}</h3>
                <p><b>{{ $f['jenis'] }}</b> &middot; {{ $f['asal'] }}</p>
                <p>{{ $f['genre'] }}</p>
            </article>
        @endforeach
    </div>
</div>
@endsection
