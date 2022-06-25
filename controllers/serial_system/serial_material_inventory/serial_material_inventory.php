<?php

trait serial_material_inventory
{

    protected  $data_code=array();
    protected  $q_serial=0;

    function __construct()
    {
        parent::__construct();
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);//databaseObject
    }



    function  serial_material_inventory()
    {

        $this->checkPermit('serial_material_inventory',$this->folder);
        $this->adminHeaderController($this->langControl($this->folder));



        require ($this->render($this->folder,'serial_material_inventory/html','material','php'));
        $this->adminFooterController();

    }


    public function processing_serial_material_inventory()
    {


        $table = $this->serial;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.model', 'dt' => 0 ,
                'formatter' => function ($id, $row) {
                    return  $id."[". $this->langControl($id) ."]";
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 1 ,
                'formatter' => function ($id, $row) {
                 $this->data_code=$this->data_code($id,$row[0]);
                    return  $this->data_code['title'];
                }
            ),
            array( 'db' => $table.'.bill', 'dt' => 2),
            array( 'db' => $table.'.code', 'dt' => 3),

            array( 'db' =>  "(SELECT   GROUP_CONCAT(spare_code SEPARATOR ',')      FROM spare_code WHERE spare_code.code = {$table}.code AND spare_code.model = {$table}.model)", 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                return $row[4];
                }
            ),


            array( 'db' => $table.'.code', 'dt' => 5 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['color'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 6 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['size'];
                }
            ),
            array( 'db' => $table.'.code', 'dt' => 7,
                'formatter' => function ($id, $row) {

                $this->q_serial=$this->sum_serial_enter($id,$row[0]);
                $m="'{$row[0]}'";
                return '
                <button class="btn btn-warning btn_quantity_enter" onclick="get_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#multiCollapseExample-'.$id.$row[0].'" aria-expanded="false" aria-controls="multiCollapseExample'.$id.$row[0].'">'.$this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="multiCollapseExample-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
                ),

            array( 'db' => $table.'.code', 'dt' => 8,
                'formatter' => function ($id, $row) {

                $m="'{$row[0]}'";
                return '
                <button class="btn btn-info btn_quantity_enter" onclick="get_location_serial('.$id.','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location_serial-'.$id.$row[0].'" aria-expanded="false" aria-controls="get_location_serial'.$id.$row[0].'">'. $this->q_serial.'</button>
                   <div class="collapse multi-collapse" id="get_location_serial-'.$id.$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="location_serial_data_collapse_'.$id.$row[0].'">
                   </div>
                </div>
                ';
                }
             ),


            array( 'db' => $table.'.code', 'dt' => 9 ,
                'formatter' => function ($id, $row) {
                    return  $this->data_code['quantity'];
                }
            ),

            array( 'db' =>  "(SELECT SUM(location.quantity) FROM location WHERE location.code = {$table}.code AND location.model =  {$table}.model)", 'dt' => 10 ,
                'formatter' => function ($id, $row) {

                    $m="'{$row[0]}'";
                    $q=0;
                     if ($row[10])
                        {
                            $q=$row[10];
                        }
                    return '
                <button class="btn btn-primary btn_location" onclick="list_location('.$row[3].','.$m.')"  type="button" data-toggle="collapse" data-target="#get_location-'.$row[3].$row[0].'" aria-expanded="false" aria-controls="get_location'.$row[3].$row[0].'">'.$q.'</button>
                   <div class="collapse multi-collapse" id="get_location-'.$row[3].$row[0].'">
                      <div style="padding: 5px;margin:0" class="card card-body" id="data_location_'.$row[3].$row[0].'">
                   </div>
                </div>
                ';

                }
            ),

            array( 'db' =>  $table.'.date', 'dt' => 11 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array( 'db' =>  $table.'.code', 'dt' => 12 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_serial',$this->folder))
                    {
                        $code="'{$id}'";
                        $model="'{$row[0]}'";
                        return '
                          <button class="btn btn-danger" onclick="delete_serial_by_code('.$code.','.$model.')"  type="button"  ><i class="fa fa-trash"></i> </button>   
                    ';
                    }
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 13),




        );

        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db'   => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = " inner JOIN user ON user.id = {$table}.userid   ";

       if ($this->admin($this->userid))
       {
           $whereAll = array("");
       }else
       {
           $whereAll = array("userId={$this->userid}");
       }

        $group="  GROUP BY {$table}.code, {$table}.model  ";

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,1));

    }



    function time_taken($code,$model)
    {

        if ($this->admin($this->userid))
        {
            $stmt  = $this->db->prepare("SELECT  time_taken  FROM serial  WHERE code=? AND  model=? ORDER BY  id DESC LIMIT 1");
            $stmt ->execute(array($code,$model));
        }else
        {
            $stmt  = $this->db->prepare("SELECT  time_taken  FROM serial  WHERE code=? AND  model=? AND userId =? ORDER BY  id DESC LIMIT 1");
            $stmt ->execute(array($code,$model,$this->userid));
        }

        return $stmt ->fetch(PDO::FETCH_ASSOC)['time_taken'] ;
    }


    function sum_serial_enter($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT  SUM(quantity) as q FROM serial  WHERE code=? AND  model=?");
            $stmt ->execute(array($code,$model ));

        return $stmt ->fetch(PDO::FETCH_ASSOC)['q'] ;
    }






    function list_location ($code,$model)
    {


            $stmt  = $this->db->prepare("SELECT    location,quantity  FROM location  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));

        $html = "<table class='table_location'>";
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "<tr> <td>{$row['location']}<td><span class='badge badge-pill badge-success'>{$row['quantity']} </span></td> </tr>    ";
             }
        }else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
        $html .="</table>";
        echo $html;
    }


    function get_location_serial ($code,$model)
    {


            $stmt  = $this->db->prepare("SELECT    serial,location    FROM serial  WHERE code=? AND  model=?  AND location <>''  ORDER BY serial");
            $stmt ->execute(array( $code,$model));

        $html = "<table class='table_serial_location'>";
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html .= "<tr> <td>{$row['serial']}<td><span>{$row['location']} </span></td> </tr>    ";
             }
        }else
        {
            $html .= "</tr><td> لا يوجد مواقع</td></tr>";
        }
        $html .="</table>";
        echo $html;
    }



    function list_location_no_html ($code,$model)
    {

            $stmt  = $this->db->prepare("SELECT    location,quantity  FROM location  WHERE code=? AND  model=?  ");
            $stmt ->execute(array($code,$model));
            $location=array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $location[]=$row;
             }
          return $location;
    }






    function delete_serial($id)
    {
        if ($this->handleLogin())
        {

            $stmtRow = $this->db->prepare("SELECT * FROM serial WHERE id=? ");
            $stmtRow ->execute(array($id));
            $result=$stmtRow->fetch(PDO::FETCH_ASSOC);
            $time=time();
            $stmtData  = $this->db->prepare("INSERT INTO serial_delete (page, bill, code, serial, type_enter, quantity, model, userId, date)  SELECT page, bill, code, serial, type_enter, quantity, model, $this->userid, $time  FROM serial WHERE id=?");
            $stmtData ->execute(array($id));

            $stmt  = $this->db->prepare("DELETE FROM serial WHERE id=?");
            $stmt ->execute(array($id));
            $this->insertCodeSerial_conform($result['code'],$result['mode'],'حذف سيريال');
            echo 'true';
        }

    }

    function delete_serial_by_code($code,$model)
    {
        if ($this->handleLogin())
        {


            if ($model == 'deleted')
            {
                $stmt  = $this->db->prepare("DELETE FROM serial WHERE code=?  ");
                $stmt ->execute(array($code));
                die('true');
            }

            $time=time();
            if ($this->admin($this->userid))
            {
                $stmtRow = $this->db->prepare("SELECT * FROM serial WHERE code=? AND model=?");
                $stmtRow ->execute(array($code,$model));
            }else
            {
                $stmtRow = $this->db->prepare("SELECT * FROM serial WHERE code=? AND model=? AND  userId=?");
                $stmtRow ->execute(array($code,$model,$this->userid));
            }

            while ($row = $stmtRow->fetch(PDO::FETCH_ASSOC) )
            {
                $stmtData  = $this->db->prepare("INSERT INTO serial_delete (page, bill, code, serial, type_enter, quantity, model, userId, date)  SELECT page, bill, code, serial, type_enter, quantity, model, $this->userid, $time  FROM serial WHERE id=?");
                $stmtData ->execute(array($row['id']));
                $this->insertCodeSerial_conform($row['code'],$row['mode'],'حذف سيريال');

            }
            if ($this->admin($this->userid))
            {
                $stmt  = $this->db->prepare("DELETE FROM serial WHERE code=? AND model=?");
                $stmt ->execute(array($code,$model));

            }else
            {
                $stmt  = $this->db->prepare("DELETE FROM serial WHERE code=? AND model=? AND userId=?");
                $stmt ->execute(array($code,$model,$this->userid));


            }
            echo 'true';
        }

    }




}