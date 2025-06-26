<script>
    $(document).ready(function() {
        var table = $('.table_data').DataTable({
            "language": {
                "lengthMenu": "দেখুন _MENU_ ডাটা",
                "zeroRecords": "কোনো ডাটা পাওয়া যায়নি",
                "info": " _PAGE_ এর মধ্যে _PAGES_ পেজ",
                "infoEmpty": "কোনো ডাটা পাওয়া যায়নি",
                "infoFiltered": "( _MAX_   )",
                "search": "অনুসন্ধান",
                "paginate": {
                    "first": "প্রথম",
                    "last": "শেষ",
                    "next": "পরবর্তী",
                    "previous": "পূর্ববর্তী"
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
