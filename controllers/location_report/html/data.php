<table class="table table-bordered  table-striped">
	<thead>
	<tr>

		<th scope="col">القسم</th>
		<th scope="col">الموقع</th>
		<th scope="col">الكود</th>
		<th scope="col">اللون</th>
		<th scope="col">الكمية</th>
		<th scope="col">ملاخظة</th>
		<th scope="col">حذف</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($data as $ta)  { ?>
	<tr id="row_db_<?php echo $ta['id'] ?>">
		<td> <?php echo $ta['model'] ?> </td>
		<td> <?php echo $ta['location'] ?> </td>
		<td> <?php echo $ta['code'] ?> </td>
		<td> <?php echo $ta['color'] ?> </td>
		<td> <?php echo $ta['quantity'] ?> </td>
        <td> <textarea class="form-control" onkeyup="enter_note(this,'<?php echo $ta['id'] ?>','<?php echo $ta['model'] ?>')"><?php echo $ta['note'] ?></textarea> </td>
        <td>  <button  class="btn btn-danger" type="button" onclick="delete_row_loc(<?php echo $ta['id'] ?>)"><i class="fa fa-times"></i> </button> </td>
	</tr>
 <?php } ?>
	</tbody>
</table>
<hr>
<div class="text-center">
	   <button  class="btn btn-primary" type="button" onclick="save_transport()">حفظ   </button>
</div>