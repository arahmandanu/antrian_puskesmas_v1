<!-- Marquee Text (Fixed at Bottom) -->
<div id="marque" class="fixed bottom-0 left-0 w-full h-16 overflow-hidden z-50 bg-green-600 bg-opacity-70">
    <!-- Background hitam di sisi kiri untuk jam, lebih stylish -->
    <div id="footer-time-bg" onclick="closeApp()"
        class="absolute left-0 top-0 h-full w-40 bg-gradient-to-b from-gray-900 via-black to-gray-800 z-20
        flex items-center justify-center rounded-r-lg shadow-lg border-r-2 border-gray-700">
        <span id="footer-time" class="font-mono font-semibold text-white text-xl"></span>
    </div>

    <!-- Marquee Text berjalan di belakang background jam -->
    <div
        class="marquee absolute top-1/2 left-0 transform -translate-y-1/2 whitespace-nowrap text-2xl font-thin z-10 pl-44 text-white">
        Selamat datang di {{ Config::get('mysite.company_name', 'KOSONG') }} • Tetap jaga kesehatan Anda • Mohon
        menunggu panggilan nomor antrian dengan tertib •
        Terima kasih atas kerjasamanya
    </div>
</div>

<script>
    function closeApp() {
        if (confirm("Apakah Anda yakin ingin menutup aplikasi?")) {
            // window.close();
            safeAjax({
                    type: "GET",
                    url: "{{ route('master.CloseApp') }}",
                    data: {},
                    dataType: "JSON"
                })
                .fail(function(data, textStatus, xhr) {
                    Swal.fire({
                        title: 'Error!',
                        text: data.responseJSON.message,
                        icon: 'error',
                        confirmButtonText: 'Cool',
                        didOpen: () => {
                            document.body.removeAttribute('style');
                            document.body.classList.remove('swal2-height-auto');
                        }
                    });
                })
                .always(function() {});
        }
    }

    function updateFooterTime() {
        const timeContainer = document.getElementById('footer-time');
        const now = new Date();
        const hours = now.getHours().toString().padStart(2, '0');
        const minutes = now.getMinutes().toString().padStart(2, '0');
        const seconds = now.getSeconds().toString().padStart(2, '0');
        timeContainer.textContent = `${hours}:${minutes}:${seconds}`;
    }

    setInterval(updateFooterTime, 1000);
    updateFooterTime();
</script>
