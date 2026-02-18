/**
 * Common CRUD JS for DataTables, Select2 AJAX, and Toasts
 * Matches the Herozi theme DataTable styling from datatable.init.js
 */

$(document).ready(function () {
    // CSRF Token for AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize Select2 AJAX
    window.initSelect2Ajax = function (selector, url, placeholder = "Search...") {
        $(selector).select2({
            ajax: {
                url: url,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        q: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {
                    params.page = params.page || 1;
                    return {
                        results: data.items,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            placeholder: placeholder,
            minimumInputLength: 1,
            width: '100%'
        });
    };

    // Initialize DataTable (matching Herozi theme style)
    window.initDataTable = function (selector, url, columns) {
        var table = $(selector).DataTable({
            processing: true,
            serverSide: true,
            ajax: url,
            columns: columns,
            order: [[0, 'desc']],
            dom:
                '<"card-header dt-head d-flex flex-column flex-sm-row justify-content-between align-items-center gap-3"' +
                '<"d-flex align-items-center gap-2"l>' +
                '<"d-flex flex-column flex-sm-row align-items-center justify-content-sm-end gap-3 w-100"f<"add_button">>' +
                '>' +
                '<"table-responsive"t>' +
                '<"card-footer d-flex flex-column flex-sm-row justify-content-between align-items-center gap-2"i' +
                '<"d-flex align-items-sm-center justify-content-end gap-4"p>' +
                '>',
            language: {
                sLengthMenu: 'Show _MENU_',
                search: '',
                searchPlaceholder: 'Search...',
                paginate: {
                    next: '<i class="ri-arrow-right-s-line"></i>',
                    previous: '<i class="ri-arrow-left-s-line"></i>'
                },
                processing: '<div class="spinner-border text-primary" role="status"></div>'
            },
            lengthMenu: [10, 20, 50],
            pageLength: 10,
            initComplete: function () {
                // Remove form-control-sm from search input
                var inputEl = $(selector).closest('.card').find('.dataTables_filter .form-control');
                if (inputEl.length) {
                    inputEl.removeClass('form-control-sm');
                }
                // Remove form-select-sm from length select
                var selectEl = $(selector).closest('.card').find('.dataTables_length .form-select');
                if (selectEl.length) {
                    selectEl.removeClass('form-select-sm');
                }
            }
        });

        return table;
    };

    // Toast Notification Handler
    window.showToast = function (message, type) {
        type = type || 'success';
        var toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            var container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'toast-container position-fixed top-0 end-0 p-3';
            container.style.zIndex = '1080';
            document.body.appendChild(container);
        }

        var toastId = 'toast-' + Date.now();
        var bgClass = type === 'success' ? 'bg-success' : 'bg-danger';

        var toastHtml =
            '<div id="' + toastId + '" class="toast align-items-center text-white ' + bgClass + ' border-0" role="alert" aria-live="assertive" aria-atomic="true">' +
            '<div class="d-flex">' +
            '<div class="toast-body">' + message + '</div>' +
            '<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
            '</div>' +
            '</div>';

        document.getElementById('toast-container').insertAdjacentHTML('beforeend', toastHtml);
        var toastElement = document.getElementById(toastId);
        var toast = new bootstrap.Toast(toastElement);
        toast.show();

        toastElement.addEventListener('hidden.bs.toast', function () {
            toastElement.remove();
        });
    };
});
