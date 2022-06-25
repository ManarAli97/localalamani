
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_serial_system"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > <?php  echo $this->langControl('add') ?>  </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?php echo url.'/'.$this->folder ?>/generation" method="post">


            <div class="row">
                <div class="col-auto">
                    <label for="validationServer-length"> <span>  طول السيريال  </span> <span style="color: red;font-size: 14px;" id="length"></span>  </label>
                    <input    autocomplete="off" name="length" value="<?php echo  $data['length']  ?>" type="number" class="form-control " id="validationServer-length" required >
                </div>

                <div class="col-auto">
                    <label for="validationServer-number"> <span>   العدد </span> <span style="color: red;font-size: 14px;" id="number"></span>  </label>
                    <input   name="number"  autocomplete="off" value="<?php echo  $data['number']  ?>"  type="number" class="form-control " id="validationServer-number" required >
                </div>
                <div class="col-auto">
                    <label for="validationServer-code"> <span>   رمز المادة </span> <span style="color: red;font-size: 14px;" id="code"></span>  </label>
                    <input   name="code"  autocomplete="off" value="<?php echo  $data['code']  ?>"  type="text" class="form-control " id="validationServer-code" required >
                </div>
                <div class="col-auto align-self-end">


                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"   name="type"   value="1" id="customradioInline-1" class="custom-control-input" required>
                        <label class="custom-control-label" for="customradioInline-1">   ارقام  </label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"   name="type"    value="2" id="customradioInline-2" class="custom-control-input" required>
                        <label class="custom-control-label" for="customradioInline-2">   حروف  </label>
                    </div>

                    <div class="custom-control custom-radio custom-control-inline">
                        <input type="radio"   name="type"    value="3" id="customradioInline-3" class="custom-control-input" required>
                        <label class="custom-control-label" for="customradioInline-3">   ارقام وحروف  </label>
                    </div>


                </div>
            </div>

            <hr>
            <div class="container">
                <div class="row justify-content-md-center align-items-center ">
                    <div class="col-md-auto">
                        <input   class="btn btn-primary" type="submit" name="submit" value="<?php echo $this->langControl('save') ?>">
                    </div>
                </div>
            </div>
        </form>



<?php if(!empty($this->error_form ))  { ?>
    <script>

        var error=<?php echo $this->error_form ?>;
        for (var prop in error) {
            $('#'+prop).html('&nbsp;&nbsp;'+error[prop] +'*');
            $("*[name='"+prop+"']").addClass('error_border_red');
        }
    </script>
    <style>
        .error_border_red
        {
            border: 1px solid red !important;
            box-shadow:0 0 0 0.2rem rgba(212, 10, 12, 0.17);
        }
    </style>
<?php  } ?>


        <style>

            .herderDoc
            {
                visibility: hidden;
                height: 0;
                overflow: hidden;
            }


            .footerDoc
            {
                visibility: hidden;
                height: 0;
                overflow: hidden;
            }

            @media print {
                * {
                    -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
                    color-adjust: exact !important; /*Firefox*/
                }

                body * {
                    visibility: hidden;
                    height: 0;
                }

                .print   {
                    position: relative;
                }

                .print * {
                    visibility: visible;
                    height: auto;
                }
                .hidePrint *
                {
                    display: none;
                }

                .herderDoc {
                    visibility: visible;
                    border: 2px solid #9198a0 !important;
                    margin-bottom: 30px;
                    padding: 10px 35px;
                    background: #f8f9fa !important;
                    border-radius: 5px;
                    height: auto;
                    overflow: auto;
                }

                .logoDoc
                {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;

                }

                .logoDoc img
                {
                    width: 100%;
                    height: 100%;

                }


                .footerDoc {
                    visibility: visible;
                    border: 2px solid #9198a0 !important;
                    margin-bottom: 30px;
                    padding: 10px 35px;
                    background: #f8f9fa !important;
                    border-radius: 5px;
                    position: fixed;
                    bottom: 0 !important;
                    width: 100%;
                    left: 2px;
                    height: auto;
                    overflow: auto;
                }

                .logoDocFooter
                {
                    width: 100px;
                    height: 100px;
                    border-radius: 50%;

                }


                .logoDocFooter img
                {
                    width: 100%;
                    height: 100%;

                }


                .number
                {
                    text-align: left;
                    font-size: 18px !important;
                    padding:   8px 0  8px 15px !important;

                }

                .mail
                {
                    text-align: left;
                    font-size: 18px !important;
                    padding:   8px 0  8px 15px !important;
                }

                .icon_print
                {
                    display: none;
                }


                .border_xxx
                {
                    visibility: visible;
                    margin-top: 30px;
                    padding: 20px;
                    height: 1080px;
                    border: 2px solid #9198a0 !important;
                    margin-bottom: 30px;
                    background: #f8f9fa !important;
                    border-radius: 5px;
                }


            }


            #showPassword
            {
                padding: 0;
                margin: 0;
                background: transparent;
                border: 0;
                cursor: pointer;
                outline: none;
                box-shadow: unset;
            }


        </style>


        <br>
        <br>
        <br
        <br>
        <br>
        <br>