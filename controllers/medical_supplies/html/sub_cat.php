

<ul>

    <?php  if ($this->ck_sub_cat($row['id'])) { ?>

        <li class="<?php  echo $this->sub_cat_active($row['id'],$id)  ?> cccc card_<?php echo $row['id']?>"> <a href="#" class="medical_supplies"> <?php   echo  $row['title']?></a>
            <a href="<?php echo  url ?>/medical_supplies/edit_category/<?php   echo $row['id'] ?>"  class="medical_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/medical_supplies/add_category/<?php   echo $row['id'] ?>"  class="medical_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/medical_supplies/admin_category/<?php   echo $row['id']?>"  class="medical_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('show_category')  ?>"><i class="fa fa-th-large" aria-hidden="true"></i></a>

            <?php   $this->listSubCategory($row['id'],$id) ?>
        </li>
    <?php   }else {  ?>

        <li class="card_<?php echo $row['id']?>"> <a href="<?php echo url ?>/medical_supplies/list_medical_supplies/<?php    echo $row['id'] ?>" class="medical_supplies"> <?php   echo $row['title']?></a>
            <a href="<?php echo  url ?>/medical_supplies/edit_category/<?php   echo $row['id'] ?>"  class="medical_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('edit_category')  ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
            <a href="<?php echo  url ?>/medical_supplies/add_category/<?php   echo $row['id'] ?>"  class="medical_supplies" data-toggle="tooltip" data-placement="top" title="<?php echo $this->langControl('add_category')  ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
        </li>

    <?php   }  ?>

</ul>





