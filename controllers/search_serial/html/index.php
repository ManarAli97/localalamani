
<br>

<div class="row">
    <div class="col">
        <span></span>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php  echo url.'/'.$this->folder?>"><?php  echo $this->langControl('search_serial') ?> </a></li>
            </ol>
        </nav>


        <hr>
    </div>
</div>


<div class="row">
    <div class="col-auto">
        <input type="text"  autocomplete="off" placeholder="بحث عن سيريال منتج مباع" class="form-control" id="serial">
    </div>
    <div class="col-auto">
        <button class="btn btn-primary" id="search"   onclick="search()" > بحث </button>
    </div>
</div>

<br>

<div class="result"></div>


<script>

    function search() {
        $(".result").empty();
        if ($("#serial").val())
        {
            $.get( "<?php echo url .'/'.$this->folder  ?>/get",{value:$("input#serial").val()}, function( data ) {
                $( ".result" ).html( data );
            });
        }else
        {
            alert("يجب ادخال سيرايل الجهاز")
        }



    }


</script>