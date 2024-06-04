
<!-- MODAL FORM -->
<div class="modal fade" id="ModalaForm" tabindex="-1" role="dialog" aria-labelledby="largeModal" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="clear_data()" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3 class="modal-title" id="myModalLabel">Tambah Lesson</h3>
            </div>
            <form class="form-horizontal" method="post" id="form">
                <div class="modal-body">
	<div class="form-group">
                        <label class="control-label col-xs-3" >Idlesson</label>
                        <div class="col-xs-9">
                        <input type="text" name="idlesson" id="idlesson" class="form-control" placeholder="Idlesson" />
                        </div>
                    </div>
	<div class="form-group">
                        <label class="control-label col-xs-3" >Period Id</label>
                        <div class="col-xs-9">
                        <input type="text" name="period_id" id="period_id" class="form-control" placeholder="Period Id" />
                        </div>
                    </div>
	<div class="form-group">
                        <label class="control-label col-xs-3" >Lesson Nick</label>
                        <div class="col-xs-9">
                        <input type="text" name="lesson_nick" id="lesson_nick" class="form-control" placeholder="Lesson Nick" />
                        </div>
                    </div>
	<div class="form-group">
                        <label class="control-label col-xs-3" >Name Lesson</label>
                        <div class="col-xs-9">
                        <input type="text" name="name_lesson" id="name_lesson" class="form-control" placeholder="Name Lesson" />
                        </div>
                    </div></div>
 
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