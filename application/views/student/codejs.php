<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript">
    var previewData = [];
    let periode = $("#name_period").val(),
        kls = $("#idkelas").val(),
        jenjang = $("#jenjang").val()
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
        t.ajax.reload();
    });
    $('#reset_filter').click(function() {
        // $("#idunit").val('all').trigger("change");
        $("#idkelas").val('all').trigger("change");
        periode = $("#name_period").val();
        // unit = $("#idunit").val();
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
                }, {
                    "data": "name_class",
                    "className": "text-center"
                }, {
                    "data": "status",
                    "className": "text-center"
                },
                {
                    "data": null,
                    "defaultContent": '<button class="btn btn-info btn-xs modal-mutation"><i class="fa fa-share"></i></button> <button class="btn btn-primary btn-xs view-details"><i class="fa fa-info"></i></button>',
                    "orderable": false,
                    "className": "text-center",
                    searchable: false
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
                [5, 'asc'],
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
        //                 url: "student/deletebulk",
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
            prd = $("#name_period").val();
            $('#form')[0].reset();
            $('.modal-title').text("Tambah student");
            $('#action').val("Add");
            $('#actions').val("Add");
            $.ajax({
                url: "<?php echo base_url(); ?>helpers/get_filter_kelas",
                method: "POST",
                data: {
                    periode: prd
                },
                async: false,
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    var i;

                    // html += '<option value="all" selected="selected">[SEMUA KELAS]</option>';
                    for (i = 0; i < data.length; i++) {
                        html += '<option value=' + data[i].idclass + '>' + data[i].name_class + '</option>';
                    }
                    $('#class_id_').html(html);
                }
            });

            var autocompleteInput = $("#personid");
            autocompleteInput.autocomplete({
                source: "<?= site_url('student/get_autocomplete'); ?>",
                select: function(event, ui) {
                    $('[name="personid"]').val(ui.item.value);
                },
                minLength: 3 // Jumlah karakter minimum sebelum permintaan AJAX dilakukan
            }).data("ui-autocomplete")._renderItem = function(ul, item) {
                return $("<li>")
                    .append("<div class='box box-solid'><div class='box-header with-border bg-info'><i class='fa fa-user'></i><h3 class='box-title'>" + item.label + "</h3></div><div class='box-body' style='margin-top:-17px;'><div><br><span class='label bg-gray-active'>ID Person</span><span class='pull-right'>" + item.value + "</span><br><span class='label bg-gray-active'>Nama</span><span class='pull-right'>" + item.label + "</span></div></div></div>")
                    .appendTo(ul);
            };
            autocompleteInput.autocomplete("option", "appendTo", ".eventInsForm");

            val = "S";
            $.ajax({
                url: "<?php echo base_url('helpers/uniqid'); ?>",
                type: "POST",
                data: {
                    _uniq: val
                },
                dataType: "json",
                success: function(data) {
                    // console.log(data.hasil);
                    $("[name='idstudent']").val(data.hasil);
                }
            });
        });
        $('#cfg_mutation_id').change(function() {
            var vals = $('#cfg_mutation_id').val();
            mutation(vals);

        });
        $('#download_button').click(function() {
            prd = $("#name_period").val();

            // Kirim nilai input ke controller menggunakan AJAX
            $.ajax({
                url: '<?php echo base_url("student/generate_excel"); ?>',
                type: 'POST',
                data: {
                    periode: prd
                },
                success: function(response) {
                    // Berhasil, lakukan pengunduhan file
                    window.location.href = '<?php echo base_url("student/download_excel"); ?>';
                }
            });
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
                            var previewHtml = '<br><table class="table table-striped"><thead><tr><th class="text-center">NIS</th><th class="text-center">Kelas</th></tr></thead>                            <tbody>';
                            $.each(previewData, function(index, row) {
                                previewHtml += '<tr><td class="text-center">' + row['B'] + '</td><td class="text-center">' + row['C'] + '</td></tr>';
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
                url: '<?= base_url('student/import') ?>',
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

        getkelasfilter();

        t.on('click', '.modal_detail', function() {
            var id = $(this).attr("id");
            $('.modal-title').text("Ubah Data Person");
            edit_data_siswa(id);
        });
        t.on('click', '.modal-mutation', function() {
            var data = t.row($(this).parents('tr')).data();
            $('.modal-title').text("Mutasi Siswa");
            mutation_data(data.idstudent);
        });
        t.on('click', '.view-details', function() {
            var tr = $(this).closest('tr');
            var row = t.row(tr);

            if (row.child.isShown()) {
                row.child.hide();
                tr.removeClass('shown');
            } else {
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });
    $(document).on('submit', '#form', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('student/json_form'); ?>",
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    $('#ModalaForms').modal('hide');
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

    $(document).on('submit', '#form_person', function(event) {
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
                    $('#form_person')[0].reset();
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

    $(document).on('submit', '#form_mutation', function(event) {
        event.preventDefault();

        $.ajax({
            url: "<?php echo base_url('mutation/json_form'); ?>",
            method: 'POST',
            data: new FormData(this),
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(data) {
                if (data.status) {
                    $('#ModalaMutation').modal('hide');
                    $('#form_mutation')[0].reset();
                    t.ajax.reload();
                    resetForm();
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

    function mutation(vals) {
        $("#next_class").hide();
        $("#next_school").hide();
        switch (vals) {
            case 'JM17165374291XG3':
                // pindah sekolah
                $("#next_school").show();
                break;
            case 'JM1716537721T7T3':
                // pindah kelas
                var jenjang = $("#jenjang").val();
                $.ajax({
                    url: "<?= base_url('helpers/get_kelas'); ?>",
                    type: "POST",
                    data: {
                        jenjang: jenjang,
                        type: vals,
                        periode: periode
                    },
                    dataType: "json",
                    success: function(data) {
                        var select1 = $('#new_classes');
                        select1.empty();
                        select1.append('<option value="" disabled>-- Pilih Kelas --</option>');
                        $.each(data, function(key, value) {
                            select1.append('<option value="' + value.idclass + '">' + value.name_class + '</option>');
                        });
                    }
                });
                $("#next_class").show();
                break;
            case 'JM17165377488HZS':
                // pindah tingkat
                var jenjang = $("#jenjang").val();
                $.ajax({
                    url: "<?= base_url('helpers/get_kelas'); ?>",
                    type: "POST",
                    data: {
                        jenjang: jenjang,
                        type: vals,
                        periode: periode
                    },
                    dataType: "json",
                    success: function(data) {
                        var select1 = $('#new_classes');
                        select1.empty();
                        select1.append('<option value="" disabled>-- Pilih Kelas --</option>');
                        $.each(data, function(key, value) {
                            select1.append('<option value="' + value.idclass + '">' + value.name_class + '</option>');
                        });
                    }
                });
                $("#next_class").show();
                break;
            default:
                return;
        }
    }

    function format(d) {
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
            '<tr>' +
            '<td>Name</td>' +
            '<td>' + d.name + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Gender</td>' +
            '<td>' + d.gender + '</td>' +
            '</tr>' +
            '<tr>' +
            '<td>Kelas</td>' +
            '<td>' + d.name_class + '</td>' +
            '</tr>' +
            '</table>';
    }

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

                html += '<option value="all" selected="selected">[SEMUA KELAS]</option>';
                for (i = 0; i < data.length; i++) {
                    html += '<option value=' + data[i].idclass + '>' + data[i].name_class + '</option>';
                }
                $('#idkelas').html(html);
            }
        });
        $("#filter_get").click();
    }

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
        $("#myModalLabel").text("Ubah Student");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=idstudent]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('student/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $("#ModalaForms").modal("show");
                $("[name='idstudent']").val(data.idstudent);
                $("[name='class_id']").val(data.class_id);
                $("[name='personid']").val(data.personid);
                $("[name='status']").val(data.status);
                $('#ModalaForms #action').val("Edit");
                $('#ModalaForms #actions').val("Edit");
            }
        });
        return false;
    }

    function mutation_data(id) {
        $("#myModalLabel").text("Ubah Student");
        $("#btn_simpan").attr("id", "btn_ubah");
        $("#btn_ubah").text("Ubah");
        $("[name=idstudent]").attr("readonly", true);
        $.ajax({
            url: "<?php echo base_url('student/json_get'); ?>",
            type: "POST",
            data: {
                id: id
            },
            dataType: "json",
            success: function(data) {
                $('#ModalaMutation').modal('show');
                val = "M";
                $.ajax({
                    url: "<?php echo base_url('helpers/uniqid'); ?>",
                    type: "POST",
                    data: {
                        _uniq: val
                    },
                    dataType: "json",
                    success: function(data) {
                        // console.log(data.hasil);
                        $("[name='idmutation']").val(data.hasil);
                    }
                });

                $('.profile-username').text(data.name);
                $('._class').text(data.name_class);
                $('._nis').text(data.numberid);
                $('._nisn').text(data.nisn);
                $("[name='student_id']").val(data.idstudent);
                $("[name='jenjang']").val(data.jenjang);
                $("[name='old_classes']").val(data.class_id);
                $("[name='person_id']").val(data.personid);
                $("[name='status']").val(data.status);
                $('#ModalaMutation #action').val("Add");
                $('#ModalaMutation #actions').val("Add");
            }
        });
        return false;
    }

    function edit_data_siswa(id) {
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
                $('#ModalaForm #action').val("Edit");
                $('#ModalaForm #actions').val("Edit");
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

            }
        });
        return false;
    }

    function clear_data() {
        $("[name=idstudent]").attr("readonly", false);
        $('.modal-title').text("Tambah Tbl_siswa");
        $('#action').val("Add");
        $('#actions').val("Add");
        $("#btn_ubah").attr("id", "btn_simpan");
        $("#btn_simpan").text("Simpan");
        $("[name='idstudent']").val("");
        $("[name='class_id']").val("");
        $("[name='personid']").val("");
        $("[name='status']").val("");
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
    }

    function resetForm() {
        $('#uploadForm')[0].reset();
        $('#form_mutation')[0].reset();
        $('#excel_data').empty();
        $('#import_data').hide();
        $('#tampil_data').hide();
        // $('#importButton').prop('disabled', true);
        filePath = '';
        $(".form-group").toggleClass("has-success has-error", false);
        $(".text-danger").hide();
        $("#next_class").hide();
        $("#next_school").hide();
    }
</script>