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
        $('.footer-select').change(function() {
            var selectedValue = $(this).val();
            var dayIndex = $(this).data('day');
            var periodIndex = $(this).data('period');

            $('tbody tr').each(function() {
                $(this).find('td.day-' + dayIndex).eq(periodIndex - 1).find('select').val(selectedValue);
            });
        });
    });
</script>