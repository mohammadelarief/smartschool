<script type="text/javascript">
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
            ajax: {
                "url": "semester/json",
                "type": "POST"
            },
            columns: [{
                    "data": "idsemester",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "idsemester",
                    "orderable": false
                }, {
                    "data": "idsemester"
                }, {
                    "data": "period_id"
                }, {
                    "data": "description"
                }, {
                    "data": "start_date"
                }, {
                    "data": "end_date"
                }, {
                    "data": "status"
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
                    "targets": 7,
                    "data": "",
                    "mRender": function(data, type, row) {
                        var text = "";
                        if (type == "display") {
                            if (data == "1") {
                                text = "<button type='button' class='btn btn-success btn-xs'>Aktif</button>";
                            } else {
                                text = "<button type='button' class='update-status btn btn-danger btn-xs'>Nonaktif</button>";
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
                [1, 'desc']
            ],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(1)', row).html(index);
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
                        url: "semester/deletebulk",
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

        $('#mytable').on('click', '.update-status', function() {
            var data = t.row($(this).parents('tr')).data();
            $.ajax({
                url: "<?= base_url('semester/update_status') ?>",
                type: "POST",
                data: {
                    id: data.idsemester
                },
                success: function(response) {
                    var result = JSON.parse(response);
                    if (result.status === 'success') {
                        t.ajax.reload();
                    } else {
                        alert('Error updating status');
                    }
                }
            });
        });
        $('#add_button').click(function() {
            $('#form')[0].reset();
            $('.modal-title').text("Tambah semester");
            $('#action').val("Add");
            $('#actions').val("Add");
            val = "SMS";
            $.ajax({
                url: "<?php echo base_url('helpers/uniqid'); ?>",
                type: "POST",
                data: {
                    _uniq: val
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data.hasil);
                    $("[name='idsemester']").val(data.hasil);
                }
            });
        });
    });
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('semester/json_form'); ?>",
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
        $("#myModalLabel").text("Ubah Semester");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=idsemester]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('semester/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#ModalaForm").modal("show");
                $("[name='idsemester']").val(data.idsemester);
                $("[name='period_id']").val(data.period_id);
                $("[name='start_date']").val(data.start_date);
                $("[name='end_date']").val(data.end_date);
                $("[name='description']").val(data.description);
                $("[name='status']").val(data.status);
                $('#action').val("Edit");
                $('#actions').val("Edit");
            }
        });
        return false;
    }

    function clear_data() {
        $("[name=idsemester]").attr("readonly", false);
        $('.modal-title').text("Tambah Tbl_siswa");
        $('#action').val("Add");
        $('#actions').val("Add");
        $("#btn_ubah").attr("id", "btn_simpan");
        $("#btn_simpan").text("Simpan");
        $("[name='idsemester']").val("");
        $("[name='period_id']").val("");
        $("[name='start_date']").val("");
        $("[name='end_date']").val("");
        $("[name='description']").val("");
        $("[name='status']").val("");
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }
</script>