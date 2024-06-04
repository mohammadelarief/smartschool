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
                "url": "employment_detail/json",
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
                    "data": "email"
                }, {
                    "data": "phone"
                }, {
                    "data": "relationship"
                }, {
                    "data": "name_partner"
                }, {
                    "data": "childrens"
                }, {
                    "data": "name_mother"
                }, {
                    "data": "npwp"
                }, {
                    "data": "position"
                }, {
                    "data": "status_employment"
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
                        url: "employment_detail/deletebulk",
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
            $('.modal-title').text("Tambah employment_detail");
            $('#action').val("Add");
            $('#actions').val("Add");
        });
    });
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('employment_detail/json_form'); ?>",
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
        $("#myModalLabel").text("Ubah Employee_detail");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=id]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('employment_detail/json_get'); ?>",
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
                $("[name='email']").val(data.email);
                $("[name='phone']").val(data.phone);
                $("[name='relationship']").val(data.relationship);
                $("[name='name_partner']").val(data.name_partner);
                $("[name='childrens']").val(data.childrens);
                $("[name='name_mother']").val(data.name_mother);
                $("[name='npwp']").val(data.npwp);
                $("[name='position']").val(data.position);
                $("[name='status_employment']").val(data.status_employment);
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
        $("[name='email']").val("");
        $("[name='phone']").val("");
        $("[name='relationship']").val("");
        $("[name='name_partner']").val("");
        $("[name='childrens']").val("");
        $("[name='name_mother']").val("");
        $("[name='npwp']").val("");
        $("[name='position']").val("");
        $("[name='status_employment']").val("");
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }
</script>