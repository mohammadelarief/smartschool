<script type="text/javascript">
    let periode = $("#name_period").val(),
        kls = $("#idkelas").val()
    $('#name_period').change(function() {
        $("#filter_get").click();
        getkelasfilter();
    });
    $('#idkelas').change(function() {
        $("#filter_get").click();
    });
    $('#filter_get').click(function() {
        periode = $("#name_period").val();
        kls = $("#idkelas").val();
        t.ajax.reload();
    });
    $('#reset_filter').click(function() {
        $("#idkelas").val('all').trigger("change");
        periode = $("#name_period").val();
        kls = $("#idkelas").val();
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
            ajax: {
                "url": "lesson/json",
                "type": "POST",
                data: function(data) {
                    data.periode = periode;
                    data.kls = kls;
                    return data;
                }
            },
            columns: [{
                    "data": "idlesson",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "idlesson",
                    "orderable": false
                },
                // {
                //     "data": "idlesson"
                // }, 
                {
                    "data": "period_id"
                }, {
                    "data": "name_class"
                }, {
                    "data": "name"
                }, {
                    "data": "subject"
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
        getkelasfilter();
        // $('#myform').keypress(function(e) {
        //     if (e.which == 13) return false;

        // });
        // $("#myform").on('submit', function(e) {
        //     var form = this
        //     var rowsel = t.column(0).checkboxes.selected();
        //     $.each(rowsel, function(index, rowId) {
        //         $(form).append(
        //             $('<input>').attr('type', 'hidden').attr('name', 'id[]').val(rowId)
        //         )
        //     });

        //     if (rowsel.join(",") == "") {
        //         alertify.alert('', 'Tidak ada data terpilih!', function() {});

        //     } else {
        //         var prompt = alertify.confirm('Apakah anda yakin akan menghapus data tersebut?', 'Apakah anda yakin akan menghapus data tersebut?').set('labels', {
        //             ok: 'Yakin',
        //             cancel: 'Batal!'
        //         }).set('onok', function(closeEvent) {
        //             $.ajax({
        //                 url: "lesson/deletebulk",
        //                 type: "post",
        //                 data: "msg = " + rowsel.join(","),
        //                 success: function(response) {
        //                     if (response == true) {
        //                         location.reload();
        //                     }
        //                 },
        //                 error: function(jqXHR, textStatus, errorThrown) {
        //                     console.log(textStatus, errorThrown);
        //                 }
        //             });

        //         });
        //     }
        //     $(".ajs-header").html("Konfirmasi");
        // });
        $('#add_button').click(function() {
            $('#form')[0].reset();
            clear_data();
            get_periode();
            $('.modal-title').text("Tambah Pelajaran");
            $('#action').val("Add");
            $('#actions').val("Add");
            val = "LS";
            $.ajax({
                url: "<?= base_url('helpers/uniqid'); ?>",
                type: "POST",
                data: {
                    _uniq: val
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data.hasil);
                    $("[name='idlesson']").val(data.hasil);
                }
            });
            $("[name=period_id]").change(function() {
                var classes = "<?= site_url('Helpers/get_class'); ?>/" + $(this).val();
                var subject = "<?= site_url('Helpers/get_subject'); ?>/" + $(this).val();
                $('#subject_id').load(subject);
                $('#class_id').load(classes);
                return false;
            })
        });
        $('#ModalaForm').on('hidden.bs.modal', function() {
            // Reset the form
            // $('#form')[0].reset();
            clear_data();
        });
    });
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('lesson/json_form'); ?>",
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

    function getkelasfilter() {
        $.ajax({
            url: "<?php echo base_url(); ?>Helpers/get_filter_kelas",
            method: "POST",
            data: {
                periode: periode
            },
            async: false,
            dataType: 'json',
            success: function(data) {
                var html = '';
                var i;

                html += '<option value="all" selected="selected">[SEMUA KELAS]</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].idclass + '>' + data[i].name_class + '</option>';
                }
                $('#idkelas').html(html);
            }
        });
        $("#filter_get").click();
    }

    // for edit_data
    function get_periode() {
        var periode = "<?= site_url('Helpers/get_period'); ?>";
        return new Promise((resolve, reject) => {
            $('#period_id').load(periode, function(response, status, xhr) {
                if (status == "success") {
                    resolve();
                } else {
                    reject();
                }
            });
        });
    }

    function get_employee() {
        var employee = "<?= site_url('Helpers/get_employee'); ?>";
        return new Promise((resolve, reject) => {
            $('#employee_id').load(employee, function(response, status, xhr) {
                if (status == "success") {
                    resolve();
                } else {
                    reject();
                }
            });
        });
    }

    function get_periode_subject(period, data) {
        var subject = "<?= site_url('Helpers/get_subject'); ?>/" + period + "/" + data;
        return new Promise((resolve, reject) => {
            $('#subject_id').load(subject, function(response, status, xhr) {
                if (status == "success") {
                    resolve();
                } else {
                    reject();
                }
            });
        });
    }

    function get_periode_class(period, data) {
        var classes = "<?= site_url('Helpers/get_class'); ?>/" + period + "/" + data;
        return new Promise((resolve, reject) => {
            $('#class_id').load(classes, function(response, status, xhr) {
                if (status == "success") {
                    resolve();
                } else {
                    reject();
                }
            });
        });
    }

    function edit_data(id) {
        $("#myModalLabel").text("Ubah Pelajaran");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=idlesson]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('lesson/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#ModalaForm").modal("show");
                $("[name='idlesson']").val(data.idlesson);
                Promise.all([get_periode(), get_employee()]).then(() => {
                    $('#period_id').val(data.period_id).trigger('change');
                    $('#employee_id').val(data.employee_id).trigger('change');
                    return get_periode_class(data.period_id, data.class_id);
                }).then(() => {
                    $('#class_id').val(data.class_id).trigger('change');
                    return get_periode_subject(data.period_id, data.subject_id);
                }).then(() => {
                    $('#subject_id').val(data.subject_id).trigger('change');
                }).catch((error) => {
                    console.error('An error occurred:', error);
                });
                $('#action').val("Edit");
                $('#actions').val("Edit");
            }
        });
        return false;
    }

    function clear_data() {
        $("[name=idlesson]").attr("readonly", false);
        $('.modal-title').text("Tambah Tbl_siswa");
        $('#action').val("Add");
        $('#actions').val("Add");
        $("#btn_ubah").attr("id", "btn_simpan");
        $("#btn_simpan").text("Simpan");
        $("[name='idlesson']").val("");
        $('#employee_id').val('').trigger('change');
        $('#subject_id').val('').trigger('change');
        $('#class_id').val('').trigger('change');
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }
</script>