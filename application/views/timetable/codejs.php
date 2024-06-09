<script type="text/javascript">
    $(document).ready(function() {
        $('#select-day').change(function() {
            var selectedDay = $(this).val();
            if (selectedDay === 'all') {
                $('.day-header').show();
                $('.day-column').show();
            } else {
                $('.day-header').hide();
                $('.day-column').hide();
                $('.' + selectedDay).show();
            }
        });
        $('#select-class').change(function() {
            var selectedJenjang = $(this).val();
            if (selectedJenjang === 'all') {
                $('tbody tr').show();
            } else {
                $('tbody tr').hide();
                $('tbody tr.' + selectedJenjang).show();
            }
        });
    });
</script>