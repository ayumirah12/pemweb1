// Film Favorit: klik kartu film = pop-up trailer. YouTube dimuat saat dibuka dan dihentikan saat ditutup.
(function () {
    var kartu = Array.prototype.slice.call(document.querySelectorAll('.kartu-film'));
    if (!kartu.length) return;

    var terbuka = null, terakhir = null;

    function buka(modal, pemicu) {
        terakhir = pemicu;
        terbuka = modal;
        modal.hidden = false;
        document.body.classList.add('kunci');
        var f = modal.querySelector('.fm-embed');
        if (f && !f.getAttribute('src')) f.setAttribute('src', f.getAttribute('data-src'));
        modal.querySelector('.tm-tutup').focus();
    }

    function tutup() {
        if (!terbuka) return;
        var f = terbuka.querySelector('.fm-embed');
        if (f) f.removeAttribute('src'); // video berhenti
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

    document.querySelectorAll('.tm-modal[id^="fm-"]').forEach(function (m) {
        m.querySelector('.tm-tutup').addEventListener('click', tutup);
        m.addEventListener('click', function (e) { if (e.target === m) tutup(); });
    });

    document.addEventListener('keydown', function (e) {
        if (!terbuka) return;
        if (e.key === 'Escape') { tutup(); return; }
        if (e.key === 'Tab') {
            var f = terbuka.querySelectorAll('button, a[href]');
            var awal = f[0], akhir = f[f.length - 1];
            if (e.shiftKey && document.activeElement === awal) { e.preventDefault(); akhir.focus(); }
            else if (!e.shiftKey && document.activeElement === akhir) { e.preventDefault(); awal.focus(); }
        }
    });
})();
