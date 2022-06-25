

<br>
<div class="row align-items-center">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl($this->folder) ?> </a></li>
                <li class="breadcrumb-item">  فواتير شراء غير  مدخلة  </li>
            </ol>
        </nav>

    </div>

</div>



<script>
    $(document).ready(function() {

        var selected = [];
        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_bills_note_enter/<?php   echo $from_date_stm .'/'.$to_date_stm  ?>",
            info:false,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[7]);
            },
            "order": [[ 2, 'asc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
            oLanguage: {
                sLoadingRecords: "تحميل ...",
                  sProcessing:  `
                <span style="vertical-align: sub;" class="spinner-grow text-light spinner-grow-sm" role="status" aria-hidden="true"></span>
                  جاري التحميل ...
                `,
                sLengthMenu: "عرض _MENU_ ",
                sSearch: "أبحث",
                oPaginate: {sFirst: "First", sLast: "Last", sNext: "&raquo;", sPrevious: "&laquo;"},
                sZeroRecords: "لا توجد نتائج اعد المحاولة ! ",
                sSearchPlaceholder: "البحث"
            }
            ,
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            bFilter: true, bInfo: false

        } );
    } );
</script>



<form action="<?php echo url.'/'.$this->folder?>/bills_note_enter" method="get">

    <div class="row align-items-end">
        <div class="col-auto">
            من تاريخ
            <input  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  name="date" class="form-control" value="<?php  echo $date ?>"  required>
        </div>
        <div class="col-auto">
            الى تاريخ
            <input  type="datetime-local"     data-toggle="tooltip" data-placement="top" title="السنة/اليوم/الشهر"  name="todate" class="form-control" value="<?php  echo $todate ?>"  required>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-warning" >بحث</button>
            <a href="<?php echo url.'/'.$this->folder?>/bills_crystal_enter" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
        </div>
    </div>

</form>
<hr>
<?php   if (!empty($bill)) {  ?>

    <button  id="export_g" class="btn btn-warning" onclick="add_group()" >   <span>   تصدير الفواتير الى مجموعة </span>  <span class="badge badge-info"> <?php  echo count($bill) ?>  </span>

        <span  id="loading_bos" style="vertical-align: sub;color: #ffffFF;display: none" class="spinner-border   spinner-border-sm" role="status" aria-hidden="true"></span>
    </button>
<?php  } else {  ?>

    <button    class="btn btn-warning"  onclick="alert('لا توجد فواتير مجهزة جديدة')" >  <span>   تصدير الفواتير الى مجموعة </span>  <span class="badge badge-info"> <?php  echo count($bill) ?>     </button>

<?php  } ?>
<hr>
<br>


<table class="table table-striped display d-table  set_text_table" id="example">
    <thead>
    <tr>
        <th scope="col">   اسم الزبون  </th>
        <th scope="col">     رقم الهاتف  </th>
        <th scope="col">     رقم الفاتورة     </th>
        <th scope="col">   مبلغ الفاتورة  </th>
        <th scope="col">   ادخال رقم فاتورة كرستال   </th>
        <th scope="col">   المحاسب </th>
        <th scope="col">    تاريخ المحاسبة </th>



    </tr>
    </thead>
</table>


<script>





    function saveBill(number_bill) {

        if($('#numberBill_'+number_bill).val())
        {

            $.get( "<?php  echo url .'/'.$this->folder ?>/crystal_bill",{number_bill:number_bill,crystal_bill:$('#numberBill_'+number_bill).val()}, function( data ) {
                if (data ==='1')
                {
                    alert('تم اضافة فاتورة كرستال');
                    $("#row_"+number_bill).remove();

                }

            });

        }else {

            alert('حقل فاتورة كرستال فارغ !')
        }

    }

    function send_data() {
        $.get("<?php echo url.'/'.$this->folder?>/chbill", function (data) {
            if (data)
            {
                var result=JSON.parse(data);

                for (var i=0;i <  result.length;i++)
                {
                    $('#row_'+result[i]).remove();
                }
            }
        });
    }
    setInterval(send_data, 5000);




    function add_group(){

        $('#loading_bos').show();

        $.get( "<?php echo url.'/'.$this->folder?>/add_group", function( data ) {


            if (data)
            {
                $('#loading_bos').show();
                window.location="<?php   echo  url.'/'.$this->folder   ?>/export_group/"+data;
            }else
            {
                alert('فشل انشاء مجموعة')
                $('#loading_bos').hide();
            }

        });

    }



</script>


<style>


    .withBill
    {
        width: 85px;
    }
    .addBill
    {
        color: #fff !important;
        background-color: #28a745 !important;
        border-color: #28a745 !important;
    }

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
    .class_delete_row
    {
        background: transparent;
        border-radius: 50%;
        padding: 0;
        width: 35px;
        height: 35px;
        font-size: 28px;
        margin: 0;
    }
    table tr td a {
        color: red;
        font-size: 20px;
        font-weight: bold;
        border: 1px solid #eaeaea;
        display: block;
        width: auto;
    }
</style>

<br>
<br>
<br>
<br>














