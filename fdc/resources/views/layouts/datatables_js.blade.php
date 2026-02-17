<script>
    $(document).ready(function() {
        var table = $('.table_data').DataTable({
            "language": {
                "lengthMenu": "{{ __('messages.show_menu_data') }}",
                "zeroRecords": "{{ __('messages.no_data_found') }}",
                "info": "{{ __('messages.page_of_pages') }}",
                "infoEmpty": "{{ __('messages.no_data_found') }}",
                "infoFiltered": "( _MAX_   )",
                "search": "{{ __('messages.search') }}",
                "paginate": {
                    "first": "{{ __('messages.first') }}",
                    "last": "{{ __('messages.last') }}",
                    "next": "{{ __('messages.next') }}",
                    "previous": "{{ __('messages.previous') }}"
                }
            }
        });

        // Clear the search box and redraw the table
        table.search('').draw();
    });
</script>

<!-- Datatables -->
<script src="{{ asset('vendors/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/datatables/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
