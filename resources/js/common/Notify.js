import swal from 'sweetalert';
import Promise from 'promise';

const locale = window.Laravel.locale;

export default {
    success: function(message) {
        this.notify('success', message);
    },

    warning: function(message) {
        this.notify('warning', message);
    },

    error: function(message) {
        this.notify('error', message);
    },

    danger: function(message) {
        return this.overlay(message, 'error');
    },

    dangerWarning: function(message) {
        return this.overlay(message, 'warning');
    },   

    overlay: function(message, type = 'success') {
        return new Promise((resolve, reject) => {
            swal({
                title: '',
                text: message,
                type: type,
            }, () => resolve());
        });
    },

    confirm: function(message, type = 'warning') {
        return new Promise((resolve, reject) => {
            swal({
                title: '',
                text: message,
                type: type,
                html: true,
                showCancelButton: true,
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }, confirm => (confirm ? resolve() : reject()));
        });
    }
}
