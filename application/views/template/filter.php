<div class="row" style="margin-bottom: 5px">
    <div class="col-sm-4 form-horizontal">
        <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
            <label for="inputEmail3" class="col-sm-5 control-label">Periode</label>

            <div class="col-sm-7">
                <?= cmb_periode('idperiode', 'period', 'name_period', 'name_period', null, 'DESC'); ?>
            </div>
        </div>
        <!-- <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
            <label for="inputEmail3" class="col-sm-5 control-label">Semester</label>

            <div class="col-sm-7">
                <select class="form-control select2 filter" id="idsemester" style="width: 100%;">
                    <option></option>

                </select>
            </div>
        </div> -->
    </div>
    <div class="col-sm-4 form-horizontal">
        <?php
        $uri = $this->uri->segment(1);
        $uri2 = $this->uri->segment(2);
        if ($uri == "student" || $uri == "lesson") {
            echo '
        <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
            <label for="inputEmail3" class="col-sm-5 control-label">Kelas</label>

            <div class="col-sm-7">
                <select class="form-control select2 filter" id="idkelas" style="width: 100%;">
                    <option value="all" selected="selected">[SEMUA KELAS]</option>

                </select>
            </div>
        </div>
        ';
        } else if ($uri == "employment" && $uri2 == "status") {
            echo '
        <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
            <label for="inputEmail3" class="col-sm-5 control-label">Status</label>

            <div class="col-sm-7">
                <select class="form-control select2 filter" id="idstatus" style="width: 100%;">
                    <option value="all" selected="selected">[SEMUA STATUS]</option>
                    <option value="GTT" >GTT</option>
                    <option value="GTY" >GTY</option>
                    <option value="PTT" >PTT</option>
                    <option value="PTY" >PTY</option>

                </select>
            </div>
        </div>
        ';
        } else if ($uri == "employment" && $uri2 == "group") {
            echo '
        <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
            <label for="inputEmail3" class="col-sm-5 control-label">Grup Kepegawaian</label>

            <div class="col-sm-7">
                <select class="form-control select2 filter" id="idgroup" style="width: 100%;">
                    <option value="all" selected="selected">[SEMUA GRUP]</option>
                    <option value="1" >GURU</option>
                    <option value="2" >STRUKTURAL</option>

                </select>
            </div>
        </div>
        ';

        }
        ?>
    </div>
    <div class="col-sm-4 form-horizontal">
        <div class="form-group" style="margin-bottom: 5px; margin-top: 5px">
            <label for="inputEmail3" class="col-sm-5 control-label"></label>

            <div class="col-sm-7">
                <button type="submit" id="filter_get" class="btn btn-warning">Apply Filter</button>
                <button type="submit" id="reset_filter" class="btn btn-danger">Reset Filter</button>
            </div>
        </div>
    </div>
</div>