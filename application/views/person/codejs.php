<script type="text/javascript">
    var previewData = [];
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
                "url": "person/json",
                "type": "POST"
            },
            columns: [{
                    "data": "idperson",
                    "orderable": false,
                    "className": "text-center"
                },
                {
                    "data": "idperson",
                    "orderable": false
                }, {
                    "data": "numberid",
                    "className": "text-center"
                }, {
                    "data": "name",
                    createdCell: function(td, cellData, data, row, col) {
                        $(td).html('<a href="#" class="modal_detail" name="' + data.numberid + '" id="' + data.numberid + '" >' + data.name + '</a>');
                    }
                }, {
                    "data": "nisn",
                    "className": "text-center"
                }, {
                    "data": "gender",
                    "className": "text-center"
                }, {
                    "data": "status",
                    "className": "text-center"
                }
                // ,
                // {
                //     "data": "action",
                //     "orderable": false,
                //     "className": "text-center"
                // }
            ],
            columnDefs: [{
                    className: "text-center",
                    targets: 0,
                    checkboxes: {
                        selectRow: true,
                    }
                },
                {
                    "targets": 6,
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
        t.on('click', '.modal_detail', function() {
            var id = $(this).attr("id");
            $('.modal-title').text("Ubah Data");
            edit_data(id);
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
                        url: "person/deletebulk",
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
            $('.modal-title').text("Tambah person");
            $('#action').val("Add");
            $('#actions').val("Add");
        });

        $("#provinsi").change(function() {
            var url = "<?php echo site_url('Helpers/add_ajax_kab'); ?>/" + $(this).val();
            $('#kabupaten').load(url);
            return false;
        })
        $("#kabupaten").change(function() {
            var url = "<?php echo site_url('Helpers/add_ajax_kec'); ?>/" + $(this).val();
            $('#kecamatan').load(url);
            return false;
        })

        $("#kecamatan").change(function() {
            var url = "<?php echo site_url('Helpers/add_ajax_des'); ?>/" + $(this).val();
            $('#kelurahan').load(url);
            return false;
        })
        $("#kelurahan").change(function() {
            var url = "<?php echo site_url('Helpers/add_ajax_kodepos'); ?>/" + $(this).val();
            $('#zipcode').load(url);
            return false;
        });

        $('#tampil_data').click(function() {
            var file_path = $('#path_upload').val();
            if (file_path !== "") {
                $.ajax({
                    url: "<?php echo base_url('helpers/get_excel_data'); ?>",
                    type: "POST",
                    data: {
                        file_path: file_path
                    },
                    dataType: 'json',
                    success: function(response) {
                        // Tampilkan data dalam tabel atau format yang sesuai
                        console.log(response);
                        // response = JSON.parse(response);
                        if (response.status == 'success') {
                            previewData = response.data;
                            // var data = response.data;
                            var previewHtml = '<br><table class="table table-striped"><thead><tr><th class="text-center">Nama</th><th class="text-center">NIS</th><th class="text-center">NISN</th><th class="text-center">NIS EMIS</th><th class="text-center">JK</th><th class="text-center">STATUS</th></tr></thead>                            <tbody>';
                            $.each(previewData, function(index, row) {
                                previewHtml += '<tr><td class="text-center">' + row['C'] + '</td><td class="text-center">' + row['B'] + '</td><td class="text-center">' + row['D'] + '</td><td class="text-center">' + row['E'] + '</td><td class="text-center">' + row['F'] + '</td><td class="text-center">' + row['G'] + '</td></tr>';
                            });
                            previewHtml += '</tbody></table>';
                            $('#excel_data').html(previewHtml); // atau append ke dalam div #excel_data
                            $('#import_data').show();

                        }
                    }
                });
            } else {
                alert('Anda belum mengunggah file Excel.');
            }
        });
        $('#import_data').click(function() {
            var file_path = $('#path_upload').val();
            $.ajax({
                url: '<?= base_url('person/import') ?>',
                type: 'POST',
                data: {
                    file_path: file_path
                },
                dataType: 'json',
                success: function(response) {
                    $('#ModalaImport').modal('hide');
                    t.ajax.reload();
                    // response = JSON.parse(response);
                    $('#response').html(response.message);
                }
            });
        });

    });

    $(document).on('submit', '#form', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: "<?php echo base_url('person/json_form'); ?>",
            method: 'POST',
            // data: new FormData(this),

            data: formData,
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
                        if (element.is('input:radio') || element.is('select')) {
                            element = element.parent();
                        }

                        element.closest('div.form-group')
                            .removeClass('has-error')
                            .addClass(value.length > 0 ? 'has-error' : '')
                            .find('.text-danger')
                            .remove();

                        element.after(value)

                    });
                }
            }
        });
    });

    function uploadFile() {
        $('.modal-title').text("Form Upload");
        var formData = new FormData();
        formData.append('file', $('#file')[0].files[0]);

        $.ajax({
            url: '<?= base_url("helpers/form_excel"); ?>',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                if (response.status == 'success') {
                    console.log(response);
                    $('#tampil_data').show();
                    $('#path_upload').val(response.userfile.full_path);
                    $('#name_file').val(response.userfile.file_name);

                } else {
                    console.log(response);
                }
                // Handle success response
            }
        });
    }

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
        $("#myModalLabel").text("Ubah Person");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=idperson]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('person/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#ModalaForm").modal("show");
                $("[name=idperson]").val(data.idperson);
                $("[name='name']").val(data.name);
                $('#numberid').prop('readonly', true);
                $("[name='numberid']").val(data.numberid);
                $("[name='nisn']").val(data.nisn);
                var genders = data.gender;
                if (genders == 'L') {
                    $("#genderL").prop('checked', true);
                } else if (genders == 'P') {
                    $("#genderP").prop('checked', true);
                }
                var nationalitys = data.nationality;
                if (nationalitys == 'WNI') {
                    $("#nationalityWNI").prop('checked', true);
                } else if (nationalitys == 'WNA') {
                    $("#nationalityWNA").prop('checked', true);
                }
                $("[name='status']").val(data.status);

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
                // $("[name='nationality']").val(data.nationality);
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
        $("[name=idperson]").attr("readonly", false);
        $('.modal-title').text("Tambah Tbl_siswa");
        $('#action').val("Add");
        $('#actions').val("Add");
        $("#btn_ubah").attr("id", "btn_simpan");
        $("#btn_simpan").text("Simpan");
        $("[name=idperson]").val("");

        $("[name='name']").val("");
        $("[name='numberid']").val("");
        $("[name='nisn']").val("");
        // $("[name='gender']").val("");
        $("[name='status']").val("");
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }

    function resetForm() {
        $('#uploadForm')[0].reset();
        $('#excel_data').empty();
        $('#import_data').hide();
        $('#tampil_data').hide();
        // $('#importButton').prop('disabled', true);
        filePath = '';
    }
</script>