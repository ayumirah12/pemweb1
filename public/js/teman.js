// Me n My Friends: klik kartu teman = pop-up berisi lagu. Spotify dimuat saat dibuka dan dihentikan saat ditutup.
(function () {
    var kartu = Array.prototype.slice.call(document.querySelectorAll('.kartu-teman'));
    if (!kartu.length) return;

    var terbuka = null, terakhir = null;

    function muat(panel) {
        var f = panel.querySelector('.tm-embed');
        if (f && !f.getAttribute('src')) f.setAttribute('src', f.getAttribute('data-src'));
        if (window.Sorot) panel.querySelectorAll('.sorot').forEach(window.Sorot.mulai);
    }

    function pilihLagu(modal, btn) {
        modal.querySelectorAll('.tm-lagu-btn').forEach(function (b) {
            var aktif = (b === btn);
            b.classList.toggle('aktif', aktif);
            b.setAttribute('aria-selected', aktif ? 'true' : 'false');
        });
        modal.querySelectorAll('.tm-lagu-panel').forEach(function (p) {
            var tampil = (p.id === btn.getAttribute('data-lagu'));
            p.hidden = !tampil;
            if (tampil) muat(p);
            else if (window.Sorot) p.querySelectorAll('.sorot').forEach(window.Sorot.henti);
        });
    }

    function buka(modal, pemicu) {
        terakhir = pemicu;
        terbuka = modal;
        modal.hidden = false;
        document.body.classList.add('kunci');
        var pertama = modal.querySelector('.tm-lagu-panel:not([hidden])');
        if (pertama) muat(pertama);
        modal.querySelector('.tm-tutup').focus();
    }

    function tutup() {
        if (!terbuka) return;
        // Kosongkan iframe supaya lagu berhenti
        terbuka.querySelectorAll('.tm-embed').forEach(function (f) { f.removeAttribute('src'); });
        if (window.Sorot) terbuka.querySelectorAll('.sorot').forEach(window.Sorot.henti);
        terbuka.hidden = true;
        document.body.classList.remove('kunci');
        terbuka = null;
        if (terakhir) terakhir.focus();
    }

    kartu.forEach(function (k) {
        k.addEventListener('click', function () {
            buka(document.getElementById(k.getAttribute('data-modal')), k);
        });
    });

    document.querySelectorAll('.tm-modal').forEach(function (m) {
        m.querySelector('.tm-tutup').addEventListener('click', tutup);
        // Klik area gelap = tutup
        m.addEventListener('click', function (e) { if (e.target === m) tutup(); });
        m.querySelectorAll('.tm-lagu-btn').forEach(function (b) {
            b.addEventListener('click', function () { pilihLagu(m, b); });
        });
    });

    document.addEventListener('keydown', function (e) {
        if (!terbuka) return;
        if (e.key === 'Escape') { tutup(); return; }
        if (e.key === 'Tab') {
            var f = terbuka.querySelectorAll('button:not([hidden]), a[href]');
            var awal = f[0], akhir = f[f.length - 1];
            if (e.shiftKey && document.activeElement === awal) { e.preventDefault(); akhir.focus(); }
            else if (!e.shiftKey && document.activeElement === akhir) { e.preventDefault(); awal.focus(); }
        }
    });
})();
