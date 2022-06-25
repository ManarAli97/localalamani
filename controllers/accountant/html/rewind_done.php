

<br>
<div class="row">
	<div class="col">

		<nav aria-label="breadcrumb" >

			<ol class="breadcrumb"  >
				<li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('accountant') ?> </a></li>
				<li class="breadcrumb-item active" aria-current="page" >  تم الاسترجاع   </li>

			</ol>

		</nav>

	</div>
    <div class="col-auto">
        <div style="cursor: pointer" onclick="sun_total_money()" class="sumAllMoney"  data-toggle="tooltip" data-placement="top" title="  اضغط هنا لعرض المجموع الكلي " >
            <span> حساب المجموع الكلي </span>
        </div>
    </div>


</div>

<script>

    function  sun_total_money () {
        $( ".sumAllMoney" ).html(`
         <span>  جاري  حساب المبلغ   : </span>  <img style="width:18px" src="<?php echo $this->static_file_site ?>/image/site/loding.gif">
        ` );
        $.get( "<?php  echo url .'/'.$this->folder ?>/sun_total_money", function( data ) {
            if (data)
            {
                $( ".sumAllMoney" ).html(`
         <span>  المبلغ الكلي   : </span> <span>  ${data}  </span> <span> د.ع</span>
        ` );
            }
        });
    }

</script>




<br>

 

<nav id="reloadPage">
	<div class="nav nav-tabs" id="nav-tab" role="tablist">
		<a class="nav-item nav-link "  id="nav-profile-tab"    href="<?php echo url .'/'.$this->folder ?>" ><span>قيد المحاسبة</span> <span id="notif" class="badge badge-danger" data-notif="<?php  echo $this-> all_notification_buy() ?>" >  <?php  echo $this-> all_notification_buy() ?>   </span></a>
		<a class="nav-item nav-link " id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/accounting_made" > تمت المحاسبة</a>

		<?php  if ($this->permit('rest_amount_to_customer',$this->folder)) {  ?>
			<a class="nav-item nav-link  "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="باقي المبلغ الى الزبون"  href="<?php echo url .'/'.$this->folder ?>/minus" > <span>باقي المبلغ الى الزبون</span>  <i class="fa fa-undo">   </i> <span id="notif2" class="badge badge-danger" data-notif2="<?php  echo $this-> minus_notification_buy() ?>" >  <?php  echo $this-> minus_notification_buy() ?>   </span></a>
		<?php } ?>
		<?php  if ($this->permit('retrieval',$this->folder)) {  ?>
			<a class="nav-item nav-link  "  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="قيد الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind" > <span>قيد الاسترجاع</span>     <i class="fa fa-undo">   </i> <span id="rewindNotifx" class="badge badge-danger" data-rewindNotif_data="<?php  echo $this-> rewindNotif() ?>" >  <?php  echo $this-> rewindNotif() ?>      </a>
		<?php } ?>
		<?php  if ($this->permit('rewind_done',$this->folder)) {  ?>
			<a class="nav-item nav-link active"  id="nav-profile-tab"  data-toggle="tooltip" data-placement="top" title="تم الاسترجاع"  href="<?php echo url .'/'.$this->folder ?>/rewind_done" > <span>تم الاسترجاع</span>       </a>
		<?php } ?>
        <?php  if ($this->permit('auto_print',$this->folder)) {  ?>
            <a class="nav-item nav-link "    data-toggle="tooltip" data-placement="top" title=" 1-بقاء هذة النافذة مفتوحة   <br> 2-يجب ضبط الطباعة وتحديد الطابعة من نافذة الطباعة في المتصفح <br> 3- ضبط kiosk mode للمتصفح"   data-html="true"  id="nav-home-tab" href="<?php echo url .'/'.$this->folder ?>/auto_print" >  الطباعة التلقائه  للفواتير  </a>
        <?php } ?>
	</div>
</nav>
<div class="row">
	<div class="col-lg-3" id="loadListRow" >

		<div class="tab-content" id="nav-tabContent">
			<div class="tab-pane fade  " id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">...</div>
			<div class="tab-pane fade show active" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
				<div class="userList" style="margin-top: 10px">
					<input type="text"  onkeyup="searchCustomer()" id="searchCustomer" name="search" class="form-control" autocomplete="off" placeholder="بحث عن الاسم او رقم الهاتف ">

					<div id="listSearch"></div>
					<div id="listRoll">
						<div  id="results"></div>
						<div id="loader_image" ><img src="<?php echo $this->static_file_site ?>/image/site/loadchat.gif" > </div>
						<div class="margin10"></div>
						<div id="loader_message"></div>
					</div>

				</div>


			</div>

		</div>


	</div>
	<div class="col-lg-9">
		<div class="result"></div>
	</div>

</div>




<style>


    .userList {
        overflow-y: auto;
        border: 2px solid #cad8e6;
        padding: 4px;
        background: #fbfbfb;
        border-top: 0;
    }

	.infoCustomer
	{
		display: block;
		text-decoration: none;
		background: #ecedee;
		margin: 7px 0 7px 0;
		padding: 5px 14px;

	}
	.infoCustomer:hover
	{

		text-decoration: none;


	}
	.result {


		overflow-y: auto;
	}
	.thisActive
	{
		background: #adb !important;
		color: #ffffff;
	}
	.thisActive:hover
	{

		color: #ffffff;
	}
</style>


<script>

    $(document).ready(function() {
        $('.result_order').css('height',Number($('body').height()-175 )+'px')
        $('.userList').css('height',Number($('body').height()-175 )+'px')

    });


    var publicid='row';

    $(document).ready(function() {
        $('.result').css('height',Number($('body').height()-175 )+'px')
    });


    function getRewind(id) {

        publicid="#row"+id;
        $.get( "<?php  echo url .'/'.$this->folder?>/view_rewind2/"+id, function( data ) {

            $( ".result" ).html( data );
            $( ".ifactive" ).removeClass( 'thisActive' );
            $( "#row"+id ).addClass( 'thisActive' );
        });

    }


    function checkNewOrder()
    {

        notifx=$('#notif').attr('data-notif');

        $.get( "<?php  echo url .'/'.$this->folder?>/notification_order/", function( data ) {
            if (Number(data) > 0 && Number(data)  > Number(notifx))
            {
                $.get(window.location.href, function (data) {
                    var founddata = $(data).find('#reloadPage').children();
                    $('#reloadPage').empty().html(founddata);
                    $(publicid).addClass( 'thisActive' );
                });
            }
        });
    }


    function rewindNotif_data()
    {

        rewindNotif=$('#rewindNotifx').attr('data-rewindNotif_data');

        $.get( "<?php  echo url .'/'.$this->folder?>/rewindNotif/", function( datar ) {
            if (datar > 0 && datar > rewindNotif)
            {
                $.get(window.location.href, function (datar) {
                    var founddata = $(datar).find('#reloadPage').children();
                    $('#reloadPage').empty().html(founddata);

                    var founddataRow = $(data).find('#loadListRow').children();
                    $('#loadListRow').empty().html(founddataRow);
                    $(publicid).addClass( 'thisActive' );



                    $(publicid).addClass( 'thisActive' );
                });

            }
        });
    }



    setInterval(function() {
        checkNewOrder();
        rewindNotif_data()
    }, 5000);



    function checkNewOrder2()
    {

        notif=$('#notif2').attr('data-notif2');

        $.get( "<?php  echo url .'/'.$this->folder?>/notification_minus/", function( data ) {
            if (data > 0 && data > notif)
            {
                $.get(window.location.href, function (data) {
                    var founddata = $(data).find('#reloadPage').children();
                    $('#reloadPage').empty().html(founddata);

                    $(publicid).addClass( 'thisActive' );
                });
            }
        });

    }




    setInterval(function() {
        checkNewOrder2()
    }, 5000);




    function number_bill_reload() {
        $(publicid).click();
    }



    toggleOn();
    function toggleOn() {
        $('.menuControl').css('display','none');
        $('#controlMenu').bootstrapToggle('on')
    }



    function reloadData() {

        $.get(window.location.href, function (data) {
            var founddata = $(data).find('#reloadPage').children();
            $('#reloadPage').empty().html(founddata);
            $(publicid).addClass( 'thisActive' );
        });
    }





    function searchCustomer() {
        value=$('#searchCustomer').val();

        if (value)
        {
            $('#listSearch').show();
            $('#listRoll').hide();

            $.get( "<?php echo url .'/'.$this->folder  ?>/rewind_search",{value:value}, function( data ) {
                $( "#listSearch" ).html( data );
            });

        }
        else
        {
            $('#listSearch').hide().empty();
            $('#listRoll').show()
        }

    }





    var busy = false;
    var limit = 100;
    var offset = 0;

    function displayRecords(lim, off) {
        $.ajax({
            type: "GET",
            async: false,
            url: "<?php echo url .'/'.$this->folder ?>/loadmore_view_rewind",
            data: "limit=" + lim + "&offset=" + off,
            cache: false,
            beforeSend: function() {
                $("#loader_message").html("").hide();
                $('#loader_image').show();
            },
            success: function(html) {

                $("#results").append(html);
                $('#loader_image').hide();
                if (html === "") {
                    $("#loader_message").html('<span class="no_thing"> لا يوجد شي </span>').show()
                }
                window.busy = false;

            }
        });
    }

    $(document).ready(function() {
        // start to load the first set of data
        if (busy == false) {
            busy = true;
            // start to load the first set of data
            displayRecords(limit, offset);
        }


        $('.userList').scroll(function() {
            // make sure u give the container id of the data to be loaded in.

            if ($('.userList').scrollTop() + $('.userList').height() > $("#results").height() && !busy) {
                busy = true;
                offset = limit + offset;

                // this is optional just to delay the loading of data
                setTimeout(function() { displayRecords(limit, offset); }, 500);

                // you can remove the above code and can use directly this function
                // displayRecords(limit, offset);

            }
        });

    });








</script>

<style>


	.g_account
	{
		background: #4CAF50;
		color: #ffff;
		padding: 0 6px;
		border-radius: 15px;
		display: block;
	}

	.n_account
	{
		background: #000000;
		color: #ffff;
		padding: 1px 6px;
		border-radius: 15px;
		display: block;
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
	.set_text_table
	{
		text-align:center;
	}
</style>





