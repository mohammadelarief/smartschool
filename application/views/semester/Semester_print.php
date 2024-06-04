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
    <h3 align="center">DATA Semester</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idsemester</th>
		<th>Period Id</th>
		<th>Start Date</th>
		<th>End Date</th>
		<th>Description</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($semester_data as $semester)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $semester->idsemester ?></td>
		      <td><?php echo $semester->period_id ?></td>
		      <td><?php echo $semester->start_date ?></td>
		      <td><?php echo $semester->end_date ?></td>
		      <td><?php echo $semester->description ?></td>
		      <td><?php echo $semester->status ?></td>	
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