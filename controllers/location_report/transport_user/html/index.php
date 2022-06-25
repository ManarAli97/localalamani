


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >   مناقلات   مؤكدة </li>
				<li class="breadcrumb-item active" aria-current="page" > عرض المستخدمين </li>
			</ol>
		</nav>


		<hr>
	</div>
</div>




<script>
    var  table;
    $(document).ready(function() {

        var selected = [];

        table=$('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_transport_user/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },




            aLengthMenu: [ 10, 25, 50,100, 200, 300,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: " أبحث  ",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"


            },
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],

            bFilter: true, bInfo: true
        } );


    } );
</script>



<form action="<?php echo url.'/'.$this->folder?>/transport_user" method="get">

	<div class="row align-items-end">
		<div class="col-auto">
			من تاريخ
			<input type="datetime-local" name="date" class="form-control" value="<?php  echo $date ?>"  required>
		</div>
		<div class="col-auto">
			الى تاريخ
			<input type="datetime-local" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-warning" >بحث</button>
			<a href="<?php echo url.'/'.$this->folder?>/transport_user" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
		</div>
	</div>

</form>

<hr>



<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>


				<th>   المستخدمين  </th>
				<th>   عدد المناقلات   </th>


			</tr>
			</thead>

		</table>

	</div>
</div>


<style>

	table thead tr
	{
		text-align: center;
	}

	table tbody tr td
	{
		text-align: center;
	}


	.d-table
	{
		width:100%;
		border: 1px solid #c4c2c2;
		border-radius: 5px;
	}
</style>

<br>
<br>
<br>








