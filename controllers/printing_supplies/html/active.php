

    <br>

    <div class="row">
        <div class="col">
            <span></span>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/admin_category"><?php  echo $this->langControl($this->folder) ?> </a></li>

                    <li class="breadcrumb-item active" aria-current="page" >   تفعيل / الغاء تفعيل المواقع او ادخال السيريال عند التجهيز </li>

                </ol>
            </nav>


            <hr>
        </div>
    </div>

<div class="row align-items-center">
    <div class="col-lg-4">
        <div class="  select_drop"  style="width: 100%" >
            <select  id="list_catg"  class="selectpicker"   aria-expanded="false"  data-live-search="true"  >
                <option value="all" > كل محتويات الاقسام </option>
                <?php foreach ($data_cat as $list_cat)  {     ?>
                    <option  value="<?php  echo $list_cat['id'] ?>"   > <?php   echo $list_cat['title'] ?> </option>
                <?php  }  ?>
            </select>
        </div>
    </div>

    <div class="col-auto">

        <select id="type" name="type" class="form-control"  >
            <option value="location" >مواقع  </option>
            <option value="serial"> ادخال السيريال عند التجهيز </option>
        </select>

    </div>

    <div class="col-auto">

        <div class="custom-control custom-radio custom-control-inline">
            <input checked type="radio"  value="1" id="customRadioInline1" name="ls" class="custom-control-input" >
            <label class="custom-control-label" for="customRadioInline1">  تفعيل </label>
        </div>
        <div class="custom-control custom-radio custom-control-inline">
            <input type="radio" value="0" id="customRadioInline2" name="ls" class="custom-control-input">
            <label class="custom-control-label" for="customRadioInline2"> الغاء تفعيل </label>
        </div>
    </div>

    <div class="col-auto">
        <button class="btn btn-primary"  onclick="active_set()"  >موافق</button>
    </div>

    <div class="col-lg-2" id="process_active">
        <div class="progress">
            <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
        </div>

    </div>


</div>

    <script>
        
        function   active_set() {

            if (confirm('هل انت متأكد؟')) {
                $('#process_active').show()

                cat = $("#list_catg :selected").val();
                type = $("#type").val();
                ls = $("input[name='ls']:checked").val();
                $.get("<?php echo url . '/' . $this->folder  ?>/active_pro", {
                    cat: cat,
                    type: type,
                    ls: ls
                }, function (data) {

                    console.log(data)
                    if (data) {
                        $('#process_active').hide()

                        if (ls === '1') {
                            alert("تم التفعيل")

                        } else {
                            alert("تم الغاء التفعيل")
                        }

                    } else {
                        $('#process_active').hide()
                        alert("حدثت مشكلة في العملية")
                    }


                });
            }return false;
        }
    </script>
    
<hr>


    <style>
        #process_active
        {
            display: none;
        }
        .bootstrap-select:not([class*="col-"]):not([class*="form-control"]):not(.input-group-btn) {
            width: 100%;
        }

    </style>

<br>
<br>