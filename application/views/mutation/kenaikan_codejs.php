<script src="<?= base_url('assets/bower_components/select2/dist/js/select2.full.min.js'); ?>"></script>
<script type="text/javascript">
    //select2
    $('.select2').select2();
</script>
<script type="text/javascript">
    let periode = $("#name_period").val(),
        kls = $("#idkelas").val(),
        next_kls = $("#next_class").val(),
        next_periode = $("#next_period").val()

    $('#name_period').change(function() {
        $("#filter_get").click();
        getkelasfilter();
    });
    $('#idkelas').change(function() {
        $("#filter_get").click();

    });
    $('#filter_get').click(function() {
        periode = $("#name_period").val();
        // unit = $("#idunit").val();
        kls = $("#idkelas").val();

        nextperiod();
    });
    $(document).ready(function() {
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };
        t = $("#mytable").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode != 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: {
                "url": "student/json",
                "type": "POST",
                data: function(data) {
                    data.periode = periode;
                    // data.unit = unit;
                    data.kls = kls;
                    return data;
                }
            },
            columns: [{
                    "data": "idstudent",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "idstudent",
                    "orderable": false
                }, {
                    "data": "personid",
                    "className": "text-center"
                }, {
                    "data": "name",
                    createdCell: function(td, cellData, data, row, col) {
                        $(td).html('<a href="#" class="modal_detail" name="' + data.personid + '" id="' + data.personid + '" >' + data.name + '</a>');
                    }
                }, {
                    "data": "gender",
                    "className": "text-center"
                }
            ],
            columnDefs: [{
                    className: "text-center",
                    targets: 0,
                    checkboxes: {
                        selectRow: true,
                    }
                }

            ],
            select: {
                style: 'multi'
            },
            order: [
                [3, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(1)', row).html(index);
            }
        });
        t1 = $("#mytabless").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#mytable_filter input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        if (e.keyCode != 13) {
                            api.search(this.value).draw();
                        }
                    });
            },
            oLanguage: {
                sProcessing: "loading..."
            },
            scrollCollapse: true,
            processing: true,
            serverSide: true,
            pageLength: 25,
            ajax: {
                "url": "student/json",
                "type": "POST",
                data: function(data) {
                    data.periode = next_periode;
                    // data.unit = unit;
                    data.kls = next_kls;
                    return data;
                }
            },
            columns: [{
                    "data": "idstudent",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "idstudent",
                    "orderable": false
                }, {
                    "data": "personid",
                    "className": "text-center"
                }, {
                    "data": "name",
                    createdCell: function(td, cellData, data, row, col) {
                        $(td).html('<a href="#" class="modal_detail" name="' + data.personid + '" id="' + data.personid + '" >' + data.name + '</a>');
                    }
                }, {
                    "data": "gender",
                    "className": "text-center"
                }
            ],
            columnDefs: [{
                    className: "text-center",
                    targets: 0,
                    checkboxes: {
                        selectRow: true,
                    }
                }

            ],
            select: {
                style: 'multi'
            },
            order: [
                [3, 'asc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(1)', row).html(index);
            }
        });
        getkelasfilter();
        nextperiod();

    });

    function getkelasfilter() {
        $.ajax({
            url: "<?php echo base_url(); ?>helpers/get_filter_kelas",
            method: "POST",
            data: {
                periode: periode
            },
            async: false,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;

                html += '';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].idclass + '>' + data[i].name_class + '</option>';
                }
                $('#idkelas').html(html);
            }
        });
        $("#filter_get").click();
    }

    function getkelasnextperiod() {
        next_periode = $("#next_period").val();
        $.ajax({
            url: "<?php echo base_url(); ?>helpers/get_filter_kelas",
            method: "POST",
            data: {
                periode: next_periode
            },
            async: false,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;

                html += '';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].idclass + '>' + data[i].name_class + '</option>';
                }
                $('#next_class').html(html);
            }
        });
        // $("#filter_get").click();
    }

    function nextperiod() {
        $.ajax({
            url: "<?php echo base_url(); ?>helpers/next_period",
            method: "POST",
            data: {
                periode: periode
            },
            async: false,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;

                html += '';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].name_period + '>' + data[i].name_period + '</option>';
                }
                $('#next_period').html(html);
            }
        });
        getkelasnextperiod();
        t.ajax.reload();
    }
</script>