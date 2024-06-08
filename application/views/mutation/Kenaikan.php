<div class="row">
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Kenaikan Kelas</h3>
            </div>
            <form id="myform" method="post" onsubmit="return false">
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-sm-9 form-horizontal">
                                <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Periode</label>

                                    <div class="col-sm-7">
                                        <?= cmb_periode('idperiode', 'period', 'name_period', 'name_period', null, 'DESC'); ?>
                                    </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
                                    <label for="inputEmail3" class="col-sm-5 control-label">Kelas Asal</label>

                                    <div class="col-sm-7">
                                        <select class="form-control select2 filter" id="idkelas" style="width: 100%;">
                                            <option value="all" selected="selected">[SEMUA KELAS]</option>

                                        </select>
                                    </div>
                                </div>
                                <button type="button" id="filter_get" class="btn btn-warning" style="display: none;">Apply Filter</button>
                                <button type="button" id="reset_filter" class="btn btn-danger" style="display: none;">Reset Filter</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-bottom: 10px">
                        <div class="col-xs-12 text-right">
                            <button class="btn btn-warning" type="submit"><i class="fas fa-share"></i> Proses</button>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped" id="mytable" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th width=""></th>
                                            <th class="text-center" width="10px">No</th>
                                            <th class="text-center">NIS</th>
                                            <th class="text-center">Nama</th>
                                            <th class="text-center">Gender</th>
                                        </tr>
                                    </thead>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-xs-6">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
                        <i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Refresh">
                        <i class="fa fa-refresh"></i></button>
                </div>
            </div>

            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-sm-9 form-horizontal">
                            <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
                                <label for="inputEmail3" class="col-sm-5 control-label">Periode Selanjutnya</label>

                                <div class="col-sm-7">
                                    <select class="form-control select2 filter" id="next_period" style="width: 100%;">
                                        <!-- <option value="all" selected="selected">[SEMUA KELAS]</option> -->

                                    </select>
                                </div>
                            </div>
                            <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
                                <label for="inputEmail3" class="col-sm-5 control-label">Kelas Tujuan</label>

                                <div class="col-sm-7">
                                    <select class="form-control select2 filter" id="next_class" style="width: 100%;">
                                        <option value="all" selected="selected">[SEMUA KELAS]</option>

                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="mytabless" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width=""></th>
                                        <th class="text-center" width="10px">No</th>
                                        <th class="text-center">NIS</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Gender</th>
                                    </tr>
                                </thead>


                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>