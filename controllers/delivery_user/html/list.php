

<script>
    $(document).ready(function() {


        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url ?>/delivery_user/processing",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();
            },
            "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                $(nRow).attr('id','row_'+ aData[6]);
            },
            "order": [[ 5, 'desc'] ],
            aLengthMenu: [ 10,25, 50, 100,-1],
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

            }
        } );
    } );
</script>

    <br>
    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">

                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('customers_view_the_delivery_service') ?>  </li>

                </ol>
            </nav>
            <hr>
        </div>
    </div>


<div class="smile">

    <div class="row justify-content-center" >
        <div class="col-lg-8 col-md-10 col-sm-12">
            <div class="row justify-content-between">
                <div class="col-auto">
                    <button  class="btn smile1"  > <i class="fa fa-smile-o"></i>  </button>
                    <div class="testsmile">  <?php  echo $s1 ?>  </div>
                </div>
                <div class="col-auto">
                    <button  class="btn smile2"  > <i class="fa fa-meh-o"></i>  </button>
                    <div class="testsmile"> <?php  echo $s2 ?> </div>
                </div>
                <div class="col-auto">
                    <button  class="btn smile3"  > <i class="fa fa-frown-o"></i>  </button>
                    <div class="testsmile"> <?php  echo $s3 ?> </div>
                </div>

            </div>
        </div>
    </div>

</div>
<style>
.testsmile
{
    font-size: 20px;
}

    .smile
    {
        text-align: center;
    }
    .smile1
    {
        padding: 0;
        background: transparent;
        font-size: 71px;
        color: #4CAF50;
    }

    .smile2
    {
        padding: 0;
        background: transparent;
        font-size: 71px;
        color: #FFC107;
    }

    .smile3
    {
        padding: 0;
        background: transparent;
        font-size: 71px;
        color: #FF5722;
    }


</style>







<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th>اسم الزبون</th>
                    <th>   رقم الزبون</th>
                    <th>رأي الزبون</th>
                    <th>  رسالة  </th>
                    <th>  موظف خدمة التوصيل  </th>
                    <th> التاريخ</th>
                    <th>  تفاصيل الطلب  </th>

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

</style>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> </h5>


            </div>
            <div class="modal-body">

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">الغاء</button>
                <button type="button" value="" id='save' class="btn btn-danger">حذف </button>
            </div>
        </div>
    </div>
</div>







<script>
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget);
        var recipient = button.data('id') ;
        var title = button.data('title') ;
        var modal = $(this);
        modal.find('.modal-title').text('هل انت متاكد من حذف العنصر ؟ ' );
        modal.find('.modal-body').text(title);
        modal.find('#save').val(recipient)
    });

    $('#save').on('click',function () {
        var  id= $('#save').val();
        $.get( "<?php echo url ?>/accessories/delete_accessories/"+id, function( data ) {
            $('#row_'+id).remove();
            $('#exampleModal').modal('hide')
        });
    });
 </script>


<script>


    function visible_accessories(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;
        $.get("<?php echo url ?>/accessories/visible_accessories/"+vis+'/'+id, function(){ })
    }



</script>