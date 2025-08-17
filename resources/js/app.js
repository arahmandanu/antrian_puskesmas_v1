require('./bootstrap');
import Swal from 'sweetalert2';
window.Swal = Swal;


function ejaanNomor(nomor) {
    return nomor.split("").join(" ");
}
window.ejaanNomor = ejaanNomor;
