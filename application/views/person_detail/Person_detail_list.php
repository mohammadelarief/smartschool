<div class="row">
<div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">List Person_detail</h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                    title="Collapse">
              <i class="fa fa-minus"></i></button>
              <button type="button" class="btn btn-box-tool" onclick="location.reload()" title="Refresh">
              <i class="fa fa-refresh"></i></button>
          </div>
      </div>

      <div class="box-body">
     
        <form id="myform" method="post" onsubmit="return false">

           <div class="row" style="margin-bottom: 10px">
            <div class="col-xs-12 col-md-4"><a href="#" id="add_button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalaForm"><span class="fa fa-plus"></span> Create</a></div>
            <div class="col-xs-12 col-md-4 text-center">
                <div style="margin-top: 4px"  id="message">
                    
                </div>
            </div>
            <div class="col-xs-12 col-md-4 text-right">
	    
         </div>
        </div>
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="mytable" style="width:100%">
            <thead>
                <tr>
                    <th width=""></th>
                    <th width="10px">No</th>
		    <th>Person Id</th>
		    <th>Date Born</th>
		    <th>Where Born</th>
		    <th>Address</th>
		    <th>Dusun</th>
		    <th>Kelurahan</th>
		    <th>Kecamatan</th>
		    <th>Kabupaten</th>
		    <th>Provinsi</th>
		    <th>Zipcode</th>
		    <th>Nik</th>
		    <th>Kk</th>
		    <th>Religion</th>
		    <th>Nationality</th>
		    <th>Anak Ke</th>
		    <th>Jumlah Saudara Kandung</th>
		    <th>Weight</th>
		    <th>Height</th>
		    <th>Email</th>
		    <th>Phone</th>
		    <th>Name Father</th>
		    <th>Name Mother</th>
		    <th>Nik Father</th>
		    <th>Nik Mother</th>
		    <th>Work Father</th>
		    <th>Education Father</th>
		    <th>Earnings Father</th>
		    <th>Phone Father</th>
		    <th>Work Mother</th>
		    <th>Education Mother</th>
		    <th>Earnings Mother</th>
		    <th>Phone Mother</th>
		 
                    <th width="80px">Action</th>   
                </tr>
            </thead>
            
	
        </table>
         </div>
        <button class="btn btn-danger" type="submit"><i class="fa fa-trash"></i> Hapus Data Terpilih</button>
        </form>

      </div>
    </div>
  </div>
</div>