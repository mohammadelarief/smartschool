<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Person_detail</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label col-xs-3">Person Id</label>
                        <div class="col-xs-9">
                            <input type="text" name="person_id" id="person_id" class="form-control" placeholder="Person Id" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Date Born</label>
                        <div class="col-xs-9">
                            <input type="text" name="date_born" id="date_born" class="form-control" placeholder="Date Born" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Where Born</label>
                        <div class="col-xs-9">
                            <input type="text" name="where_born" id="where_born" class="form-control" placeholder="Where Born" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Address</label>
                        <div class="col-xs-9">
                            <textarea name="address" id="address" rows="3" class="form-control" placeholder="Address"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Dusun</label>
                        <div class="col-xs-9">
                            <input type="text" name="dusun" id="dusun" class="form-control" placeholder="Dusun" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kelurahan</label>
                        <div class="col-xs-9">
                            <input type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Kelurahan" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kecamatan</label>
                        <div class="col-xs-9">
                            <input type="text" name="kecamatan" id="kecamatan" class="form-control" placeholder="Kecamatan" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kabupaten</label>
                        <div class="col-xs-9">
                            <input type="text" name="kabupaten" id="kabupaten" class="form-control" placeholder="Kabupaten" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Provinsi</label>
                        <div class="col-xs-9">
                            <input type="text" name="provinsi" id="provinsi" class="form-control" placeholder="Provinsi" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Zipcode</label>
                        <div class="col-xs-9">
                            <input type="text" name="zipcode" id="zipcode" class="form-control" placeholder="Zipcode" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Nik</label>
                        <div class="col-xs-9">
                            <input type="text" name="nik" id="nik" class="form-control" placeholder="Nik" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Kk</label>
                        <div class="col-xs-9">
                            <input type="text" name="kk" id="kk" class="form-control" placeholder="Kk" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Religion</label>
                        <div class="col-xs-9">
                            <input type="text" name="religion" id="religion" class="form-control" placeholder="Religion" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Nationality</label>
                        <div class="col-xs-9">
                            <input type="text" name="nationality" id="nationality" class="form-control" placeholder="Nationality" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Anak Ke</label>
                        <div class="col-xs-9">
                            <input type="text" name="anak_ke" id="anak_ke" class="form-control" placeholder="Anak Ke" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Jumlah Saudara Kandung</label>
                        <div class="col-xs-9">
                            <input type="text" name="jumlah_saudara_kandung" id="jumlah_saudara_kandung" class="form-control" placeholder="Jumlah Saudara Kandung" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Weight</label>
                        <div class="col-xs-9">
                            <input type="text" name="weight" id="weight" class="form-control" placeholder="Weight" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Height</label>
                        <div class="col-xs-9">
                            <input type="text" name="height" id="height" class="form-control" placeholder="Height" />
                        </div>
                    </div>
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
                    <div class="form-group">
                        <label class="control-label col-xs-3">Name Father</label>
                        <div class="col-xs-9">
                            <input type="text" name="name_father" id="name_father" class="form-control" placeholder="Name Father" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Name Mother</label>
                        <div class="col-xs-9">
                            <input type="text" name="name_mother" id="name_mother" class="form-control" placeholder="Name Mother" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Nik Father</label>
                        <div class="col-xs-9">
                            <input type="text" name="nik_father" id="nik_father" class="form-control" placeholder="Nik Father" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Nik Mother</label>
                        <div class="col-xs-9">
                            <input type="text" name="nik_mother" id="nik_mother" class="form-control" placeholder="Nik Mother" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Work Father</label>
                        <div class="col-xs-9">
                            <input type="text" name="work_father" id="work_father" class="form-control" placeholder="Work Father" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Education Father</label>
                        <div class="col-xs-9">
                            <input type="text" name="education_father" id="education_father" class="form-control" placeholder="Education Father" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Earnings Father</label>
                        <div class="col-xs-9">
                            <input type="text" name="earnings_father" id="earnings_father" class="form-control" placeholder="Earnings Father" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Phone Father</label>
                        <div class="col-xs-9">
                            <input type="text" name="phone_father" id="phone_father" class="form-control" placeholder="Phone Father" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Work Mother</label>
                        <div class="col-xs-9">
                            <input type="text" name="work_mother" id="work_mother" class="form-control" placeholder="Work Mother" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Education Mother</label>
                        <div class="col-xs-9">
                            <input type="text" name="education_mother" id="education_mother" class="form-control" placeholder="Education Mother" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Earnings Mother</label>
                        <div class="col-xs-9">
                            <input type="text" name="earnings_mother" id="earnings_mother" class="form-control" placeholder="Earnings Mother" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Phone Mother</label>
                        <div class="col-xs-9">
                            <input type="text" name="phone_mother" id="phone_mother" class="form-control" placeholder="Phone Mother" />
                        </div>
                    </div>
                    <input type="hidden" name="id" />
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
<!--END MODAL FORM-->