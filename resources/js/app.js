require('./bootstrap');
import Swal from 'sweetalert2';
window.Swal = Swal;


function ejaanNomor(nomor) {
    return nomor.split("").join(" ");
}
window.ejaanNomor = ejaanNomor;


import Swiper from 'swiper/bundle';
window.Swiper = Swiper;


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    }
});

// Helper: refresh CSRF and update meta + ajaxSetup
function refreshCsrfToken(callback) {
    $.get('/refresh-csrf', function (data) {
        let newToken = data.csrf_token;
        document.querySelector('meta[name="csrf-token"]').setAttribute('content', newToken);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': newToken
            }
        });
        if (callback) callback(newToken);
    });
}

// Wrapper for safe AJAX with auto-retry
window.safeAjax = function (options) {
    let jqXHR = $.ajax(options);

    jqXHR.fail(function (xhr) {
        if (xhr.status === 419) {
            console.warn("CSRF mismatch, refreshing token…");
            refreshCsrfToken(function (newToken) {
                options.headers = { "X-CSRF-TOKEN": newToken };
                $.ajax(options); // retry once (fire & forget)
            });
        }
    });

    return jqXHR; // return so caller can chain
};
