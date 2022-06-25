<?php

class report extends Controller
{

    public $ids = array();
    function __construct()
    {
        parent::__construct();

        $this->report_withdrawn = 'report_withdrawn';
        $this->date_upload = 'date_upload';
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->report_withdrawn}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT,
          `id_product`  int(11) NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `quantity` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `note` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->date_upload}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT,
          `category` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->report_withdrawn,$this->date_upload));

    }




	function report_upload()
	{


		$this->checkPermit('report_upload','report');
		$this->adminHeaderController($this->langControl('report_upload '));


		$cat=null;

		$fromdate=0;
		$totdate = 0;
		$fromtime_stamp=0;
		$totime_stamp=0;
        $out=array();
        $out_id=0;
		 if (isset($_GET['cat']))
		 {

			 $cat=$_GET['cat'];
		 }

		 if (isset($_GET['out']))
		 {
		     if (!empty($_GET['out']))
             {
                  $out=$_GET['out'];
                  $out_id=implode(',',$out);

             }

		 }





		if (isset($_GET['fromdate']))
		{
			$fromdate=$_GET['fromdate'];
			$fromtime_stamp=strtotime($fromdate);
		}

		 if (isset($_GET['todate']))
		 {
			 $totdate=$_GET['todate'];
			 $totime_stamp=strtotime($totdate);
		 }

        $_SESSION['fromDate']=$fromtime_stamp;
        $_SESSION['toDate']=$totime_stamp;

        if ($cat=='savers')
        {
            $_SESSION['model']='product_savers';
        }else{
            $_SESSION['model']=$cat;
        }


	  	$string=$cat.'/'.$fromtime_stamp.'/'.$totime_stamp;





        $name_cat='category_'.$cat;

        $stmt = $this->db->prepare("SELECT * from `{$name_cat}`   ");
        $stmt->execute();
        $allCat=array();
        if ($stmt->rowCount() > 0) {

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $allCat[]=$row;

            }

        }




		require($this->render($this->folder, 'quantity', 'index', 'php'));
		$this->adminFooterController();
	}


	public function processing_quantity(

		$cat=null,

		$fromtime_stamp=null,
		$totime_stamp=null


	)
	{
        $out=null;
	    if (isset($_GET['out']))
        {
             $out=$_GET['out'];
        }


		if ($cat=='savers')
		{



			$part='name_device';
			$table = 'cart_shop';
			$primaryKey = $table . '.id';
			$excel = 'excel_savers';

			$columns = array(


				array('db' => $part.'.title', 'dt' => 0),
				array('db' => 'product_savers.title', 'dt' => 1),
				array('db' => $table.'.code', 'dt' => 2),
				array('db' => $table.'.table', 'dt' => 3 ,
					'formatter' => function( $d, $row ) {
                        return  $this->sum_quantity_location($d,$row[2]) ;
					}
				),
				array('db' => $table.'.table', 'dt' => 4 ,
					'formatter' => function( $d, $row ) {
                        return  $this->sum_quantity_locationall($d,$row[2]) ;
					}
				),
				array('db' => $table.'.code', 'dt' => 5,

					'formatter' => function( $d, $row ) {
						return  $this->sale($d) ;
					}

				),
				array('db' => $table.'.price_dollars', 'dt' => 6,

					'formatter' => function( $d, $row ) {
						return   $d ;
					}

				),


                array('db' => $table.'.price_dollars', 'dt' => 7,

                    'formatter' => function( $d, $row ) {
                        return   $this->price_dollarsAdmin($d);
                    }

                ),

				array('db' =>$table.'.image', 'dt' => 8,
					'formatter' => function( $d, $row ) {
						return "<img  src='".$this->save_file.$d."' style='width: 50px;border: 1px solid gainsboro;'>";
					}
				),


			);

			// SQL server connection information
			$sql_details = array(
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db' => DB_NAME,
				'host' => DB_HOST,
				'charset' => 'utf8'
			);

			if (!empty($out))
            {

                $join = " inner JOIN product_savers ON product_savers.id = cart_shop.id_item   inner JOIN name_device ON name_device.id = product_savers.id_device   inner JOIN category_savers ON category_savers.id = name_device.id_cat ";
                if (!empty($fromtime_stamp) && !empty($totime_stamp))
                {
                    $whereAll = array(   "category_savers.`id` IN ({$out}) ",   "cart_shop.`table` = 'product_savers' "," cart_shop.`number`  > 0  "," cart_shop.`cancel`  = 0  "," cart_shop.`accountant`  = 1  ","cart_shop.`date_accountant`  BETWEEN {$fromtime_stamp}  AND {$totime_stamp} ");


              }


            }else
            {
                $join = " inner JOIN product_savers ON product_savers.id = cart_shop.id_item   inner JOIN name_device ON name_device.id = product_savers.id_device ";
                if (!empty($fromtime_stamp) && !empty($totime_stamp))
                {
                    $whereAll = array("cart_shop.`table` = 'product_savers' "," cart_shop.`number`  > 0  "," cart_shop.`cancel`  = 0  "," cart_shop.`accountant`  = 1  ","cart_shop.`date_accountant`  BETWEEN {$fromtime_stamp}  AND {$totime_stamp} ");




                }



            }


            $group="GROUP BY  cart_shop.id_item , cart_shop.code,cart_shop.`table`";

			echo json_encode(

		     SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,null));


		}else if ($cat=='accessories')
		{


			$part='category_'.$cat;

			$table = 'cart_shop';
			$primaryKey = $table . '.id';
			$excel = 'excel_accessories';


			$columns = array(


				array('db' => $part.'.title', 'dt' => 0),
				array('db' => $cat.'.title', 'dt' => 1),

				array('db' => $table.'.code', 'dt' => 2),
                array('db' => $table.'.table', 'dt' => 3 ,

                    'formatter' => function( $d, $row ) {
                        return  $this->sum_quantity_location($d,$row[2]) ;
                    }

                ),
                array('db' => $table.'.table', 'dt' => 4 ,
                    'formatter' => function( $d, $row ) {
                        return  $this->sum_quantity_locationall($d,$row[2]) ;
                    }
                ),
				array('db' => $table.'.code', 'dt' => 5,

					'formatter' => function( $d, $row ) {
						return  $this->sale($d) ;
					}

				),
                array('db' => $table.'.price_dollars', 'dt' => 6,

                    'formatter' => function( $d, $row ) {
                        return   $d ;
                    }

                ),

                array('db' => $table.'.price_dollars', 'dt' => 7,

                    'formatter' => function( $d, $row ) {
                        return   $this->price_dollarsAdmin($d);
                    }

                ),
				array('db' =>$table.'.image', 'dt' => 8,
					'formatter' => function( $d, $row ) {
						return "<img  src='".$this->save_file.$d."' style='width: 50px;border: 1px solid gainsboro;'>";
					}
				),


			);

           // SQL server connection information
			$sql_details = array(
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db' => DB_NAME,
				'host' => DB_HOST,
				'charset' => 'utf8'
			);


            if (!empty($out)  )
            {
//                $this->ids[]=$out;
//                if (!empty($this->getLoopIdX($out,$part)))
//                {
//                    $this->ids[]=  $this->getLoopIdX($out,$part);
//                }
//                $ids_cat=implode(',', $this->ids);
//

                $join = " inner JOIN accessories ON accessories.id = cart_shop.id_item  inner JOIN {$part} ON {$part}.id = {$cat}.id_cat   inner JOIN color_accessories ON color_accessories.id_item = accessories.id  ";

                if (!empty($fromtime_stamp) && !empty($totime_stamp))
                {
                    $whereAll = array("{$part}.`id` IN ({$out}) ","cart_shop.`table` = '{$cat}' "," cart_shop.`number`  > 0  "," cart_shop.`cancel`  = 0  "," cart_shop.`accountant`  = 1  ","cart_shop.`date_accountant`  BETWEEN {$fromtime_stamp}  AND {$totime_stamp} ");



                }

            }else
            {

                $join = " inner JOIN accessories ON accessories.id = cart_shop.id_item  inner JOIN {$part} ON {$part}.id = {$cat}.id_cat   inner JOIN color_accessories ON color_accessories.id_item = accessories.id     ";

                if (!empty($fromtime_stamp) && !empty($totime_stamp))
                {
                    $whereAll = array("cart_shop.`table` = '{$cat}' "," cart_shop.`number`  > 0  "," cart_shop.`cancel`  = 0  "," cart_shop.`accountant`  = 1  ","cart_shop.`date_accountant`  BETWEEN {$fromtime_stamp}  AND {$totime_stamp} ");


                }
            }



            $group="GROUP BY  cart_shop.id_item , cart_shop.code,cart_shop.`table`";

			echo json_encode(

				SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,null));


		}else
		{


			$part='category_'.$cat;
			if ($cat=='mobile')
			{
				$table = 'cart_shop';
				$primaryKey = $table . '.id';
                $code='code';
				$color='color';
				$excel='excel';

			}else
			{

				$table = 'cart_shop';
				$primaryKey = $table . '.id';
				$code='code_'.$cat;
				$color='color_'.$cat;
				$excel='excel_'.$cat;
			}




			$columns = array(


				array('db' => $part.'.title', 'dt' => 0),
				array('db' => $cat.'.title', 'dt' => 1),

				array('db' => $table.'.code', 'dt' => 2),
                array('db' => $table.'.table', 'dt' => 3 ,

                    'formatter' => function( $d, $row ) {
                        return  $this->sum_quantity_location($d,$row[2]) ;
                    }

                ),
                array('db' => $table.'.table', 'dt' => 4 ,
                    'formatter' => function( $d, $row ) {
                        return  $this->sum_quantity_locationall($d,$row[2]) ;
                    }
                ),
				array('db' => $table.'.code', 'dt' => 5,
					'formatter' => function( $d, $row ) {
						return  $this->sale($d) ;
					}
				),
                array('db' => $table.'.price_dollars', 'dt' => 6,

                    'formatter' => function( $d, $row ) {
                        return   $d ;
                    }

                ),
                array('db' => $table.'.price_dollars', 'dt' => 7,

                    'formatter' => function( $d, $row ) {
                        return   $this->price_dollarsAdmin($d);
                    }

                ),
				array('db' =>$table.'.image', 'dt' => 8,
					'formatter' => function( $d, $row ) {
						return "<img  src='".$this->save_file.$d."' style='width: 50px;border: 1px solid gainsboro;'>";
					}
				),


			);

// SQL server connection information
			$sql_details = array(
				'user' => DB_USER,
				'pass' => DB_PASS,
				'db' => DB_NAME,
				'host' => DB_HOST,
				'charset' => 'utf8'
			);


            if (!empty($out)  ) {

//
//                $this->ids[] = $out;
//                if (!empty($this->getLoopIdX($out, $part))) {
//                    $this->ids[] = $this->getLoopIdX($out, $part);
//                }
//                $ids_cat = implode(',', $this->ids);

                $join = " inner JOIN {$cat} ON {$cat}.id= {$table}.id_item inner JOIN {$part} ON {$part}.id = {$cat}.id_cat    ";
                if (!empty($fromtime_stamp) && !empty($totime_stamp)) {
                    $whereAll = array("{$part}.`id`  IN ({$out}) ", "cart_shop.`table` = '{$cat}' ", " cart_shop.`number`  > 0  ", " cart_shop.`cancel`  = 0  ", " cart_shop.`accountant`  = 1  ", "cart_shop.`date_accountant`  BETWEEN {$fromtime_stamp}  AND {$totime_stamp} ");

                }

            }else {

                $join = " inner JOIN {$cat} ON {$cat}.id= {$table}.id_item inner JOIN {$part} ON {$part}.id = {$cat}.id_cat    ";
                if (!empty($fromtime_stamp) && !empty($totime_stamp)) {
                    $whereAll = array("cart_shop.`table` = '{$cat}' ", " cart_shop.`number`  > 0  ", " cart_shop.`cancel`  = 0  ", " cart_shop.`accountant`  = 1  ", "cart_shop.`date_accountant`  BETWEEN {$fromtime_stamp}  AND {$totime_stamp} ");



                }
            }



            $group="GROUP BY  cart_shop.id_item , cart_shop.code,cart_shop.`table`";

			echo json_encode(

				SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,$group,null));


		}


	}


	 
	function sum_quantity_location($table,$code)
    {

        if ($table=='product_savers')
        {
            $table='savers';
        }

        $stmt= $this->db->prepare("SELECT SUM(t1.quantity) as q
        FROM location t1
        LEFT JOIN tamayaz_locations t2 ON t2.location = t1.location
        WHERE t2.location IS NULL AND  t1.`model`=? AND t1.`code` = ?  AND t1.quantity > 0");


        $stmt->execute(array($table,$code));
        if ($stmt->rowCount() > 0)
        {
            $quantity = $stmt->fetch(PDO::FETCH_ASSOC);

            return $quantity['q'];
        }else{

            return 0;
        }
    }



	function sum_quantity_locationall($table,$code)
    {

        if ($table=='product_savers')
        {
            $table='savers';
        }

//        $stmt= $this->db->prepare("SELECT SUM(t1.quantity) as q
//        FROM location t1
//        LEFT JOIN tamayaz_locations t2 ON t2.location = t1.location
//        WHERE t2.location IS NULL AND  t1.`model`=? AND t1.`code` = ?  AND t1.quantity > 0");
//

        $stmt= $this->db->prepare("SELECT SUM(quantity) as q
        FROM location   WHERE  `model`=? AND `code` = ?  AND quantity > 0");

        $stmt->execute(array($table,$code));
        if ($stmt->rowCount() > 0)
        {
            $quantity = $stmt->fetch(PDO::FETCH_ASSOC);

            return $quantity['q'];
        }else{

            return 0;
        }
    }


	function booked_up($code)
	{
		$stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` = ? AND `table`=? AND  date_req between ? AND  ?  AND `buy` = 1  AND cancel=0   ");
		$stmt->execute(array($code,$_SESSION['model'],$_SESSION['fromDate'],$_SESSION['toDate']));
		$booked = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($booked['num'])
		{
			return $booked['num'];
		}else{

			return 0;
		}
	}



	function sale($code)
	{

		$stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` = ? AND `table`=? AND  date_accountant between ? AND  ?   AND cancel=0  AND  `accountant`=1 AND number > 0 GROUP BY  id_item ,code,`table`");
		$stmt->execute(array($code,$_SESSION['model'],$_SESSION['fromDate'],$_SESSION['toDate']));

		if ($stmt->rowCount() > 0)
		{
            $sale = $stmt->fetch(PDO::FETCH_ASSOC);
			return $sale['num'];
		}else{

			return 0;
		}
	}



	function booked_up2($code,$color)
	{
		$stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` = ?  AND `name_color`=?  AND `table`=? AND  date_req between ? AND  ?  AND `buy` = 1  AND cancel=0   ");
		$stmt->execute(array($code,$color,$_SESSION['model'],$_SESSION['fromDate'],$_SESSION['toDate']));
		$booked = $stmt->fetch(PDO::FETCH_ASSOC);
		if ($booked['num'])
		{
			return $booked['num'];
		}else{

			return 0;
		}
	}


    function getLoopIdX($id,$category)
    {

        $stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
        $stmt->execute(array($id));
        while (  $s=$stmt->fetch(PDO::FETCH_ASSOC))
        {
            $this->ids[]=$s['id'];
            $this->getLoopIdX($s['id'],$category);

        }

    }

    function getLoopId($id,$category)
    {

        if (!empty($id))
        {
            $this->ids[]=$id;
        }

        $stmt=$this->db->prepare("SELECT *from  {$category} WHERE  `relid` = {$id} AND `active` = 1 ");
        $stmt->execute(array($id));
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $this->ids[]=$row['id'];


            $this->getLoopIdX($row['id'],$category);
        }

        return $this->ids;
    }


//	function sale2($code)
//	{
//
//		$stmt= $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` = ? AND `table`=? AND  date_req between ? AND  ?  AND `buy` = 2  AND cancel=0  AND  `accountant`=1");
//		$stmt->execute(array($code,$_SESSION['model'],$_SESSION['fromDate'],$_SESSION['toDate']));
//		$sale = $stmt->fetch(PDO::FETCH_ASSOC);
//		if ($sale['num'])
//		{
//			return $sale['num'];
//		}else{
//
//			return 0;
//		}
//	}


/*
    function report_upload($all=null,$cat=null)
    {

        $this->checkPermit('report_upload','report');
        $this->adminHeaderController($this->langControl('report '));



        $report=array();

        if (isset($_GET['submit']) || $all != null)
        {



            if ($all == null)
            {
                $totime = trim($_GET['todate']);
                $fromtime=trim( $_GET['fromdate']);
                $cat= trim($_GET['cat']);
                $fromtime_stamp=strtotime($fromtime);
                $totime_stamp=strtotime('+1 day',strtotime($totime));
            }


               if ($all == null )
               {

                   $stmt = $this->db->prepare("SELECT  `code`,`name_color`  FROM `cart_shop` WHERE (`date_req` >= ?  AND  `date_req` <= ?) AND `table` = ? GROUP BY  `code`,`name_color` ");
                   if ($cat !='savers')
                   {
                       $stmt->execute(array($fromtime_stamp,$totime_stamp,$cat));
                   }else
                   {
                       $stmt->execute(array($fromtime_stamp,$totime_stamp,'product_savers'));
                   }

               }else
               {
                   if ($cat=='mobile')
                   {
                       $code='code.code';
                       $t= 'code';
                   }else if ($cat=='games' || $cat=='camera' || $cat=='network' )
                   {
                       $code= 'code_'.$cat.'.code';
                       $t= 'code_'.$cat;
                   }
                   else if ($cat=='accessories')
                   {
                       $code= 'color_accessories.code';
                       $stmt = $this->db->prepare("SELECT color_accessories.code FROM color_accessories LEFT JOIN cart_shop ON {$code} = cart_shop.code WHERE 1  GROUP BY code,cart_shop.name_color  ");
                       $stmt->execute();

                   }else{

                      $stmt = $this->db->prepare("SELECT product_savers.code,cart_shop.name_color FROM product_savers LEFT JOIN cart_shop ON product_savers.code = cart_shop.code INNER JOIN product_color ON product_savers.id = product_color.id_product WHERE 1 GROUP BY product_savers.code,cart_shop.name_color ");
                      $stmt->execute();

                   }

                   if ($cat=='games' || $cat=='camera' || $cat=='network' || $cat=='mobile')
                   {

                       $stmt = $this->db->prepare("SELECT {$code} FROM {$t} LEFT JOIN cart_shop ON {$code} = cart_shop.code WHERE 1  GROUP BY code  ");

                           $stmt->execute();

                   }

               }



            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {

                if ($cat =='mobile') {
                    $excel = 'excel';
                }else
                {
                    $excel = 'excel_' . $cat;
                }
                $stmtCode_mobile=$this->db->prepare("SELECT *FROM `{$excel}` WHERE `code`=?");
                $stmtCode_mobile->execute(array($row['code']));
                $result=$stmtCode_mobile->fetch(PDO::FETCH_ASSOC);
                $row['quantity']=$result['quantity'];


                if ($cat !='accessories' && $cat !='savers' ) {

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`= ? ");
                    $stmt_order->execute(array($row['code'], $cat));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $row['order'] = $only_order['num'];


                    $stmt_done = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 2  AND `status` =1  AND `delivered`=0  AND `table`= ? ");
                    $stmt_done->execute(array($row['code'], $cat));
                    $only_done = $stmt_done->fetch(PDO::FETCH_ASSOC);
                    $row['done'] = $only_done['num'];


                    $stmt_delivered = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 2  AND `status` =1  AND `delivered`=1  AND `table`= ? ");
                    $stmt_delivered->execute(array($row['code'], $cat));
                    $only_delivered = $stmt_delivered->fetch(PDO::FETCH_ASSOC);
                    $row['delivered'] = $only_delivered['num'];
                    if ($cat =='mobile') {
                        $code = 'code' ;
                    }else{
                        $code = 'code_' . $cat;
                    }
                    $stmt_cd = $this->db->prepare("SELECT  `id_color`,`size`  FROM `{$code}` WHERE `code` =?  ");
                    $stmt_cd->execute(array($row['code']));
                    $id_color = $stmt_cd->fetch(PDO::FETCH_ASSOC);
                    $row['size'] = $id_color['size'];
                    if ($cat =='mobile') {
                        $color = 'color';
                    }else
                    {
                        $color = 'color_' . $cat;
                    }
                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,`code_color`,`color`  FROM `{$color}` WHERE `id` =?  ");
                    $stmt_img->execute(array($id_color['id_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $row['img'] = $this->save_file . $img_div['img'];
                    $row['code_color'] = $img_div['code_color'];
                    $row['name_color'] = $img_div['color'];


                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `{$cat}` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $row['name'] = $name_device['title'];
                    $row['id'] = $name_device['id'];






                }
                else if ( $cat =='accessories')
                {

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`= ? ");
                    $stmt_order->execute(array($row['code'], $cat));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                    $row['order'] = $only_order['num'];


                    $stmt_done = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 2  AND `status` =1  AND `delivered`=0  AND `table`= ? ");
                    $stmt_done->execute(array($row['code'], $cat));
                    $only_done = $stmt_done->fetch(PDO::FETCH_ASSOC);
                    $row['done'] = $only_done['num'];


                    $stmt_delivered = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 2  AND `status` =1  AND `delivered`=1  AND `table`= ? ");
                    $stmt_delivered->execute(array($row['code'], $cat));
                    $only_delivered = $stmt_delivered->fetch(PDO::FETCH_ASSOC);
                    $row['delivered'] = $only_delivered['num'];


                    $color='color_'.$cat;
                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,code_color,`code`,`color`  FROM `{$color}` WHERE `code` =?  ");
                    $stmt_img->execute(array($row['code']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $row['img'] = $this->save_file . $img_div['img'];
                    $row['code_color'] = $img_div['code_color'];
                    $row['name_color'] = $img_div['color'];
                    $row['size'] = '';




                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `{$cat}` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_item']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $row['name'] = $name_device['title'];
                    $row['id'] = $name_device['id'];





                }else if ($cat =='savers')
                {


                    $catx='product_savers';
                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `name_color` = ?  AND `buy` = 1  AND `status` =0    AND `table`= ? ");
                    $stmt_order->execute(array($row['code'],$row['name_color'], $catx));
                    $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                     $row['order'] = $only_order['num'];


                    $stmt_done = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =? AND `name_color` = ?  AND `buy` = 2  AND `status` =1  AND `delivered`=0  AND `table`= ? ");
                    $stmt_done->execute(array($row['code'],$row['name_color'], $catx));
                    $only_done = $stmt_done->fetch(PDO::FETCH_ASSOC);
                    $row['done'] = $only_done['num'];


                    $stmt_delivered = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `name_color`=? AND `buy` = 2  AND `status` =1  AND `delivered`=1  AND `table`= ? ");
                    $stmt_delivered->execute(array($row['code'],$row['name_color'], $catx));
                    $only_delivered = $stmt_delivered->fetch(PDO::FETCH_ASSOC);
                    $row['delivered'] = $only_delivered['num'];

                    $row['size']='';



                    $stmt_img = $this->db->prepare("SELECT  `img`,`id_product`,`code_color`,`color`  FROM `product_color` WHERE `color` = ?  ");
                    $stmt_img->execute(array($row['name_color']));
                    $img_div = $stmt_img->fetch(PDO::FETCH_ASSOC);
                    $row['img'] = $this->save_file . $img_div['img'];
                    $row['code_color'] = $img_div['code_color'];



                    $stmt_name_device = $this->db->prepare("SELECT  `id`,`title` FROM `product_savers` WHERE `id` =?    ");
                    $stmt_name_device->execute(array($img_div['id_product']));
                    $name_device = $stmt_name_device->fetch(PDO::FETCH_ASSOC);
                    $row['name'] = $name_device['title'];
                    $row['id'] = $name_device['id'];




                }







                $report[]=$row;
            }



        }
        else
        {
            $cat='mobile';
            $totime = date('Y-m-d', strtotime('+1 day',time()));
            $stmt_last_upload =$this->db->prepare("SELECT  `date` FROM `{$this->date_upload}`  WHERE `category` = ?  ORDER BY `date` DESC  LIMIT 1");
            $stmt_last_upload->execute(array($cat));
            $fromtime= date('Y-m-d',$stmt_last_upload->fetch(PDO::FETCH_ASSOC)['date']);


             $fromtime_stamp=strtotime($fromtime);
            $totime_stamp=strtotime('+1 day',time());

            $stmt = $this->db->prepare("SELECT  `code`  FROM `cart_shop` WHERE (`date_req` >= ?  AND  `date_req` <= ?) AND `table` = ? GROUP BY  code ");
            $stmt->execute(array($fromtime_stamp,$totime_stamp,$cat));
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {


                $stmtCode_mobile=$this->db->prepare("SELECT *FROM `excel` WHERE `code`=?");
                $stmtCode_mobile->execute(array($row['code']));
                $result=$stmtCode_mobile->fetch(PDO::FETCH_ASSOC);
                $row['quantity']=$result['quantity'];

                $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 1  AND `status` =0    AND `table`= ? ");
                $stmt_order->execute(array($row['code'],$cat));
                $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);
                $row['order']=$only_order['num'];



                $stmt_done = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 2  AND `status` =1  AND `delivered`=0  AND `table`= ? ");
                $stmt_done->execute(array($row['code'],$cat));
                $only_done=$stmt_done->fetch(PDO::FETCH_ASSOC);
                $row['done']=$only_done['num'];


                $stmt_delivered = $this->db->prepare("SELECT   SUM(`number`)as num  FROM `cart_shop` WHERE `code` =?  AND `buy` = 2  AND `status` =1  AND `delivered`=1  AND `table`= ? ");
                $stmt_delivered->execute(array($row['code'],$cat));
                $only_delivered=$stmt_delivered->fetch(PDO::FETCH_ASSOC);
                $row['delivered']=$only_delivered['num'];



                $stmt_cd = $this->db->prepare("SELECT  `id_color`,`size`  FROM `code` WHERE `code` =?  ");
                $stmt_cd->execute(array($row['code']));
                $id_color=$stmt_cd->fetch(PDO::FETCH_ASSOC);
                $row['size']=$id_color['size'];

                $stmt_img = $this->db->prepare("SELECT  `img`,`id_item`,`code_color`,`color`  FROM `color` WHERE `id` =?  ");
                $stmt_img->execute(array($id_color['id_color']));
                $img_div=$stmt_img->fetch(PDO::FETCH_ASSOC);
                $row['img']=$this->save_file.$img_div['img'];
                $row['code_color']=$img_div['code_color'];
                $row['name_color']=$img_div['color'];


                $stmt_name_device = $this->db->prepare("SELECT  `id`,`title`,`id_cat` FROM `{$cat}` WHERE `id` =?    ");
                $stmt_name_device->execute(array($img_div['id_item']));
                $name_device=$stmt_name_device->fetch(PDO::FETCH_ASSOC);
                $row['name'] = $name_device['title'];
                $row['id'] = $name_device['id'];

                $report[]=$row;
            }




        }







        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();



    }

*/







    function report_withdrawn_ajax()
    {

         $this->checkPermit('withdrawn','report');
         $code = strip_tags(trim($_POST['code']));
         $cat = strip_tags(trim($_POST['cat']));
         $quantity = strip_tags(trim($_POST['quantity']));
         $serial = strip_tags(trim($_POST['serial']));
         $note = strip_tags(trim($_POST['note']));
         $id = strip_tags(trim($_POST['id']));
         $name_color = strip_tags(trim($_POST['name_color']));


         $excel=null;
         if ($cat == 'mobile')
         {
             $excel='excel';
         }else
         {
             $excel='excel_'.$cat;
         }

         if (is_numeric($quantity)) {
             if (isset($_POST['location'])) {

                 $location = trim($_POST['location']);
                 $stmtch = $this->db->prepare("SELECT *FROM location WHERE id=? AND model=? AND code=? ");
                 $stmtch->execute(array($location, $cat, $code));
                 if ($stmtch->rowCount() > 0) {


                     $stmtch_q = $this->db->prepare("SELECT *FROM location WHERE id=? AND model=? AND code=? AND quantity >= {$quantity}");
                     $stmtch_q->execute(array($location, $cat, $code));
                     if ($stmtch_q->rowCount() > 0) {


                         $stmtch_excel = $this->db->prepare("SELECT *FROM  `{$excel}`  WHERE code=? AND quantity >= {$quantity}");
                         $stmtch_excel->execute(array($code));
                         if ($stmtch_excel->rowCount() > 0) {


                             $getLocation = $stmtch_q->fetch(PDO::FETCH_ASSOC);

                             $stmtl = $this->db->prepare("UPDATE location SET quantity=quantity - {$quantity} WHERE id=? AND location=?  AND model=? AND code=?");
                             $stmtl->execute(array($_POST['location'], $getLocation['location'], $cat, $code));


                             $stmt = $this->db->prepare("INSERT INTO `{$this->report_withdrawn}` (`id_product`,`code`,`quantity`,`note`,`userid`,`date`,`category`,`name_color`,`location`,`serial`) VALUES (?,?,?,?,?,?,?,?,?,?)");
                             $stmt->execute(array($id, $code, $quantity, $note, $this->userid, time(), $cat, $name_color, $getLocation['location'], $serial));
                             if ($stmt->rowCount() > 0) {

                                 $stmt2 = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=quantity - {$quantity} WHERE  `code`= ?  ");
                                 $stmt2->execute(array($code));

                                 if ($stmt2->rowCount() > 0) {
                                     echo 'true';
                                 }


                                 $this->Add_to_sync_schedule($code, $cat,'quantity_adjustment',' ',' controllers\report\report.php 1046 '.$this->UserInfo($this->userid));
                             }
                         } else {
                             echo '-q' . $excel . '-' . $quantity;
                         }

                     } else {
                         echo '-q2';
                     }


                 } else {

                     echo 'notLocation';

                 }


             } else {
                 $stmtch_excel = $this->db->prepare("SELECT *FROM  `{$excel}`  WHERE code=? AND quantity >= {$quantity}");
                 $stmtch_excel->execute(array($code));
                 if ($stmtch_excel->rowCount() > 0) {
                     $stmt2 = $this->db->prepare("UPDATE  `{$excel}` SET `quantity`=quantity - {$quantity} WHERE  `code`= ?  ");
                     $stmt2->execute(array($code));

                     if ($stmt2->rowCount() > 0) {

                         $stmt = $this->db->prepare("INSERT INTO `{$this->report_withdrawn}` (`id_product`,`code`,`quantity`,`note`,`userid`,`date`,`category`,`name_color`,`serial`) VALUES (?,?,?,?,?,?,?,?,?)");
                         $stmt->execute(array($id, $code, $quantity, $note, $this->userid, time(), $cat, $name_color, $serial));


                         $stmtc = $this->db->prepare("UPDATE  `location_confirm` SET `quantity`=`quantity` - {$quantity} WHERE  `code` = ?  AND `model`=? AND quantity > 0 ");
                         $stmtc->execute(array($code, $cat));

                         $stmtDeleconf = $this->db->prepare("UPDATE  `location_confirm` SET `quantity`= 0  WHERE  `code` = ?  AND `model`=? AND quantity <  0 ");
                         $stmtDeleconf->execute(array($code, $cat));
                         echo 'true';

                     }

                 } else {
                     echo '-q';
                 }
             }
         }else
         {
             echo 'not_number';
         }
    }




    function report_withdrawn()
    {

        $this->checkPermit('report_withdrawn','report');
        $this->adminHeaderController($this->langControl('report_withdrawn'));





        $date=null;
        $todate=null;

        $from_date_stm=null;
        $to_date_stm=null;

        if (isset($_GET['date'])&&isset($_GET['todate'])) {
            $date = $_GET['date'];
            $todate = $_GET['todate'];

            $from_date_stm =   strtotime($date);
            $to_date_stm =  strtotime($todate);

        }

        require ($this->render($this->folder,'html','drow','php'));
        $this->adminFooterController();

    }



    public function processing($fromDate=null,$toDate=null)
    {
        $this->checkPermit('report_withdrawn', $this->folder);
        $table = $this->report_withdrawn;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'id_product', 'dt' => 0,
                'formatter' => function( $d, $row ) {
                    return $this->name_item($d,$row[1]) ;
                }),
            array('db' => 'category', 'dt' => 1,
                'formatter' => function( $d, $row ) {
                    return $this->langControl($d) ;
                }),

            array('db' =>  'code', 'dt' => 2),
            array('db' =>  'serial', 'dt' => 3),

            array('db' =>'quantity', 'dt' => 4),
            array('db' =>'q_excel', 'dt' => 5),
            array(  'db' => 'location', 'dt'=>6,
                'formatter'=> function($d,$row)
                {
                    return $this->tamayaz_locations($d);
                }
            ),


            array('db' => 'userid', 'dt' => 7,
                'formatter' => function( $d, $row ) {
                    return  $this->UserInfo($d);
                }),


            array('db' => 'date', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    return  date('Y-m-d h:i:s A',$d);
                }),

            array('db' =>'note', 'dt' => 9),


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        if ($fromDate && $toDate)
        {
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns," `date` between  {$fromDate} AND  {$toDate} "));

        }else{
            echo json_encode(
                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns));

        }

    }

    function name_item($id,$table)
    {

        if ($table == 'savers')
        {
            $table='product_savers';
        }

        $stmt=$this->db->prepare("SELECT title FROM {$table} WHERE id=?");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            $result=$stmt->fetch(PDO::FETCH_ASSOC);
            return $result['title'];
        }else
        {
            return '';
        }

    }




}