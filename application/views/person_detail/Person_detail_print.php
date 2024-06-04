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
    <h3 align="center">DATA Person Detail</h3>
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
		
            </tr><?php
            foreach ($person_detail_data as $person_detail)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $person_detail->person_id ?></td>
		      <td><?php echo $person_detail->date_born ?></td>
		      <td><?php echo $person_detail->where_born ?></td>
		      <td><?php echo $person_detail->address ?></td>
		      <td><?php echo $person_detail->dusun ?></td>
		      <td><?php echo $person_detail->kelurahan ?></td>
		      <td><?php echo $person_detail->kecamatan ?></td>
		      <td><?php echo $person_detail->kabupaten ?></td>
		      <td><?php echo $person_detail->provinsi ?></td>
		      <td><?php echo $person_detail->zipcode ?></td>
		      <td><?php echo $person_detail->nik ?></td>
		      <td><?php echo $person_detail->kk ?></td>
		      <td><?php echo $person_detail->religion ?></td>
		      <td><?php echo $person_detail->nationality ?></td>
		      <td><?php echo $person_detail->anak_ke ?></td>
		      <td><?php echo $person_detail->jumlah_saudara_kandung ?></td>
		      <td><?php echo $person_detail->weight ?></td>
		      <td><?php echo $person_detail->height ?></td>
		      <td><?php echo $person_detail->email ?></td>
		      <td><?php echo $person_detail->phone ?></td>
		      <td><?php echo $person_detail->name_father ?></td>
		      <td><?php echo $person_detail->name_mother ?></td>
		      <td><?php echo $person_detail->nik_father ?></td>
		      <td><?php echo $person_detail->nik_mother ?></td>
		      <td><?php echo $person_detail->work_father ?></td>
		      <td><?php echo $person_detail->education_father ?></td>
		      <td><?php echo $person_detail->earnings_father ?></td>
		      <td><?php echo $person_detail->phone_father ?></td>
		      <td><?php echo $person_detail->work_mother ?></td>
		      <td><?php echo $person_detail->education_mother ?></td>
		      <td><?php echo $person_detail->earnings_mother ?></td>
		      <td><?php echo $person_detail->phone_mother ?></td>	
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