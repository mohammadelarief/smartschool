<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Class</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Idclass</label>
                        <div class="col-xs-9">
                        </div>
                    </div> -->
                    <input type="hidden" name="idclass" id="idclass" class="form-control" placeholder="Idclass" />
                    <div class="form-group">
                        <label class="control-label col-xs-3">Period</label>
                        <div class="col-xs-9">
                            <?= cmb_where('period_id', 'period', 'name_period', 'name_period', 'name_period', 'status'); ?>
                            <!-- <input type="text" name="period_id" id="period_id" class="form-control" placeholder="Period Id" /> -->
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Employee Id</label>
                        <div class="col-xs-9">
                            <input type="text" name="employee_id" id="employee_id" class="form-control" placeholder="Employee Id" />
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label class="control-label col-xs-3">Name Class</label>
                        <div class="col-xs-9">
                            <input type="text" name="name_class" id="name_class" class="form-control" placeholder="Name Class" />
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="control-label col-xs-3">Jenjang</label>
                        <div class="col-xs-9">
                            <input type="text" name="jenjang" id="jenjang" class="form-control" placeholder="Jenjang" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Tingkat</label>
                        <div class="col-xs-9">
                            <input type="text" name="tingkat" id="tingkat" class="form-control" placeholder="Tingkat" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-xs-3">Rombel</label>
                        <div class="col-xs-9">
                            <input type="text" name="rombel" id="rombel" class="form-control" placeholder="Rombel" />
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
                    <div class="form-group">
                        <label class="control-label col-xs-3">Capacity</label>
                        <div class="col-xs-9">
                            <input type="text" name="capacity" id="capacity" class="form-control" placeholder="Capacity" />
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
<!--END MODAL FORM-->