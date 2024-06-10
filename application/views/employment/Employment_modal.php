<!-- MODAL FORM -->
<div class="modal fade modal-fullscreen" id="ModalaForm" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="margin: 15px;width:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Employee</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
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
                                <label class="control-label col-xs-3">NIL</label>
                                <div class="col-xs-9">
                                    <input type="text" name="numberid" id="numberid" class="form-control" placeholder="Numberid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">NIP</label>
                                <div class="col-xs-9">
                                    <input type="text" name="nip" id="nip" class="form-control" placeholder="Nip" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">NIP.Y</label>
                                <div class="col-xs-9">
                                    <input type="text" name="nipy" id="nipy" class="form-control" placeholder="Nipy" />
                                </div>
                            </div>
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
                                        <label class="control-label col-xs-3">Email</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="email" id="email" class="form-control" placeholder="Email" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Phone</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Position</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="position" id="position" class="form-control" placeholder="Position" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Status Employment</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="status_employment" id="status_employment" class="form-control" placeholder="Status Employment" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label class="control-label col-xs-3">NIK</label>
                                <div class="col-xs-9">
                                    <input type="text" name="nik" id="nik" class="form-control" placeholder="Nik" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">Nomor KK</label>
                                <div class="col-xs-9">
                                    <input type="text" name="kk" id="kk" class="form-control" placeholder="Kk" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-xs-3">NPWP</label>
                                <div class="col-xs-9">
                                    <input type="text" name="npwp" id="npwp" class="form-control" placeholder="Npwp" />
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
                            <br>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Relationship</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="relationship" id="relationship" class="form-control" placeholder="Relationship" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Name Partner</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="name_partner" id="name_partner" class="form-control" placeholder="Name Partner" />
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Childrens</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="childrens" id="childrens" class="form-control" placeholder="Childrens" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-xs-3">Name Mother</label>
                                        <div class="col-xs-9">
                                            <input type="text" name="name_mother" id="name_mother" class="form-control" placeholder="Name Mother" />
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

<div class="modal fade modal-fullscreen" id="ModalaImport" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="margin: 15px;width:auto">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="resetForm()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Import Pegawai</h3>
            </div>
            <div class="modal-body">
                <a href="<?php echo base_url("assets/templates/import_employee.xlsx"); ?>" id="import_button" class="btn btn-sm btn-info" download><span class="fas fa-cloud-download-alt"></span> Download Template</a>
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
<!--END MODAL FORM-->