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
    <h3 align="center">DATA Class</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idclass</th>
		<th>Period Id</th>
		<th>Employee Id</th>
		<th>Name Class</th>
		<th>Jenjang</th>
		<th>Tingkat</th>
		<th>Rombel</th>
		<th>Status</th>
		<th>Capacity</th>
		
            </tr><?php
            foreach ($classes_data as $classes)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $classes->idclass ?></td>
		      <td><?php echo $classes->period_id ?></td>
		      <td><?php echo $classes->employee_id ?></td>
		      <td><?php echo $classes->name_class ?></td>
		      <td><?php echo $classes->jenjang ?></td>
		      <td><?php echo $classes->tingkat ?></td>
		      <td><?php echo $classes->rombel ?></td>
		      <td><?php echo $classes->status ?></td>
		      <td><?php echo $classes->capacity ?></td>	
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