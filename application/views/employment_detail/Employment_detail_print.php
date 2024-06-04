<!DOCTYPE html>
<html>
<head>
    <title>Tittle</title>
    <style type="text/css" media="print">
    @page {
        margin: 0;  /* this affects the margin in the printer settings */
    }
      table{
        border-collapse: collapse;
        border-spacing: 0;
        width: 100%;
      }
      table th{
          -webkit-print-color-adjust:exact;
        border: 1px solid;

                padding-top: 11px;
    padding-bottom: 11px;
    background-color: #a29bfe;
      }
   table td{
        border: 1px solid;

   }
        </style>
</head>
<body>
    <h3 align="center">DATA Employee Detail</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
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
		<th>Email</th>
		<th>Phone</th>
		<th>Relationship</th>
		<th>Name Partner</th>
		<th>Childrens</th>
		<th>Name Mother</th>
		<th>Npwp</th>
		<th>Position</th>
		<th>Status Employment</th>
		
            </tr><?php
            foreach ($employment_detail_data as $employment_detail)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $employment_detail->person_id ?></td>
		      <td><?php echo $employment_detail->date_born ?></td>
		      <td><?php echo $employment_detail->where_born ?></td>
		      <td><?php echo $employment_detail->address ?></td>
		      <td><?php echo $employment_detail->dusun ?></td>
		      <td><?php echo $employment_detail->kelurahan ?></td>
		      <td><?php echo $employment_detail->kecamatan ?></td>
		      <td><?php echo $employment_detail->kabupaten ?></td>
		      <td><?php echo $employment_detail->provinsi ?></td>
		      <td><?php echo $employment_detail->zipcode ?></td>
		      <td><?php echo $employment_detail->nik ?></td>
		      <td><?php echo $employment_detail->kk ?></td>
		      <td><?php echo $employment_detail->religion ?></td>
		      <td><?php echo $employment_detail->nationality ?></td>
		      <td><?php echo $employment_detail->email ?></td>
		      <td><?php echo $employment_detail->phone ?></td>
		      <td><?php echo $employment_detail->relationship ?></td>
		      <td><?php echo $employment_detail->name_partner ?></td>
		      <td><?php echo $employment_detail->childrens ?></td>
		      <td><?php echo $employment_detail->name_mother ?></td>
		      <td><?php echo $employment_detail->npwp ?></td>
		      <td><?php echo $employment_detail->position ?></td>
		      <td><?php echo $employment_detail->status_employment ?></td>	
                </tr>
                <?php
            }
            ?>
        </table>
</body>
<script type="text/javascript">
      window.print()
    </script>
</html>