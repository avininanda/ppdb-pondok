// Countdown timer untuk pesan throttle login
const errorMsg = document.getElementById('error-msg');

if (errorMsg) {
    const text = errorMsg.innerText;

    // Cek apakah pesannya mengandung kata "detik"
    // Kalau iya, berarti pesan throttle → jalankan countdown
    const match = text.match(/(\d+) detik/);

    if (match) {
        let sisaDetik = parseInt(match[1]);

        const interval = setInterval(function () {
            sisaDetik--;

            if (sisaDetik <= 0) {
                // Waktu habis → ubah pesan jadi hijau
                clearInterval(interval);
                errorMsg.innerHTML = '✅ Silakan coba login kembali.';
                errorMsg.style.color = '#166534';
                document.getElementById('error-box').style.background = '#f0fdf4';
                document.getElementById('error-box').style.borderColor = '#bbf7d0';
            } else {
                // Update angka detik
                errorMsg.innerHTML = '⚠️ Terlalu banyak percobaan login. Silakan coba lagi dalam ' + sisaDetik + ' detik.';
            }
        }, 1000);
    }
}