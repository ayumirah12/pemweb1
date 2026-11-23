// Teks bergerak ala Spotify: menyorot baris sesuai posisi lagu (Spotify iFrame API).
(function () {
    var api = null, antri = [], dimuat = false;

    function siapApi(cb) {
        if (api) return cb(api);
        antri.push(cb);
        if (dimuat) return;
        dimuat = true;
        window.onSpotifyIframeApiReady = function (a) {
            api = a;
            antri.splice(0).forEach(function (f) { f(a); });
        };
        var s = document.createElement('script');
        s.src = 'https://open.spotify.com/embed/iframe-api/v1';
        s.async = true;
        document.body.appendChild(s);
    }

    function tandai(box, detik) {
        var li = box.querySelectorAll('.sorot-baris li');
        var idx = -1;
        for (var i = 0; i < li.length; i++) {
            if (+li[i].getAttribute('data-t') <= detik) idx = i; else break;
        }
        if (idx === box._idx) return;
        box._idx = idx;
        for (var j = 0; j < li.length; j++) {
            li[j].classList.toggle('aktif', j === idx);
            li[j].classList.toggle('lewat', j < idx);
        }
        if (idx >= 0) {
            var ul = box.querySelector('.sorot-baris');
            var target = li[idx].offsetTop - ul.clientHeight / 2 + li[idx].clientHeight / 2;
            var kurang = window.matchMedia && matchMedia('(prefers-reduced-motion: reduce)').matches;
            ul.scrollTo({ top: Math.max(0, target), behavior: kurang ? 'auto' : 'smooth' });
        }
    }

    function lompat(box, li) {
        var c = box._ctrl;
        if (c) { c.seek(+li.getAttribute('data-t')); c.resume(); }
    }

    function mulai(box) {
        if (box._mulai) return;
        box._mulai = true;
        box._idx = -2;
        box.querySelectorAll('.sorot-baris li').forEach(function (li) {
            li.addEventListener('click', function () { lompat(box, li); });
            li.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); lompat(box, li); }
            });
        });
        siapApi(function (a) {
            a.createController(box.querySelector('.sorot-player'),
                { uri: box.getAttribute('data-uri'), width: '100%', height: 152 },
                function (c) {
                    box._ctrl = c;
                    c.addListener('playback_update', function (e) {
                        if (e && e.data) tandai(box, e.data.position / 1000);
                    });
                });
        });
    }

    function henti(box) {
        if (box._ctrl) box._ctrl.pause();
    }

    window.Sorot = { mulai: mulai, henti: henti };

    // Halaman playlist: mulai otomatis; ganti tab = jeda lagu
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.sorot[data-auto]').forEach(mulai);
        document.querySelectorAll('.tab-btn').forEach(function (b) {
            b.addEventListener('click', function () {
                document.querySelectorAll('.sorot').forEach(henti);
            });
        });
    });
})();
