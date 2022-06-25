<?php
require "type_cover/type_cover.php";
require "feature_cover/feature_cover.php";
class savers extends Controller
{

use type_cover,feature_cover;

    function __construct()
    {
        parent::__construct();
        $this->category = 'category_savers'; //  الماركة
        $this->table = 'name_device'; //   السلسلة
        $this->type_device = 'type_device';//  اسم الجهاز
        $this->color_savers = 'color_savers';//excel الون في كرستال
        $this->excel = 'excel_savers';//
        $this->like_savers = 'like_savers';//
        $this->cart_shop = 'cart_shop';//



        $this->product_savers = 'product_savers';//
        $this->product_savers_connect = 'product_savers_connect';//
        $this->cover_material = 'cover_material';//
        $this->type_cover = 'type_cover';//
        $this->feature_cover = 'feature_cover';//




        $this->setting=new Setting();
        $this->menu = new Menu();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `relid` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `order_cat` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` int(11) NOT NULL,
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->type_device}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_device` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->color_savers}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `type_device` int (10) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->excel}` (
            `id` int(10) NOT NULL AUTO_INCREMENT ,
            `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price_dollars`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `price`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `quantity`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `color`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
            `date` bigint(20) NOT NULL,
            PRIMARY KEY (`id`)
       ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->like_savers}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_device` int(11) NOT NULL  DEFAULT '0',
          `id_member_r` int(11) NOT NULL,
          `like` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->product_savers}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content` longtext COLLATE utf8_unicode_ci NOT NULL,
          `tags` longtext COLLATE utf8_unicode_ci NOT NULL,
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `bast_it` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->product_savers_connect}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ids` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->cover_material}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `cover_material` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,

          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->type_cover}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `type_cover` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,

          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->feature_cover}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `feature_cover` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` varchar(250) COLLATE utf8_unicode_ci NOT NULL,

          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->table, $this->category, $this->feature_cover,$this->type_cover,$this->cover_material, $this->type_device, $this->color_savers, $this->excel, $this->like_savers, $this->product_savers,$this->product_savers));

    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }


    public function list_savers($id = null)
    {

        $this->checkPermit('view_content', 'savers');
        $this->adminHeaderController($this->langControl('view_content'));

        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();

    }


    public function list_view()
    {


        $stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1 AND {$this->is_delete}");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }



        $date=time();


            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  FIND_IN_SET('$this->folder',model)   AND `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute();



        $offers=array();
        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {

            $row['dollar']= $this->priceDollarOffer($row['id'],3);

            if ($row['range_price'] == 0)
            {
                $row['priceC']=$this->priceDollarOffer($row['id'],4);
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                if ($this->loginUser())
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],4);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }else
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],5);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }

            }
            $row['image']=$this->show_file_site.$row['img'];
            $row['code']=$this->show_file_site.$row['code'];

            $offers[]=$row;
        }





        require($this->render($this->folder, 'html', 'view_list', 'php'));
    }



    public function getImage($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT `id`,`img` FROM `{$this->product_savers}` WHERE   `id`= ?   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }




    function numberItems($id)
    {
        $stmt = $this->db->prepare("SELECT `id`  FROM product_savers WHERE   `id_product`= ? AND {$this->is_delete} ");
        $stmt->execute(array($id));
        return $stmt;
    }



    public function smt_ch_q($code,$color)
    {

        $stmt = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?   AND  `color`= ?   AND  `quantity` > 0");
        $stmt->execute(array($code,trim($color)));
        return $stmt;
    }

    public function getPrice($id,$code,$limit) //for details
    {

        $stmt = $this->db->prepare("SELECT `color`,`code_color` FROM `{$this->product_savers}` WHERE   `id`= ?  AND {$this->is_delete} ");
        $stmt->execute(array($id));

        $arr_code=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $arr_code[]=$row;
        }


        $stop=false;

        foreach ($arr_code as $color)
        {
            $stmt2 = $this->db->prepare("SELECT `price`,`price_dollars` FROM `{$this->excel}` WHERE   `code`= ?  AND    `color`= ?  AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0        LIMIT 1 ");
            $stmt2->execute(array($code,$color['color']));
            if ($stmt2->rowCount() > 0)
            {

                $stop=true;
                $result_= $stmt2->fetch(PDO::FETCH_ASSOC);

                return array('price'=>$result_['price'],'color'=>$color['color'],'code_color'=>$color['code_color']);
                break;
            } else {
                continue;
            }

        }

        if ($stop ==false)
        {
            $stmt = $this->db->prepare("SELECT  `price`,`price_dollars`,`code_color`,`color` FROM `{$this->product_savers}` WHERE   `id`= ? AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $this->db->prepare("SELECT `price`  FROM `{$this->excel}` WHERE `code`= ?  AND    `color`= ?       LIMIT 1 ");
            $stmt2->execute(array($code,$result['color']));
            $result_= $stmt2->fetch(PDO::FETCH_ASSOC);
            return array('price'=>$result_['price'],'color'=>$result['color'],'code_color'=>$result['code_color']);
        }



    }


    public function getPrice2($id,$code,$limit) //for lest
    {

        $stmt = $this->db->prepare("SELECT `color`,`code_color` FROM `{$this->product_savers}` WHERE   `id_product`= ?  AND {$this->is_delete}    ");
        $stmt->execute(array($id));

        $arr_code=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $arr_code[]=$row;
        }



        $stop=false;

        foreach ($arr_code as $color)
        {
            $stmt2 = $this->db->prepare("SELECT `price`,`price_dollars`,`wholesale_price` FROM `{$this->excel}` WHERE   `code`= ?  AND    `color`= ?  AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0        LIMIT 1 ");
            $stmt2->execute(array($code,$color['color']));
            if ($stmt2->rowCount() > 0)
            {

                $stop=true;
                $result_= $stmt2->fetch(PDO::FETCH_ASSOC);


                if ($this->loginUser() )
                {

                    $price = $this->price_dollarsAdmin($result_['price_dollars']);
                    return array('price'=>$price,'price_dollars' => $result_['price_dollars'],'color'=>$color['color'],'code_color'=>$color['code_color']);
                }else
                {
                    $price = $this->price_dollars($result_['price_dollars']);
                    return array('price'=>$price,'price_dollars' => $result_['price_dollars'],'color'=>$color['color'],'code_color'=>$color['code_color']);
                }

                break;
            } else {
                continue;
            }

        }

        if ($stop ==false)
        {
            $stmt = $this->db->prepare("SELECT  `price`,`price_dollars`,`code_color`,`color` FROM `{$this->product_savers}` WHERE   `id`= ?    AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $this->db->prepare("SELECT `price`  FROM `{$this->excel}` WHERE `code`= ?  AND    `color`= ?       LIMIT 1 ");
            $stmt2->execute(array($code,$result['color']));
            $result_= $stmt2->fetch(PDO::FETCH_ASSOC);


            if ($this->loginUser() )
            {

                $price = $this->price_dollarsAdmin($result_['price_dollars']);
                return array('price'=>$price,'color'=>$result['color'],'code_color'=>$result['code_color']);
            }else
            {
                $price = $this->price_dollars($result_['price_dollars']);
                return array('price'=>$price,'color'=>$result['color'],'code_color'=>$result['code_color']);
            }


        }



    }




    public function getPriceNew($code) //for lest
    {

            $stmt2 = $this->db->prepare("SELECT  *FROM `excel_savers` WHERE   `code`= ?   AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0    LIMIT 1 ");
            $stmt2->execute(array($code));
            if ($stmt2->rowCount() > 0) {
				$result_ = $stmt2->fetch(PDO::FETCH_ASSOC);

				if ($this->loginUser() )
				{

					$price = $this->price_dollarsAdmin($result_['price_dollars']);
					return array('price'=>$price,'quantity'=>$result_['quantity']);
				}else
				{
					$price = $this->price_dollars($result_['price_dollars']);
					return array('price'=>$price,'quantity'=>$result_['quantity']);
				}
			}else
			{
				return false;
			}

    }



    public function details($id,$id_device)
    {
        if (!is_numeric($id)) {$error=new Errors(); $error->index();}
        if (!is_numeric($id_device)) {$error=new Errors(); $error->index();}



		$stmt=$this->db->prepare("SELECT *FROM {$this->product_savers} WHERE  `id` = ?  AND {$this->is_delete} ");
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);

		$latiniin=array();
		if ($result['latiniin'])
        {
            $stmt = $this->db->prepare("SELECT * from product_savers  WHERE `latiniin` = ?   AND {$this->is_delete}");
            $stmt->execute(array($result['latiniin']));
        }else
        {
            $stmt = $this->db->prepare("SELECT * from product_savers  WHERE   `id` = ?  AND {$this->is_delete} ");
            $stmt->execute(array($id));
        }

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$row['image'] = $this->save_file . $row['img'];

			$smt_price = $this->getPriceNew($row['code']);
			if ($smt_price) {


				$stmtlc=$this->db->prepare("SELECT *FROM location WHERE `code`=? AND model=? ");
				$stmtlc->execute(array($row['code'],'savers'));
				$row['location']=array();
				while ($rowlc = $stmtlc->fetch(PDO::FETCH_ASSOC))
				{
					$row['location'][]= $rowlc;
				}


			$latiniin[]=$row;
			}
		}








		$stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete} ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


        $g_c_content=array();
        $id_c=0;
        $count=0;


        $stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete} ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }



        require ($this->render($this->folder,'html','details','php'));


    }


    public function getImageAndColor($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT *FROM `{$this->product_savers}` WHERE   `id_product`= ?  AND {$this->is_delete}  LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt;
    }



    function price()
    {

        $code=strip_tags(trim($_GET['code']));

        $stmt= $this->db->prepare("SELECT product_savers.id , `{$this->excel}`.price_dollars, `{$this->excel}`.wholesale_price, `{$this->excel}`.wholesale_price2, `{$this->excel}`.cost_price from `{$this->excel}` INNER  JOIN product_savers  ON product_savers.code={$this->excel}.code  WHERE  {$this->excel}.`code`=? AND  product_savers.`code`=?  LIMIT 1 ");
        $stmt->execute(array($code,$code));
        if ($stmt->rowCount()>0)
        {

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

          require($this->render($this->folder, 'html', 'price', 'php'));

        }else
        {
            echo  'السعر غير معروف';
        }


    }





    function getNmaDevice_public($id)
    {



        $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id_cat`= ?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $nameDevice = array();
        $c=0;
        $html='';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($c==0)
            {
                $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
            }else
            {
                $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
            }

            $c++;
        }
        echo $html ;

    }



    function colorDevice_public($id,$type='all')
    {

		$table=array();

        $stmt_ch = $this->db->prepare("SELECT `ids` FROM `product_savers_connect` WHERE  FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
        $stmt_ch->execute(array($id));
        if ($stmt_ch->rowCount()>0)
        {
            $result = $stmt_ch->fetch(PDO::FETCH_ASSOC);
            $ids=$result['ids'];
            if ($type=='all')
            {
                $stmt = $this->db->prepare("SELECT type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device   INNER  JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device`  IN ({$ids})  AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> ''  AND   {$this->excel}.`quantity`  >  0   AND product_savers.`is_delete`=0");
                $stmt->execute();
            }else
            {

                $type="'%{$type}%'";
                $stmt = $this->db->prepare("SELECT  type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device  JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device`  IN ({$ids})  AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> '' AND ( product_savers.latiniin LIKE '%fm%' OR product_savers.latiniin LIKE  ? ) AND   {$this->excel}.`quantity`  >  0  AND product_savers.`is_delete`=0");
                $stmt->execute(array($type));
            }


        }else{


            if ($type=='all')
            {
                $stmt = $this->db->prepare("SELECT  type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device   JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device` = ?    AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> '' AND   {$this->excel}.`quantity`  >  0 AND product_savers.`is_delete`=0");
                $stmt->execute(array($id));
            }else
            {

                $type="'%{$type}%'";
                $stmt = $this->db->prepare("SELECT  type_device.title as title_device, product_savers.*,{$this->excel}.price_dollars as excel_price_dollars , {$this->excel}.wholesale_price , {$this->excel}.wholesale_price2 , {$this->excel}.cost_price  from `product_savers` INNER JOIN type_device ON type_device.id =product_savers.id_device   JOIN {$this->excel} ON {$this->excel}.code =product_savers.code WHERE product_savers.`id_device` = ?    AND product_savers.`active`=1 AND  product_savers.`img` <> '' AND product_savers.`title` <> ''  AND ( product_savers.latiniin LIKE '%fm%' OR product_savers.latiniin LIKE  ? ) AND   {$this->excel}.`quantity`  >  0  AND product_savers.`is_delete`=0");
                $stmt->execute(array($id,$type));
            }



        }

		if ($stmt->rowCount() > 0 ){
			while ($idProd=$stmt->fetch(PDO::FETCH_ASSOC))
			{
				$idProd['image'] = $this->save_file . $idProd['img'];
				$idProd['id_device'] = $id;

                if ($this->loginUser()) {
                    $idProd['priceC'] = $this->price_dollarsAdmin($idProd['excel_price_dollars']);
                    $idProd['price'] =$idProd['priceC'] . ' د.ع ';

                    $idProd['wholesale_price'] = $this->price_dollarsAdmin($idProd['wholesale_price']). ' د.ع ';
                    $idProd['wholesale_price2'] = $this->price_dollarsAdmin($idProd['wholesale_price2']). ' د.ع ';
                    $idProd['cost_price'] = $this->price_dollarsAdmin($idProd['cost_price']). ' د.ع ';


                } else {

                        $idProd['priceC'] = $this->price_dollars($idProd['excel_price_dollars']);
                        $idProd['price'] =  $idProd['priceC']  . ' د.ع ';

                        $idProd['wholesale_price'] = $this->price_dollars($idProd['wholesale_price']). ' د.ع ';
                        $idProd['wholesale_price2'] = $this->price_dollars($idProd['wholesale_price2']). ' د.ع ';
                        $idProd['cost_price'] = $this->price_dollars($idProd['cost_price']). ' د.ع ';


                }


					$table[]= $idProd;



			}

		}


        $date=time();

        if ($id) {
            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  FIND_IN_SET(?,`ids_cat`) AND  FIND_IN_SET('$this->folder',model)   AND `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute(array($id));
        } else

        {
            $stmtOffer=$this->db->prepare("SELECT *FROM  offers WHERE  FIND_IN_SET('$this->folder',model)   AND `active`=1 AND {$date} BETWEEN `fromdate` AND `todate` ");
            $stmtOffer->execute();
        }

        $offers=array();
        while ($row = $stmtOffer->fetch(PDO::FETCH_ASSOC))
        {

            $row['dollar']= $this->priceDollarOffer($row['id'],3);

            if ($row['range_price'] == 0)
            {
                $row['priceC']=$this->priceDollarOffer($row['id'],4);
                $row['range']=$row['priceC'] . '  د.ع ';

            }else
            {
                if ($this->loginUser())
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],4);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }else
                {
                    $row['priceC']=$this->priceDollarOffer($row['id'],5);
                    $row['range']=$row['priceC'] . '  د.ع ';

                }

            }
            $row['image']=$this->show_file_site.$row['img'];
            $offers[]=$row;
        }





        require ($this->render($this->folder,'html','filter','php'));


    }


    function typeDevice_public($id)
    {


        $stmt = $this->db->prepare("SELECT * from `{$this->type_device}` WHERE `id_device`= ?  AND {$this->is_delete} ORDER BY title ASC");
        $stmt->execute(array($id));

        $c=0;
        $html='';
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            if ($c==0)
            {
                $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
            }else
            {
                $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
            }

            $c++;
        }
        echo $html ;

    }


    function getNmaDevice_public_export_excel($id)
    {



        $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id_cat`= ?   AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $nameDevice = array();
        $c=0;
        $html="<option value=''    ></option>" ;
//        $html="<option value='all'    >الكل</option>" ;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;

            $c++;
        }
        echo $html ;

    }



    function typeDevice_public_export_excel($id)
    {


        $stmt = $this->db->prepare("SELECT * from `{$this->type_device}` WHERE `id_device`= ?  AND {$this->is_delete}  ORDER BY title ASC");
        $stmt->execute(array($id));

        $c=0;
        $html="<option value=''    ></option>" ;
//        $html="<option value='all'    >الكل</option>" ;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {


                $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;


            $c++;
        }
        echo $html ;

    }




    public function type_device($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT `id`  FROM `{$this->type_device}` WHERE   `id_device`= ?  AND {$this->is_delete}   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function color_device($id,$limit)
    {
        $stmt = $this->db->prepare("SELECT `color`  FROM `{$this->color_savers}` WHERE   `type_device`= ?   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function excel_det($color,$code,$limit)
    {
        $stmt = $this->db->prepare("SELECT `price`,`price_dollars`,`quantity`  FROM `{$this->excel}` WHERE   `color`= ?  AND `code` = ?  LIMIT $limit ");
        $stmt->execute(array($color,$code));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function like_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $stmt = $this->db->prepare("INSERT INTO  `{$this->like_savers}` (`id_device`,`id_member_r`,`like`,`date`) value (?,?,?,?)  ");
            $stmt->execute(array($id,$_SESSION['id_member_r'],1,time()));
            echo 'done';
        }else
        {
            echo '404';
        }
    }

    public function unlike_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            $stmt = $this->db->prepare("DELETE FROM  `{$this->like_savers}` WHERE `id_device`=? AND `id_member_r`=? ");
            $stmt->execute(array($id,$_SESSION['id_member_r']));
            echo 'done';
        }else
        {
            echo '404';
        }
    }
    public function ckeckLick($id)
    { if (isset($_SESSION['username_member_r'])) {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->like_savers}` WHERE `id_member_r` =?  AND `id_device` =  ? ");
        $stmt->execute(array($_SESSION['id_member_r'],$id));
        if ($stmt->rowCount()>0)
        {
            return true;
        }else
        {
            return false;
        }
    }
    }




    public function list_category()
    {

        $this->checkPermit('list_category', 'savers');
        $this->adminHeaderController($this->langControl('list_category'));

        require($this->render($this->folder, 'cat', 'list', 'php'));
        $this->adminFooterController();

    }




    public function add_category()
    {


        $this->checkPermit('add_category', 'savers');
        $this->adminHeaderController($this->langControl('add_category'));

        $data['title'] = '';
        $data['order_cat'] = '';

        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('title')
                    ->val('is_empty', 'حقل اسم الماركة فارغ')
                    ->val('strip_tags');


                $form  ->post('order_cat')
                    ->val('strip_tags');

                $form  ->post('code_cat')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['userid'] = $this->userid;
                $data['date'] = time();

                $stmt = $this->db->prepare("INSERT INTO `{$this->category}` (`title`,`order_cat`,`date`) VALUE (?,?,?)");
                $stmt->execute(array($data['title'], $data['order_cat'], $data['date']));
				// h27
				// هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
				$id_cat_h = $this->db->lastInsertId();
            	//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
				$this->Add_to_sync_schedule($id_cat_h,'savers','add_category_savers');
                $this->lightRedirect(url . "/savers/list_category", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'cat', 'add', 'php'));
        $this->adminFooterController();

    }



    public function edit_category($id)
    {
        $this->checkPermit('edit_category', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $files = new Files();
        $this->adminHeaderController($this->langControl('edit_category'));

        $data = $this->db->select("SELECT * from `{$this->category}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('title')
                    ->val('is_empty', 'حقل اسم الماركة فارغ')
                    ->val('strip_tags');


                $form  ->post('order_cat')
                    ->val('strip_tags');

                $form  ->post('code_cat')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                if ($this->permit('save_edit_catg',$this->folder)) {
                    $stmt = $this->db->prepare("UPDATE `{$this->category}` SET  `title`=? ,  `order_cat`=?   WHERE `id`=?");
                    $stmt->execute(array($data['title'], $data['order_cat'], $id));

					// h27
					$this->Add_to_sync_schedule($id,'savers','add_category_savers');
                    $this->lightRedirect(url . "/savers/list_category", 0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'cat', 'edit', 'php'));
        $this->adminFooterController();

    }






    public function add()
    {


        $this->checkPermit('add', 'savers');
        $this->adminHeaderController($this->langControl('add'));


        $category = $this->db->select("SELECT * from `{$this->category}`  WHERE {$this->is_delete} ");


        $data['id_cat'] = '';
        $data['date'] = time();
        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_cat')
                    ->val('is_empty', 'اختر الماركة')
                    ->val('strip_tags');

                $form->post('name_device')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();


                $name_device = json_decode($data['name_device'], true);



                foreach ($name_device as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->table}` (`title`,`id_cat`,`date`) VALUE (?,?,?)");
                    $stmt_c->execute(array($save_data,$data['id_cat'], time()));
               		//             h27
                	//             	هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
                	$id_cat_h = $this->db->lastInsertId();
                	//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
					$this->Add_to_sync_schedule($id_cat_h,$this->table,'add_name_device');
                }

                $this->lightRedirect(url . "/savers/list_savers", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();

    }



    public function edit($id)
    {
        $this->checkPermit('edit', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];

        $category = $this->db->select("SELECT * from `{$this->category}`  WHERE {$this->is_delete}");


        $catg = $this->db->select("SELECT * from `{$this->category}` WHERE `id`=:id LIMIT 1 ", array(':id' => $data['id_cat']));
        $catg = $catg[0];




        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_cat')
                    ->val('is_empty', 'اختر الماركة ')
                    ->val('strip_tags');

                $form->post('title')
                    ->val('is_empty', '   اسم السلسة ')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                if ($this->permit('save_edit',$this->folder)) {
                    $this->db->update($this->table, $data, "id={$id}");

					//                 h27
					$this->Add_to_sync_schedule($id,$this->table,'add_name_device');
                    $this->lightRedirect(url . "/savers/list_savers", 0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'html', 'edit', 'php'));
        $this->adminFooterController();

    }




    public function list_type_device()
    {

        $this->checkPermit('type_device', 'savers');
        $this->adminHeaderController($this->langControl('type_device'));

        require($this->render($this->folder, 'type', 'list', 'php'));
        $this->adminFooterController();

    }

    public function add_type_device()
    {


        $this->checkPermit('add_type_device', 'savers');
        $this->adminHeaderController($this->langControl('add_type_device'));

        $category = $this->db->select("SELECT * from `{$this->table}`  WHERE {$this->is_delete} ");



        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }





        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_device')
                    ->val('is_empty', 'اختر السلسلة')
                    ->val('strip_tags');

                $form->post('type_device')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('id_device_mobile')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();



                $type_device = json_decode($data['type_device'], true);
                $id_device_mobile= json_decode($data['id_device_mobile'], true);



                foreach ($type_device as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->type_device}` (`title`,`id_device_mobile`,`id_device`,`date`,userid) VALUE (?,?,?,?,?)");
                    $stmt_c->execute(array($save_data,$id_device_mobile[$key],$data['id_device'], time(),$this->userid));
					//             h27
					//             	هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
					$id_cat_h = $this->db->lastInsertId();
                	//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
                	$this->Add_to_sync_schedule($id_cat_h,'type_device','add_type_device');
                }

                $this->lightRedirect(url . "/savers/list_type_device", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'type', 'add', 'php'));
        $this->adminFooterController();

    }



    public function edit_type_device($id)
    {
        $this->checkPermit('edit_type_device', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->type_device}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];

        $category = $this->db->select("SELECT * from `{$this->table}` WHERE  {$this->is_delete} ");


        $catg = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ", array(':id' => $data['id_device']));
        $catg = $catg[0];



        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('id_device')
                    ->val('is_empty', 'اختر الماركة ')
                    ->val('strip_tags');

                $form->post('title')
                    ->val('is_empty', '   اسم السلسة ')
                    ->val('strip_tags');


                $form->post('id_device_mobile')
                    ->val('is_empty', ' تحديد الجهاز مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $data['userid']=$this->userid;
                if ($this->permit('save_edit',$this->folder)) {
                    $this->db->update($this->type_device, $data, "id={$id}");

					//                 h27
					$this->Add_to_sync_schedule($id,'type_device','add_type_device');
                    $this->lightRedirect(url . "/savers/list_type_device", 0);
                }

            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'type', 'edit', 'php'));
        $this->adminFooterController();

    }




    function save_file($image)
    {

        $save_file = $this->root_file;
        @mkdir($save_file);
        $path = $save_file;

        $file = array();
        foreach ($image["name"] as $i => $data) {
            if ($image['error'][$i] == 0) {
                $fileName_agency_file = $image['name'][$i];
                $file_agency_file = $image['tmp_name'][$i];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                $fileName_agency_file = time() . md5(mt_rand(1, time())) . '_.' . $extension_agency_file;
                move_uploaded_file($file_agency_file, $path . '/' . $fileName_agency_file);
                $setting=new Setting();
                $file_class=new Files();
                $file_class->smart_resize_image($this->root_file.$fileName_agency_file,$this->root_file.$fileName_agency_file,null,$setting->get('width',1800) ,$setting->get('height',1600),$setting->get('proportional',1),'file',false,false, $setting->get('quality',75) , $setting->get('grayscale',0) );

                $file[$i] = $fileName_agency_file;
            }
        }
        return $file;
    }



    function check_file($image, $arg, $ex = array())
    {

        foreach ($image["name"] as $i => $data) {
            if ($image['error'][$i] == 0) {
                $fileName_agency_file = $image['name'][$i];
                $file_agency_file = $image['tmp_name'][$i];
                $temp_agency_file = explode(".", $fileName_agency_file);
                $extension_agency_file = strtolower(end($temp_agency_file));
                if ($image['size'][$i] < 5194304) {
                    if (in_array($extension_agency_file, $ex)) {
                        if (is_uploaded_file($file_agency_file)) {
                        } else {
                            return $error['document'] = " فشل تحميل ملف {$arg} ";
                        }
                    } else {
                        return $error['document'] = "صيغة الملف غير مسموح بيها";

                    }
                } else {
                    return $error['document'] = "   حجم الملف اكبر من 5 ميكابت ";
                }
            } else {
                return $error['document'] = "مطلوب ";
            }
        }
    }


    public function processing()
    {


        $table = $this->category;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),

            array(
                'db' => 'id',
                'dt' =>1,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/list_saver_connect/$id>  <span>ربط الاجهزة</span> </a>
                    </div> ";
                }
            ),

            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' =>4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_category/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' =>5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 6)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }

    public function processing_hardware_chains()
    {


        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),
            array('db' => 'date', 'dt' => 1,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 2,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_name_device($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 5)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }



    public function processing_type_device()
    {


        $table = $this->type_device;
        $primaryKey = $table.'.id';

        $columns = array(


            array('db' => $table.'.title', 'dt' => 0),
            array('db' =>  'menu_link_device_acc_cover.name_device', 'dt' => 1),
            array('db' => $table.'.date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                 return date('Y-m-d h:i:s a', $d);
                }

            ),
            array(
                'db' => $table.'.id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                     {$this->off_on_device($id)}
                <div style='text-align: center'>
                  <input {$this->ch_type_device($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => $table.'.id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_type_device/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => $table.'.id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array(
                'db' => $table.'.userid',
                'dt' => 6,
                'formatter' => function ($id, $row) {

                    return $this->UserInfo($id);
                }
            ),
            array('db' =>$table.'.id', 'dt' => 7),
            array('db' =>$table.'.active', 'dt' => 8)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


                    $join = "LEFT JOIN menu_link_device_acc_cover ON menu_link_device_acc_cover.id=type_device.id_device_mobile";
                    $whereAll = array("");
                echo json_encode(

                SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null));

    }




    public function visible_savers($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category, array('active' => $v), "`id`={$id}");
    }

    public function visible_savers_name_device($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }

        $data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
    }

    public function visible_savers_type_device($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }

        $data = $this->db->update($this->type_device, array('active' => $v), "`id`={$id}");
    }


    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->category} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function ch_name_device($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function ch_type_device($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->type_device} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function off_on_device($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->type_device} WHERE `id` = ? AND `active` = 1   AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'ON';
        } else {
            return 'OFF';
        }
    }


    function remove_row_database($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->table);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->table,'title'),'',$oldData,'');

            // $c= $this->db->prepare("DELETE FROM `$this->table`  WHERE  `id`=?");
            // $c->execute(array($id));

//            $c= $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id_device`=?");
//            $c->execute(array($id));
            echo true;
        }
    }

    function remove_sub_row_database($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->type_device);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->type_device,'title'),'',$oldData,'');

            // $c= $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id`=?");
            // $c->execute(array($id));
            echo true;
        }
    }

    function delete_savers($id)
    {
        if ($this->handleLogin() ) {

            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->category);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->category,'title'),'',$oldData,'');


            // $response = $this->db->delete($this->category, "`id`={$id}");
  			 $this->update_is_delete($this->category, 'id = '.$id.'');
        	 $stmt_name_device =$this->db->prepare("SELECT id FROM name_device where id_cat = $id AND is_delete = 0");
                $stmt_name_device->execute();
                if($stmt_name_device->rowCount()>0)
                {
                    while($row_name = $stmt_name_device->fetch())
                    {
                    	$this->update_is_delete($this->table, 'id = '.$row_name['id'].'');
                    	$this->update_is_delete('type_device', 'id_device = '.$row_name['id'].'');
                     	 $stmt_type_device =$this->db->prepare("SELECT id FROM type_device where id_device = ".$row_name['id']."");
                		 $stmt_type_device->execute();
                		if($stmt_type_device->rowCount()>0)
                		{
                    		while($row_type = $stmt_type_device->fetch())
                    		{
                        		// $result_update_type_device = $this->delete_savers_type_device($row_type['id']);
                                $this->update_is_delete('product_savers', 'id_device = '.$row_type['id'].' AND is_delete = 0');

        	        		}
                		}

                    // $this->update_is_delete('product_savers', 'id = '.$row_savers['id'].'');
                        // $result_update_name_device = $this->delete_savers_name_device($row_name['id']);

        	        }
                }

        		  $this->Add_to_sync_schedule($id,$this->category,'delete_category_savers');

//            $c_id = $this->db->prepare("SELECT `id` FROM `$this->table`  WHERE  `id_cat`=? limit 1");
//            $c_id->execute(array($id));
//            $c_id_c = $c_id->fetch(PDO::FETCH_ASSOC)['id'];
//
//            $c = $this->db->prepare("DELETE FROM `$this->table`  WHERE  `id_cat`=?");
//            $c->execute(array($id));
//
//            $cd = $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id_device`=?");
//            $cd->execute(array($c_id_c));
        }
    }



    function delete_savers_name_device($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->table, "`id`={$id}");



            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->table);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->table,'title'),'',$oldData,'');

            // $c = $this->db->prepare("DELETE FROM `$this->table`  WHERE  `id`=?");
            // $c->execute(array($id));


        	$this->update_is_delete($this->table, 'id = '.$id.'');
          	$stmt_type_device =$this->db->prepare("SELECT id FROM type_device where id_device = $id ");
            $stmt_type_device->execute();
                if($stmt_type_device->rowCount()>0)
                {
                    while($row_type = $stmt_type_device->fetch())
                    {
                        $this->update_is_delete('type_device', 'id = '.$row_type['id'].'');
                    	$stmt_savers=$this->db->prepare("SELECT id FROM `product_savers` where id_device = ".$row_type['id']." ");
                		$stmt_savers->execute();
                		if($stmt_savers->rowCount()>0)
                		{
                    		while($row_savers = $stmt_savers->fetch())
                    		{
                    			$this->update_is_delete('product_savers', 'id = '.$row_savers['id'].'');

        	        		}
                		}


        	        }
                }
            $this->Add_to_sync_schedule($id,'name_device','delete_name_device');

//            $cd = $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id_device`=?");
//            $cd->execute(array($response['id']));
        }
    }



    function delete_savers_connect($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->product_savers_connect, "`id`={$id}");
        }
    }


    function delete_savers_type_device($id)
    {
        if ($this->handleLogin() ) {



            $trace=new trace_site();
            $oldData=$trace->trace_category($id,$this->type_device);
            $trace->add($id,'category_'.$this->folder,'delete',$trace->inforow($id,$this->type_device,'title'),'',$oldData,'');

            // $cd = $this->db->prepare("DELETE FROM `$this->type_device`  WHERE  `id`=?");
            // $cd->execute(array($id));


        	 $this->update_is_delete('type_device', 'id = '.$id.'');
        	 $stmt_savers=$this->db->prepare("SELECT id FROM `product_savers` where id_device = $id AND is_delete = 0 ");
             $stmt_savers->execute();
                if($stmt_savers->rowCount()>0)
                {
                    while($row_savers = $stmt_savers->fetch())
                    {
                        // $this->delete_savers_product_savers($row_savers['id']);
                    	$this->update_is_delete('product_savers', 'id = '.$row_savers['id'].' AND is_delete = 0');

        	        }
                }

        		$this->Add_to_sync_schedule($id,'type_device','delete_type_device');

        }
    }




    function connect($id=null)
    {
        $this->checkPermit('connect_between_cover_and_excel', 'savers');
        $this->adminHeaderController($this->langControl('connect_between_cover_and_excel'));

        $stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete}");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }


        require($this->render($this->folder, 'html', 'connect', 'php'));
        $this->adminFooterController();

    }


    function excel($id=null)
    {
        $this->checkPermit('connect_between_cover_and_excel', 'savers');
        $this->adminHeaderController($this->langControl('connect_between_cover_and_excel'));

        $stmt = $this->db->prepare("SELECT * from `{$this->category}`   ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }


        require($this->render($this->folder, 'html', 'excel', 'php'));
        $this->adminFooterController();

    }


      function  excel_ajax()
        {

             $lastId=0;
            if(isset($_POST["submit"])) {


                try {
                    $form = new  Form();


                    $form->post('files_normal')
                        ->val('is_empty', 'مطلوب')
                        ->val('strip_tags');


                    $form->submit();
                    $data = $form->fetch();
                    $name_file=json_decode($data['files_normal'],true);

                       $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];

                    if (file_exists($inputFileName)) {

                        //  Read your Excel workbook
                        try {
                            $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($inputFileName);
                        } catch (Exception $e) {
                            die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                        }

                        //  Get worksheet dimensions
                        $sheet = $objPHPExcel->getSheet(0);
                        $highestRow = $sheet->getHighestRow();
                        $highestColumn = $sheet->getHighestColumn();



						$x=array();
                        for ($row = 1; $row <= $highestRow; $row++) {
							//  Read a row of data into an array
							$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
								NULL,
								TRUE,
								TRUE);


							 if (count($rowData[0]) >= 7) {
								if (count($rowData[0]) == 7) {
									$rowData[0][7] = '';
								}


								 $stmtUp1 = $this->db->prepare("UPDATE `color_savers` SET `color`=?,symbol=? where color = ?");
								 $stmtUp1->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][1]));

								 $stmtUp2 = $this->db->prepare("UPDATE `product_savers` SET `color`=?,symbol=?,`code`=?,`title`=?,latiniin=?,`content`=?  where color = ? AND code =?");
								 $stmtUp2->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][2], $rowData[0][3], $rowData[0][6], $rowData[0][7], $rowData[0][1], $rowData[0][0]));


/*
								 $stmt = $this->db->prepare("SELECT *FROM `color_savers` where color = ?");
								$stmt->execute(array($rowData[0][1]));
								if ($stmt->rowCount() > 0) {

									$stmtUp1 = $this->db->prepare("UPDATE `color_savers` SET `color`=?,symbol=? where color = ?");
									$stmtUp1->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][1]));

								} else {

									$stmtIn1 = $this->db->prepare("INSERT  INTO `color_savers` (`color`,`symbol`) VALUES (?,?) ");
									$stmtIn1->execute(array($rowData[0][4], $rowData[0][5]));
								}


								$stmt2 = $this->db->prepare("SELECT *FROM `product_savers` where color = ? AND code =? ");
								$stmt2->execute(array($rowData[0][1], $rowData[0][0]));
								if ($stmt2->rowCount() > 0) {

									$stmtUp2 = $this->db->prepare("UPDATE `product_savers` SET `color`=?,symbol=?,`code`=?,`title`=?,latiniin=?,`content`=?  where color = ? AND code =?");
									$stmtUp2->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][2], $rowData[0][3], $rowData[0][6], $rowData[0][7], $rowData[0][1], $rowData[0][0]));

								} else {

									$stmtIn2 = $this->db->prepare("INSERT  INTO `product_savers` (`color`,symbol,`code`,`title`,latiniin,`content` ) VALUES (?,?,?,?,?,?) ");
									$stmtIn2->execute(array($rowData[0][4], $rowData[0][5], $rowData[0][2], $rowData[0][3], $rowData[0][6], $rowData[0][7]));
								}

*/
							 }else
						       {
							  echo 'a';
					    	}
						}
                        @unlink($inputFileName);
                        echo '1';

                    }else
                    {

                       echo 'b';
                    }


                } catch (Exception $e) {
                    $data =$form -> fetch();
                    $this->error_form=$e -> getMessage();

                }


            }



        }



    function getNmaDevice($id)
    {
        if ($this->handleLogin() ) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id_cat`= ?  AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $nameDevice = array();
            $c=0;
            $html='';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if ($c==0)
                {
                    $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
                }else
                {
                    $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
                }

                $c++;
            }
            echo $html ;

        }
    }


    function typeDevice($id)
    {
        if ($this->handleLogin() ) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->type_device}` WHERE `id_device`= ?  AND {$this->is_delete} ");
            $stmt->execute(array($id));

            $c=0;
            $html='';
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                if ($c==0)
                {
                    $html.="<option value='{$row['id']}'  selected >{$row['title']}</option>"  ;
                }else
                {
                    $html.="<option value='{$row['id']}'   >{$row['title']}</option>"  ;
                }

                $c++;
            }
            echo $html ;

        }
    }

    function getColor($id)
    {
        if ($this->handleLogin() ) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->color_savers}` WHERE `type_device`= ?  ");
            $stmt->execute(array($id));

            $html="";
            $c=0;
            if ($stmt->rowCount() > 0)
            {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                    if ($c==0)
                    {
                        $html.="
                            <div class='row'>
                            <div class='col-3'>
                              <input type='color' name='color_code[{$row['id']}]' value='{$row['color_code']}' class='form-control colorBox' >
                            </div>
                            <div class='col'>
                              <input type='text' name='color[{$row['id']}]' value='{$row['color']}' class='form-control colorBox'  placeholder='لون المادة في كرستال'>
                            </div>
                            </div>

                         "  ;

                    }else
                    {
                        $html.="
                        <div class='row'>
                        <div class='col-2'>
                          <input type='color' name='color_code[{$row['id']}]' value='{$row['color_code']}' class='form-control colorBox' >

                        </div>
                        <div class='col'>
                            <div class='input-group colorBox delete_db_color{$row['id']}'>

                          <input  type='text' name='color[{$row['id']}]' value='{$row['color']}'  class='form-control'  placeholder='لون المادة في كرستال' required>

                           <div class='input-group-prepend'>
                            <div class='input-group-text delete_row'>  <button onclick='delete_db_color({$row['id']})' class='btn btn-danger' type='button'> <i class='fa fa-trash'></i> </button>  </div>
                        </div>
                        </div>

                        </div>
                        </div>

                    "  ;
                    }
                    $c++;
                }

            }else{
                $html.="
                            <div class='row'>
                            <div class='col-3'>
                             <input  type='color' name='color_code[new]'   class='form-control colorBox'  required>
                            </div>
                            <div class='col'>
                              <input  type='text' name='color[new]'   class='form-control colorBox'  placeholder='لون المادة في كرستال' required>
                            </div>
                            </div>

                         "  ;


            }


            echo $html ;

        }
    }



    function show_color_add_edit_product($id)
    {
        if ($this->handleLogin()) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT * from `{$this->color_savers}` WHERE `type_device`= ?  ");
            $stmt->execute(array($id));

            $html = "";
            $c = 0;
            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $html.='<div class="col-auto"><div class="colorProduct" style="background-color:'.$row['color_code'].' "></div> </div>';
                }

                echo $html;
            }  else{
                echo '<span style="color: red">المنتج لا يحتوى على الالوان في كرستال</span>';
            }
        }


    }



    function color()
    {
        $this->checkPermit('add_color', 'savers');
        if (isset($_POST['submit']))
        {

            $typeDevice=strip_tags(trim($_POST['typeDevice']));
            $color=$_POST['color'];
            $color_code=$_POST['color_code'];
            foreach ($color as $key => $c) {
                $stmt_d = $this->db->prepare("INSERT INTO `{$this->color_savers}` (`id`,`color`,`color_code`,`type_device`) VALUE (?,?,?,?)   ON DUPLICATE KEY UPDATE `id`=VALUES(id),`color`=VALUES(color),`color_code`=VALUES(color_code),`type_device`=VALUES(type_device) ");
                $stmt_d->execute(array($key,$c,$color_code[$key], $typeDevice));
            }
            echo 'true';

        }else
        {
            echo 'false';
        }

    }


    function delete_db_color($id)
    {
        if ($this->handleLogin() ) {

            $c= $this->db->prepare("DELETE FROM `$this->color_savers`  WHERE  `id`=?");
            $c->execute(array($id));
            echo true;
        }
    }






    function car_item($id,$count)
    {


        $error=array();

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            if (!is_numeric($count)) {$error=new Errors(); $error->index();}





            $stmt_product= $this->db->prepare("SELECT  *FROM `$this->product_savers`  WHERE  `id`=?  AND {$this->is_delete}");
            $stmt_product->execute(array($id));
            $result_product=$stmt_product->fetch(PDO::FETCH_ASSOC);



         $data['id_item']=$id;
        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }
            $data['number']=$count;
            $data['date']=time();



            if (empty($error))
            {
                $number=preg_replace('~\D~', '', $data['number']);
                $stmt_ch= $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `code`=?   AND `quantity` >= {$number}  AND `quantity` <> 0  AND `quantity` <> '' ");
                $stmt_ch->execute(array($result_product['code']));


                if ($stmt_ch->rowCount() > 0) {


                    $result = $stmt_ch->fetch(PDO::FETCH_ASSOC);

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop` WHERE `code` =?    AND `table`=? AND  `id_member_r` = ? AND  `buy` = 0 AND `status` = 0     ");
                    $stmt_order->execute(array($result['code'], $this->product_savers,$data['id_member_r']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);

                    $q= $result['quantity']  - $only_order['num'];

                    if ($q >= $number) {



                        $data['code'] = $result_product['code'];
                        $data['image'] = $result_product['img'];
                        $data['name_color'] = $result_product['color'];

                        if ($result_product['cuts']== 1)
                        {
                            $data['price'] = $result_product['price_cuts'];
                        }else
                        {
                            if ($this->loginUser()) {

                                $data['price'] = $this->price_dollarsAdmin($result['price_dollars']);

                            } else {
                                $data['price'] = $this->price_dollars($result['price_dollars']);
                            }

                        }

						$dollar=new Dollar_price();
						$data['dollar_exchange']=$dollar->dollar_get();
                        $data['price_dollars'] = $result['price_dollars'];
                        $data['table'] = $this->product_savers;


						$stmt_chx = $this->db->prepare("SELECT   *FROM `cart_shop` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND  price_type=0 ");
						$stmt_chx->execute(array($data['id_item'],$data['code'], $this->product_savers, $data['id_member_r']));
						if ($stmt_chx->rowCount() > 0)
						{
							$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop` SET `number`=number+? WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND  price_type=0");
							$stmtUpdate_cart->execute(array($data['number'],$data['id_item'],$data['code'], $this->product_savers, $data['id_member_r']));
						}else{
							$this->db->insert($this->cart_shop, $data);
						}


                     }else
                    {
                        echo json_encode(array(3=> "الكمية غير متوفرة الان تتوفر قريبا ." ),1);
                    }

                }else
                {

                    echo json_encode(array(3=> "الكمية غير متوفرة الان تتوفر قريبا  ." ),1);
                }
            }
            else
            {
                echo json_encode(array(1=>$error),1);
            }



    }




    function cart_order($id,$count=1)
    {


        $error=array();

            if (!is_numeric($id)) {$error=new Errors(); $error->index();}
            if (!is_numeric($count)) {$error=new Errors(); $error->index();}



            $stmt_product= $this->db->prepare("SELECT  *FROM `$this->product_savers`  WHERE  `id`=?  AND {$this->is_delete}");
            $stmt_product->execute(array($id));
            $result_product=$stmt_product->fetch(PDO::FETCH_ASSOC);



         $data['id_item']=$id;
        if(!$this->isDirect())
        {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        }else{
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }


        if (isset($_GET['number']))
        {
            if (is_numeric($_GET['number']))
            {
                $data['number'] =strip_tags($_GET['number']);
            }else
            {
                $data['number'] = $count;
            }
        }else
        {
            $data['number'] =$count;
        }


        if (isset($_GET['price_type']))
        {
            if (is_numeric($_GET['price_type']))
            {
                $data['price_type'] =$_GET['price_type'];
            }else
            {
                $data['price_type']=0;
            }

        }else
        {
            $data['price_type']=0;
        }



        $data['date']=time();



            if (empty($error))
            {
                $number=preg_replace('~\D~', '', $data['number']);
                $stmt_ch= $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `code`=?   AND `quantity` >= {$number}  AND `quantity` <> 0  AND `quantity` <> '' ");
                $stmt_ch->execute(array($result_product['code']));


                if ($stmt_ch->rowCount() > 0) {


                    $result = $stmt_ch->fetch(PDO::FETCH_ASSOC);

                    $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num ,`dollar_exchange` FROM `cart_shop` WHERE `code` =?    AND `table`=? AND  `id_member_r` = ? AND  `buy` = 0 AND `status` = 0     ");
                    $stmt_order->execute(array($result['code'], $this->product_savers,$data['id_member_r']));
                    $only_order=$stmt_order->fetch(PDO::FETCH_ASSOC);

                    $q= $result['quantity']  - $only_order['num'];

                    if ($q >= $number) {



                        $data['code'] = $result_product['code'];
                        $data['image'] = $result_product['img'];
                        $data['name_color'] = $result_product['color'];


                        if ($this->loginUser()) {

                            $data['price'] = $this->price_dollarsAdmin($result['price_dollars']);

                        } else {
                            $data['price'] = $this->price_dollars($result['price_dollars']);
                        }


                        $dollar=new Dollar_price();
						$data['dollar_exchange']=$dollar->dollar_get();


                        if ($this->ch_wcprice())
                        {

                            if ($data['price_type'] == 1) {
                                $data['price_dollars'] = $result['wholesale_price'];

                            } else if ($data['price_type'] == 2) {
                                $data['price_dollars'] = $result['wholesale_price2'];

                            } else if ($data['price_type'] == 3) {
                                $data['price_dollars'] = $result['cost_price'];
                            } else {
                                $data['price_dollars'] = $result['price_dollars'];
                            }
                        }else
                        {
                            $data['price_dollars'] = $result['price_dollars'];
                        }


                        $data['table'] = $this->product_savers;

						$stmt_chx = $this->db->prepare("SELECT   *FROM `cart_shop` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?  AND  price_type=?   ");
						$stmt_chx->execute(array($data['id_item'],$data['code'], $this->product_savers, $data['id_member_r'], $data['price_type']));
						if ($stmt_chx->rowCount() > 0)
						{
							$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop` SET `number`=number+? WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?   AND  price_type=? ");
							$stmtUpdate_cart->execute(array($data['number'],$data['id_item'],$data['code'], $this->product_savers, $data['id_member_r'], $data['price_type']));
						}else{
							$this->db->insert($this->cart_shop, $data);
						}


                     }else
                    {
                        echo 'finish';
                    }

                }else
                {

                    echo 'finish';
                }
            }
            else
            {
                echo 'error';
            }



    }





    public function getAllContentFromCar_new($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `size`, `id_item`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date` FROM `{$this->cart_shop}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `id_item`,`table`,`price`,`name_color` ORDER BY `id`  DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }

    function count_c()
    {
        if ($this->isDirect())
        {
            $id=$this->isUuid();
        }else{
            $id= $_SESSION['id_member_r'];
        }

        $stmt=$this->getAllContentFromCar_new($id);
            $car=array();
            $count=0;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $count=$count+$row['number'];
            }

            echo $count;

    }



    function device()
    {
        if (isset($_POST['submit'])) {

            $nameDid = strip_tags(trim($_POST['nameDevice_public']));
            $color = strip_tags(trim($_POST['colorDevice_public']));

            $result=array();
            $stmt = $this->db->prepare("SELECT * from `{$this->table}` WHERE `id` = ?  AND {$this->is_delete}  LIMIT 1");
            $stmt->execute(array($nameDid));

            while ($row =  $stmt->fetch(PDO::FETCH_ASSOC)) {


                $stmt_img_id = $this->getImage($row['id'], 1);


                $row['color'] = $color;

                $excel = $this->excel_det($row['color'], $row['code'], 1);


                if ($excel['quantity'] > 0) {
                    if (isset($_COOKIE['currency'])) {
                        if ($_COOKIE['currency'] == 0) {
                            $row['priceC'] = $excel['price'];
                            $row['price'] = $excel['price'] . ' د.ع ';
                        } else {
                            $row['priceC'] = $excel['price_dollars'];
                            $row['price'] = $excel['price_dollars'] . '$ ';
                        }

                    } else {
                        $row['priceC'] = $excel['price'];
                        $row['price'] = $excel['price'] . ' د.ع ';
                    }

                    $row['code_color'] = $row['color'];

                    $row['image'] = $this->save_file . $stmt_img_id['img'];
                    $row['nameImage'] = $stmt_img_id['img'];
                    $row['like'] = $this->ckeckLick($row['id']);
                    $result[]=$row;

                    require($this->render($this->folder, 'html', 'filter', 'php'));

                }else
                {
                    echo 'notFound';
                }

            }


        }else
        {
            echo 'notSelect';
        }

    }





    public function list_product_savers()
    {

        $this->checkPermit('product_savers', 'savers');
        $this->adminHeaderController($this->langControl('product_savers'));

        require($this->render($this->folder, 'product', 'list', 'php'));
        $this->adminFooterController();

    }











    public function processing_product_savers()
    {


        $table = $this->product_savers;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),
            array('db' => 'code', 'dt' => 1),
            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                    return "
                <div style='text-align: center'>
                  <input {$this->ch_product_savers($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_product_savers/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                    return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 6)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }





    function delete_image($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->update($this->product_savers,array('img'=>0),"`id`={$id}");
            echo 'true';
        }
    }



    function remove_row_database_color_image($id)
    {
        if ($this->handleLogin() ) {
            $c= $this->db->prepare("DELETE FROM `$this->product_savers`  WHERE  `id`=?");
            $c->execute(array($id));

            echo true;
        }
    }

    /*
        function c()
        {


    //  Include PHPExcel_IOFactory
            include 'PHPExcel/Classes/PHPExcel.php';

            $inputFileName = $this->root_file . '/files/' .'1c3902a8dbed0355df220915b798b385_.xlsx';

            //  Read your Excel workbook
            try {
                $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                $objPHPExcel = $objReader->load($inputFileName);
            } catch (Exception $e) {
                die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
            }

            //  Get worksheet dimensions
            $sheet = $objPHPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();


            //  Loop through each row of the worksheet in turn

            for ($row = 1; $row <= $highestRow; $row++) {
                //  Read a row of data into an array
                $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                    NULL,
                    TRUE,
                    FALSE);

    //            if (count($rowData[0]) == 2) {
    //
                    $stmt = $this->db->prepare("INSERT INTO product_savers (`color`,`code`,`date`) VALUES(?,?,?)");
    //                  $stmt->execute(array(trim(str_replace('"','',$rowData[0][1])),trim(str_replace('"','',$rowData[0][0])),time() ));
    //echo $row.'<br>';
    //            }

            }


        }


        function c2()
        {
            $stmt = $this->db->prepare("SELECT `code` FROM `product_savers` GROUP BY `code`");
            $stmt->execute();
            $c=1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $stmt2 = $this->db->prepare("INSERT INTO   product_savers (`code`,`date`) VALUES(?,?)");
                $stmt2->execute(array($row['code'],time()+1));
               if ($stmt2->rowCount() > 0)
               {
                   echo $c++ .'<br>';
               }

            }


        }



        function c3()
        {
            $stmt = $this->db->prepare("SELECT `id`,`code` FROM `product_savers`  ");
            $stmt->execute();
            $c=1;
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
            {
                $stmt2 = $this->db->prepare("UPDATE   product_savers SET  `id_product`=? WHERE  `code`=?");
                $stmt2->execute(array($row['id'],$row['code']));
                if ($stmt2->rowCount() > 0)
                {
                    echo $c++ .'<br>';
                }

            }

        }



    */





	function checkColor($color)
	{
		$stmt=$this->db->prepare("SELECT *FROM `color_savers` WHERE `color`=?");
		$stmt->execute(array($color));
		if ($stmt->rowCount() > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}

	function checkColor_idProd($color,$id)
	{
		$stmt=$this->db->prepare("SELECT *FROM `product_savers` WHERE `color`=? AND `id_product`=?  AND {$this->is_delete}");
		$stmt->execute(array($color,$id));
		if ($stmt->rowCount() > 0)
		{
			return true;
		}else
		{
			return false;
		}
	}


	function open_savers($id=null,$type='all')
	{
		$this->checkPermit('open_savers', $this->folder);

		$this->adminHeaderController($this->langControl('open_savers'));


		$stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete}  ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}





		require($this->render($this->folder, 'html', 'open_savers', 'php'));
		$this->adminFooterController();




	}





	function add_product_savers($id=null,$all=null)
	{
        $this->checkPermit('add_product_savers',$this->folder);


		$stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete}");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


		$stmtcover_material = $this->db->prepare("SELECT * from `cover_material`   ");
		$stmtcover_material->execute(array());
        $cover_material=array();
		while ($row = $stmtcover_material->fetch(PDO::FETCH_ASSOC))
		{
			$cover_material[]=$row;
		}

        $stmttype_cover = $this->db->prepare("SELECT * from `type_cover`   ");
        $stmttype_cover->execute(array());
        $type_cover=array();
        while ($row = $stmttype_cover->fetch(PDO::FETCH_ASSOC))
        {
            $type_cover[]=$row;
        }


		$stmtfeature_cover = $this->db->prepare("SELECT * from `feature_cover`   ");
		$stmtfeature_cover->execute(array());
        $feature_cover=array();
		while ($row = $stmtfeature_cover->fetch(PDO::FETCH_ASSOC))
		{
			$feature_cover[]=$row;
		}


		$this->adminHeaderController($this->langControl('add'));



		if (isset($_POST['submit']))
		{

			try{
				$form =new Form();

				$form  ->post('devise')
					->val('is_empty','مطلوب')
					->val('strip_tags');


				$form  ->post('content')
					->val('strip_tags',TAG);

				$form  ->post('tags')
					->val('strip_tags',TAG);

				$form  ->post('title')
					->val('is_array')
					->val('strip_tags');


				$form  ->post('code')
					->val('is_array')
					->val('strip_tags');
				$form  ->post('point')
					->val('is_array')
					->val('strip_tags');

				$form  ->post('latiniin')
					->val('is_array')
					->val('strip_tags');


				$form  ->post('serial_flag')
					->val('is_array')
					->val('strip_tags');





				$form  ->post('enter_serial')
					->val('is_array')
					->val('strip_tags');

				$form  ->post('change_price')
					->val('is_array')
					->val('strip_tags');

				$form->post('serial')
					->val('is_array')
					->val('strip_tags');

				$form->post('tags')
					->val('is_array')
					->val('strip_tags');

				$form->post('locationTag')
					->val('is_array')
					->val('strip_tags');


				$form->post('cover_material')
					->val('is_array')
					->val('strip_tags');


				$form->post('type_cover')
					->val('is_array')
					->val('strip_tags');



				$form->post('feature_cover')
					->val('is_array')
					->val('strip_tags');




				$form ->submit();
				$data =$form -> fetch();

				$file=new Files();

				$data['userId']=$this->userid;

				$title=json_decode($data['title'],true);
				$code=json_decode($data['code'],true);
				$point=json_decode($data['point'],true);
				$latiniin=json_decode($data['latiniin'],true);
				$serial_flag=json_decode($data['serial_flag'],true);
				$locationTag=json_decode($data['locationTag'],true);
				$enter_serial=json_decode($data['enter_serial'],true);
				$change_price=json_decode($data['change_price'],true);
				$serial=json_decode($data['serial'],true);
				$tags=json_decode($data['tags'],true);
				$cover_material=json_decode($data['cover_material'],true);
				$type_cover=json_decode($data['type_cover'],true);
				$feature_cover=json_decode($data['feature_cover'],true);


				$image=array();
				if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
					$image = $this->save_file($_FILES['image']);
				} else {
					$this->error_form['image'] = $this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png'));
				}

				foreach ($code as $key => $save_data)
				{

                    $cover_material_value='';
				    if (isset($cover_material[$key]))
                    {
                        $cover_material_value=$cover_material[$key];
                    }

                     $type_cover_value='';
				    if (isset($type_cover[$key]))
                    {
                        $type_cover_value=$type_cover[$key];
                    }

                    $featureCover='';
				    if (isset($feature_cover[$key]))
                    {
                        $featureCover=implode(',',$feature_cover[$key]);
                    }



                    $stmt_c=$this->db->prepare("INSERT INTO `product_savers` (`code`,`point`,`latiniin`,`img`,`title`,`content`,`id_device`,`userId`,`serial_flag`,`locationTag`,`enter_serial`,`change_price`,`serial`,`tags`,`date`,`cover_material`,`type_cover`,`feature_cover`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
					$stmt_c->execute(array($save_data,$point[$key],$latiniin[$key],$image[$key],$title[$key],$data['content'],$data['devise'],$data['userId'],$serial_flag[$key], $locationTag[$key], $enter_serial[$key], $change_price[$key],$serial[$key],$tags[$key], time(),$cover_material_value, $type_cover_value,$featureCover));
					$lastId=$this->db->lastInsertId();

					$trace=new trace_site();
					$newData=$trace->neaw($lastId,$this->folder);
					$trace->add($lastId,$this->folder,'add','',$data['title'],'',$newData);
                	$this->Add_to_sync_schedule($lastId,$this->folder,'add_savers');

				}

                if ($all){
                    $this->lightRedirect(url . "/savers/all_cover", 0);

                }else
                {
                    $this->lightRedirect(url . "/savers/open_savers/{$data['devise']}", 0);

                }

			}

			catch (Exception $e)
			{
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();
			}

		}



		require ($this->render($this->folder,'product','add','php'));
		$this->adminFooterController();

	}





	function edit_product_savers($id,$all=null)
	{


		if (!is_numeric($id)) { $error = new Errors(); $error->index();}
		$this->checkPermit('save_edit',$this->folder);


		$stmt = $this->db->prepare("SELECT * from `{$this->product_savers}` WHERE `id`= ?  AND {$this->is_delete}  LIMIT 1 ");
		$stmt->execute(array($id));
		$result=$stmt->fetch(PDO::FETCH_ASSOC);


        $stmt = $this->db->prepare("SELECT * from `{$this->category}` WHERE `active` = 1  AND {$this->is_delete} ");
        $stmt->execute(array());
        $category=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $category[]=$row;
        }

		$this->adminHeaderController($result['title']);




        $stmtcover_material = $this->db->prepare("SELECT * from `cover_material`   ");
        $stmtcover_material->execute(array());
        $cover_material=array();
        while ($row = $stmtcover_material->fetch(PDO::FETCH_ASSOC))
        {
            $cover_material[]=$row;
        }

        $stmttype_cover = $this->db->prepare("SELECT * from `type_cover`   ");
        $stmttype_cover->execute(array());
        $type_cover=array();
        while ($row = $stmttype_cover->fetch(PDO::FETCH_ASSOC))
        {
            $type_cover[]=$row;
        }


        $stmtfeature_cover = $this->db->prepare("SELECT * from `feature_cover`   ");
        $stmtfeature_cover->execute(array());
        $feature_cover=array();
        while ($row = $stmtfeature_cover->fetch(PDO::FETCH_ASSOC))
        {
            $feature_cover[]=$row;
        }






        if (isset($_POST['submit']))
		{


			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);


			try
			{
				$form =new Form();

                $form  ->post('id_device')
                    ->val('strip_tags',TAG);

				$form  ->post('content')
					->val('strip_tags',TAG);

				$form  ->post('title')
					->val('is_array')
					->val('strip_tags');


				$form  ->post('code')
					->val('is_empty','مطلوب')
					->val('strip_tags');



				$form  ->post('point')

					->val('strip_tags');



				$form  ->post('latiniin')
					->val('is_empty','مطلوب')
					->val('strip_tags');

				$form  ->post('serial_flag')
					->val('strip_tags');

				$form  ->post('change_price')
					->val('strip_tags');


				$form  ->post('locationTag')
					->val('strip_tags');


				$form  ->post('enter_serial')
					->val('strip_tags');

				$form->post('serial')
					->val('strip_tags');

				$form->post('tags')
					->val('strip_tags');

                $form->post('cover_material')
                    ->val('strip_tags');

                $form->post('type_cover')
                    ->val('strip_tags');


                $form->post('feature_cover')
                    ->val('is_array')
                    ->val('strip_tags');






                $form ->submit();
				$data =$form -> fetch();

				$image=array();
				if ($_FILES['image']['error'][0]==0)
				{
					if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
						$image = $this->save_file($_FILES['image']);
						$data['img']=$image[0];
					}
				}else{
					$data['img']=$result['img'];
				}
                $feature_cover=implode(',',json_decode($data['feature_cover'],true));

				$stmt=$this->db->prepare("UPDATE `product_savers` SET `title`=?,`content`=?,`code`=?,`point`=?,`img`=?,`latiniin`=?,`serial_flag`=?,`locationTag`=?,`enter_serial`=?,`serial`=?,`tags`=?,`change_price`=?,`userId`=? ,id_device=?,cover_material=?,type_cover=?,feature_cover=? WHERE `id`=?");
				$stmt->execute(array($data['title'],$data['content'],$data['code'],$data['point'],$data['img'],$data['latiniin'],$data['serial_flag'],$data['locationTag'],$data['enter_serial'],$data['serial'],$data['tags'],$data['change_price'],$this->userid,$data['id_device'],$data['cover_material'],$data['type_cover'],$feature_cover,$id));


				$trace=new trace_site();
				$newData=$trace->neaw($id,$this->folder);
				$trace->add($id,$this->folder,'edit',$result['title'],$data['title'],$oldData,$newData);
				$this->Add_to_sync_schedule($id,$this->folder,'add_savers');

				if ($all){
                    $this->lightRedirect(url . "/savers/all_cover", 0);

                }else
                {
                    $this->lightRedirect(url . "/savers/open_savers/{$data['id_device']}", 0);

                }

			}
			catch (Exception $e)
			{
				$this->error_form= $e -> getMessage();
			}
		}
		require ($this->render($this->folder,'product','edit','php'));
		$this->adminFooterController();
	}



	public function processing_open_savers($id=null,$type='all')
	{


		$table = $this->product_savers;
		$primaryKey = 'product_savers.id';

		$columns = array(


			array('db' => 'product_savers.title', 'dt' => 0),
			array('db' => 'product_savers.code', 'dt' => 1),
			array('db' => 'excel_savers.quantity', 'dt' => 2),
			array('db' => 'product_savers.latiniin', 'dt' => 3),
			array('db' => 'product_savers.group_name', 'dt' => 4),
			array('db' => 'type_device.title', 'dt' => 5),
			array('db' => 'product_savers.date', 'dt' => 6,
				'formatter' => function ($d, $row) {
					return date('Y-m-d h:s:i a', $d);
				}

			),
			array('db' => 'product_savers.img', 'dt' => 7,
				'formatter' => function ($d, $row) {
					if ($d)
					{
						return "<img width=150 src='".$this->save_file.$d."' >";
					}else{
						return 'لاتوجد صورة';
					}

				}

			),
			array(
				'db' => 'product_savers.id',
				'dt' =>8 ,
				'formatter' => function ($id, $row) {
					if ($this->permit('visible',$this->folder)) {
						return "
                <div style='text-align: center'>
                  <input {$this->ch_product_savers($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
					else
					{
						return $this->langControl('forbidden');
					}
				}
			),

			array(
				'db' => 'product_savers.id',
				'dt' => 9,
				'formatter' => function ($id, $row) {
					return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_product_savers/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
				}
			),
			array(
				'db' => 'product_savers.id',
				'dt' => 10,
				'formatter' => function ($id, $row) {
					if ($this->permit('delete',$this->folder)) {
						return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
					else
					{
						return $this->langControl('forbidden');
					}
				}
			),
			array('db' => 'product_savers.id', 'dt' => 11)


		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);


        $join = "INNER JOIN type_device ON type_device.id =product_savers.id_device  LEFT JOIN excel_savers ON product_savers.code = excel_savers.code ";

        if ($type=='all')
        {

            $whereAll=array("product_savers.id_device='{$id}' "," product_savers.id_device <> 0 and product_savers.is_delete = 0");
//            echo json_encode(
//            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
//                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns,"id_device='{$id}' AND id_device <> 0")
//
//            );
        }else
        {
             $type="'%{$type}%'";
            $whereAll=array("product_savers.id_device='{$id}' "," product_savers.id_device <> 0"," latiniin LIKE  {$type} ");

//            echo json_encode(
//            // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
//                SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns, "id_device='{$id}' AND id_device <> 0 AND ( latiniin LIKE '%fm%' OR latiniin LIKE  {$type} ) ")
//            );

        }

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null,1));

    }


	public function ch_product_savers($id)
	{


		$stmt = $this->db->prepare("SELECT * FROM {$this->product_savers} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete} ");
		$stmt->execute(array($id));
		if ($stmt->rowCount() > 0) {
			return 'checked';
		} else {
			return '';
		}
	}


	function delete_savers_product_savers($id)
	{
		if ($this->handleLogin() ) {



			$stmt=$this->db->prepare("SELECT  *FROM `product_savers` WHERE `id`  = ?   " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

        	$code = strval($result['code']);
        	$this->Add_to_sync_schedule($id,'product_savers','delete_savers', $code);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$trace->add($id,$this->folder,'delete',$result['title'],$result['title'],$oldData,'');

			$this->update_is_delete('product_savers', 'id = '.$id.'');


			// $cd = $this->db->prepare("DELETE FROM `$this->product_savers`  WHERE  `id`=?");
			// $cd->execute(array($id));




		}
	}



	public function visible_savers_product_savers($v_, $id_)
	{
		if ($this->handleLogin()) {
			if (is_numeric($v_) && is_numeric($id_)) {
				$v = $v_;
				$id = $id_;
			} else {
				$v = 0;
				$id = 0;
			}

			$stmt=$this->db->prepare("SELECT  *FROM `product_savers` WHERE `id`  = ?   AND {$this->is_delete}" );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$data = $this->db->update($this->product_savers, array('active' => $v), "`id`={$id}");

			$newData=$trace->neaw($id,$this->folder);
			$trace->add($id,$this->folder,'active',$result['title'],$result['title'],$oldData,$newData);


		}

	}



	function quantity()
	{

		$this->checkPermit('export_excel', $this->folder);
		$this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));


        $category = $this->db->select("SELECT * from `{$this->category}`  WHERE {$this->is_delete}");

        $cat='all';
        $name_device='';
        $device='';
        $from_price=null;
        $to_price=null;

        if (isset($_GET['cat']))
        {
            $cat=$_GET['cat'];
        }

        if (isset($_GET['name_device']))
        {
            $name_device=$_GET['name_device'];
        }

        if (isset($_GET['device']))
        {
            $device=$_GET['device'];
        }

        if (isset($_GET['from_price']))
        {
            $from_price=$_GET['from_price'];
        }

        if (isset($_GET['to_price']))
        {
            $to_price=$_GET['to_price'];
        }






        require($this->render($this->folder, 'quantity', 'index', 'php'));
		$this->adminFooterController();
	}


	public function processing_quantity()
	{
		$this->checkPermit('view_quantity', $this->folder);
		$table = 'product_savers';
		$primaryKey = $table . '.id';
		$tableJoin = $table . '.';

		$columns = array(


			array('db' => 'name_device.title', 'dt' => 0),
			array('db' => 'type_device.title', 'dt' => 1),
			array('db' => 'product_savers.title', 'dt' =>2),
			array('db' => $tableJoin . 'code', 'dt' => 3),
			array('db' => 'excel_savers.quantity', 'dt' => 4),
			array('db' => 'excel_savers.price_dollars', 'dt' => 5),

            array('db' =>'product_savers.locationTag', 'dt' => 6,
                'formatter' => function( $d, $row ) {
                    if ($d == 1) {
                        $span = "<span class='location_active_{$row[9]}' style='color: green;font-weight: bold;display: block'>ON</span>";
                    } else {
                        $span = "<span class='location_active_{$row[9]}' style='color: red;font-weight: bold;display: block'>OFF</span>";

                    }
                    if ($this->permit('visible_location', $this->folder)) {
                        $span .= "
                            <div style='text-align: center'>
                              <input {$this->ch_location($row[9])} class='toggle-demo' onchange='visible_savers_location(this,$row[9])' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                             </div>
                         ";
                    }

                    return $span;
                }
            ),


            array('db' =>'product_savers.img', 'dt' =>7,
				'formatter' => function( $d, $row ) {
					return "<img  src='".$this->save_file.$d."' style='width: 50px;border: 1px solid gainsboro;'>";
				}
			),
            array('db' => 'excel_savers.date', 'dt' => 8,
                'formatter' => function( $d, $row ) {
                    return  date('Y-m-d h:i:s A') ;
                }),

            array('db' => 'product_savers.id', 'dt' => 9),

		);

// SQL server connection information
		$sql_details = array(
			'user' => DB_USER,
			'pass' => DB_PASS,
			'db' => DB_NAME,
			'host' => DB_HOST,
			'charset' => 'utf8'
		);

        if ( $_GET['cat']  =='all' && empty($_GET['name_device'])  && empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device    LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''");

        }else    if ( $_GET['cat']  =='all' && empty($_GET['name_device'])  && empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device    LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");

        }else  if ( is_numeric($_GET['cat'])   && empty($_GET['name_device'])  && empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}");

        }else   if ( is_numeric($_GET['cat'])   && empty($_GET['name_device'])  && empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");


        } else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}");
          }

         else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");
          }

         else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && !empty($_GET['device'])   && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","product_savers.id_device={$_GET['device']}");
          }

         else   if ( is_numeric($_GET['cat'])   && !empty($_GET['name_device'])  && !empty($_GET['device'])   && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {

            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device   INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''","category_savers.id={$_GET['cat']}","name_device.id={$_GET['name_device']}","product_savers.id_device={$_GET['device']}","excel_savers.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");
          }


        echo json_encode(

			SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null));

	}

    public function ch_location($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM `product_savers` WHERE `id` = ? AND `locationTag` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0)
        {
            return 'checked';
        }
        else
        {
            return '';
        }
    }



    public function visible_savers_location($v_,$id_)
    {

        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

            $stmt=$this->db->prepare("SELECT  *FROM `{$this->product_savers}` WHERE `id`  = ?    AND {$this->is_delete}" );
            $stmt->execute(array($id));
            $result=$stmt->fetch(PDO::FETCH_ASSOC);

            $trace=new trace_site();
            $oldData=$trace->old($id,$this->folder);

            $data = $this->db->update($this->product_savers, array('locationTag' => $v), "`id`={$id}");

            $newData=$trace->neaw($id,$this->folder);
            $trace->add($id,$this->product_savers,'active',$result['title'],$result['title'],$oldData,$newData);
            echo $v;
        }
    }





    function  unknown()
	{
		$this->checkPermit('unknown',$this->folder);
		$this->adminHeaderController($this->langControl('add'));

		$stmt = $this->db->prepare("SELECT * from `{$this->category}`  WHERE {$this->is_delete} ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


		if(isset($_POST["submit"])) {


			try {
				$form = new  Form();

				$form->post('cat')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');

				$form->post('files_normal')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');


				$form->submit();
				$data = $form->fetch();
				$name_file=json_decode($data['files_normal'],true);

				$inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
				if (file_exists($inputFileName)) {

					//  Read your Excel workbook
					try {
						$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($inputFileName);
					} catch (Exception $e) {
						die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
					}

					//  Get worksheet dimensions
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();




					//  Loop through each row of the worksheet in turn

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
							TRUE,
							TRUE);


						if (count($rowData[0])  >= 4  ) {



                            $point='';
                            if (isset($rowData[0][4]))
                            {
                                $point =$rowData[0][4];
                            }



                            $stmt = $this->db->prepare("SELECT * FROM  product_savers  WHERE `code`=?   AND {$this->is_delete}");
							$stmt->execute(array(trim($rowData[0][1])));
							if ($stmt->rowCount() <= 0) {

                                $stmt_in_m = $this->db->prepare("INSERT INTO product_savers  (`id_device`,`title`,`code`,`latiniin`,`group_name`,`img`,`active`,`date`,`userid`,`point`) VALUES(?,?,?,?,?,?,?,?,?,?)");
                                $stmt_in_m->execute(array($data['cat'], $rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3], 'alixcol' . $this->uuid(55) . '.png', 1, time() + 1,$this->userid,$point));

                                $idm=$this->db->lastInsertId('product_savers');

                                $trace=new trace_site();
                                $newData=$trace->neaw($idm,$this->folder);
                                $trace->add($idm,$this->folder,'رفع سريع','',$rowData[0][0],'',$newData);



                            }
						} else {
							$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
							break;
						}

					}

					@unlink($inputFileName);

				}else
				{

					$this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
				}

				if (empty($this->error_form))
				{
					$this->lightRedirect(url.'/'.$this->folder."/open_savers/".$data['cat']);

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','unknown','php'));
		$this->adminFooterController();
	}




	function  unknown2()
	{
		$this->checkPermit('unknown',$this->folder);
		$this->adminHeaderController($this->langControl('add'));

		$stmt = $this->db->prepare("SELECT * from `{$this->category}`   WHERE {$this->is_delete} ");
		$stmt->execute(array());
		$category=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$category[]=$row;
		}


		if(isset($_POST["submit"])) {


			try {
				$form = new  Form();


				$form->post('files_normal')
					->val('is_empty', 'مطلوب')
					->val('strip_tags');


				$form->submit();
				$data = $form->fetch();
				$name_file=json_decode($data['files_normal'],true);

				$inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
				if (file_exists($inputFileName)) {

					//  Read your Excel workbook
					try {
						$inputFileType = PHPExcel_IOFactory::identify($inputFileName);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						$objPHPExcel = $objReader->load($inputFileName);
					} catch (Exception $e) {
						die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
					}

					//  Get worksheet dimensions
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();




					//  Loop through each row of the worksheet in turn

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							FALSE,
							TRUE,
							TRUE);


						if (count($rowData[0])  >= 7  ) {




							$stmttd = $this->db->prepare('SELECT type_device.id FROM type_device INNER JOIN name_device ON name_device.id=type_device.id_device INNER JOIN category_savers ON category_savers.id =name_device.id_cat WHERE type_device.title = ? AND name_device.title=? AND category_savers.title =? LIMIT 1');
							$stmttd->execute(array($rowData[0][4],$rowData[0][5],$rowData[0][6]));
							if ($stmttd->rowCount() > 0) {

							    $result=$stmttd->fetch(PDO::FETCH_ASSOC);

                                $stmt = $this->db->prepare("SELECT * FROM  product_savers  WHERE `code`=? AND `id_device`=?  AND {$this->is_delete}");
                                $stmt->execute(array($rowData[0][0], $result['id']));
                                if ($stmt->rowCount() > 0) {
                                    continue;
                                }

                                $stmt_in_m = $this->db->prepare("INSERT INTO product_savers  (`id_device`,`code`,`title`,`color`,`latiniin`,`img`,`active`,`date`) VALUES(?,?,?,?,?,?,?,?)");
                                $stmt_in_m->execute(array( $result['id'], $rowData[0][0], $rowData[0][1], $rowData[0][2], $rowData[0][3], 'alixcol' . $this->uuid(55) . '.png', 1, time() + 1));

                            }

						} else {
							$this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
							break;
						}

					}

					@unlink($inputFileName);

				}else
				{

					$this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
				}

				if (empty($this->error_form))
				{
					$this->lightRedirect(url.'/'.$this->folder."/open_savers");

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','unknown2','php'));
		$this->adminFooterController();
	}




    public function list_saver_connect($id)
    {

        $this->checkPermit('list_saver_connect', 'savers');
        $this->adminHeaderController($this->langControl('list_saver_connect'));

        $stmt = $this->db->prepare("SELECT `title` FROM `category_savers` WHERE  `id`=?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        require($this->render($this->folder, 'connect', 'index', 'php'));
        $this->adminFooterController();

    }



    public function processing_connect($id)
    {


        $table = $this->product_savers_connect;
        $primaryKey = 'product_savers_connect.id';

        $columns = array(


            array('db' => 'product_savers_connect.title', 'dt' => 0),

            array(
                'db' => 'product_savers_connect.id',
                'dt' => 1,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_connect($id)} class='toggle-demo' onchange='visible_savers_connect(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array('db' => 'product_savers_connect.date', 'dt' =>2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),

            array(
                'db' => 'product_savers_connect.id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_product_savers_connect',$this->folder)) {
                        return "
                   <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'user.username', 'dt' => 4),
            array('db' => 'product_savers_connect.id', 'dt' => 5)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


            $join = " inner JOIN user ON user.id = product_savers_connect.userid  ";
            $whereAll = array("product_savers_connect.id_cat={$id}");

        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null ));




    }

    public function ch_connect($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->product_savers_connect} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function visible_savers_connect($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->product_savers_connect, array('active' => $v), "`id`={$id}");
    }

    public function add_connect_device($id)
    {


        $this->checkPermit('add_connect_device', 'savers');
        $this->adminHeaderController($this->langControl('add_connect_device'));

        $stmt = $this->db->prepare("SELECT `title` FROM `category_savers` WHERE  `id`=?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);



        if (isset($_POST['submit']))
        {
            try
            {
                $form =new  Form();



                $form  ->post('ids')
                    ->val('is_array')
                    ->val('strip_tags');


                $form ->submit();
                $data =$form -> fetch();
                $data['date']=time();

                $data['userid']=$this->userid;


                $ids= json_decode($data['ids'], true);

                if (!empty($ids)) {

                    $title = array();
                    foreach ($ids as $d) {

                        $stmt = $this->db->prepare("SELECT `title` FROM `type_device` WHERE  `id`=?  AND {$this->is_delete}");
                        $stmt->execute(array($d));
                        $dev = $stmt->fetch(PDO::FETCH_ASSOC);
                        $title[] = $dev['title'];

                    }


                    $data['id_cat'] =  $id;
                    $data['title'] = implode(' // ', $title);
                    $data['ids'] = implode(',', $ids);


                      $id_add=$this->db->insert($this->product_savers_connect,$data);

                    }
               $this->lightRedirect(url.'/'.$this->folder."/list_saver_connect/{$id}",0);


            }
            catch (Exception $e)
            {
                $data =$form -> fetch();

                $this->error_form= $e -> getMessage();
            }

        }

        require($this->render($this->folder, 'connect', 'add', 'php'));
        $this->adminFooterController();

    }


    function search($id)
    {
        if ($this->handleLogin()) {
            $data = $_GET['q'];
            $data = '%' . $data . '%';
            $stmt = $this->db->prepare("SELECT * FROM `type_device`  WHERE   {$this->is_delete} AND type_device.title LIKE ?   ");
            $stmt->execute(array($data));

            if ($stmt->rowCount() > 0) {
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<div  id='c_{$row['id']}' class='dropdownCustomer'> <button type='button' class='btn' onclick=add_c({$row["id"]}) >   <i class='fa fa-plus-circle'></i> </button>  " . $row['title'] . "  </div>";
                }
            } else
            {
                echo "لا يوجد";
            }
        }
    }

    function savers_info($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT `title` FROM `type_device` WHERE  `id`=?  AND {$this->is_delete} ");
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $result['title'];
        }
    }

    function  type_cover()
    {
        $this->checkPermit('type_cover',$this->folder);
        $this->adminHeaderController($this->langControl('type_cover'));

        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();



                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            NULL,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 2)
                        {


                                $stmtcode = $this->db->prepare("UPDATE  product_savers SET  `latiniin`=  ?   WHERE  code=?");
                                $stmtcode->execute(array($rowData[0][1],$rowData[0][0]));


                        }else{
                            $this->error_form=json_encode(array('files_normal'=>'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);
                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/open_savers");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','type_cover','php'));
        $this->adminFooterController();
    }


    function all_cover()
    {
        $this->checkPermit('all_cover', $this->folder);

        $this->adminHeaderController($this->langControl('all_cover'));





        require($this->render($this->folder, 'html', 'all_cover', 'php'));
        $this->adminFooterController();




    }


    public function processing_all_cover()
    {


        $table = $this->product_savers;
        $primaryKey =  $table.'.id';

        $columns = array(

            array('db' => 'category_savers.title', 'dt' => 0),
            array('db' => $table.'.title', 'dt' => 1),
            array('db' =>  $table.'.code', 'dt' => 2),
            array('db' => 'excel_savers.quantity', 'dt' => 3),
            array('db' =>  $table.'.latiniin', 'dt' => 4),
            array('db' =>  $table.'.date', 'dt' => 5,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:s:i a', $d);
                }

            ),
            array('db' =>  $table.'.img', 'dt' => 6,
                'formatter' => function ($d, $row) {
                    if ($d)
                    {
                        return "<img width=140 src='".$this->save_file.$d."' >";
                    }else{
                        return 'لاتوجد صورة';
                    }

                }

            ),
            array(
                'db' =>  $table.'.id',
                'dt' =>7 ,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_product_savers($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),

            array(
                'db' =>  $table.'.id',
                'dt' => 8,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_product_savers/{$id}/all> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' =>  $table.'.id',
                'dt' => 9,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[1]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' =>  $table.'.id', 'dt' => 10)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );

        $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device   INNER JOIN name_device ON name_device.id=type_device.id_device    INNER JOIN category_savers ON category_savers.id=name_device.id_cat   LEFT JOIN excel_savers ON excel_savers.code = product_savers.code ";
        $whereAll = array("product_savers.code <> ''");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));


    }
function x()
{


    for ($i=1;$i<=6810;$i++){

        $stmt=$this->db->prepare("INSERT INTO cover_code (code) values ('')");
        $stmt->execute();
        if ($stmt->rowCount() > 0)
        {
            echo $i.'<br>';
        }


    }

}

    function check_code()
    {

        if($this->handleLogin())
        {
            $code=trim($_GET['code']);
            $stmt=$this->db->prepare("SELECT *FROM {$this->product_savers} WHERE code =? AND {$this->is_delete}  ");
            $stmt->execute(array($code));
            if ($stmt->rowCount() > 0)
            {
                echo '1';
            }else
            {
                echo '0';
            }

        }
    }




    public function list_cover_material()
    {

        $this->checkPermit('cover_material', 'savers');
        $this->adminHeaderController($this->langControl('cover_material'));

        require($this->render($this->folder, 'cover_material', 'html/list', 'php'));
        $this->adminFooterController();

    }

    public function add_cover_material()
    {


        $this->checkPermit('add_cover_material', 'savers');
        $this->adminHeaderController($this->langControl('add_cover_material'));

        $category = $this->db->select("SELECT * from `{$this->table}` WHERE {$this->is_delete}  ");


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();



                $form->post('cover_material')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('number')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = time();
                $data['userid'] = $this->userid;


                $cover_material = json_decode($data['cover_material'], true);
                $number = json_decode($data['number'], true);



                foreach ($cover_material as $key => $save_data) {
                    $stmt_c = $this->db->prepare("INSERT INTO `{$this->cover_material}` (`cover_material`,`number`,`userid`,`date`) VALUE (?,?,?,?)");
                    $stmt_c->execute(array($save_data,$number[$key],$this->userid, time()));

                }

                $this->lightRedirect(url . "/savers/list_cover_material", 0);

            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'cover_material', 'html/add', 'php'));
        $this->adminFooterController();

    }



    public function edit_cover_material($id)
    {
        $this->checkPermit('edit_cover_material', 'savers');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->cover_material}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();


                $form->post('cover_material')
                    ->val('is_empty', ' اسم المادة مطلوب  ')
                    ->val('strip_tags');

                $form->post('number')
                    ->val('is_empty', ' رقم المادة مطلوب  ')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();


                    $this->db->update($this->cover_material, $data, "id={$id}");


                    $this->lightRedirect(url . "/savers/list_cover_material", 0);


            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'cover_material', 'html/edit', 'php'));
        $this->adminFooterController();

    }

    public function processing_cover_material()
    {


        $table = $this->cover_material;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'cover_material', 'dt' => 0),
            array('db' => 'number', 'dt' =>1),
            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {

                        return "
                <div style='text-align: center'>
                  <input {$this->ch_cover_material($id)} class='toggle-demo' onchange='visible_savers(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }


            ),

            array(
                'db' => 'id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/savers/edit_cover_material/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_cover_material',$this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";}
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 6)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );
        echo json_encode(
        // SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns );
            SSP::complex($_GET, $sql_details, $table, $primaryKey, $columns)
        );

    }


    public function ch_cover_material($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->cover_material} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }
    public function visible_savers_cover_material($v_, $id_)
    {

        if ($this->handleLogin())
        {

        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }

        $data = $this->db->update($this->cover_material, array('active' => $v), "`id`={$id}");
    }

 }

    function delete_savers_cover_material($id)
    {
        if ($this->handleLogin() ) {

            $cd = $this->db->prepare("DELETE FROM `$this->cover_material`  WHERE  `id`=?");
            $cd->execute(array($id));
        }
    }


    function rprice()
    {

        if (isset($_POST['submit']))
        {
            $iditem=$_POST['idcolor'];
            $qr=$_POST['qr'];

            $stmtqr=$this->db->prepare("SELECT *FROM user WHERE hash=?");
            $stmtqr->execute(array($qr));
            if ($stmtqr->rowCount() > 0)
            {


                $stmt=$this->db->prepare("SELECT  {$this->excel}.price_dollars  FROM product_savers inner JOIN {$this->excel} ON {$this->excel}.code = product_savers.code   WHERE  product_savers.id= ? LIMIT 1");
                $stmt->execute(array($iditem));
                if ($stmt->rowCount() > 0 )
                {
                    $result=$stmt->fetch(PDO::FETCH_ASSOC);
                    echo  $this->price_dollarsAdmin($result['price_dollars']) .' د.ع ';

                } else
                {
                    echo 'unk';
                }
            }else{

                echo 'rqr';
            }

        }else
        {
            echo 'rqr';
        }



    }



    public function active()
    {

        $this->checkPermit('active_location_and_enter_serial',$this->folder);
        $this->adminHeaderController($this->langControl('active'));
        $data_cat=$this->db->select("SELECT * from  {$this->type_device} WHERE {$this->is_delete} ");
        foreach ($data_cat as $key => $d_cat)
        {

            $data_cat[$key]=$d_cat;
        }


        require ($this->render($this->folder,'html','active','php'));
        $this->adminFooterController();

    }


    public function active_pro()
    {

        $this->checkPermit('active_location_and_enter_serial',$this->folder);


        $cat=$_GET['cat'];
        $type=$_GET['type'];
        $ls=$_GET['ls'];

        if ($cat=='all')
        {
            if ($type=='location')
            {
                $stmt=$this->db->prepare("UPDATE product_savers SET locationTag=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE product_savers  SET enter_serial=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }

        }else
        {



            if ($type=='location')
            {
                $stmt=$this->db->prepare("UPDATE product_savers SET locationTag=? ,userId=? WHERE id_device = ?");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE product_savers SET enter_serial=? ,userId=?  WHERE  id_device = ?  ");
                $stmt->execute(array($ls,$this->userid));
            }

        }

        echo 1;

    }



    function quantity2()
    {

        $this->checkPermit('export_excel2', $this->folder);
        $this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));



        require($this->render($this->folder, 'quantity', 'index2', 'php'));
        $this->adminFooterController();
    }

    public function processing_quantity2()
    {
        $this->checkPermit('view_quantity2', $this->folder);
        $table = 'product_savers';
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(

            array('db' => 'type_device.title', 'dt' => 0),
            array('db' => 'product_savers.title', 'dt' =>1),
            array('db' => $tableJoin . 'code', 'dt' => 2),
            array('db' => 'excel_savers.quantity', 'dt' => 3),
            array('db' => 'product_savers.latiniin', 'dt' => 4),
            array('db' => 'excel_savers.date', 'dt' => 5,
                'formatter' => function( $d, $row ) {
                    return  date('Y-m-d h:i:s A') ;
                }),

            array('db' => 'product_savers.id', 'dt' => 6),

        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );


            $join = "INNER JOIN type_device ON type_device.id=product_savers.id_device    LEFT JOIN excel_savers ON excel_savers.code = product_savers.code";
            $whereAll = array("product_savers.title <> ''","product_savers.img <> ''");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll,null,null));

    }



    /*
        function del_cover ($s=null)
        {
            if ($s) {



                $list="
    154648";

                $your_array = explode("\n", $list);

                $c=0;
                foreach ($your_array as $ya ) {

                        $stmtd = $this->db->prepare("DELETE   FROM product_savers WHERE title=? AND id_device=802");
                        $stmtd->execute(array($ya));
                        if ($stmtd->rowCount() > 0 )
                        {
                            echo $c ++;    echo '<br>';
                        }

                }
            }else{
                echo 'enter 1 for start move !';
            }
        }
    */

/*  حذف الكفرات النادرة علي الشامي 2022-2-19  */
    function xcover()
    {

        $stmt=$this->db->prepare("SELECT  product_savers.code,excel_savers.quantity FROM `product_savers`   INNER JOIN ali_cover ON ali_cover.code = product_savers.code   LEFT JOIN excel_savers ON excel_savers.code=product_savers.code WHERE  excel_savers.quantity <= 0 OR excel_savers.quantity IS NULL");
        $stmt->execute();
        $c=0;
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmtd=$this->db->prepare("DELETE  FROM `product_savers` WHERE code=? ");
            $stmtd->execute(array(trim($row['code'])));
            if ($stmtd->rowCount() > 0)
            {
                echo $c++;
                echo '<br>';
            }else
            {
                echo $row['code'];
                echo '<br>';
            }

        }

    }


    function fixed_location() {

        $stmt=$this->db->prepare("SELECT  code  FROM  location WHERE model='savers' AND fixed_location=0 ");
        $stmt->execute();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

            $stmt2 = $this->db->prepare("INSERT INTO  location  (code,location,model,sequence,userid,`date`,quantity,fixed_location) values (?,?,?,?,?,?,?,?) ");
            $stmt2->execute(array(trim($row['code']),555555, 'savers', '99', $this->userid, time(),0,1));

            echo $row['code'];
        }

    }


    function  point()
    {
        $this->checkPermit('point',$this->folder);
        $this->adminHeaderController($this->langControl('point'));


        if(isset($_POST["submit"])) {


            try {
                $form = new  Form();

                $form->post('files_normal')
                    ->val('is_empty', 'مطلوب')
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();
                $name_file=json_decode($data['files_normal'],true);

                $inputFileName=$this->root_file.'/files/'.$name_file[0]['rand_name'];
                if (file_exists($inputFileName)) {

                    //  Read your Excel workbook
                    try {
                        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
                        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                        $objPHPExcel = $objReader->load($inputFileName);
                    } catch (Exception $e) {
                        die('Error loading file "' . pathinfo($inputFileName, PATHINFO_BASENAME) . '": ' . $e->getMessage());
                    }

                    //  Get worksheet dimensions
                    $sheet = $objPHPExcel->getSheet(0);
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();




                    //  Loop through each row of the worksheet in turn

                    for ($row = 1; $row <= $highestRow; $row++) {
                        //  Read a row of data into an array
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
                            FALSE,
                            TRUE,
                            TRUE);


                        if (count($rowData[0])  >= 2  ) {


                            $stmtc = $this->db->prepare("SELECT * FROM product_savers  WHERE  `code`=? AND {$this->is_delete} ");
                            $stmtc->execute(array(trim($rowData[0][0])));
                            if ($stmtc->rowCount() > 0) {
                                $result = $stmtc->fetch(PDO::FETCH_ASSOC);

                                $stmt_point = $this->db->prepare("UPDATE product_savers  SET  point=?   WHERE code = ?  ");
                                $stmt_point->execute(array($rowData[0][1], $rowData[0][0]));
                                if ($stmt_point->rowCount() > 0 )
                                {


                                        $trace=new trace_site();
                                        $newData=$trace->neaw($result['id'],$this->folder);
                                        $trace->add($result['id'],$this->folder,'رفع نقاط المادة','',$result['title'],'',$newData);


                                }

                            }



                        } else {
                            $this->error_form = json_encode(array('files_normal' => 'يرجى تعديل ملف الاكسل على حسب المثال في الاعلى'));
                            break;
                        }

                    }

                    @unlink($inputFileName);

                }else
                {

                    $this->error_form=json_encode(array('files_normal'=>'يرجى اعادة رفع الملف'));
                }

                if (empty($this->error_form))
                {
                    $this->lightRedirect(url.'/'.$this->folder."/open_savers");

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','point','php'));
        $this->adminFooterController();
    }



    function del_acc_array ($s=null)
    {
        if ($s) {



            $list="10997
12187
12191
13142
13423
13558
13559
13560
13806
13959
15069
15078
18356
137009
137711
143428
154682
154683
156607
161002
163821
163920
164122
164252
164837
164892
164893
165062
165405
165409
166315
166804
166879
167497
167712
167827
168119
168502
168578
169132
169137
169227
169370
169411
169418
169550
169569
169594
169678
169763
169822
171006
171014
173557
173589
173794
177626
178150
178250
178257
178300
178330
181434
181479
181480
181483
184146
184790
185453
185785
189235
189237
189464
189473
189641
190030
190031
190171
190175
190214
190331
190333
190337
190397
190405
190468
190487
191094
191154
192110
192177
192307
192309
192345
192411
192449
192468
192471
192829
192901
193570
194022
194023
194241
194405
196319
198196
198202
198205
198208
198212
202268
202289
202530
202536
206391
206466
206481
206633
206634
206892
207819
207820
207821
208072
208073
208227
10528
10623
10742
10765
10769
10778
10817
10861
10868
10876
10907
10946
10951
10955
10956
10958
10959
10960
10961
10962
10963
10965
10968
10971
10975
10979
10981
10983
10987
10998
10999
12188
12213
12252
12541
13174
13295
13442
13484
13487
13889
13908
13913
13940
14120
15050
15058
15203
15376
15499
15513
15515
18324
18326
18378
18385
18386
75004
100790
101117
101119
101121
101126
101127
101129
101135
101145
101146
101148
101149
101150
101151
101152
101153
101156
101157
101162
101163
114018
137081
137223
137332
137396
138333
138752
139134
139142
139143
139164
139338
139339
139350
139396
139508
139528
142675
142823
142990
142997
143082
143414
143415
143419
143431
143469
143489
143494
154407
154498
154509
154521
154658
154676
154739
154744
154761
154786
154787
154788
154789
154807
154963
154966
155007
155038
155180
155236
155271
155272
155347
155403
155765
155961
156435
156612
156968
157164
157182
157218
157263
157366
157469
157476
157617
157845
157927
158009
158011
158134
158157
158950
158956
160109
160157
160307
160433
160517
161088
161110
161343
161436
161547
161785
162236
162241
162253
162347
163343
163447
163454
163873
163948
164254
164255
164469
164684
164767
164848
164920
165022
165371
167140
167379
167484
167727
167772
167773
167859
167964
168146
168296
168889
169168
169276
169332
169440
169476
169490
169511
169545
169549
169556
169559
169578
169635
169719
169758
169787
169945
169958
170034
173262
177003
177004
177005
177010
177027
177029
177036
177037
177039
177079
177086
177088
177090
177092
177094
177095
177096
177097
177098
177120
177122
177123
177124
177125
177126
177135
177146
177158
177211
177219
177221
177224
177247
177249
177250
177251
177253
177285
177286
177287
177288
177290
177292
177330
177331
177334
177362
177365
177366
177367
177373
177412
177414
177415
177440
177458
177459
177466
177503
177540
177570
177583
177589
177590
177603
177606
177607
177645
177649
177650
177651
177708
177718
177737
177841
177886
177964
178032
178033
178048
178062
178069
178097
178110
178267
178397
178540
178566
178647
178741
178974
178975
178976
179454
179564
181294
189638
189790
189932
190009
190219
190220
190221
191219
191668
192275
192385
192923
192924
192925
193001
193003
193012
193407
193675
193955
193957
193961
193962
207157
1006615
1006806
1006859
1006860
1011729
1011944
1011945
1012011";

            $your_array = explode("\n", $list);


            foreach ($your_array as $ya ) {


                    $stmt_c = $this->db->prepare("DELETE FROM  `product_savers`  WHERE code=? AND id_device=919  ");
                    $stmt_c->execute(array(trim($ya)));

                    $stmt_  = $this->db->prepare("DELETE FROM  `excel_savers`  WHERE code=?");
                    $stmt_->execute(array(trim($ya)));



            }
        }else{
            echo 'enter 1 for start move !';
        }
    }






}