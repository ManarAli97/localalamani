
<script>
    var  table=null;
    $(document).ready(function() {

        var selected = [];

      table =  $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "<?php echo url .'/'.$this->folder ?>/processing_screen/<?php  echo $y ?>/<?php  echo $fromDate ?>/<?php  echo $toDate ?>",
            info:true,
            "fnDrawCallback": function() {
                jQuery('.toggle-demo').bootstrapToggle();

            },
            "order": [[ 12, 'asc'] ],
            aLengthMenu: [ 10,25,75,100,200,-1],
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

            },       <?php  if ($this->permit('export_excel',$this->folder)) { ?>
            dom: 'Bfrtip',
            buttons: [
                'excel'  ,
                'pageLength'
            ],
            <?php  }  ?>
            bFilter: true, bInfo: true
        } );
    } );
</script>



    <br>

    <div class="row align-items-center">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_registration"><?php  echo $this->langControl('registration') ?> </a></li>
                    <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('view_content') ?>  </li>
                </ol>
            </nav>
        </div>
        <div class="col-auto" style="position: relative">
            <a href="<?php  echo url .'/'.$this->folder ?>/all_active_buy">  <i class="fa fa-bell bell_style"> </i>  <span class="number_req" > <?php  echo $this-> all_notification_buy() ?> </span></a>
        </div>
    </div>
<hr>
<div class="row justify-content-between">
    <div class="col-auto">


        <form action="<?php echo url.'/'.$this->folder?>/subscribers_screen" method="get">

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
                    <a href="<?php echo url.'/'.$this->folder?>" class="btn btn-success" ><i class="fa fa-refresh"></i></a>
                </div>
            </div>

        </form>


    </div>
    <div class="col-auto">


        <form action="<?php  echo url .'/'.$this->folder ?>/subscribers" method="POST">
            <div class="row">
                <div class="col-auto">
                    <select class="custom-select custom-select-sm" name="year" >
                        <option value="0" >  اختر سنة </option>
                        <?php foreach ($year as $ye)  {     ?>
                            <option value="<?php echo $ye ?>"  <?php  if ($ye == $y) echo 'selected'?>  > <?php   echo $ye ?> </option>
                        <?php  }  ?>
                    </select>
                </div>

                <div class="col-auto">
                    <input type="submit" class="btn btn-primary btn-sm" name="submit" value="بحث">
                </div>
            </div>
        </form>

    </div>
</div>


<hr>
    <div class="row">
        <div class="col">

            <table  id="example" class="table table-striped display d-table"  >
                <thead>
                <tr>
                    <th> الاسم واللقب</th>
                    <th> المهنة </th>
                    <th><?php  echo $this->langControl('phone') ?></th>
                    <th><?php  echo $this->langControl('city') ?></th>
                    <th><?php  echo $this->langControl('address') ?></th>
                    <th>  الجنس </th>
                    <th>  تاريخ الميلاد </th>
                    <th>  سعر جملة </th>
                    <th>  سعر جملة الجملة </th>
                    <th>  سعر التكلفة  </th>

                    <th> حاله الزبون  </th>
                    <th> ملاحظات </th>
                    <th><?php  echo $this->langControl('date') ?></th>
                    <th><?php  echo $this->langControl('details') ?></th>
                    <th><?php  echo $this->langControl('notification') ?></th>
                    <th><?php  echo $this->langControl('edit') ?></th>
                    <th> موظف الشاشة </th>
                    <th>   الوقت المستغرق </th>
                    <th><?php  echo $this->langControl('delete') ?></th>
                </tr>
                </thead>

            </table>

        </div>
    </div>



<div class="modal fade" id="exampleModalXnortex" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> السبب </h5>
            </div>
            <div class="modal-body">

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">السبب</label>
                        <textarea type="text" class="form-control" id="notethiscustomer"></textarea>
                    </div>
                <input hidden id="id_customer">
                <input hidden id="typle_customer">



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="out_note_customer()" data-dismiss="modal">خروج</button>
                <button type="button" class="btn btn-primary" onclick="note_customer()"> موافق </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalnote_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"> ملاحظات حول الزبون </h5>
            </div>
            <div class="modal-body">
                <div class="table_note"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"  data-dismiss="modal">خروج</button>

            </div>
        </div>
    </div>
</div>

<script>


    function get_note(id) {

        $('#exampleModalnote_customer').modal('show');
        $.get("<?php echo url   ?>/note_user/get_note_customer/"+id, function(data){

            if (data)
            {
                $('.table_note').html(data);

            }
        })

    }



function price_type(e,id) {

    var type_price = [];
    $('.list_price_type'+id+':checked').each(function(d) {
        type_price.push(this.value);
    })
      $.get("<?php echo url  .'/'. $this->folder?>/change_price_type/"+id,{type_price: JSON.stringify( type_price )}, function(data){

          console.log(data)
        })



}


    function type_customer(e,id) {
        var vis=$(e).is( ':checked' )? 1:0;


        $('#id_customer').val(id);
        $('#typle_customer').val(vis);



        $('#exampleModalXnortex').modal({
            backdrop: 'static',
            keyboard: false
        });
    }


    function note_customer() {

        notex=$('#notethiscustomer').val();
        id=$('#id_customer').val();
        vis=$('#typle_customer').val();

        if (notex)
        {

            $.get("<?php echo url  .'/'. $this->folder?>/type_customer/"+vis+'/'+id,{note:notex}, function(){

                $('#exampleModalXnortex').modal('hide');
                $('textarea#notethiscustomer').val('');
                $('input#id_customer').val('');
                $('input#typle_customer').val('');
            })

        }   else
        {


            alert('يجب كتابة السبب')
        }


    }


    function out_note_customer() {
        vis=$('#typle_customer').val();
        id=$('#id_customer').val();

        if (vis === '0')
        {
              $('tr#row_'+id+' td div input').bootstrapToggle('on');
        }else {
            $('tr#row_'+id+' td div input').bootstrapToggle('off')
        }

    }


</script>

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

    .bell_style
    {
        font-size: 33px;
        color: red;
        margin-top: -10px;
    }
.number_req
{
    position: absolute;
    top: -14px;
    width: 25px;
    height: 25px;
    background: #007bff;
    text-align: center;
    left: 4px;
    border-radius: 50%;
    font-weight: bold;
    color: #ffffff;
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
        $.get( "<?php echo url .'/'.$this->folder ?>/delete_registration/"+id, function( e ) {
            if (e !=='true')
            {
                window.location='<?php  echo url ."/login/user"?>'
            }else
            {
                 table.draw();
                $('#exampleModal').modal('hide')
            }

        });
    });
 </script>

