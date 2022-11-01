
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

// window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// const app = new Vue({
//     el: '#app'
// });

var updateAccountAction = function () {
    var form = $('#editAccountModalForm');

    if (! form) {
        return;
    }

    var notices = $('#editAccountModalNotices');
    var errors = $('#editAccountModalErrors');
    var submitButton = $('#editAccountModalFormButton');
    
    form.on('submit', function (e) {
        e.preventDefault();
        var target = $(e.target);

        // Remove any actions
        notices.hide();
        errors.hide();
        $('.invalid-feedback').hide();
        $('.form-control').removeClass('is-invalid');

        submitButton.val('Saving...');
        submitButton.attr('disabled', true);

        var fields = {};
        target.serializeArray().map(function (field) {
            fields[field.name] = field.value;
        });

        $.ajax({
            type: 'POST',
            url: form.attr('action'),
            // contentType: 'application/json',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': fields._token
            },
            data: fields,
            success: function (response, status) {
                submitButton.text('Save Changes');
                submitButton.attr('disabled', false);   

                notices.find('.alert-content').text(response.message);
                notices.show();

                $('.is-password').val('');

                ['name', 'last_name', 'email'].forEach(function (value) {
                    $(`#account-${value}`).text(fields[value]);
                });
            },
            error: function (response) {
                submitButton.text('Save Changes');
                submitButton.attr('disabled', false);   
                
                errors.find('.alert-content').text(response.responseJSON.message);
                errors.show();
                
                var err = response.responseJSON.errors;
                Object.keys(err).map(function (v) {
                    form.find(`input[name=${v}]`).addClass('is-invalid');
                    form.find(`#invalid-message-${v}`).text(err[v]).show();
                })
            }
        });
    });
};

var deleteRecord = function () {
    var trigger = $('.delete-record');

    if (! trigger) {
        return;
    }

    trigger.on('click', function () {
        var record = $(this);
        
        $('#deleteRecordModalForm').attr('action', record.data('action'));
    });
};

$(document).ready(function () {
    updateAccountAction();
    deleteRecord();
});