<?php

class material_inventory extends Controller
{

     public   $location=array();
     public   $l='';
     public   $model='';
     function __construct()
     {
        parent::__construct();

     }

    function list_material($model)
    {

        $this->checkPermit($model, $this->folder);
        $this->adminHeaderController($this->langControl($model));


        $stmt_locat = $this->db->prepare("SELECT  location FROM `location_model`  WHERE  `model` =?  ");
        $stmt_locat->execute(array($model));
        while ($row = $stmt_locat->fetch(PDO::FETCH_ASSOC))
        {
            $this->location[]=$row['location'];
        }



        require($this->render($this->folder, 'html', 'index', 'php'));
        $this->adminFooterController();

    }


    public function processing($model)
    {

        $table = $model;
        $primaryKey = $model.'.id';

        if ($model=='mobile') {
            $code = 'code';
            $color = 'color';
        }else  {
            $code = 'code_'.$model;
            $color = 'color_'.$model;
        }

        $stmt_locat = $this->db->prepare("SELECT  location FROM `location_model`  WHERE  `model` =?  ");
        $stmt_locat->execute(array($model));
        while ($row = $stmt_locat->fetch(PDO::FETCH_ASSOC))
        {
            $this->location[]=$row['location'];
        }
        $this->l='';

        $columns = array(
            array(  'db' =>'location.model', 'dt'=>0,
                'formatter' => function ($id, $row) {

                    return $this->langControl($id);
                }
            ),
            array(  'db' => $code.'.code', 'dt'=>1),
            array(  'db' => $model.'.title', 'dt'=>2),


            array(
                'db' =>  $code.'.code',
                'dt' => 3,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 1)
                    {
                        $this->l= $this->location[0];
                    }
                    return $this->q_location($id,$row[0], $this->l);
                }
            ),

            array(
                'db' =>  $code.'.code',
                'dt' => 4,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 2)
                    {
                        $this->l= $this->location[1];
                    }
                    return $this->q_location($id,$row[0], $this->l);
                }
            ),


            array(
                'db' =>  $code.'.code',
                'dt' => 5,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 3)
                    {
                        $this->l= $this->location[2];
                    }
                    return $this->q_location($id,$row[0], $this->l);
                }
            ),




            array(
                'db' =>  $code.'.code',
                'dt' => 6,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 4)
                    {
                        $this->l= $this->location[3];
                    }
                    return $this->q_location($id,$row[0], $this->l);
                }
            ),


            array(
                'db' =>  $code.'.code',
                'dt' => 7,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 5)
                    {
                        $this->l= $this->location[4];
                    }
                    return $this->q_location($id,$row[0], $this->l);
                }
            ),



            array(
                'db' =>  $code.'.code',
                'dt' => 8,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 6)
                    {
                        $this->l= $this->location[5];
                    }
                    return $this->q_location($id,$row[0], $this->l);
                }
            ),


            array(
                'db' =>  $code.'.code',
                'dt' => 9,
                'formatter' => function ($id, $row) {

                    if (count($this->location) >= 7)
                    {
                      return 'تواصل مع المبرمج لتفعيل الحقل';
                    }else
                    {
                        return 0;
                    }
                }
            ),




        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


            $join = "INNER JOIN {$color} ON {$color}.id_item={$model}.id INNER JOIN `{$code}` ON {$code}.id_color={$color}.id  INNER JOIN location ON location.code={$code}.code";
            $whereAll = array("location.model='{$model}'");
            $group="GROUP BY location.code";
            $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group);

            echo json_encode($result);


    }





    public function processing_accessories($model)
    {

        $table = 'location';

        $primaryKey = $table.'.id';
        $color = 'color_'.$model;

        $columns = array(
            array(  'db' =>'location.model', 'dt'=>0,
                'formatter' => function ($id, $row) {

                    return $this->langControl($id);
                }
            ),
            array(  'db' => $color.'.code', 'dt'=>1),
            array(  'db' => $model.'.title', 'dt'=>2),
            array(  'db' => 'location.location', 'dt'=>3,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
            ),
            array(  'db' => 'location.quantity', 'dt'=>4)

          );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        $join = "INNER JOIN {$color} ON {$color}.code=location.code  INNER JOIN {$model} ON {$model}.id={$color}.id_item ";
        $whereAll = array( "location.model='{$model}'", "location.quantity  > 0");
       // $group="GROUP BY {$color}.code";
        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1);
         echo json_encode($result);

    }


    public function processing_savers()
    {

        $table = 'location';
        $primaryKey = $table.'.id';


        $columns = array(
            array(  'db' =>'location.model', 'dt'=>0,
                'formatter' => function ($id, $row) {

                    return $this->langControl($id);
                }
            ),
            array(  'db' => 'product_savers.code', 'dt'=>1),
            array(  'db' => 'product_savers.title', 'dt'=>2),
            array(  'db' => 'location.location', 'dt'=>3,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
            ),
            array(  'db' => 'location.quantity', 'dt'=>4)
        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



        $join = "INNER JOIN product_savers ON product_savers.code={$table}.code  ";
        $whereAll = array( "location.model='savers'", "location.quantity  > 0");
       // $group="GROUP BY {$table}.code";

        $result=SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1);

            echo json_encode($result);


    }



    function  table_location($code,$model)
    {
        $stmt=$this->db->prepare("SELECT *FROM `location` WHERE code=? AND `model`=?  ");
        $stmt->execute(array($code,$model));
        if ($stmt->rowCount() > 0)
        {
            $html="
		<table class='table table-bordered' style='background: #fff;margin: 0;padding: 0'><tbody>";
            $html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #add'> الموقع  </td>
        <td style='padding: 0;    vertical-align: unset;background: #fea'>  الكمية </td>
      
           </tr>
			";
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
           $html .= "
		 <tr>
        <td style='padding: 0;    vertical-align: unset;background: #ad7'>   {$row['location']}   </td>
        <td style='padding: 0;    vertical-align: unset;background: #ffffff'> {$row['quantity']} </td>
      
           </tr>
			";

            }

            $html.="</tbody> </table>";
            return $html ;
        }



    }





    function q_location($code,$model,$location)
    {
        $stmt= $this->db->prepare("SELECT  quantity FROM `location`  WHERE code=? AND `model` =? AND location =? ");
        $stmt->execute(array($code,$model,trim($location)));
        if ($stmt->rowCount() >0)
        {
            return $stmt->fetch(PDO::FETCH_ASSOC)['quantity'];
        }else
        {
            return 0;
        }

    }




    public function excel_compare($model)
    {
        $this->checkPermit('excel_compare',$this->folder);
        $this->adminHeaderController($this->langControl('excel_compare'));

        if ($model=='mobile')
        {
            $excel='excel';
        }else
        {
            $excel='excel_'.$model;
        }


//        $stmt= $this->db->prepare("SELECT count(*) as cout  FROM ( SELECT {$excel}.code,{$excel}.quantity as exq ,location.quantity as lgq ,SUM(location.quantity) as smq  FROM `{$excel}` INNER JOIN location ON location.code={$excel}.code  WHERE  location.model=?  GROUP BY {$excel}.code  ) as t WHERE ( t.smq < t.exq OR  t.smq  > t.exq) ");
//        $stmt->execute(array($model));
//        $result=$stmt->fetch(PDO::FETCH_ASSOC);
//        $count=0;
//        if ($result['cout'] > 0)
//        {
//        $count  =$result['cout'];
//        }

        require ($this->render($this->folder,'html','compare','php'));
        $this->adminFooterController();

    }



    public function processing_excel_compare($model)
    {
        $this->checkPermit('excel_compare',$this->folder);



        if ($model=='mobile')
        {
            $excel='excel';
        }else
        {
            $excel='excel_'.$model;
        }

        $this->model=$model;

        $table =$excel;
        $primaryKey ='id';

        $columns = array(

            array( 'db' => 'code', 'dt' => 0 ),
            array( 'db' => 'quantity', 'dt' => 1 ),
            array( 'db' => 'code', 'dt' => 2,
                'formatter' => function( $d, $row ) {
                    return  $this->sumQuantityLocation($d, $this->model) ;
                }
            ),
            array( 'db' => 'code', 'dt' => 3,
                'formatter' => function( $d, $row ) {
                    return  $this->table_location($d, $this->model) ;
                }
            ),

            array(  'db' => 'id', 'dt'=>4)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


        echo json_encode(

            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns));


        // SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns )

    }


    function sumQuantityLocation($code,$model)
    {
        $stmt= $this->db->prepare("SELECT  SUM(quantity) as q FROM `location`  WHERE code=? AND `model` =?  ");
        $stmt->execute(array($code,$model));

           $result=$stmt->fetch(PDO::FETCH_ASSOC);
           return $result['q'];



    }

function start_convert ()
{
    $model=$_GET['model'];
    $one=$_GET['one'];
    $two=$_GET['two'];
    $three=$_GET['three'];
    $code=null;
    if (isset($_GET['code']))
    {
        $code=strip_tags(trim($_GET['code']));
    }
    if ($model== 'mobile')
    {
        $excel='excel';

    }else
    {
        $excel='excel_'.$model;

    }

    if (!empty($code))
    {

        $stmt= $this->db->prepare("SELECT  t.code,t.exq,t.lsmq,t.price_dollars FROM   ( SELECT {$excel}.code,{$excel}.price_dollars,{$excel}.quantity as exq , SUM(location.quantity) as lsmq  FROM `{$excel}` INNER JOIN location ON location.code={$excel}.code  WHERE  location.model=? AND   location.code=? AND  {$excel}.code =?  GROUP BY {$excel}.code  ) as t WHERE ( t.lsmq < t.exq OR  t.lsmq  > t.exq) ");
        $stmt->execute(array($model,$code,$code));
    }else
    {

        $stmt= $this->db->prepare("SELECT  t.code,t.exq,t.lsmq,t.price_dollars  FROM   ( SELECT {$excel}.code,{$excel}.price_dollars,{$excel}.quantity as exq , SUM(location.quantity) as lsmq  FROM `{$excel}` INNER JOIN location ON location.code={$excel}.code  WHERE  location.model=?  GROUP BY {$excel}.code  ) as t WHERE ( t.lsmq < t.exq OR  t.lsmq  > t.exq) ");
        $stmt->execute(array($model));
    }


    while ($row = $stmt->fetch(PDO::FETCH_ASSOC) )
    {
        if ($one==1) {
            if($row['exq'] > $row['lsmq'] )
            {

                $stmtlc = $this->db->prepare("SELECT quantity FROM location_confirm WHERE code=? AND model= ? ");
                $stmtlc->execute(array($row['code'], $model));
                if ($stmtlc->rowCount() > 0) {
                    $clocation = $stmtlc->fetch(PDO::FETCH_ASSOC);
                    $q = (int)$row['lsmq'] + (int)$clocation['quantity'];
                    if ($row['exq'] > $q) {

                        $over = (int)$row['exq'] - $q;
                        $stmtlcu = $this->db->prepare("UPDATE location_confirm SET  quantity=quantity+{$over} ,`date`=?,userid=? WHERE code=? AND model= ? ");
                        $stmtlcu->execute(array(time(), $this->userid, $row['code'], $model));

                    }

                } else {
                    $over = (int)$row['exq'] - (int)$row['lsmq'];
                    $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                    $stmtExcel_conform->execute(array($over, $row['code'], $model, time(), $this->userid));

                }
            }

        }


        if ($two==1) {
          if ($row['lsmq'] > $row['exq'] )
            {


                $stmtlc = $this->db->prepare("SELECT quantity FROM location_confirm WHERE code=? AND model= ? ");
                $stmtlc->execute(array($row['code'], $model));
                if ($stmtlc->rowCount() > 0) {
                    $clocation = $stmtlc->fetch(PDO::FETCH_ASSOC);
                    $q = (int)$row['lsmq'] + (int)$clocation['quantity'];
                    if ($q > $row['exq']) {

                        $over = $q - (int)$row['exq'];
                        $stmtlcu = $this->db->prepare("UPDATE {$excel} SET  quantity=quantity+{$over} ,`date`=?,userid=? WHERE code=?   ");
                        $stmtlcu->execute(array(time(), $this->userid, $row['code']));

                        $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,`number_bill`,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                        $stmt_user_add_excel->execute(array($row['code'], $over, $row['price_dollars'], $this->userid, $_SESSION['usernamelogin'], time(), date('Y-m-d h:i A', time()), 'نظام التسوية الموجود بجرد المواد', 'new', $model, 0, 0, 0, 0));

                    }

                } else {
                    $over = (int)$row['lsmq'] - (int)$row['exq'];
                    $stmtlcu = $this->db->prepare("UPDATE {$excel} SET  quantity=quantity+{$over} ,`date`=?,userid=? WHERE code=?   ");
                    $stmtlcu->execute(array(time(), $this->userid, $row['code']));

                    $stmtExcel_conform = $this->db->prepare("INSERT INTO  location_confirm (quantity,code,model,date,userid)  values (?,?,?,?,?)");
                    $stmtExcel_conform->execute(array(0, $row['code'], $model, time(), $this->userid));


                    $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,`number_bill`,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt_user_add_excel->execute(array($row['code'],   $over,$row['price_dollars'], $this->userid, $_SESSION['usernamelogin'], time(), date('Y-m-d h:i A', time()), 'نظام التسوية الموجود بجرد المواد', 'new', $model, 0, 0, 0, 0));

                }
            }
        }

        if ($three==1) {
            if($row['exq'] > $row['lsmq'] )
            {

                $stmtlcu = $this->db->prepare("UPDATE  {$excel} SET  quantity=? ,`date`=?,userid=? WHERE code=?  ");
                $stmtlcu->execute(array($row['lsmq'],time(), $this->userid, $row['code']));

                $stmt_user_add_excel = $this->db->prepare("INSERT INTO uesr_add_excel (`code`,`quantity`,`price`,`userid`,`username`,`date`,`normal_date`,`color`,`type`,`model`,`number_bill`,`wholesale_price`,`wholesale_price2`,`cost_price`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt_user_add_excel->execute(array($row['code'], $row['lsmq'] , $row['price_dollars'] , $this->userid, $_SESSION['usernamelogin'], time(), date('Y-m-d h:i A', time()),   '  نظام التسوية الموجود بجرد المواد // الكمية المرفوعة =  ' .$row['exq']  , 'new', $model, 0, 0, 0, 0));



            }


        }



    }

    echo 'true';


}



}