
<?php if (!empty($data)) { ?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">صورة</th>
        <th scope="col">القسم</th>
        <th scope="col">اسم الزبون</th>
        <th scope="col">رقم الفاتورة</th>
        <th scope="col">الكود</th>
        <th scope="col">اللون</th>
        <th scope="col">سيريال</th>
        <th scope="col">السعر</th>
        <th scope="col">تاريخ البيع</th>
        <th scope="col">  وقت البيع </th>
        <th scope="col"> الحاله </th>

    </tr>
    </thead>
    <tbody>
    <?php foreach ($data as $key => $d)  {  ?>

    <tr>
        <th scope="row"> <?php echo $key + 1 ?>  </th>
        <td><img width="40" src="<?php  echo $this->save_file.$d['image'] ?>"></td>
        <td><?php  echo $this->langSite($d['table']) ?></td>
        <td  style="color: red"><?php  echo $this->customerInfo($d['id_member_r']) ?></td>
        <td style="color: red"> <?php  echo  $d['number_bill']  ?></td>
        <td><?php  echo $d['code'] ?></td>
        <td><?php  echo $d['name_color'] ?></td>
        <td><?php  echo $d['enter_serial'] ?></td>
        <td><?php  echo $d['price'] ?></td>
        <td><?php  echo date('Y-m-d' , $d['date_accountant'] ) ?></td>
        <td><?php  echo date('h:i:s A' , $d['date_accountant'] ) ?></td>
        <td>
        <?php  if ( $d['cancel'] ==0)  echo 'مباع';else echo 'ملغي'?>

        </td>


    </tr>
 <?php  }  ?>

    </tbody>

</table>

<?php  }  else {  ?>

    <div class="alert alert-warning" role="alert">
      لا توجد بيانات لهذا السيريال
    </div>

<?php  }   ?>