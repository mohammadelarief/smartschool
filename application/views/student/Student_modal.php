<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForms" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Student</h3>

            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Idstudent</label>
                        <div class="col-xs-9">
                            <input type="text" name="idstudent" id="idstudent" class="form-control" placeholder="Idstudent" readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Class Id</label>
                        <div class="col-xs-9">
                            <select class="form-control select2 filter" id="class_id_" name="class_id" style="width: 100%;">

                            </select>
                            <!-- <input type="text" name="class_id" id="class_id" class="form-control" placeholder="Class Id" /> -->
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Personid</label>
                        <div class="col-xs-9">
                            <input type="text" name="personid" id="personid" class="form-control" placeholder="Personid" value="" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Status</label>
                        <div class="col-xs-9">
                            <?php
                            $options = array(
                                1 => 'Aktif',
                                0 => 'Nonaktif'
                            );
                            echo select_input('status', 'status', $options);
                            ?>
                            <!-- <input type="text" name="status" id="status" class="form-control" placeholder="Status" /> -->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn" onclick="clear_data()" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <input type="hidden" name="actions" id="actions" class="btn btn-success" value="Add" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen" id="ModalaImport" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="margin: 15px;width:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="resetForm()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Import Siswa</h3>
            </div>
            <div class="modal-body">
                <button id="download_button" class="btn btn-sm btn-info"><span class="fas fa-cloud-download-alt"></span> Download Template</button>
                <br>
                <br>
                <form method="post" id="uploadForm" enctype="multipart/form-data">
                    <div class="form-group  text-center">
                        <input type="file" name="file" id="file">
                    </div>
                </form>

                <div id="excel_data"></div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-success" type="button" onclick="uploadFile()">Upload</button>
                <input type="hidden" name="path_upload" id="path_upload">
                <input type="hidden" name="name_file" id="name_file">
                <button class="btn btn-info" style="display: none;" id="tampil_data">Tampilkan Data</button>
                <button class="btn btn-info" style="display: none;" id="import_data">Import Data</button>
                <button class="btn" onclick="resetForm()" data-dismiss="modal" aria-hidden="true">Tutup</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade modal-fullscreen" id="ModalaForm" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="margin: 15px;width:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Person</h3>
            </div>
            <form class="form-horizontal" method="post" id="form_person">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label col-xs-3">Nama</label>
                                <div class="col-xs-9">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">INDUK</label>
                                <div class="col-xs-9">
                                    <input type="text" name="numberid" id="numberid" class="form-control" placeholder="Numberid" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-3">NIK</label>
                                <div class="col-xs-9">
                                    <input type="text" name="nik" id="nik" class="form-control" placeholder="Nik" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">KK</label>
                                <div class="col-xs-9">
                                    <input type="text" name="kk" id="kk" class="form-control" placeholder="Kk" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">NISN</label>
                                <div class="col-xs-9">
                                    <input type="text" name="nisn" id="nisn" class="form-control" placeholder="Nisn" />
                                </div>
                            </div>
                            <!-- <div class="form-group">
                                <label class="control-label col-xs-3">Gender</label>
                                <div class="col-xs-9">
                                    <?php
                                    $options = array(
                                        'L' => 'Laki - Laki',
                                        'P' => 'Perempuan'
                                    );
                                    echo select_input('gender', 'gender', $options);
                                    ?>
                                     <input type="text" name="gender" id="gender" class="form-control" placeholder="Gender" /> 
                                </div>
                            </div> -->
                            <div class="form-group">
                                <label class="control-label col-xs-3">JENIS KELAMIN</label>
                                <div class="col-xs-9">
                                    <div class="radio">
                                        <label><input type="radio" name="gender" id="genderL" value="L">Laki - Laki</label>
                                        <label style="margin-left: 10px;"><input type="radio" name="gender" id="genderP" value="P">Perempuan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">TEMPAT LAHIR</label>
                                <div class="col-xs-3">
                                    <input type="text" name="where_born" id="where_born" class="form-control" placeholder="Where Born" />

                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">TANGGAL LAHIR</label>
                                </div>
                                <div class="col-xs-3">
                                    <input type="date" name="date_born" id="date_born" class="form-control" placeholder="Date Born" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">AGAMA</label>
                                <div class="col-xs-9">
                                    <?php
                                    $options = array(
                                        'Islam' => 'Islam',
                                        'Kristen' => 'Kristen',
                                        'Katolik' => 'Katolik',
                                        'Hindu' => 'Hindu',
                                        'Budha' => 'Budha',
                                        'Konghucu' => 'Konghucu'
                                    );
                                    echo select_input('religion', 'religion', $options);
                                    ?>
                                    <!-- <input type="text" name="religion" id="religion" class="form-control" placeholder="Religion" /> -->
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">KEWARGANEGARAAN</label>
                                <div class="col-xs-9">
                                    <div class="radio">
                                        <label><input type="radio" name="nationality" id="nationalityWNI" value="WNI">WNI</label>
                                        <label style="margin-left: 10px;"><input type="radio" name="nationality" id="nationalityWNA" value="WNA">WNA</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-3">Anak Ke</label>
                                <div class="col-xs-2">
                                    <input type="text" name="anak_ke" id="anak_ke" class="form-control" placeholder="Anak Ke" />
                                </div>
                                <div class="col-xs-3">
                                    <label class="control-label">dari</label>
                                </div>
                                <div class="col-xs-2">
                                    <input type="text" name="jumlah_saudara_kandung" id="jumlah_saudara_kandung" class="form-control" placeholder="Anak Ke" />
                                </div>
                                <div class="col-xs-2">
                                    <label class="control-label">Bersaudara</label>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-3">Status</label>
                                <div class="col-xs-9">
                                    <?php
                                    $options = array(
                                        1 => 'Aktif',
                                        0 => 'Nonaktif'
                                    );
                                    echo select_input('status', 'status', $options);
                                    ?>
                                    <!-- <input type="text" name="status" id="status" class="form-control" placeholder="Status" /> -->
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">BERAT BADAN</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="weight" id="weight" class="form-control" placeholder="Weight" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">TINGGI BADAN</label>
                                        <div class="col-xs-8">
                                            <input type="text" name="height" id="height" class="form-control" placeholder="Height" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">EMAIL</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">NO. TELP</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="form-group">
                                        <label class="control-label col-xs-4"> </label>
                                        <label class="text-center col-xs-4">AYAH</label>
                                        <label class="text-center col-xs-4">IBU</label>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">NAMA</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="name_father" id="name_father" class="form-control" placeholder="Name" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="name_mother" id="name_mother" class="form-control" placeholder="Name" />
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-4">NIK</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="nik_father" id="nik_father" class="form-control" placeholder="Nik" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="nik_mother" id="nik_mother" class="form-control" placeholder="Nik" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">PEKERJAAN</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="work_father" id="work_father" class="form-control" placeholder="Work" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="work_mother" id="work_mother" class="form-control" placeholder="Work" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">PENDIDIKAN</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="education_father" id="education_father" class="form-control" placeholder="Education" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="education_mother" id="education_mother" class="form-control" placeholder="Education" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">PENGHASILAN</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="earnings_father" id="earnings_father" class="form-control" placeholder="Earnings" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="earnings_mother" id="earnings_mother" class="form-control" placeholder="Earnings" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-4">NO. TELP</label>
                                        <div class="col-xs-4">
                                            <input type="text" name="phone_number_father" id="phone_number_father" class="form-control" placeholder="Phone Number" />
                                        </div>
                                        <div class="col-xs-4">
                                            <input type="text" name="phone_number_mother" id="phone_number_mother" class="form-control" placeholder="Phone Number" />
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-xs-3">ALAMAT</label>
                                <div class="col-xs-9">
                                    <textarea name="address" id="address" rows="3" class="form-control" placeholder="Address"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">PROVINSI</label>
                                        <div class="col-xs-9">
                                            <select name="provinsi" class="form-control select2" style="width: 100%;" id="provinsi">
                                                <option value="" selected disabled hidden>- Pilih Provinsi -</option>
                                                <?php
                                                foreach ($provinsi_ind as $prov) {
                                                    echo '<option value="' . $prov->provinsiId . '">' . $prov->provinsiNama . '</option>';
                                                }
                                                ?>
                                            </select>
                                            <!-- <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Provinsi" /> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">KABUPATEN</label>
                                        <div class="col-xs-9">
                                            <select name="kabupaten" class="form-control select2" style="width: 100%;" id="kabupaten">
                                                <option value="" selected disabled hidden>- Pilih Kabupaten -</option>
                                            </select>
                                            <!-- <input type="text" name="kabupaten" id="kabupaten" class="form-control" placeholder="Kabupaten" /> -->
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-xs-3">KECAMATAN</label>
                                        <div class="col-xs-9">
                                            <select name="kecamatan" class="form-control select2" style="width: 100%;" id="kecamatan">
                                                <option value="" selected disabled hidden>- Pilih Kecamatan -</option>
                                            </select>
                                            <!-- <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Kecamatan" /> -->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">KELURAHAN</label>
                                        <div class="col-xs-9">
                                            <select name="kelurahan" class="form-control select2" style="width: 100%;" id="kelurahan">
                                                <option value="" selected disabled hidden>- Pilih Kelurahan -</option>
                                            </select>
                                            <!-- <input type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Kelurahan" /> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">DUSUN</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="dusun" id="dusun" class="form-control" placeholder="Dusun" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">KODEPOS</label>
                                        <div class="col-xs-9">
                                            <select name="zipcode" class="form-control select2" style="width: 100%;" id="zipcode">
                                                <option value="" selected disabled hidden>- Pilih Kode Pos -</option>
                                            </select>
                                            <!-- <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zipcode" /> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="idperson" />
                </div>

                <div class="modal-footer">
                    <button class="btn" onclick="clear_data()" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <input type="hidden" name="actions" id="actions" class="btn btn-success" value="Add" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="ModalaMutation" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog" style="margin: 15px;width:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="resetForm()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Mutation</h3>
            </div>
            <form class="form-horizontal" method="post" id="form_mutation">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="box box-primary">
                                <div class="box-body box-profile">

                                    <h3 class="profile-username text-center"></h3>

                                    <!-- <p class="text-muted text-center">Software Engineer</p> -->

                                    <ul class="list-group list-group-unbordered">
                                        <li class="list-group-item">
                                            <b>NIS</b> <a class="pull-right _nis"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>NISN</b> <a class="pull-right _nisn"></a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Kelas</b> <a class="pull-right _class"></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-9">
                            <div class="form-group">
                                <label class="control-label col-xs-3">Jenis Mutasi</label>
                                <div class="col-xs-9">
                                    <select name="cfg_mutation_id" class="form-control select2" style="width: 100%;" id="cfg_mutation_id">
                                        <option value="" selected disabled hidden>- Pilih Jenis Mutasi -</option>
                                        <?php
                                        foreach ($mutation_cfg as $cfg_m) {
                                            echo '<option value="' . $cfg_m->idmutasi . '">' . $cfg_m->title . '</option>';
                                        }
                                        ?>
                                    </select>
                                    <!-- <input type="text" name="cfg_mutation_id" id="cfg_mutation_id" class="form-control" placeholder="Cfg Mutation Id" /> -->
                                </div>
                            </div>
                            <div class="form-group" style="display: none;" id="next_class">
                                <label class="control-label col-xs-3">Kelas Selanjutnya</label>
                                <div class="col-xs-9">
                                    <select class="form-control" id="new_classes" name="new_classes">

                                    </select>
                                    <!-- <input type="text" name="new_classes" id="new_classes" class="form-control" placeholder="New Classes" /> -->
                                </div>
                            </div>
                            <div class="form-group" style="display: none;" id="next_school">
                                <label class="control-label col-xs-3">Sekolah Selanjutnya</label>
                                <div class="col-xs-9">
                                    <input type="text" name="info" id="info" class="form-control" placeholder="Sekolah Selanjutnya" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Date Mutation</label>
                                <div class="col-xs-9">
                                    <input type="date" name="date_mutation" id="date_mutation" class="form-control" placeholder="Date Mutation" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Keterangan</label>
                                <div class="col-xs-9">
                                    <textarea name="keterangan" id="keterangan" rows="3" class="form-control" placeholder="Keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" name="jenjang" id="jenjang" class="form-control" placeholder="jenjang" />
                    <input type="hidden" name="idmutation" id="idmutation" class="form-control" placeholder="Idmutation" />
                    <input type="hidden" name="student_id" id="student_id" class="form-control" placeholder="Student Id" />
                    <input type="hidden" name="person_id" id="person_id" class="form-control" placeholder="Person Id" />
                    <input type="hidden" name="old_classes" id="old_classes" class="form-control" placeholder="Old Classes" />
                    <input type="hidden" name="user_id" id="user_id" class="form-control" placeholder="User Id" />
                    <input type="hidden" name="status" id="status" class="form-control" placeholder="Status" />
                </div>

                <div class="modal-footer">
                    <button class="btn" onclick="resetForm()" data-dismiss="modal" aria-hidden="true">Tutup</button>
                    <input type="hidden" name="actions" id="actions" class="btn btn-success" value="Add" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                </div>
            </form>
        </div>
    </div>
</div>
<!--END MODAL FORM-->