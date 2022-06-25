
<br>




<div class="row">
    <div class="col-auto">
        <label> الباركود  </label>
        <div class="alert alert-secondary" role="alert">
             <?php echo $code ?>
        </div>
    </div>
    <div class="col-auto">
        <label>   الكمية الكلية  </label>
        <div class="alert alert-secondary" role="alert">
            <?php echo $quantity ?>
        </div>
    </div>

</div>

<form id="idFormsetLocation" action="<?php echo url .'/'.$this->folder ?>/inst_location/<?php echo $model.'/'.$code ?>" method="post">
    <div class="row">
        <?php  foreach ($outLocation as $key=>$d ) {  ?>
            <div class="col-lg-3 col-md-4 col-sm-6" style="margin-bottom: 25px">
                <label> موقع: <?php  echo  $this->tamayaz_locations($d['location'])  ?>  </label>
                <input type="hidden" class="form-control" name="indexLocation[<?php  echo $d['id']  ?>]" value="<?php  echo $d['location']  ?>">
                <input type="number" class="form-control sumValue"  name="setLocation[<?php  echo $d['id']  ?>]" value="<?php  echo $d['quantity']  ?>">
            </div>
        <?php  }  ?>
        <div class="col-12 text-center">
            <hr>
            <input type="submit" name="submit" value="حفظ">
        </div>
    </div>

</form>

<script>
    $("#idFormsetLocation").submit(function(e) {

        var sum = 0;
        $(".sumValue").each(function(){
            sum += +$(this).val();
        });

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var url = form.attr('action');


        if (sum > <?php echo $quantity ?>)
        {
            alert("مجموع الكميات الموزعة على المواقع اكبر من الكمية الموجودة")
        }else {

            if (sum <  <?php echo $quantity ?>)
            {

                q=<?php echo $quantity ?> - sum;

                if (confirm( " باقي من الكمية " +q+ " هل تريد الاستمرار؟ "))
                {
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: form.serialize(), // serializes the form's elements.
                        success: function (data) {
                            $('#exampleModalLocation').modal('hide')
                        }
                    });

                }else
                {
                    return false;
                }

            }else
            {



                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function (data) {
                        $('#exampleModalLocation').modal('hide')
                    }
                });
            }


        }

    });
</script>