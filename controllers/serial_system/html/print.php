

<br>
<div class="out_print">
<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>/list_serial_system"><?php  echo $this->langControl('serial_system') ?> </a></li>
                <li class="breadcrumb-item active" aria-current="page" > طباعة </li>
            </ol>
        </nav>


        <hr>
    </div>
</div>
</div>

<button class="btn btn-primary" onclick="print_table()"> <i class="fa fa-print" aria-hidden="true"></i>  <span> طباعة </span></button>
<a  href="<?php echo url .'/'.$this->folder?>/list_serial_system" role="button"    class="btn btn-warning"> <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>  <span>  رجوع  </span> </a>

<br>
<br>
<div class="row">
    <div class="col-12 print_table">

      <table class="table table-bordered">
            <tbody>

        <?php foreach ($print as $pnt) {   ?>

            <tr>
            <?php foreach ($pnt as $out) {   ?>
                <td>
                    <div style="text-align: center;font-weight: bold"><?php echo $out['code'] ?></div>
                    <svg class="barcode_<?php echo $out['id'] ?>"></svg>
                    <script>
                        JsBarcode(".barcode_<?php echo $out['id'] ?>", "<?php echo $out['serial_system'] ?>", {
                            height: 40,
                            displayValue: true
                        });
                    </script>
                </td>
            <?php } } ?>
            </tr>

            </tbody>
        </table>


    </div>
</div>


<script>

    print_table()
    function print_table() {

        window.print()
    }

</script>

<style>



    .print_table table
    {
        text-align: center;
    }

    .print_table table tr td
    {
        text-align: center;
        border: 2px solid #000000 !important;
    }


    @media print {


        * {
            -webkit-print-color-adjust: exact !important; /*Chrome, Safari */
            color-adjust: exact !important; /*Firefox*/
        }

        body * {
            visibility: hidden;

        }
        .hide_print,.out_print
        {
            display: none;
        }
        .fixed-top,.down_fixed,.notShowInPrint,.menuControl
        {
            height: 0;
            display: none;
        }


        .result
        {
            height: auto !important;
            overflow: unset !important;
        }

        .bodyControl
        {
            overflow: unset;
        }


        .print_table{
            width: 100% !important;
            height: auto !important;
            position: relative;
            visibility: visible;
            display: block;
        }

        .print_table * {
            position: relative;
            visibility: visible;
        }



    }


</style>
