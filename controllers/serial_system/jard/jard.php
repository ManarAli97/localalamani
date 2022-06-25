<?php

trait jard
{

    protected  $data_code=array();

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject
    }

    function required_location_jard($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('required_location_jard',0) ;
        }else
        {
            $this->setting->set('required_location_jard',1) ;
        }

    }


    function repet_jard($flag)
    {
        if ($flag==0)
        {
            $this->setting->set('repet',1) ;
        }else
        {
            $this->setting->set('repet',2) ;
        }

    }


    function list_jard()
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'jard/html','list','php'));
        $this->adminFooterController();

    }



    function add_jard($id)
    {

        $this->checkPermit('add_jard',  $this->folder);
        $this->adminHeaderController($this->langControl('add_jard'));


        require($this->render($this->folder, 'jard/html', 'add', 'php'));
        $this->adminFooterController();

    }


    function creat_page_jard()
    {


        $stmtpage = $this->db->prepare("SELECT `page` FROM jard_page    ORDER BY page DESC LIMIT 1");
        $stmtpage->execute();
        if ($stmtpage->rowCount() > 0) {
            $page = $stmtpage->fetch(PDO::FETCH_ASSOC)['page'] + 1;
            $stmt = $this->db->prepare("INSERT INTO `jard_page` ( page, userId, date) VALUE (?,?,?) ");
            $stmt->execute(array($page,$this->userid,time()));
        } else {
            $stmt = $this->db->prepare("INSERT INTO `jard_page` ( page, userId, date) VALUE (?,?,?) ");
            $stmt->execute(array(1,$this->userid,time()));
            $page =  1;

        }

        echo $page;
    }



    function from_add_jard($id)
    {


        $this->checkPermit('add_jard',  $this->folder);

        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();

                if ($this->setting->get('required_location_jard') == 1){
                    $form->post('location')
                        ->val('is_empty', $this->langControl('required'))
                        ->val('strip_tags');
                      }

                $form->post('serial')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $serial=trim($data['serial']);


                $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? ");
                $stmtpage->execute(array($serial));

                if ($stmtpage->rowCount() > 0) {

                    $stmtUpdatePage = $this->db->prepare("UPDATE `jard_page`  SET   from_date =?  WHERE  page=?  AND    userId=? AND  from_date = 0");
                    $stmtUpdatePage->execute(array(time(),$id,$this->userid));

                    $stmtUpdatePage2 = $this->db->prepare("UPDATE `jard_page`  SET   to_date =?  WHERE  page=?  AND    userId=?  ");
                    $stmtUpdatePage2->execute(array(time(),$id,$this->userid));

                    $result= $stmtpage->fetch(PDO::FETCH_ASSOC);

                    $serial_data= $this->data_code($result['code'],$result['model']);
                    $serial_data['model']=$result['model'];



                    if ($this->setting->get('required_location_jard') == 0){
                        $data['location']='';

                        $data['location_quantity']=0;
                    }else
                    {
                        $data['location_quantity']=$this->location_quantity($result['code'],$result['model'],$data['location']);
                    }

                    $data['location_quantity_all']=$this->location_quantity_all($result['code'],$result['model']);

                    $stmtCh=$this->db->prepare("SELECT  * FROM jard   WHERE page=?  AND  code =? AND  serial=? AND model=? AND  userId=? AND  location=?");
                    $stmtCh->execute(array($id,$serial_data['code'],$data['serial'],$serial_data['model'],$this->userid,$data['location']));
                    if ($stmtCh->rowCount() > 0)
                    {
                        $stmtUpdate = $this->db->prepare("UPDATE `jard`  SET   type_enter =? , quantity=quantity+1,userId=?,date=?  WHERE  page=?  AND  code =? AND  serial=? AND model=? AND  userId=? AND  location=?");
                        $stmtUpdate->execute(array($data['type_enter'],$this->userid,time(),$id,$serial_data['code'],$data['serial'],$serial_data['model'],$this->userid,$data['location']));
                        echo 'true';
                    }else{
                        $stmt = $this->db->prepare("INSERT INTO `jard` ( page, code, serial, type_enter, quantity,excel_quantity, model, userId,`date`,location,location_quantity,location_quantity_all) VALUE (?,?,?,?,?,?,?,?,?,?,?,?) ");
                        $stmt->execute(array($id,$serial_data['code'],$data['serial'],$data['type_enter'],1,$serial_data['quantity'],$serial_data['model'],$this->userid,time(),$data['location'],$data['location_quantity'],$data['location_quantity_all']));
                        echo 'true';

                    }

            }else{
                    echo 'er_serial';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }

    function location_quantity_all($code,$model)
    {

        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM location  WHERE code=? AND  model=?  ");
        $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }

    function location_quantity($code,$model,$location)
    {

        $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM location  WHERE code=? AND  model=? AND location=?");
        $stmt ->execute(array($code,$model,$location));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }


    function info_serial()
    {


        $serial=$_GET['serial'];

        $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? LIMIT 1");
        $stmtpage->execute(array($serial));
        if ($stmtpage->rowCount() > 0) {

            $result= $stmtpage->fetch(PDO::FETCH_ASSOC);
            $data= $this->data_code($result['code'],$result['model']);
            $data['model']=$result['model'];
            $data['quantity_serial'] = $this->sum_serial_enter_all($result['code'],$result['model']);
            $data['user'] = $this->UserInfo($result['userId']);
            $data['date'] =  date('Y-m-d h:i:s a',$result['date']);
            $data['location'] =$this->list_location_no_html($result['code'],$result['model']);
            $data['spare_code'] =$this->get_spare_code($result['code'],$result['model']);
            require($this->render($this->folder, 'jard/html', 'data', 'php'));

        }

    }




    function get_spare_code($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT   GROUP_CONCAT(spare_code SEPARATOR  ',') as spare_code FROM spare_code  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['spare_code'] ;
    }


    function sum_serial_enter_all($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM serial  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }


    public function processing_jard()
    {


        $table = $this->jard_page;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return "<a href='".url.'/'.$this->folder."/details_page_jard/{$d}'>{$d}</a>";
                }
            ),

            array( 'db' => 'user.username', 'dt' => 1 ),


            array( 'db' =>  $table.'.from_date', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    $from_date= strtotime(date('H:i:s', $id));
                    $to_date= strtotime(date('H:i:s', $row[5]));
                    $diff = $from_date - $to_date;
                    return  $this->time_reg(abs($diff));

                }
            ),

            array( 'db' =>  $table.'.date', 'dt' => 3 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),
            array( 'db' =>  $table.'.date', 'dt' => 4 ,
                'formatter' => function ($id, $row) {

                $date_add=strtotime('+1 day', $id);

                    if ($date_add >= time())
                    {
                        return "<a href='".url.'/'.$this->folder."/edit_jard/{$row[0]}'><i class='fa fa-edit'></i></a>";
                    }
                }
            ),
            array(  'db' =>   $table.'.to_date', 'dt'=> 5),
            array(  'db' =>   $table.'.id', 'dt'=> 6)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = " inner JOIN user ON user.id = {$table}.userId   ";
        if ($this->admin($this->userid)) {
            $whereAll = array("");
        }else
        {
            $whereAll = array(" {$table}.userId = {$this->userid}");
        }




        echo json_encode(
            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }






    function details_page_jard($id)
    {

        $this->checkPermit('details_page',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'jard/html','details_page','php'));
        $this->adminFooterController();

    }


    public function processing_details_pagejard($id)
    {


        $table = $this->jard;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0),
            array( 'db' => $table.'.code', 'dt' => 1),
            array( 'db' => $table.'.code', 'dt' => 2,
                'formatter' => function ($id, $row) {

                    $m="'{$row[9]}'";
                    return '
                <button class="btn btn-primary" onclick="get_serial_jard_details('.$id.','.$m.','.$row[0].')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[9].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[8].'">'.$this->sum_serial_jard($id,$row[9],$row[0]).'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[9].'">
                      <div style="padding: 5px;margin:0 ;align-items: center;" class="card card-body" id="data_collapse_'.$id.$row[9].'">
                   </div>
                </div>
                ';
                }
            ),

            array( 'db' => $table.'.location_quantity_all', 'dt' => 3,
                'formatter' => function ($id, $row) {

                    $m="'{$row[9]}'";
                    return '
                <button class="btn btn-primary" onclick="get_all_location_jard_details('.$row[1].','.$m.')"  type="button" data-toggle="collapse" data-target="#location_jard-'.$row[1].$row[9].'" aria-expanded="false" aria-controls="location_jard'.$row[1].$row[9].'">'.$id.'</button>
                   <div class="collapse multi-collapse" id="location_jard-'.$row[1].$row[9].'">
                      <div style="padding: 5px;margin:0;align-items: center;" class="card card-body" id="location_data_collapse_'.$row[1].$row[9].'">
                   </div>
                </div>
                ';
                }
            ),

            array( 'db' => $table.'.excel_quantity', 'dt' => 4),

            array( 'db' => $table.'.type_enter', 'dt' => 5 ),
            array( 'db' => 'user.username', 'dt' => 6 ),

            array( 'db' =>  $table.'.date', 'dt' => 7 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 8),
            array(  'db' =>   $table.'.model', 'dt'=> 9)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userid   ";
        $whereAll = array("page={$id}");
        $group=" GROUP BY code ";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,$group,null,1));

    }






function get_serial_jard($code,$model,$page)
{

    if ($this->admin($this->userid)) {
        $stmt  = $this->db->prepare("SELECT   id,serial,quantity  FROM jard  WHERE code=? AND  model=? AND page=? ");
        $stmt ->execute(array($code,$model,$page));
    }else
    {
        $stmt  = $this->db->prepare("SELECT   id,serial,quantity  FROM jard  WHERE code=? AND  model=? AND  userId =? AND page=? ");
        $stmt ->execute(array($code,$model,$this->userid,$page));
    }



    $html = "<table class='table_location'>";
    if ($stmt->rowCount() > 0) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($this->permit('delete_serial',$this->folder))
            {
                $html .= "<tr id='serial_{$row['id']}'> <td>{$row['serial']}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td>
               <td> <span  style='cursor: pointer;color: red ;padding: 0 5px' onclick='delete_serial_jard({$row['id']})'><i class='fa fa-times-circle'></i> </span> </td>
                 
                </tr>    ";
            }
            else {
                $html .= "<tr> <td>{$row['serial']}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
            }

        }
    }else
    {
        $html .= "</tr><td> لا يوجد سيريال</td></tr>";
    }
    $html .="</table>";
    echo $html;







}



function get_serial_jard_details($code,$model,$page)
{

    if ($this->admin($this->userid)) {
        $stmt  = $this->db->prepare("SELECT   id,serial ,quantity  FROM jard  WHERE code=? AND  model=? AND page=? ");
        $stmt ->execute(array($code,$model,$page));
    }else
    {
        $stmt  = $this->db->prepare("SELECT   id,serial ,quantity    FROM jard  WHERE code=? AND  model=? AND  userId =? AND page=? ");
        $stmt ->execute(array($code,$model,$this->userid,$page));
    }

    $html = "<table class='table_location'>";
    if ($stmt->rowCount() > 0) {

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $html .= "<tr> <td>{$row['serial']}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
        }
    }else
    {
        $html .= "</tr><td> لا يوجد سيريال</td></tr>";
    }
    $html .="</table>";
    echo $html;


}



function get_all_location_jard_details($code,$model)
{
        $stmt  = $this->db->prepare("SELECT  location,location_quantity  FROM jard  WHERE code=? AND  model=?   ");
        $stmt ->execute(array($code,$model));

        $html = "<table class='table_location'>";
        if ($stmt->rowCount() > 0) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $html .= "<tr> <td>{$row['location']}<td><span class='badge badge-pill badge-success'>{$row['location_quantity']} </span></td> </tr>    ";
            }
        }
        else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
         $html .="</table>";
        echo $html;
}




function data_code_jard($code,$model)
{

    if ($model=='accessories')
    {
        $stmt=$this->db->prepare("SELECT  accessories.title,excel_accessories.quantity,color_accessories.color FROM color_accessories INNER JOIN  accessories ON  accessories.id=color_accessories.id_item left JOIN  excel_accessories ON excel_accessories.code=color_accessories.code WHERE color_accessories.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['size']='';

    }else if($model=='savers')
    {

        $stmt=$this->db->prepare("SELECT  product_savers.title,excel_savers.quantity,product_savers.color FROM product_savers    left JOIN  excel_savers ON excel_savers.code=product_savers.code WHERE product_savers.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        $result['size']='';

    }else
    {

        if ($model == 'mobile')
        {

            $code_table='code';
            $color='color';
            $excel='excel';
        }else
        {
            $code_table='code_'.$model;
            $color='color_'.$model;
            $excel='excel_'.$model;
        }

        $stmt=$this->db->prepare("SELECT  {$model}.title,{$color}.color,{$code_table}.size,{$excel}.quantity FROM {$code_table} INNER JOIN  {$color} ON  {$color}.id={$code_table}.id_color INNER JOIN  {$model} ON {$model}.id={$color}.id_item left JOIN  {$excel} ON {$excel}.code={$code_table}.code   WHERE {$code_table}.code=? LIMIT  1");
        $stmt->execute(array($code));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
    }


   return $result;


}

    function list_serial_deleted_jard()
    {

        $this->checkPermit('list_serial_deleted',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'jard/html','serial_deleted','php'));
        $this->adminFooterController();

    }


    public function processing_serial_deleted_jard()
    {


        $table = $this->serial_delete;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.bill', 'dt' => 0),
            array( 'db' => $table.'.code', 'dt' => 1),
            array( 'db' => $table.'.serial', 'dt' => 2 ),
            array( 'db' => $table.'.type_enter', 'dt' => 3 ),
            array( 'db' => 'user.username', 'dt' => 4 ),

            array( 'db' =>  $table.'.date', 'dt' => 5 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 6)


        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userid   ";
        $whereAll = array("");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }




    function  jard_material ()
    {

        $this->checkPermit('jard_material',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'jard/html','material','php'));
        $this->adminFooterController();

    }


    public function processing_jard_material()
    {


        $table = $this->jard;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.page', 'dt' => 0  ),
            array( 'db' => $table.'.model', 'dt' => 1 ,
                'formatter' => function ($id, $row) {
                    return  $id."[". $this->langControl($id) ."]";
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 2 ,
                'formatter' => function ($id, $row) {
                    $this->data_code=$this->data_code($id,$row[1]);
                    return  $this->data_code['title'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 3),
            array( 'db' => $table.'.code', 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['color'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 5 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['size'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 6,
                'formatter' => function ($id, $row) {

                    $m="'{$row[1]}'";
                    return '
                <button class="btn btn-primary" onclick="get_serial_jard('.$id.','.$m.','.$row[0].')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[1].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[1].'">'.$this->sum_serial_jard($id,$row[1],$row[0]).'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[1].'">
                      <div style="padding: 5px;margin:0;align-items: center;"  class="card card-body" id="data_collapse_'.$id.$row[1].'">
                   </div>
                </div>
                ';
                }
            ),
            array( 'db' => $table.'.location_quantity_all', 'dt' => 7,
                'formatter' => function ($id, $row) {

                    $m="'{$row[1]}'";
                    return '
                <button class="btn btn-warning" onclick="get_all_location_jard_details('.$row[3].','.$m.')"  type="button" data-toggle="collapse" data-target="#location_jard-'.$row[3].$row[1].'" aria-expanded="false" aria-controls="location_jard'.$row[3].$row[1].'">'.$id.'</button>
                   <div class="collapse multi-collapse"   id="location_jard-'.$row[3].$row[1].'">
                      <div style="padding: 5px;margin:0;align-items: center;" class="card card-body" id="location_data_collapse_'.$row[3].$row[1].'">
                   </div>
                </div>
                ';
                }
            ),


            array( 'db' => $table.'.excel_quantity', 'dt' => 8 ,
                'formatter' => function ($id, $row) {
                    return  $id;
                }
            ),


            array( 'db' =>  $table.'.date', 'dt' => 9 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array( 'db' =>  $table.'.code', 'dt' => 10 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial',$this->folder))
                    {
                        $code="'{$id}'";
                        $model="'{$row[0]}'";
                        return '
                          <button class="btn btn-primary" onclick="delete_serial_jard_by_code('.$code.','.$model.','.$row[0].')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 11),




        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userId   ";

        if ($this->admin($this->userid))
        {
            $whereAll = array("");
        }else
        {
            $whereAll = array("userId={$this->userid}");
        }

        $group="  GROUP BY {$table}.code , {$table}.page  ";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));

    }



    function sum_serial_jard($code,$model,$page)
    {


        if ($this->admin($this->userid))
        {
            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM jard  WHERE code=? AND  model=? AND page=?");
            $stmt ->execute(array($code,$model,$page));
        }else
        {
            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM jard  WHERE code=? AND  model=? AND userId = ? AND page =? ");
            $stmt ->execute(array($code,$model,$this->userid,$page));
        }
        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }





    function edit_jard($id)
    {

        $this->checkPermit('edit_jard',  $this->folder);
        $this->adminHeaderController($this->langControl('edit_jard'));

        if (!$this->admin($this->userid))
        {
            $stmtResult = $this->db->prepare("SELECT  * FROM jard_page   WHERE page=? AND userId=?");
            $stmtResult->execute(array($id,$this->userid));
            if ($stmtResult->rowCount()  < 1)
            {
                die('
                 <br>
                    <div class="alert alert-danger" role="alert">
                       <span>تحاول التعديل على رقم جرد غير خاص بك </span>  //  <a href="'.url.'/'.$this->folder.'/list_jard" class="btn btn-warning btn-sm  ">رجوع</a> 
                    </div>
                    
                    '
                );
            }
        }





        require($this->render($this->folder, 'jard/html', 'edit', 'php'));
        $this->adminFooterController();

    }


    function from_edit_jard($id)
    {



        $stmtResult = $this->db->prepare("SELECT  * FROM jard_page   WHERE page=? ");
        $stmtResult->execute(array($id));
        $result=$stmtResult->fetch(PDO::FETCH_ASSOC);


        $date_add=strtotime('+1 day', $result['date']);

        if ($date_add <= time())
        {
            die('over_time');
        }


        $this->checkPermit('edit_jard',  $this->folder);

        if (isset($_POST['submit'])) {

            try {

                $form = new  Form();



                if ($this->setting->get('required_location_jard') == 1){
                    $form->post('location')
                        ->val('is_empty', $this->langControl('required'))
                        ->val('strip_tags');
                }

                $form->post('serial')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type_enter')
                    ->val('is_empty', $this->langControl('required'))
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $serial=trim($data['serial']);




                $stmtpage = $this->db->prepare("SELECT  * FROM serial   WHERE serial=? ");
                $stmtpage->execute(array($serial));

                if ($stmtpage->rowCount() > 0) {

                    $stmtUpdatePage = $this->db->prepare("UPDATE `jard_page`  SET   from_date =?  WHERE  page=?  AND    userId=? AND  from_date = 0");
                    $stmtUpdatePage->execute(array(time(),$id,$this->userid));

                    $stmtUpdatePage2 = $this->db->prepare("UPDATE `jard_page`  SET   to_date =?  WHERE  page=?  AND    userId=?  ");
                    $stmtUpdatePage2->execute(array(time(),$id,$this->userid));

                    $result= $stmtpage->fetch(PDO::FETCH_ASSOC);
                    $serial_data= $this->data_code($result['code'],$result['model']);
                    $serial_data['model']=$result['model'];



                    if ($this->setting->get('required_location_jard') == 0){
                        $data['location']='';

                        $data['location_quantity']=0;
                    }else
                    {
                        $data['location_quantity']=$this->location_quantity($result['code'],$result['model'],$data['location']);
                    }

                    $data['location_quantity_all']=$this->location_quantity_all($result['code'],$result['model']);



                    $stmtCh=$this->db->prepare("SELECT  * FROM jard   WHERE page=?  AND  code =? AND  serial=? AND model=? AND  userId=? AND  location=?");
                    $stmtCh->execute(array($id,$serial_data['code'],$data['serial'],$serial_data['model'],$this->userid,$data['location']));
                    if ($stmtCh->rowCount() > 0)
                    {
                        $stmtUpdate = $this->db->prepare("UPDATE `jard`  SET   type_enter =? , quantity=quantity+1,userId=?,date=?  WHERE  page=?  AND  code =? AND  serial=? AND model=? AND  userId=? AND  location=?");
                        $stmtUpdate->execute(array($data['type_enter'],$this->userid,time(),$id,$serial_data['code'],$data['serial'],$serial_data['model'],$this->userid,$data['location']));
                        echo 'true';
                    }else{
                        $stmt = $this->db->prepare("INSERT INTO `jard` ( page, code, serial, type_enter, quantity,excel_quantity, model, userId,`date`,location,location_quantity,location_quantity_all) VALUE (?,?,?,?,?,?,?,?,?,?,?,?) ");
                        $stmt->execute(array($id,$serial_data['code'],$data['serial'],$data['type_enter'],1,$serial_data['quantity'],$serial_data['model'],$this->userid,time(),$data['location'],$data['location_quantity'],$data['location_quantity_all']));
                        echo 'true';

                    }

                }else{
                    echo 'er_serial';
                }

            } catch (Exception $e) {

                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }

    }




    function delete_serial_jard($id)
    {
        if ($this->handleLogin())
        {

            $stmtRow = $this->db->prepare("SELECT * FROM jard WHERE id=? ");
            $stmtRow ->execute(array($id));
            $result=$stmtRow->fetch(PDO::FETCH_ASSOC);
            $time=time();
            $stmtData  = $this->db->prepare("INSERT INTO jard_delete (page, code, serial, type_enter, quantity,excel_quantity, model, userId, date)  SELECT page,code, serial, type_enter, quantity,excel_quantity, model, $this->userid, $time  FROM jard WHERE id=?");
            $stmtData ->execute(array($id));

            $stmt  = $this->db->prepare("DELETE FROM jard WHERE id=?");
            $stmt ->execute(array($id));
            $this->insertCodeSerial_conform($result['code'],$result['mode'],'حذف سيريال');
            echo 'true';
        }

    }

    function delete_serial_jard_by_code($code,$model,$page)
    {
        if ($this->handleLogin())
        {


            if ($model == 'deleted')
            {
                $stmt  = $this->db->prepare("DELETE FROM jard WHERE code=?  AND page=?");
                $stmt ->execute(array($code,$page));
                die('true');
            }

            $time=time();
            if ($this->admin($this->userid))
            {
                $stmtRow = $this->db->prepare("SELECT * FROM jard WHERE code=? AND model=? AND page=?");
                $stmtRow ->execute(array($code,$model,$page));
            }else
            {
                $stmtRow = $this->db->prepare("SELECT * FROM jard WHERE code=? AND model=? AND  userId=? AND page=?");
                $stmtRow ->execute(array($code,$model,$this->userid,$page));
            }

            while ($row = $stmtRow->fetch(PDO::FETCH_ASSOC) )
            {
                $stmtData  = $this->db->prepare("INSERT INTO jard_delete (page,  code, serial, type_enter, quantity,excel_quantity, model, userId, date)  SELECT page, code, serial, type_enter, quantity,excel_quantity, model, $this->userid, $time  FROM jard_delete WHERE id=?");
                $stmtData ->execute(array($row['id']));

            }
            if ($this->admin($this->userid))
            {
                $stmt  = $this->db->prepare("DELETE FROM jard WHERE code=? AND model=? AND page=?");
                $stmt ->execute(array($code,$model,$page));

            }else
            {
                $stmt  = $this->db->prepare("DELETE FROM jard WHERE code=? AND model=? AND userId=? AND page=?");
                $stmt ->execute(array($code,$model,$this->userid,$page));


            }
            echo 'true';
        }

    }






}