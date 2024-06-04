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
                "url": "person_detail/json",
                "type": "POST"
            },
            columns: [{
                    "data": "id",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "id",
                    "orderable": false
                }, {
                    "data": "person_id"
                }, {
                    "data": "date_born"
                }, {
                    "data": "where_born"
                }, {
                    "data": "address"
                }, {
                    "data": "dusun"
                }, {
                    "data": "kelurahan"
                }, {
                    "data": "kecamatan"
                }, {
                    "data": "kabupaten"
                }, {
                    "data": "provinsi"
                }, {
                    "data": "zipcode"
                }, {
                    "data": "nik"
                }, {
                    "data": "kk"
                }, {
                    "data": "religion"
                }, {
                    "data": "nationality"
                }, {
                    "data": "anak_ke"
                }, {
                    "data": "jumlah_saudara_kandung"
                }, {
                    "data": "weight"
                }, {
                    "data": "height"
                }, {
                    "data": "email"
                }, {
                    "data": "phone"
                }, {
                    "data": "name_father"
                }, {
                    "data": "name_mother"
                }, {
                    "data": "nik_father"
                }, {
                    "data": "nik_mother"
                }, {
                    "data": "work_father"
                }, {
                    "data": "education_father"
                }, {
                    "data": "earnings_father"
                }, {
                    "data": "phone_father"
                }, {
                    "data": "work_mother"
                }, {
                    "data": "education_mother"
                }, {
                    "data": "earnings_mother"
                }, {
                    "data": "phone_mother"
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
                        url: "person_detail/deletebulk",
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
            $('.modal-title').text("Tambah person_detail");
            $('#action').val("Add");
            $('#actions').val("Add");
        });
    });
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('person_detail/json_form'); ?>",
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
        $("#myModalLabel").text("Ubah Person_detail");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=id]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('person_detail/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#ModalaForm").modal("show");
                $("[name=id]").val(data.id);
                $("[name='person_id']").val(data.person_id);
                $("[name='date_born']").val(data.date_born);
                $("[name='where_born']").val(data.where_born);
                $("[name='address']").val(data.address);
                $("[name='dusun']").val(data.dusun);
                $("[name='kelurahan']").val(data.kelurahan);
                $("[name='kecamatan']").val(data.kecamatan);
                $("[name='kabupaten']").val(data.kabupaten);
                $("[name='provinsi']").val(data.provinsi);
                $("[name='zipcode']").val(data.zipcode);
                $("[name='nik']").val(data.nik);
                $("[name='kk']").val(data.kk);
                $("[name='religion']").val(data.religion);
                $("[name='nationality']").val(data.nationality);
                $("[name='anak_ke']").val(data.anak_ke);
                $("[name='jumlah_saudara_kandung']").val(data.jumlah_saudara_kandung);
                $("[name='weight']").val(data.weight);
                $("[name='height']").val(data.height);
                $("[name='email']").val(data.email);
                $("[name='phone']").val(data.phone);
                $("[name='name_father']").val(data.name_father);
                $("[name='name_mother']").val(data.name_mother);
                $("[name='nik_father']").val(data.nik_father);
                $("[name='nik_mother']").val(data.nik_mother);
                $("[name='work_father']").val(data.work_father);
                $("[name='education_father']").val(data.education_father);
                $("[name='earnings_father']").val(data.earnings_father);
                $("[name='phone_father']").val(data.phone_father);
                $("[name='work_mother']").val(data.work_mother);
                $("[name='education_mother']").val(data.education_mother);
                $("[name='earnings_mother']").val(data.earnings_mother);
                $("[name='phone_mother']").val(data.phone_mother);
                $('#action').val("Edit");
                $('#actions').val("Edit");
            }
        });
        return false;
    }

    function clear_data() {
        $("[name=id]").attr("readonly", false);
        $('.modal-title').text("Tambah Tbl_siswa");
        $('#action').val("Add");
        $('#actions').val("Add");
        $("#btn_ubah").attr("id", "btn_simpan");
        $("#btn_simpan").text("Simpan");
        $("[name=id]").val("");

        $("[name='person_id']").val("");
        $("[name='date_born']").val("");
        $("[name='where_born']").val("");
        $("[name='address']").val("");
        $("[name='dusun']").val("");
        $("[name='kelurahan']").val("");
        $("[name='kecamatan']").val("");
        $("[name='kabupaten']").val("");
        $("[name='provinsi']").val("");
        $("[name='zipcode']").val("");
        $("[name='nik']").val("");
        $("[name='kk']").val("");
        $("[name='religion']").val("");
        $("[name='nationality']").val("");
        $("[name='anak_ke']").val("");
        $("[name='jumlah_saudara_kandung']").val("");
        $("[name='weight']").val("");
        $("[name='height']").val("");
        $("[name='email']").val("");
        $("[name='phone']").val("");
        $("[name='name_father']").val("");
        $("[name='name_mother']").val("");
        $("[name='nik_father']").val("");
        $("[name='nik_mother']").val("");
        $("[name='work_father']").val("");
        $("[name='education_father']").val("");
        $("[name='earnings_father']").val("");
        $("[name='phone_father']").val("");
        $("[name='work_mother']").val("");
        $("[name='education_mother']").val("");
        $("[name='earnings_mother']").val("");
        $("[name='phone_mother']").val("");
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }
</script>