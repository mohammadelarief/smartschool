<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Employee_detail</h3>
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
                    <div class="form-group">
                        <label class="control-label col-xs-3">Npwp</label>
                        <div class="col-xs-9">
                            <input type="text" name="npwp" id="npwp" class="form-control" placeholder="Npwp" />
                        </div>
                    </div>
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