<script type="text/javascript">
    let periode = $("#name_period").val()
    // unit = $("#idunit").val(),
    // kls = $("#idkelas").val()
    $('#name_period').change(function() {
        $("#filter_get").click();
    });
    $('#filter_get').click(function() {
        periode = $("#name_period").val();
        // unit = $("#idunit").val();
        // kls = $("#idkelas").val();
        t.ajax.reload();
    });
    $('#reset_filter').click(function() {
        // $("#idunit").val('all').trigger("change");
        // $("#idkelas").val('all').trigger("change");
        periode = $("#name_period").val();
        // unit = $("#idunit").val();
        // kls = $("#idkelas").val();
        t.ajax.reload();
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
                "url": "classes/json",
                "type": "POST",
                data: function(data) {
                    data.periode = periode;
                    // data.unit = unit;
                    // data.kls = kls;
                    return data;
                }
            },
            // "rowGroup": {
            //     "dataSrc": "jenjang"
            // },
            columns: [{
                    "data": "idclass",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "idclass",
                    "orderable": false
                },
                // {
                //     "data": "idclass"
                // },
                {
                    "data": "period_id"
                }, {
                    "data": "name_class",
                    "className": "text-center"
                },
                // {
                //     "data": "employee_id"
                // }, 
                {
                    "data": "jenjang",
                    "className": "text-center"
                }, {
                    "data": "tingkat",
                    "className": "text-center"
                }, {
                    "data": "rombel",
                    "className": "text-center"
                }, {
                    "data": "capacity",
                    "className": "text-center"
                },
                {
                    "data": "jml",
                    "className": "text-center"
                },
                {
                    "data": "jml_l",
                    "className": "text-center"
                },
                {
                    "data": "jml_p",
                    "className": "text-center"
                },
                {
                    "data": "jml_non",
                    "className": "text-center"
                },
                {
                    "data": "status",
                    "className": "text-center"
                },
                {
                    "data": "action",
                    "orderable": false,
                    "className": "text-center"
                }
            ],
            columnDefs: [{
                    className: "text-center",
                    targets: 0,
                    checkboxes: {
                        selectRow: true,
                    }
                },
                {
                    "targets": 12,
                    "data": "",
                    "mRender": function(data, type, row) {
                        var text = "";
                        if (type == "display") {
                            if (data == "1") {
                                text = "<button type='button' class='btn btn-success btn-xs'>Aktif</button>";
                            } else {
                                text = "<button type='button' class='btn btn-danger btn-xs'>Nonaktif</button>";
                            }
                            data = text
                        }
                        return data;
                    },
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
            },
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                var jml = 0;
                var jml_l = 0;
                var jml_p = 0;
                var jml_non = 0;

                api.column(4, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        if (last !== null) {
                            $(rows).eq(i - 1).after(
                                '<tr class="group"><td colspan="8" style="text-align:right">Jumlah Siswa</td><td class="text-center">' + jml + '</td><td class="text-center">' + jml_l + '</td><td class="text-center">' + jml_p + '</td><td class="text-center">' + jml_non + '</td><td></td><td></td></tr>'
                            );
                        }
                        // $(rows).eq(i).before(
                        //     '<tr class="group"><td colspan="5">' + group + '</td></tr>'
                        // );
                        last = group;
                        jml = 0;
                        jml_l = 0;
                        jml_p = 0;
                        jml_non = 0;
                    }
                    jml += parseFloat(api.column(8, {
                        page: 'current'
                    }).data()[i]);
                    jml_l += parseFloat(api.column(9, {
                        page: 'current'
                    }).data()[i]);
                    jml_p += parseFloat(api.column(10, {
                        page: 'current'
                    }).data()[i]);
                    jml_non += parseFloat(api.column(11, {
                        page: 'current'
                    }).data()[i]);
                });
                if (last !== null) {
                    $(rows).eq(rows.length - 1).after(
                        '<tr class="group"><td colspan="8" style="text-align:right">Jumlah Siswa</td><td class="text-center">' + jml + '</td><td class="text-center">' + jml_l + '</td><td class="text-center">' + jml_p + '</td><td class="text-center">' + jml_non + '</td><td></td><td></td></tr>'
                    );
                }
            }
        });

        // Order by the grouping
        $('#mytable tbody').on('click', 'tr.group', function() {
            var currentOrder = t.order()[0];
            if (currentOrder[0] === 0 && currentOrder[1] === 'asc') {
                t.order([0, 'desc']).draw();
            } else {
                t.order([0, 'asc']).draw();
            }
        });

        $('#myform').keypress(function(e) {
            if (e.which == 13) return false;

        });
        $("#myform").on('submit', function(e) {
            var form = this
            var rowsel = t.column(0).checkboxes.selected();
            $.each(rowsel, function(index, rowId) {
                $(form).append(
                    $('<input>').attr('type', 'hidden').attr('name', 'id[]').val(rowId)
                )
            });

            if (rowsel.join(",") == "") {
                alertify.alert('', 'Tidak ada data terpilih!', function() {});

            } else {
                var prompt = alertify.confirm('Apakah anda yakin akan menghapus data tersebut?', 'Apakah anda yakin akan menghapus data tersebut?').set('labels', {
                    ok: 'Yakin',
                    cancel: 'Batal!'
                }).set('onok', function(closeEvent) {
                    $.ajax({
                        url: "classes/deletebulk",
                        type: "post",
                        data: "msg = " + rowsel.join(","),
                        success: function(response) {
                            if (response == true) {
                                location.reload();
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });

                });
            }
            $(".ajs-header").html("Konfirmasi");
        });
        $('#add_button').click(function() {
            $('#form')[0].reset();
            $('.modal-title').text("Tambah classes");
            $('#action').val("Add");
            $('#actions').val("Add");
            val = "K";
            $.ajax({
                url: "<?php echo base_url('helpers/uniqid'); ?>",
                type: "POST",
                data: {
                    _uniq: val
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data.hasil);
                    $("[name='idclass']").val(data.hasil);
                }
            });
        });
    });
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('classes/json_form'); ?>",
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    $('#ModalaForm').modal('hide');
                    $('#form')[0].reset();
                    t.ajax.reload();
                    clear_data();
                } else {
                    $.each(data.messages, function(key, value) {
                        var element = $('#' + key);

                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : 'has-success')
                            .find('.text-danger')
                            .remove();

                        element.after(value)

                    });
                }
            }
        });
    });

    function confirmdelete(linkdelete) {
        alertify.confirm("Apakah anda yakin akan  menghapus data tersebut?", function() {
            location.href = linkdelete;
        }, function() {
            alertify.error("Penghapusan data dibatalkan.");
        });
        $(".ajs-header").html("Konfirmasi");
        return false;
    }

    function edit_data(id) {
        $("#myModalLabel").text("Ubah Class");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=idclass]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('classes/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#ModalaForm").modal("show");
                $("[name='idclass']").val(data.idclass);
                $("[name='period_id']").val(data.period_id);
                $("[name='employee_id']").val(data.employee_id);
                $("[name='name_class']").val(data.name_class);
                $("[name='jenjang']").val(data.jenjang);
                $("[name='tingkat']").val(data.tingkat);
                $("[name='rombel']").val(data.rombel);
                $("[name='status']").val(data.status);
                $("[name='capacity']").val(data.capacity);
                $('#action').val("Edit");
                $('#actions').val("Edit");
            }
        });
        return false;
    }

    function clear_data() {
        $("[name=idclass]").attr("readonly", false);
        $('.modal-title').text("Tambah Tbl_siswa");
        $('#action').val("Add");
        $('#actions').val("Add");
        $("#btn_ubah").attr("id", "btn_simpan");
        $("#btn_simpan").text("Simpan");
        $("[name='idclass']").val("");
        $("[name='period_id']").val("");
        $("[name='employee_id']").val("");
        $("[name='name_class']").val("");
        $("[name='jenjang']").val("");
        $("[name='tingkat']").val("");
        $("[name='rombel']").val("");
        $("[name='status']").val("");
        $("[name='capacity']").val("");
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }
</script>