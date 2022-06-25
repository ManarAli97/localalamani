


<br>

<div class="row">
	<div class="col">
		<span></span>
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/location"><?php  echo $this->langControl('location_report') ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >   مناقلات   مؤكدة </li>
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
            "ajax": "<?php echo url .'/'. $this->folder ?>/processing_transport_confirm/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },

            "order": [[ 2, 'asc'] ],
            'columnDefs': [{
                "targets": [1],
                "orderable": false
            }],

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



<form action="<?php echo url.'/'.$this->folder?>/transport_confirm" method="get">

	<div class="row align-items-end">
		<div class="col-auto">
			من تاريخ
			<input type="date" name="date" class="form-control" value="<?php  echo $date ?>"  required>
		</div>
		<div class="col-auto">
			الى تاريخ
			<input type="date" name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
		</div>
		<div class="col-auto">
			<button type="submit" class="btn btn-warning" >بحث</button>
			<a href="<?php echo url.'/'.$this->folder?>/transport_confirm" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
		</div>
	</div>

</form>
<hr>
<?php   if (!empty($bill)) {  ?>

    <button  id="export_g" class="btn btn-warning" onclick="add_group()" >   <span>   تصدير المناقلات  الى مجموعة </span>  <span class="badge badge-info"> <?php  echo count($bill) ?>  </span>

        <span  id="loading_bos" style="vertical-align: sub;color: #ffffFF;display: none" class="spinner-border   spinner-border-sm" role="status" aria-hidden="true"></span>
    </button>
<?php  } else {  ?>

    <button    class="btn btn-warning"  onclick="alert('لا توجد المناقلات مؤكدة جديدة')" >  <span>   تصدير المناقلات الى مجموعة </span>  <span class="badge badge-info"> <?php  echo count($bill) ?>     </button>

<?php  } ?>
<hr>
<br>

<script>




    function add_group(){

        $('#loading_bos').show();

        $.get( "<?php echo url.'/'.$this->folder?>/add_group", function( data ) {


            if (data)
            {
                $('#loading_bos').show();
                window.location="<?php   echo  url.'/'.$this->folder   ?>/export_group?g="+data;
            }else
            {
                alert('فشل انشاء مجموعة')
                $('#loading_bos').hide();
            }

        });

    }



    function delete_transport(transport) {

        if (confirm(    ' هل انت متأكد من حذف المناقلة ذات الرقم ' + transport + "  ؟  "  )){
           $.get( "<?php echo url.'/'.$this->folder?>/delete_transport",{transport:transport}, function( data ) {

               if (data)
               {
                   table.draw()
               }else  {
                   alert('لا يمكن حذف المناقلة')
               }
           });

       } return false;

    }

</script>

<div class="row">
	<div class="col">


		<table  id="example" class="table table-striped display d-table"  >
			<thead>
			<tr>


				<th>   القسم  </th>
				<th>  اسم المنشأ </th>
				<th>  رقم المناقلة </th>
				<th>   تصدير مواد المناقلة   </th>
				<th>   اسم المؤكد  </th>
				<th>  التاريخ والوقت </th>
				<th>  حالة التصدير </th>
				<th>   المستخدم المصدر  </th>
				<th>   تاريخ التصدير </th>
				<th>  حذف </th>

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








