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
    <h3 align="center">DATA Parent</h3>
    <h4>Tanggal Cetak : <?= date("d/M/Y");?> </h4>
    <table class="word-table" style="margin-bottom: 10px">
            <tr>
                <th>No</th>
		<th>Idparent</th>
		<th>Name</th>
		<th>Gender</th>
		<th>Nik</th>
		<th>Work</th>
		<th>Education</th>
		<th>Earnings</th>
		<th>Phone Number</th>
		<th>Position</th>
		<th>Status</th>
		
            </tr><?php
            foreach ($parent__data as $parent_)
            {
                ?>
                <tr>
		      <td><?php echo ++$start ?></td>
		      <td><?php echo $parent_->idparent ?></td>
		      <td><?php echo $parent_->name ?></td>
		      <td><?php echo $parent_->gender ?></td>
		      <td><?php echo $parent_->nik ?></td>
		      <td><?php echo $parent_->work ?></td>
		      <td><?php echo $parent_->education ?></td>
		      <td><?php echo $parent_->earnings ?></td>
		      <td><?php echo $parent_->phone_number ?></td>
		      <td><?php echo $parent_->position ?></td>
		      <td><?php echo $parent_->status ?></td>	
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