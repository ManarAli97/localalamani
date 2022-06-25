<?php

class mobile extends Controller
{

    public $ids = array();
    public $stopCatg = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'mobile';
        $this->category = 'category_mobile';
        $this->color = 'color';
        $this->code = 'code';
        $this->excel = 'excel';
        $this->cart_shop = 'cart_shop';
        $this->like_mobile = 'like_mobile';
        $this->comparison = 'comparison';
        $this->category_connect = "category_{$this->folder}_connect";
        $this->rate_amount=25;
        $this->menu = new Menu();

        $this->setting = new Setting();
    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `content` longtext COLLATE utf8_unicode_ci NOT NULL,
          `description` longtext COLLATE utf8_unicode_ci NOT NULL,
          `id_cat` int(11) NOT NULL,
          `bast` int(11) NOT NULL  DEFAULT '0',
          `id_main_cat` int(11) NOT NULL,
          `img` bigint(20) NOT NULL DEFAULT '0',
          `view` bigint(20) NOT NULL DEFAULT '0',
          `active` int(11) NOT NULL DEFAULT '0',
          `main_cat` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `img` int(10) NOT NULL,
           `relid` int (10) NOT NULL,
          `active` int(10) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->color}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code_color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `id_item` int(10) NOT NULL,
          `img` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->code}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `size` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `id_color` int(10) NOT NULL,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->cart_shop}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_member_r` int(11) NOT NULL,
          `id_item` int(11) NOT NULL,
          `size` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `price_dollars`  varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `image` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `table` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number` bigint(20) NOT NULL DEFAULT '1',
          `buy` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
          `date_req` bigint(20) NOT NULL,
          `status` int(11) NOT NULL  DEFAULT '0',
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->like_mobile}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_device` int(11) NOT NULL  DEFAULT '0',
          `id_member_r` int(11) NOT NULL,
          `like` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->comparison}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `id_device` int(11) NOT NULL  DEFAULT '0',
          `id_member_r` int(11) NOT NULL,
          `comparison` int(11) NOT NULL  DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
        ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->category_connect}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `title` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `ids` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `active` int(11) NOT NULL DEFAULT '0',
          `userId` int(11) NOT NULL DEFAULT '0',
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return $this->db->cht(array($this->table, $this->category, $this->color, $this->code, $this->excel, $this->cart_shop, $this->like_mobile, $this->comparison));

    }


    public function index()
    {
        $index = new Index();
        $index->index();
    }


    public function admin_category($id = 0)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $this->checkPermit('View_category', 'mobile');
        $this->adminHeaderController($this->langControl('View_category'), $id);
        $breadcumbs = $this->Breadcumbs($this->category, $id);
        $data = $this->db->select("SELECT * from  {$this->category} WHERE  `relid` = {$id} AND {$this->is_delete} ");
        foreach ($data as $key => $dt) {

            $data[$key]['checked'] = ($dt['active'] == 1) ? 'checked' : null;
            if ($dt['img'] != 0) {
                $data[$key]['img'] = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $dt['img'], ':module' => $this->folder . '_cat'));
                $data[$key]['image'] = $this->save_file . $data[$key]['img'][0]['rand_name'];
                $data[$key]['type_file'] = $data[$key]['img'][0]['file_type'];
                unset($data[$key]['img']);
            } else {
                $data[$key]['image'] = "http://placehold.jp/20/cccccc/0000/252x252.png?text={$dt['title']}";
            }
        }
        require($this->render($this->folder, 'cat', 'admin_category', 'php'));
        $this->adminFooterController();

    }


    public function list_mobile($id = null)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $this->checkPermit('view_content', 'mobile');
        $this->adminHeaderController($this->langControl('view_content'), $id);
        $breadcumbs = $this->Breadcumbs($this->category, $id);
        $data_cat = $this->db->select("SELECT * from  {$this->category} WHERE    {$this->is_delete} ");
        foreach ($data_cat as $key => $d_cat) {


            if ($d_cat['id'] == $id) {
                $d_cat['selected'] = 'selected';

            } else {
                $d_cat['selected'] = null;
            }
            $data_cat[$key] = $d_cat;
        }


        require($this->render($this->folder, 'html', 'list', 'php'));
        $this->adminFooterController();

    }


    public function list2_mobile()
    {

        $this->checkPermit('view_content', 'mobile');
        $this->adminHeaderController($this->langControl('view_content'));
        $data_cat = $this->db->select("SELECT * from  {$this->category} WHERE {$this->is_delete}");
        foreach ($data_cat as $key => $d_cat) {

            $data_cat[$key] = $d_cat;
        }


        require($this->render($this->folder, 'html', 'list2', 'php'));
        $this->adminFooterController();

    }


    public function processing2()
    {

        $table = $this->table;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'id_cat', 'dt' => 0,
                'formatter' => function ($d, $row) {
                    return $this->category_name($d);
                }

            ),
            array('db' => 'title', 'dt' => 1),
            array('db' => 'date', 'dt' => 2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d h:i:s', $d);
                }

            ),
            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_mobile(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'view', 'dt' => 4),
            array(
                'db' => 'id',
                'dt' => 5,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/mobile/edit_mobile/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => 'id',
                'dt' => 6,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => 'id', 'dt' => 7)


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

    function category_name($id)
    {

        $stmt = $this->db->prepare("SELECT *from  {$this->category} WHERE  `id` = {$id}  AND {$this->is_delete}");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['title'];
    }


    function getLoopIdX($id)
    {
        $stmt = $this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id} AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($id));
        while ($s = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->ids[] = $s['id'];
            $this->getLoopIdX($s['id']);

        }
    }

    function getLoopId($id)
    {

        if (!empty($id)) {
            $this->ids[] = $id;
        }
        $stmt = $this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id} AND `active` = 1  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->ids[] = $row['id'];
            $this->getLoopIdX($row['id']);
        }

        return $this->ids;
    }


    public function list_all($id = null, $page = 1)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $breadcumbs = $this->BreadcumbsPublic($this->category, $id);
        $this->ids[] = $id;
        $stmt = $this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = {$id} AND `active` = 1  AND {$this->is_delete}  ORDER BY `id` DESC  ");
        $stmt->execute(array($id));
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->ids[] = $row['id'];
            if (!empty($this->getLoopIdX($row['id']))) {
                $this->ids[] = $this->getLoopIdX($row['id']);

            }
        }

        $ids_cat = implode(',', $this->ids);


        $result = $this->db->select("SELECT * from  {$this->category} WHERE  `id` = {$id} AND `active` = 1  AND {$this->is_delete} ");
        $result = $result[0];
        $stmt = $this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat` IN ($ids_cat) AND `active` = 1  AND {$this->is_delete}");
        $stmt->execute(array($ids_cat));
        $table = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['img'] == 0) {
                continue;
            }

            $stmt_price = $this->db->prepare("SELECT MIN(price) as min,MAX(price) as max  FROM {$this->size} WHERE `id_item` = ?  ");
            $stmt_price->execute(array($row['id']));
            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);
            if ($result_price['min'] == $result_price['max']) {
                $row['price'] = $result_price['min'];
            } else {
                $row['price'] = $result_price['min'] . '  - ' . $result_price['max'];
            }

            $table[] = $row;
        }


        $page_data = array_chunk($table, 8);
        $count = count($page_data);
        $data_view = array();
        if (!empty($page_data)) {
            foreach ($page_data[$page - 1] as $row) {
                if ($row['img'] != 0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                    $get_file = $get_file[0];
                    $row['img'] = $this->save_file . $get_file['rand_name'];
                } else {
                    $row['img'] = $this->static_file_control . '/image/admin/default.png';
                }
                $data_view[] = $row;
            }
        }


        require($this->render($this->folder, 'html', 'list_all', 'php'));
    }


    public function all_product($page = 1)
    {


        $stmt = $this->db->prepare("SELECT *FROM `$this->table` WHERE   `active` = 1  AND {$this->is_delete} ORDER BY `id` DESC ");
        $stmt->execute();
        $table = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if ($row['img'] == 0) {
                continue;
            }

            $stmt_price = $this->db->prepare("SELECT MIN(price) as min,MAX(price) as max  FROM {$this->size} WHERE `id_item` = ?  ");
            $stmt_price->execute(array($row['id']));
            $result_price = $stmt_price->fetch(PDO::FETCH_ASSOC);
            if ($result_price['min'] == $result_price['max']) {
                $row['price'] = $result_price['min'];
            } else {
                $row['price'] = $result_price['min'] . '  - ' . $result_price['max'];
            }

            $table[] = $row;
        }


        $page_data = array_chunk($table, 8);
        $count = count($page_data);
        $data_view = array();
        if (!empty($page_data)) {
            foreach ($page_data[$page - 1] as $row) {
                if ($row['img'] != 0) {
                    $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => $this->folder));
                    $get_file = $get_file[0];
                    $row['img'] = $this->save_file . $get_file['rand_name'];
                } else {
                    $row['img'] = $this->static_file_control . '/image/admin/default.png';
                }
                $data_view[] = $row;
            }
        }


        require($this->render($this->folder, 'html', 'all_product', 'php'));
    }


    public function list_view($id = null, $page = 1)
    {


        $range = false;
        $stmt_range = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE `range1` <> 0 AND range1 > 0  AND `range2` <> 0 AND range2 > 0 ");
        $stmt_range->execute();
        if ($stmt_range->rowCount() > 0) {
            $range = true;
        }


        $stmtCat = $this->db->prepare("SELECT *FROM {$this->category}  WHERE `active` = 1  AND {$this->is_delete}");
        $stmtCat->execute();
        $catRange = array();
        while ($row = $stmtCat->fetch(PDO::FETCH_ASSOC)) {
            $catRange[] = $row;
        }
        if (is_numeric($id)) {

            $breadcumbs = $this->BreadcumbsPublic($this->category, $id);
            $result = $this->db->select("SELECT * from  {$this->category} WHERE  `id` = {$id} AND `active` = 1  AND {$this->is_delete}");
            $result = $result[0];

        }


        $specifications = array();

        $stmt_specif = $this->db->prepare("SELECT *FROM `specifications`  WHERE `model`=?");
        $stmt_specif->execute(array($this->folder));

        while ($row = $stmt_specif->fetch(PDO::FETCH_ASSOC)) {

            $row['items'] = array();

            $stmt_item = $this->db->prepare("SELECT *FROM `specifications_item` WHERE `id_specif`=?");
            $stmt_item->execute(array($row['id']));

            while ($row_itm = $stmt_item->fetch(PDO::FETCH_ASSOC)) {
                $row['items'][] = $row_itm;
            }
            $specifications[] = $row;
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





        require($this->render($this->folder, 'html', 'view_list', 'php'));
    }




    function load($id=null)
    {

    	// Array to show lable('عروض كل يوم ') on product model mobile

        $offers_mobile=array();

        $item_per_page = 8;

        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);


        if (is_numeric($id)) {

            $stmt_ch = $this->db->prepare("SELECT `ids` FROM `{$this->category_connect}` WHERE   FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
            $stmt_ch->execute(array($id));
            if ($stmt_ch->rowCount()>0)
            {
                $result2 = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                $Id_cat=$result2['ids'];
                $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE     {$this->table}.`id_cat`  IN ({$Id_cat}) AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND {$this->table}.is_delete=0 group by   {$this->table}.`id`  ORDER BY {$this->table}.`id` DESC  LIMIT $position,$item_per_page");
                $stmt->execute();

            }else{

                $Id_cat = implode(',', $this->getLoopId($id));
                 $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE     {$this->table}.`id_cat`  IN ({$Id_cat}) AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND {$this->table}.is_delete=0  group by   {$this->table}.`id`  ORDER BY {$this->table}.`id` DESC  LIMIT $position,$item_per_page");
                $stmt->execute(array($id));

            }


        } else {
             $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE      {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  group by   {$this->table}.`id` AND  {$this->table}.is_delete=0  ORDER BY {$this->table}.`id` DESC  LIMIT $position,$item_per_page");
            $stmt->execute();
        }

        $table = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $stmtIdItC = $this->get_color($row['id']);
            if ($stmtIdItC->rowCount() > 0) {

                   $details= $stmtIdItC->fetch(PDO::FETCH_ASSOC);

                    if ($this->loginUser()) {
                        $row['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                        $row['price'] =$row['priceC'] . ' د.ع ';

                        $row['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                        $row['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                        $row['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';


                    } else {
                        if ($row['price_dollars'] == 1) {
                            $row['priceC'] = $this->price_dollars($details['price_dollars']);
                            $row['price'] =  $row['priceC']  . ' د.ع ';

                            $row['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                            $row['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                            $row['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';

                        } else {
                            $row['priceC'] = $details['price'];
                            $row['price'] = $details['price'] . ' د.ع ';
                        }
                    }

                    if (trim($details['quantity']) > 0) {
                        $row['q'] = 1;
                    } else {
                        $row['q'] = 0;
                    }

                    $row['size'] = $details['size'];
                    $row['code'] = $details['code'];
                    $row['code_color'] = $details['code_color'];
                    $row['nameImage'] = $details['img'];
                    $row['like'] = $this->ckeckLick($row['id']);
                    $row['comparison'] = $this->check_comparison($row['id']);
                    $row['image'] = $this->save_file . $details['img'];

                    $table[] = $row;

            }

        }

    	$stmtOffers=$this->db->prepare("SELECT offers.id, offers_item.code  FROM `offers` INNER JOIN `offers_item` ON offers.id = offers_item.id_offer  WHERE  NOT (offers.note = ?) AND NOT (offers.note = ?) AND offers.delete =? AND offers.todate  > ? AND offers_item.active = 1 ");
        $stmtOffers->execute(array('انتهت مدة العرض ','نفذت بعض مواد العرض', 0, time()));
        while ($rowOffers = $stmtOffers->fetch(PDO::FETCH_ASSOC))
        {
            $rowOffers['code'] = $rowOffers['code'];

            $offers_mobile[] = $rowOffers;
        }


        require ($this->render($this->folder,'html','data','php'));

    }


    function get_color($id)
    {
        $stmt = $this->db->prepare("SELECT `{$this->color}`.*,  {$this->code}.size,  {$this->code}.code,   {$this->excel}.price_dollars, {$this->excel}.wholesale_price, {$this->excel}.wholesale_price2, {$this->excel}.cost_price, {$this->excel}.price , {$this->excel}.quantity  FROM `{$this->color}`  INNER JOIN {$this->code} ON {$this->code}.id_color = `{$this->color}`.id     INNER JOIN {$this->excel} ON {$this->excel}.code = `{$this->code}`.code    WHERE   `{$this->color}`.`id_item`= ? ORDER BY  {$this->excel}.quantity  DESC LIMIT 1 ");
        $stmt->execute(array($id));
        return $stmt;
    }



    function stop($id,$code)
    {

		if (!is_numeric($id)) {
			$error = new Errors();
			$error->index();
		}



		$stmt_import_category=$this->db->prepare("SELECT  * FROM category_mobile WHERE active =1 AND  relid=0  AND {$this->is_delete}  ORDER BY  order_cat  ASC  ");
		$stmt_import_category->execute();
		$import_category=array();
		while ($row = $stmt_import_category->fetch(PDO::FETCH_ASSOC))
		{
			$import_category[]=$row;
		}

        $import_category=array_chunk($import_category,4);


		$stmt = $this->db->prepare("SELECT *FROM {$this->table} WHERE  `id` = ?  AND {$this->is_delete}");
		$stmt->execute(array($id));
		$result = $stmt->fetch(PDO::FETCH_ASSOC);


		$stmtC = $this->db->prepare("SELECT *FROM {$this->category} WHERE  `id` = ?  AND {$this->is_delete}");
		$stmtC->execute(array($result['id_cat']));
		$resultC = $stmtC->fetch(PDO::FETCH_ASSOC);



		$stmt_code=$this->db->prepare("SELECT *FROM excel WHERE code = ? LIMIT 1");
		$stmt_code->execute(array($code));
		$result_code=$stmt_code->fetch(PDO::FETCH_ASSOC);
		   $price = $this->price_dollarsAdmin($result_code['price_dollars']);
//		echo '<br>';
	     $newprice_min = (int)str_replace($this->comma,'', $this->outPrice(number_format(round((int)str_replace($this->comma,'',$price) * ((100-$this->rate_amount) / 100)))));

  //	  echo number_format($newprice_min);
//  		echo '<br>';
	  $newprice_max =(int)str_replace($this->comma,'', $this->outPrice(number_format(round((int)str_replace($this->comma,'',$price) * ((100+$this->rate_amount) / 100)))));
  //	echo number_format($newprice_max);


         $this->getLoopIdStop($resultC['relid']);

		$data_view = array();

        $stmt_list = $this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat`=? AND `id` <> ? AND `active` = 1 AND {$this->bast_it}   AND {$this->is_delete} ");
		$stmt_list->execute(array($result['id_cat'],$id));

		while ($row = $stmt_list->fetch(PDO::FETCH_ASSOC)) {
			$idItemC = array();
			$stmtIdItC = $this->numberItems($row['id']);
			while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
				$idItemC[] = $rowiIdIt;
			}

			if (!empty($idItemC)) {

				$x=count($idItemC);
				foreach ($idItemC as $key => $idItc) {
					$stmt_img_id = $this->getImage($idItc['id'], 1);

					$row['image'] = $this->save_file . $stmt_img_id['img'];

					$stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);

					if ($this->smt_ch_code($stmt_price['code'])) {
						$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
						if ($smt_ch_q->rowCount() > 0) {


					       $p=(int)str_replace($this->comma,'',$this->price_dollarsAdmin($stmt_price['price_dollars']));
							if ( $p >= $newprice_min  &&  $p <= $newprice_max)
                            {
								$row['priceC'] = $stmt_price['price'];
								$row['price'] = $stmt_price['price'] . ' د.ع ';

								$row['size'] = $stmt_price['size'];
								$row['code'] = $stmt_price['code'];
								$row['code_color'] = $stmt_img_id['code_color'];
								$row['nameImage'] = $stmt_img_id['img'];

								$row['like'] = $this->ckeckLick($row['id']);
								$row['comparison'] = $this->check_comparison($row['id']);

								$data_view[] = $row;
								break;
                            }

						}else
                        {
                            continue;
                        }
					}
				}

			}

		}

		if (($key = array_search($result['id_cat'], $this->stopCatg)) !== false) {
			unset($this->stopCatg[$key]);
		}

		if (!empty($this->stopCatg))
        {
		$ids_c=implode(',',$this->stopCatg);
        $stmt_list = $this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat` IN ({$ids_c})   AND `id` <> ? AND `active` = 1 AND {$this->bast_it}  AND {$this->is_delete}  ");
		$stmt_list->execute(array($id));
	    }


		while ($row = $stmt_list->fetch(PDO::FETCH_ASSOC)) {
			$idItemC = array();
			$stmtIdItC = $this->numberItems($row['id']);
			while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
				$idItemC[] = $rowiIdIt;
			}

			if (!empty($idItemC)) {

				$x=count($idItemC);
				foreach ($idItemC as $key => $idItc) {
					$stmt_img_id = $this->getImage($idItc['id'], 1);

					$row['image'] = $this->save_file . $stmt_img_id['img'];

					$stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);

					if ($this->smt_ch_code($stmt_price['code'])) {
						$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
						if ($smt_ch_q->rowCount() > 0) {



							$p=(int)str_replace($this->comma,'',$this->price_dollarsAdmin($stmt_price['price_dollars']));
							if ( $p >= $newprice_min  &&  $p <= $newprice_max)
							{
								$row['priceC'] = $stmt_price['price'];
								$row['price'] = $stmt_price['price'] . ' د.ع ';

								$row['size'] = $stmt_price['size'];
								$row['code'] = $stmt_price['code'];
								$row['code_color'] = $stmt_img_id['code_color'];
								$row['nameImage'] = $stmt_img_id['img'];

								$row['like'] = $this->ckeckLick($row['id']);
								$row['comparison'] = $this->check_comparison($row['id']);

								$data_view[] = $row;
								break;
                            }

						}else
                        {
                            continue;
                        }
					}
				}

			}

		}

		require($this->render($this->folder, 'html', 'stop', 'php'));

    }

    function stop_ajax($id,$code)
	{
		if (!is_numeric($id)) {
			$error = new Errors();
			$error->index();
		}

		$ids_cat=array();
		if (isset($_POST['ids_cat']))
		{
			$ids_cat=$_POST['ids_cat'];
		}

		$this->stopCatg=array();

		$data_view = array();


		$stmt_code=$this->db->prepare("SELECT *FROM excel WHERE code = ? LIMIT 1");
		$stmt_code->execute(array($code));
		$result_code=$stmt_code->fetch(PDO::FETCH_ASSOC);
		$price = $this->price_dollarsAdmin($result_code['price_dollars']);

		$newprice_min = str_replace($this->comma,'', $this->outPrice(number_format(round((int)str_replace($this->comma,'',$price) * ((100-$this->rate_amount) / 100)))));

// 	  echo number_format($newprice_min);
// 		echo '<br>';
		$newprice_max =str_replace($this->comma,'', $this->outPrice(number_format(round((int)str_replace($this->comma,'',$price) * ((100+$this->rate_amount) / 100)))));
// 		echo number_format($newprice_max);




		if (!empty($ids_cat))
		{

			foreach ($ids_cat as $ids)
			{
				$this->getLoopIdStop($ids);
			}

				$ids_c=implode(',',$this->stopCatg);
				$stmt_list = $this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat` IN ({$ids_c})   AND `id` <> ? AND `active` = 1 AND {$this->bast_it}  AND {$this->is_delete}  ");
				$stmt_list->execute(array($id));

			while ($row = $stmt_list->fetch(PDO::FETCH_ASSOC)) {
				$idItemC = array();
				$stmtIdItC = $this->numberItems($row['id']);
				while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
					$idItemC[] = $rowiIdIt;
				}

				if (!empty($idItemC)) {

					$x=count($idItemC);
					foreach ($idItemC as $key => $idItc) {
						$stmt_img_id = $this->getImage($idItc['id'], 1);

						$row['image'] = $this->save_file . $stmt_img_id['img'];

						$stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);

						if ($this->smt_ch_code($stmt_price['code'])) {
							$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
							if ($smt_ch_q->rowCount() > 0) {



//								$price_string= $this->around((int)str_replace($this->comma,'',$stmt_price['price']));
//								$split=explode('-',$price_string);
//								$p=(int)str_replace($this->comma,'',$split[0]);

								$p=(int)str_replace($this->comma,'',$this->price_dollarsAdmin($stmt_price['price_dollars']));
								if ( $p >= $newprice_min  &&  $p <= $newprice_max)
								{
									$row['priceC'] = $stmt_price['price'];
									$row['price'] = $stmt_price['price'] . ' د.ع ';

									$row['size'] = $stmt_price['size'];
									$row['code'] = $stmt_price['code'];
									$row['code_color'] = $stmt_img_id['code_color'];
									$row['nameImage'] = $stmt_img_id['img'];

									$row['like'] = $this->ckeckLick($row['id']);
									$row['comparison'] = $this->check_comparison($row['id']);

									$data_view[] = $row;
									break;
								}

							}else
							{
								continue;
							}
						}
					}

				}

			}


		}else

		{

			$stmt = $this->db->prepare("SELECT *FROM {$this->table} WHERE  `id` = ?  AND {$this->is_delete}");
			$stmt->execute(array($id));
			$result = $stmt->fetch(PDO::FETCH_ASSOC);


			$stmtC = $this->db->prepare("SELECT *FROM {$this->category} WHERE  `id` = ?  AND {$this->is_delete}");
			$stmtC->execute(array($result['id_cat']));
			$resultC = $stmtC->fetch(PDO::FETCH_ASSOC);


			$this->getLoopIdStop($resultC['relid']);

			$stmt_list = $this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat`=? AND `id` <> ? AND `active` = 1 AND {$this->bast_it}   AND {$this->is_delete} ");
			$stmt_list->execute(array($result['id_cat'],$id));

			while ($row = $stmt_list->fetch(PDO::FETCH_ASSOC)) {
				$idItemC = array();
				$stmtIdItC = $this->numberItems($row['id']);
				while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
					$idItemC[] = $rowiIdIt;
				}

				if (!empty($idItemC)) {

					$x=count($idItemC);
					foreach ($idItemC as $key => $idItc) {
						$stmt_img_id = $this->getImage($idItc['id'], 1);

						$row['image'] = $this->save_file . $stmt_img_id['img'];

						$stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);

						if ($this->smt_ch_code($stmt_price['code'])) {
							$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
							if ($smt_ch_q->rowCount() > 0) {



								$p=(int)str_replace($this->comma,'',$this->price_dollarsAdmin($stmt_price['price_dollars']));
								if ( $p >= $newprice_min  &&  $p <= $newprice_max)
								{
									$row['priceC'] = $stmt_price['price'];
									$row['price'] = $stmt_price['price'] . ' د.ع ';

									$row['size'] = $stmt_price['size'];
									$row['code'] = $stmt_price['code'];
									$row['code_color'] = $stmt_img_id['code_color'];
									$row['nameImage'] = $stmt_img_id['img'];

									$row['like'] = $this->ckeckLick($row['id']);
									$row['comparison'] = $this->check_comparison($row['id']);

									$data_view[] = $row;
									break;
								}

							}else
							{
								continue;
							}
						}
					}

				}

			}

			if (($key = array_search($result['id_cat'], $this->stopCatg)) !== false) {
				unset($this->stopCatg[$key]);
			}

			if (!empty($this->stopCatg))
			{
				$ids_c=implode(',',$this->stopCatg);
				$stmt_list = $this->db->prepare("SELECT *FROM `$this->table` WHERE `id_cat` IN ({$ids_c})   AND `id` <> ? AND `active` = 1 AND {$this->bast_it}   AND {$this->is_delete} ");
				$stmt_list->execute(array($id));
			}


			while ($row = $stmt_list->fetch(PDO::FETCH_ASSOC)) {
				$idItemC = array();
				$stmtIdItC = $this->numberItems($row['id']);
				while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
					$idItemC[] = $rowiIdIt;
				}

				if (!empty($idItemC)) {

					$x=count($idItemC);
					foreach ($idItemC as $key => $idItc) {
						$stmt_img_id = $this->getImage($idItc['id'], 1);

						$row['image'] = $this->save_file . $stmt_img_id['img'];

						$stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);

						if ($this->smt_ch_code($stmt_price['code'])) {
							$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
							if ($smt_ch_q->rowCount() > 0) {



								$p=(int)str_replace($this->comma,'',$this->price_dollarsAdmin($stmt_price['price_dollars']));
								if ( $p >= $newprice_min  &&  $p <= $newprice_max)
								{
									$row['priceC'] = $stmt_price['price'];
									$row['price'] = $stmt_price['price'] . ' د.ع ';

									$row['size'] = $stmt_price['size'];
									$row['code'] = $stmt_price['code'];
									$row['code_color'] = $stmt_img_id['code_color'];
									$row['nameImage'] = $stmt_img_id['img'];

									$row['like'] = $this->ckeckLick($row['id']);
									$row['comparison'] = $this->check_comparison($row['id']);

									$data_view[] = $row;
									break;
								}

							}else
							{
								continue;
							}
						}
					}

				}

			}

		}

		require($this->render($this->folder, 'html', 'stop_ajax', 'php'));

	}



	function getLoopIdXStop($id)
	{
		$stmt = $this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = ? AND `active` = 1  AND {$this->is_delete}");
		$stmt->execute(array($id));
		while ($s = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$this->stopCatg[] = $s['id'];
			$this->getLoopIdXStop($s['id']);

		}
	}

	function getLoopIdStop($id)
	{

		if (!empty($id)) {
			$this->stopCatg[] = $id;
		}
		$stmt = $this->db->prepare("SELECT *from  {$this->category} WHERE  `relid` = ? AND `active` = 1  AND {$this->is_delete}");
		$stmt->execute(array($id));
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$this->stopCatg[] = $row['id'];
			$this->getLoopIdXStop($row['id']);
		}

		return $this->stopCatg;
	}





    function numberItems($id)
    {
        $stmt = $this->db->prepare("SELECT `id`  FROM `{$this->color}` WHERE   `id_item`= ?    ");
        $stmt->execute(array($id));
        return $stmt;
    }


    public function details($id)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }


        $stmt = $this->db->prepare("SELECT *FROM {$this->table} WHERE  `id` = ?  AND {$this->is_delete}");
        $stmt->execute(array($id));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $breadcumbs = $this->BreadcumbsPublic($this->category, $result['id_cat']);

        $g_c = $this->getImageAndColor($result['id'], 100);
        $g_c_content = array();
        $id_c = 0;
        $count = 0;
        while ($row = $g_c->fetch(PDO::FETCH_ASSOC)) {

            $stmt_price = $this->getPrice($row['id'], 1, $result['price_dollars']);

            $smt_ch_q = $this->smt_ch_q($stmt_price['code']);
            if ($smt_ch_q->rowCount() > 0) {

                if ($count == 0) {
                    $id_c = $row['id'];
                }
                $row['image'] = $row['img'];
                $row['quantity'] = $stmt_price['quantity'];
                $row['code'] = $stmt_price['code'];
                $g_c_content[] = $row;
                $count++;
            }
        }

        $table=array();
        $stmt_table = $this->db->prepare("SELECT `{$this->color}`.*,  {$this->code}.size,  {$this->code}.code,   {$this->excel}.quantity  FROM `{$this->color}`  INNER JOIN {$this->code} ON {$this->code}.id_color = `{$this->color}`.id     INNER JOIN {$this->excel} ON {$this->excel}.code = `{$this->code}`.code    WHERE   `{$this->color}`.`id_item`= ?  AND  {$this->excel}.quantity > 0 ");
        $stmt_table->execute(array($id));
        while ($row_table =$stmt_table->fetch(PDO::FETCH_ASSOC) )
        {
            $table[]= $row_table;
        }


        $content = array();

        $stmt_content = $this->getAllContent();
        while ($row_cont = $stmt_content->fetch(PDO::FETCH_ASSOC)) {


            $idItemC = array();

            $stmtIdItC = $this->numberItems($row_cont['id']);
            while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
                $idItemC[] = $rowiIdIt;
            }

            if (!empty($idItemC)) {

                foreach ($idItemC as $idItc) {
                    $stmt_img_id = $this->getImage($idItc['id'], 1);

                    $row_cont['image'] = $this->save_file . $stmt_img_id['img'];

                    $stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row_cont['price_dollars']);

                    $smt_ch_q = $this->smt_ch_q($stmt_price['code']);
                    if ($smt_ch_q->rowCount() > 0) {


                        if (isset($_COOKIE['currency'])) {
                            if ($_COOKIE['currency'] == 0) {
                                $row_cont['price'] = $stmt_price['price'] . ' د.ع ';
                            } else {
                                $row_cont['price'] = $stmt_price['price_dollars'] . '$ ';
                            }

                        } else {
                            $row_cont['price'] = $stmt_price['price'] . ' د.ع ';
                        }


                        $row_cont['size'] = $stmt_price['size'];
                        $row_cont['code'] = $stmt_price['code'];
                        $row_cont['code_color'] = $stmt_img_id['code_color'];
                        $row_cont['nameImage'] = $stmt_img_id['img'];
                        $row_cont['like'] = $this->ckeckLick($row_cont['id']);
                        $content[] = $row_cont;
                        break;
                    } else {
                        continue;
                    }
                }

            }

        }


        $stmtc=$this->db->prepare("SELECT *FROM {$this->color} WHERE `id_item`=?");
        $stmtc->execute(array($id));
        $color=array();
        while ($row=$stmtc->fetch(PDO::FETCH_ASSOC))
        {

            $stmtco=$this->db->prepare("SELECT *FROM {$this->code} WHERE `id_color`=?");
            $stmtco->execute(array($row['id']));
            $row['code']=array();
            while ($rowco=$stmtco->fetch(PDO::FETCH_ASSOC))
            {
               $stmtlc=$this->db->prepare("SELECT *FROM location WHERE `code`=? AND model=? ");
               $stmtlc->execute(array($rowco['code'],$this->folder));
               $rowco['location']=array();
                while ($rowlc = $stmtlc->fetch(PDO::FETCH_ASSOC))
                {
                    $rowco['location'][]= $rowlc;
                }
                $row['code'][]=$rowco;
            }
            $color[]=$row;
        }



        $stmt = $this->db->prepare("UPDATE `{$this->table}` SET view = view+1 WHERE id = ?");
        $stmt->execute(array($id));


		$table_accessories = array();

        if ($result['id_device']) {

            $idcarAcc=array();
            $stmtIdCatAcc=$this->db->prepare("SELECT id FROM category_accessories WHERE  id_device=? AND  `active` = 1  AND {$this->is_delete} ");
            $stmtIdCatAcc->execute(array($result['id_device']));
            while ($row=$stmtIdCatAcc->fetch(PDO::FETCH_ASSOC))
            {
                $idcarAcc[]=$row['id'];
            }
            $idcarAcc=implode(',',$idcarAcc);
			$accessories = new  Accessories();
			$stmt_accessories = $this->db->prepare("SELECT *FROM `accessories` WHERE `id_cat` in({$idcarAcc})  AND `active` = 1 AND {$this->bast_it}  AND {$this->is_delete} ORDER BY `id` DESC  ");
			$stmt_accessories->execute( );


			while ($row = $stmt_accessories->fetch(PDO::FETCH_ASSOC)) {

				$idItemC = array();

				$stmtIdItC = $accessories->numberItems($row['id']);
				while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
					$idItemC[] = $rowiIdIt;
				}

				if (!empty($idItemC)) {

					foreach ($idItemC as $idItc) {

						$stmt_img_id = $accessories->getImage($idItc['id'], 1);

						$row['image'] = $this->save_file . $stmt_img_id['img'];
						$stmt_price = $accessories->getPrice($stmt_img_id['code'], 1, $row['price_dollars']);

						$smt_ch_q = $accessories->smt_ch_q($stmt_img_id['code'], $stmt_img_id['color']);
						if ($smt_ch_q->rowCount() > 0) {

							$row['priceC'] = $stmt_price['price'];
							$row['price'] = $stmt_price['price'] . ' د.ع ';


							$row['code'] = $stmt_img_id['code'];
							$row['code_color'] = $stmt_img_id['code_color'];
							$row['color'] = $stmt_img_id['color'];
							$row['nameImage'] = $stmt_img_id['img'];

							$row['like'] = $accessories->ckeckLick($row['id']);

							$table_accessories[] = $row;
							break;
						} else {
							continue;
						}
					}
				}
			}



		$table_savers=array();

		$savers=new  Savers();



            $idcarCover=array();
            $stmtIdCatCover=$this->db->prepare("SELECT id FROM type_device WHERE  id_device_mobile=? AND  `active` = 1 ");
            $stmtIdCatCover->execute(array($result['id_device']));
            while ($row=$stmtIdCatCover->fetch(PDO::FETCH_ASSOC))
            {
                $idcarCover[]=$row['id'];
            }
            $idcarCover=implode(',',$idcarCover);
			$stmt = $this->db->prepare("SELECT * from `product_savers` WHERE `id_device` in({$idcarCover})  AND `active`=1 AND  `img` <> '' AND `title` <> '' ");
			$stmt->execute();
			if ($stmt->rowCount() > 0) {
				while ($idProd = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$idProd['image'] = $this->save_file . $idProd['img'];
					$idProd['id_device'] = $id;

					$smt_price = $savers->getPriceNew($idProd['code']);
					if ($smt_price) {

						$idProd['quantity'] = $smt_price['quantity'];
						$idProd['priceC'] = $smt_price['price'];
						$idProd['price'] = $smt_price['price'] ;

						$table_savers[] = $idProd;

					}

				}

			}


		}




		require($this->render($this->folder, 'html', 'details', 'php'));


    }

    function dtl($id)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $stmt = $this->db->prepare("SELECT `{$this->code}`.`code`,`{$this->code}`.`size`,`{$this->excel}`.id from `{$this->code}` INNER JOIN `{$this->excel}` ON `{$this->excel}`.code=`{$this->code}`.code  WHERE  `{$this->code}`.`id_color`=? AND `{$this->excel}`.`quantity` > 0  ");
        $stmt->execute(array($id));
        $excel = array();
        $html = '';
        $c = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if ($c == 0) {
                    $html .= "<option value='{$row['id']}'  selected >{$row['size']}</option>";
                } else {
                    $html .= "<option value='{$row['id']}'   >{$row['size']}</option>";
                }
             $c++;
            $excel[] = $row;
        }
        echo $html;
    }

    function dtl_start_price($id)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }


        $stmt_c = $this->db->prepare("SELECT `id` from `{$this->color}` WHERE  `id_item`=?  ");
        $stmt_c->execute(array($id));
        $color_id = array();
        while ($row_c = $stmt_c->fetch(PDO::FETCH_ASSOC)) {
            $color_id[] = $row_c['id'];
        }

        $Id_color = implode(',', $color_id);
        $stmt = $this->db->prepare("SELECT `code` from `{$this->code}` WHERE  `id_color` IN ({$Id_color})   ");
        $stmt->execute(array($id));
        $code = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $code[] = $row['code'];
        }


        $Id_code = implode(',', $code);
        if (isset($_COOKIE['currency'])) {
            if ($_COOKIE['currency'] == 0) {
                $stmt_x = $this->db->prepare("SELECT `price`,`price_dollars`,`wholesale_price` from `{$this->excel}` WHERE  `code` IN ({$Id_code})  ORDER BY `price` ASC LIMIT 1 ");
            } else {
                $stmt_x = $this->db->prepare("SELECT `price`,`price_dollars` ,`wholesale_price` from `{$this->excel}` WHERE  `code` IN ({$Id_code})  ORDER BY `price_dollars` ASC LIMIT 1 ");

            }
        } else {
            $stmt_x = $this->db->prepare("SELECT `price`,`price_dollars`,`wholesale_price` from `{$this->excel}` WHERE  `code` IN ({$Id_code})  ORDER BY `price` ASC LIMIT 1 ");

        }
        $stmt_x->execute();

        if (isset($_COOKIE['currency'])) {
            if ($_COOKIE['currency'] == 0) {

                if ($this->loginUser()) {
                    return $stmt_x->fetch(PDO::FETCH_ASSOC)['wholesale_price'];
                } else {
                    return $stmt_x->fetch(PDO::FETCH_ASSOC)['price'];
                }

            } else {
                return $stmt_x->fetch(PDO::FETCH_ASSOC)['price_dollars'];
            }

        } else {
            if ($this->loginUser()) {
                return $stmt_x->fetch(PDO::FETCH_ASSOC)['wholesale_price'];
            } else {
                return $stmt_x->fetch(PDO::FETCH_ASSOC)['price'];
            }
        }

    }


    function price($id, $price_dollars)
    {
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }

        $stmt = $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `id`=?  ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

        require($this->render($this->folder, 'html', 'price', 'php'));

        } else {
       echo 'السعر غير معروف';
      }
    }


       public function add_mobile($id = null,$r=null)
    {

        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $this->checkPermit('add', 'mobile');
        $this->adminHeaderController($this->langControl('add'), $id);
        $breadcumbs = $this->Breadcumbs($this->category, $id);
        $data_cat = $this->db->select("SELECT * from  {$this->category} WHERE    {$this->is_delete}");
        foreach ($data_cat as $key => $d_cat) {


            if ($d_cat['id'] == $id) {
                $d_cat['checked'] = 'checked';

            } else {
                $d_cat['checked'] = null;
            }
            $data_cat[$key] = $d_cat;
        }



        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }



        $stmt_specif = $this->db->prepare("SELECT *FROM `specifications`  WHERE `model`=?");
        $stmt_specif->execute(array($this->folder));
        $specifications = array();
        while ($row = $stmt_specif->fetch(PDO::FETCH_ASSOC)) {

            $row['items'] = array();

            $stmt_item = $this->db->prepare("SELECT *FROM `specifications_item` WHERE `id_specif`=?");
            $stmt_item->execute(array($row['id']));

            while ($row_itm = $stmt_item->fetch(PDO::FETCH_ASSOC)) {
                $row['items'][] = $row_itm;
            }
            $specifications[] = $row;
        }


        $data['title'] = '';
        $data['bast_it'] = '';
        $data['serial_flag'] = '';
        $data['price_dollars'] = '';
        $data['location'] = '';
        $data['enter_serial'] = '';
        $data['cuts'] = '';
        $data['price_cuts'] = '';
        $data['content'] = '';
        $data['description'] = '';
        $data['tags'] = '';
        $data['date'] = time();

//        $data['id_accessories'] = '';

//        $data['id_savers'] = '';
        $data['stop'] = '';
        $data['change_price'] =1;
        $data['id_device'] =0;


        if (isset($_POST['submit'])) {
            try {
                $form = new  Form();

                $form->post('title')
                    ->val('is_empty', 'حقل العنوان فاغ')
                    ->val('strip_tags');

                $form->post('content')
                    ->val('is_empty', $this->langControl('the_detail_field_is_empty'))
                    ->val('strip_tags', TAG);

                $form->post('description')
                    ->val('strip_tags', TAG);

                $form->post('id_cat')
                    ->val('is_empty', 'يرجى تحديد قسم')
                    ->val('strip_tags');

                $form->post('bast_it')
                    ->val('strip_tags');

                $form->post('serial_flag')
                    ->val('strip_tags');
                $form->post('price_dollars')
                    ->val('strip_tags');

                $form->post('location')
                    ->val('strip_tags');

                $form->post('enter_serial')
                    ->val('strip_tags');

                $form->post('stop')
                    ->val('strip_tags');

                $form->post('cuts')
                    ->val('strip_tags');

                $form->post('price_cuts')
                    ->val('strip_tags');
                $form->post('change_price')
                    ->val('strip_tags');

                $form->post('name_color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('point')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('size')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('serial')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->post('date')
                    ->val('is_empty', 'تحديد الوقت ')
                    ->val('strip_tags');

                $form->post('tags')
                    ->val('strip_tags');

                $form->post('specifications')
                    ->val('is_array')
                    ->val('strip_tags');

				$form->post('name_accessories')
					->val('strip_tags');

				$form->post('id_device')
                    ->val('is_empty', 'مطلوب تحديد الجهاز')
                    ->val('strip_tags');

//				$form->post('id_accessories')
//					->val('strip_tags');
//                $form->post('id_savers')
//                    ->val('strip_tags');
				$form->post('name_savers')
					->val('strip_tags');



                $form->submit();
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                if ($r)
                {
                    $data['active']=1;
                }

                if ($data['cuts'] == 1) {
                    if (empty($data['price_cuts'])) {
                        $this->error_form['price_cuts'] = 'سعر العرض الخاص مطلوب';
                    }

                }

                if (empty($this->error_form)) {

                    $name_color = json_decode($data['name_color'], true);
                    $color = json_decode($data['color'], true);
                    $code = json_decode($data['code'], true);
                    $point = json_decode($data['point'], true);
                    $size = json_decode($data['size'], true);
                    $serial = json_decode($data['serial'], true);

                    if (!empty($data['specifications'])) {
                        $specifications = json_decode($data['specifications'], true);
                        $specifications = implode(',', $specifications);
                    } else {
                        $specifications = '';
                    }

                    $stmt = $this->db->prepare("INSERT INTO `{$this->table}` (`title`,`id_cat`,`content`,`description`,`date`,`bast_it`,`serial_flag`,`price_dollars`,`tags`,`cuts`,`price_cuts`,`specifications`,`location`,`enter_serial`,`id_device`,`stop`,`change_price`,`userId`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                    $stmt->execute(array($data['title'], $data['id_cat'], $data['content'], $data['description'], $data['date'], $data['bast_it'], $data['serial_flag'], $data['price_dollars'], $data['tags'], $data['cuts'], $data['price_cuts'], $specifications, $data['location'], $data['enter_serial'],  $data['id_device'], $data['stop'], $data['change_price'],$this->userid));
                    $lastId = $this->db->lastInsertId();

            //       $stmt_online= $this->onlinedb()->prepare("INSERT INTO `{$this->table}` (`title`,`id_cat`,`content`,`description`,`date`,`bast_it`,`serial_flag`,`price_dollars`,`tags`,`cuts`,`price_cuts`,`specifications`,`location`,`enter_serial`) VALUE (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
              //     $stmt_online->execute(array($data['title'], $data['id_cat'], $data['content'], $data['description'], $data['date'], $data['bast_it'], $data['serial_flag'], $data['price_dollars'], $data['tags'], $data['cuts'], $data['price_cuts'], $specifications, $data['location'], $data['enter_serial']));


                    $image = array();
                    if (empty($this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png')))) {
                        $image = $this->save_file($_FILES['image']);
                    } else {
                        $this->error_form['image'] = $this->check_file($_FILES['image'], 'صور مطلوبة', array('jpg', 'jpeg', 'png'));
                    }


                    foreach ($name_color as $key => $save_data) {
                        $stmt_c = $this->db->prepare("INSERT INTO `{$this->color}` (`color`,`code_color`,`id_item`,`img`,`date`) VALUE (?,?,?,?,?)");
                        $stmt_c->execute(array($save_data, $color[$key], $lastId, $image[$key], time()));

//                        $stmt_c_online =$this->onlinedb()->prepare("INSERT INTO `{$this->color}` (`color`,`code_color`,`id_item`,`img`,`date`) VALUE (?,?,?,?,?)");
//                        $stmt_c_online->execute(array($save_data, $color[$key], $lastId, $image[$key], time()));


                       if ($stmt_c->rowCount() > 0) {
                            $lastId_c = $this->db->lastInsertId();
                            foreach ($code[$key] as $index => $cd) {
                                $stmt_cd = $this->db->prepare("INSERT INTO `{$this->code}` (`code`,`point`,`size`,`serial`,`id_color`,`date`) VALUE (?,?,?,?,?,?)");
                                $stmt_cd->execute(array($cd, $point[$key][$index],  $size[$key][$index], $serial[$key][$index],  $lastId_c, time()));

//                                $stmt_cd_online = $this->onlinedb()->prepare("INSERT INTO `{$this->code}` (`code`,`size`,`serial`,`id_color`,`date`) VALUE (?,?,?,?,?)");
//                                $stmt_cd_online->execute(array($cd, $size[$key][$index], $serial[$key][$index],  $lastId_c, time()));
                            }
                        }

                    }


                    $trace=new trace_site();
					$newData=$trace->neaw($lastId,$this->folder);
                    $trace->add($lastId,$this->folder,'add','',$data['title'],'',$newData);
					$this->Add_to_sync_schedule($lastId,$this->folder,'add_mobile');
                    if ($r)
                    {
						$this->lightRedirect(url . "/purchase_customer/purchase", 0);
					}else
					{
						$this->lightRedirect(url . "/mobile/list_mobile/{$id}", 0);

					}

                }


            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }

        require($this->render($this->folder, 'html', 'add', 'php'));
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


      public function edit_mobile($id)
    {
        $this->checkPermit('edit', 'mobile');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $files = new Files();
        $this->adminHeaderController($this->langControl('edit'));

        $data = $this->db->select("SELECT * from `{$this->table}` WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];
        $oldTitle=$data['title'];

        $breadcumbs = $this->Breadcumbs($this->category, $data['id_cat']);


        $specifications_id = explode(',', $data['specifications']);

        $stmt_specif = $this->db->prepare("SELECT *FROM `specifications`  WHERE `model`=?");
        $stmt_specif->execute(array($this->folder));
        $specifications = array();
        while ($row = $stmt_specif->fetch(PDO::FETCH_ASSOC)) {
            $row['items'] = array();

            $stmt_item = $this->db->prepare("SELECT *FROM `specifications_item` WHERE `id_specif`=?");
            $stmt_item->execute(array($row['id']));

            while ($row_itm = $stmt_item->fetch(PDO::FETCH_ASSOC)) {
                $row['items'][] = $row_itm;
            }
            $specifications[] = $row;
        }




        $stmt_device_name = $this->db->prepare("SELECT *FROM `menu_link_device_acc_cover` ");
        $stmt_device_name->execute();
        $device_name= array();
        while ($row = $stmt_device_name->fetch(PDO::FETCH_ASSOC)) {
            $device_name[] = $row;
        }


        $stmt_color = $this->db->prepare("SELECT *FROM `{$this->color}` WHERE `id_item` = ? ");
        $stmt_color->execute(array($id));
        $color = array();
        $image = array();
        while ($row = $stmt_color->fetch(PDO::FETCH_ASSOC)) {
            $image[$row['id']] = $row['img'];
            $row['code'] = array();
            $stmt_code = $this->db->prepare("SELECT *FROM `{$this->code}` WHERE `id_color` = ? ");
            $stmt_code->execute(array($row['id']));
            while ($row_code = $stmt_code->fetch(PDO::FETCH_ASSOC)) {
                $row['code'][] = $row_code;
            }

            $color[] = $row;
        }
        $stmt_last_id = $this->db->prepare("SELECT `id` FROM `{$this->color}` WHERE `id_item` = ? ORDER BY `id` DESC  LIMIT 1");
        $stmt_last_id->execute(array($id));
        $last_id = $stmt_last_id->fetch(PDO::FETCH_ASSOC)['id'];


        $data_cat = $this->db->select("SELECT * from  {$this->category} WHERE    {$this->is_delete} ");
        foreach ($data_cat as $key => $d_cat) {
            if ($d_cat['id'] == $data['id_cat']) {
                $d_cat['checked'] = 'checked';
            } else {
                $d_cat['checked'] = null;
            }
            $data_cat[$key] = $d_cat;
        }


        if (isset($_POST['submit'])) {


			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);


			try {
                $form = new  Form();

                $form->post('title')
                    ->val('is_empty', 'حقل العنوان فاغ')
                    ->val('strip_tags');


                $form->post('content')
                    ->val('is_empty', $this->langControl('the_detail_field_is_empty'))
                    ->val('strip_tags', TAG);

                $form->post('description')
                    ->val('strip_tags', TAG);
                $form->post('id_cat')
                    ->val('is_empty', 'يرجى تحديد قسم')
                    ->val('strip_tags');

                $form->post('bast_it')
                    ->val('strip_tags');

                $form->post('serial_flag')
                    ->val('strip_tags');

                $form->post('price_dollars')
                    ->val('strip_tags');

                $form->post('location')
                    ->val('strip_tags');

				$form->post('stop')
					->val('strip_tags');

                $form->post('enter_serial')
                    ->val('strip_tags');

                $form->post('cuts')
                    ->val('strip_tags');


                $form->post('price_cuts')
                    ->val('strip_tags');

                $form->post('change_price')
                    ->val('strip_tags');


                $form->post('name_color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('color')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('code')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('point')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('size')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('serial')
                    ->val('is_array')
                    ->val('strip_tags');



                $form->post('date')
                    ->val('is_empty', 'تحديد الوقت ')
                    ->val('strip_tags');

                $form->post('tags')
                    ->val('strip_tags');

                $form->post('specifications')
                    ->val('is_array')
                    ->val('strip_tags');

                $form->post('name_accessories')
                    ->val('strip_tags');


                $form->post('id_device')
                    ->val('is_empty', 'مطلوب تحديد الجهاز')
                    ->val('strip_tags');

//                $form->post('id_accessories')
//                    ->val('strip_tags');

                $form->post('name_savers')
                    ->val('strip_tags');

//                $form->post('id_savers')
//                    ->val('strip_tags');

                $form->submit();
                $data = $form->fetch();

                if ($data['cuts'] == 1) {
                    if (empty($data['price_cuts'])) {
                        $this->error_form['price_cuts'] = 'سعر العرض الخاص مطلوب';
                    }

                }
                $form->submit();
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);


                $name_color = json_decode($data['name_color'], true);
                $color_inst = json_decode($data['color'], true);
                $code = json_decode($data['code'], true);
                $point = json_decode($data['point'], true);
                $size = json_decode($data['size'], true);
                $serial = json_decode($data['serial'], true);


                if (!empty($data['specifications'])) {
                    $specifications = json_decode($data['specifications'], true);
                    $specifications = implode(',', $specifications);
                } else {
                    $specifications = '';
                }


                $image_new = array();
                $image_new = $this->save_file($_FILES['image']);

                foreach ($image_new as $key => $img) {
                    $image[$key] = $image_new[$key];
                }

                if ($this->permit('save_edit', $this->folder)) {
                    if (empty($this->error_form)) {
                        $stmt = $this->db->prepare("UPDATE   `{$this->table}` SET  `title`=? ,  `content`=? ,  `description`=? , `id_cat`=? ,`date`=? ,`bast_it`=? ,`serial_flag`=? ,`price_dollars`=? ,`tags`=?,`cuts`=?,`price_cuts`=?,`specifications`=?,`location`=?,`enter_serial`=? ,`id_device`=? ,`stop`=?,`change_price`=? ,`userId`=? WHERE `id`=?");
                        $stmt->execute(array($data['title'], $data['content'], $data['description'], $data['id_cat'], $data['date'], $data['bast_it'], $data['serial_flag'], $data['price_dollars'], $data['tags'], $data['cuts'], $data['price_cuts'], $specifications, $data['location'], $data['enter_serial'],$data['id_device'],$data['stop'], $data['change_price'],$this->userid, $id));


                        foreach ($name_color as $key => $save_data) {
                            $stmt_c = $this->db->prepare("INSERT INTO `{$this->color}` (`id`,`color`,`code_color`,`img`,`id_item`,`date`) VALUE (?,?,?,?,?,?)  ON DUPLICATE KEY UPDATE `id`=VALUES(id),`color`=VALUES(color),`code_color`=VALUES(code_color),`img`=VALUES(img),`id_item`=VALUES(id_item)");
                            $stmt_c->execute(array($key, $save_data, $color_inst[$key], $image[$key], $id, time()));
                            $lastIdColor = $this->db->lastInsertId();
                            if ($lastIdColor == 0) {
                                $key_id = $key;
                            } else {
                                $key_id = $lastIdColor;
                            }

                            foreach ($code[$key] as $index => $cd) {


                                $stmt_cd = $this->db->prepare("INSERT INTO `{$this->code}` (`id`,`code`,`point`,`size`,`serial`,`id_color`,`date`) VALUE (?,?,?,?,?,?,?)  ON DUPLICATE KEY UPDATE `id`=VALUES(id),`code`=VALUES(code),`point`=VALUES(point),`size`=VALUES(size),`serial`=VALUES(serial),`id_color`=VALUES(id_color)");
                                $stmt_cd->execute(array($index, $cd, $point[$key][$index], $size[$key][$index], $serial[$key][$index], $key_id, time()));

                            }
                        }


						$trace=new trace_site();
						$newData=$trace->neaw($id,$this->folder);
                    	$this->Add_to_sync_schedule($id,$this->folder,'add_mobile');
						$trace->add($id,$this->folder,'edit',$oldTitle,$data['title'],$oldData,$newData);


						$this->lightRedirect(url . "/mobile/list_mobile/{$data['id_cat']}", 0);
                    }
                }
            } catch (Exception $e) {
                $data = $form->fetch();
                $data['date'] = strtotime($data['date']);
                $this->error_form = json_decode($e->getMessage(), true);

            }

        }


        require($this->render($this->folder, 'html', 'edit', 'php'));
        $this->adminFooterController();

    }

    public function processing($id)
    {


        $table = $this->table;
        $primaryKey = $table.'.id';

        $columns = array(


            array('db' => $table.'.title', 'dt' => 0),
            array('db' => $table.'.id', 'dt' => 1,


                'formatter' => function ($d, $row) {
                    return $this->sumqy( $d);
                }
                ),
            array('db' => 'menu_link_device_acc_cover.name_device', 'dt' => 2),

            array('db' => $table.'.date', 'dt' => 3,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),
            array(
                'db' => $table.'.id',
                'dt' => 4,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible', $this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch($id)} class='toggle-demo' onchange='visible_mobile(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => $table.'.view', 'dt' => 5),
            array(
                'db' => $table.'.id',
                'dt' => 6,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url . "/mobile/edit_mobile/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' => $table.'.id',
                'dt' => 7,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete', $this->folder)) {
                        return "
                <div style='text-align: center'>
                    <button class='btn class_delete_row'  data-toggle='modal' data-target='#exampleModal' data-id='{$id}' data-title='{$row[0]}'   >
                    <i class='fa fa-trash-o' aria-hidden='true'></i></i>
                         </button>
                    </div> ";
                    } else {
                        return $this->langControl('forbidden');
                    }
                }
            ),
            array('db' => $table.'.id', 'dt' => 8)


        );

// SQL server connection information
        $sql_details = array(
            'user' => DB_USER,
            'pass' => DB_PASS,
            'db' => DB_NAME,
            'host' => DB_HOST,
            'charset' => 'utf8'
        );



            $join = " LEFT  JOIN menu_link_device_acc_cover ON menu_link_device_acc_cover.id = {$this->table}.id_device    ";
              $whereAll = array("{$this->table}.id_cat={$id}","  {$this->table}.is_delete=0");


        echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));


    }



    function sumqy($id)
    {
        $stmt=$this->db->prepare("SELECT SUM({$this->excel}.quantity) as s FROM {$this->table} inner JOIN {$this->color} ON {$this->color}.id_item = {$this->table}.id  inner JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id      LEFT JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE $this->table.id=? AND   $this->table.is_delete=0  ");
        $stmt->execute(array($id));
        $result=$stmt->fetch(PDO::FETCH_ASSOC);
        return $result['s'];

    }


    public function visible_mobile($v_, $id_)
    {
        if ($this->handleLogin()) {
            if (is_numeric($v_) && is_numeric($id_)) {
                $v = $v_;
                $id = $id_;
            } else {
                $v = 0;
                $id = 0;
            }

			$stmt=$this->db->prepare("SELECT  *FROM `{$this->table}` WHERE `id`  = ?  AND {$this->is_delete}  " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$data = $this->db->update($this->table, array('active' => $v), "`id`={$id}");
        	$this->Add_to_sync_schedule($id,$this->folder,'add_mobile');

			$newData=$trace->neaw($id,$this->folder);
			$trace->add($id,$this->folder,'active',$result['title'],$result['title'],$oldData,$newData);


		}
    }


    function delete_mobile($id)
    {
        if ($this->handleLogin()) {

        	 $ids_color = array();


        	$stmt_codes_sync=$this->db->prepare("SELECT code FROM `code` where id_color in (select id from `color` where id_item =? )");
            $stmt_codes_sync->execute(array($id));

            $check_codes="( ";
            while($row_codes = $stmt_codes_sync->fetch(PDO::FETCH_ASSOC))
            {
                $check_codes.='"'.$row_codes['code'].'",';
            }

        	$check_codes=substr($check_codes,0,-1).')';
        	 $this->Add_to_sync_schedule($id,'mobile','delete_item', $check_codes);

			$stmt=$this->db->prepare("SELECT  *FROM `{$this->table}` WHERE `id`  = ?   AND {$this->is_delete} " );
			$stmt->execute(array($id));
			$result=$stmt->fetch(PDO::FETCH_ASSOC);

			$trace=new trace_site();
			$oldData=$trace->old($id,$this->folder);

			$trace->add($id,$this->folder,'delete',$result['title'],$result['title'],$oldData,'');

			$this->update_is_delete('mobile', 'id = '.$id.'');
			// $response = $this->db->delete($this->table, "`id`={$id}");

            $c_id = $this->db->prepare("SELECT `id` FROM `$this->color`  WHERE  `id_item`=?");
            $c_id->execute(array($id));

        	while($row_color =$c_id->fetch(PDO::FETCH_ASSOC))
            {
                $ids_color[]=$row_color['id'];
            }

        	$this->update_is_delete('color', 'id_item = '.$id.'');
            // $c_id_c = $c_id->fetch(PDO::FETCH_ASSOC)['id'];

            // $c = $this->db->prepare("DELETE FROM `$this->color`  WHERE  `id_item`=?");
            // $c->execute(array($id));



            for($i = 0; $i < count($ids_color); $i++){
            	$this->update_is_delete($this->code, 'id_color = '.$ids_color[$i].' AND is_delete = 0');
                // $cd = $this->db->prepare("DELETE FROM `$this->code`  WHERE  `id_color`=?");
                // $cd->execute(array($ids_color[$i]));
            }


		}
    }


    function delete_from_db_sub_item($id)
    {
        if ($this->handleLogin()) {
            $response = $this->db->delete($this->size, "`id`={$id}");
            echo 'true';
        }
    }

    function remove_color_from_db($id)
    {
        if ($this->handleLogin()) {
            // $response = $this->db->delete($this->color, "`id`={$id}");
            // echo 'true';
        	$this->update_is_delete($this->color, 'id = '.$id.'');
        }
    }

    public function ch($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE `id` = ? AND `active` = 1  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }


    public function select_category_mobile($id)
    {
        $stmt = $this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function ck_sub_cat($id)
    {
        $stmt = $this->db->prepare("SELECT * from  {$this->category} WHERE `relid`=?  AND {$this->is_delete}");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function listSubCategory($relid, $id = null)
    {

        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?  AND {$this->is_delete} ");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {
            require($this->render($this->folder, 'cat', 'sub_cat', 'php'));
        }
    }


    public function sub_cat_active($r_id, $id = null)
    {

        if ($id == null) {
            return 'close_this_mobile';
        }
        $stmt = $this->db->prepare("SELECT * from  `$this->category`  WHERE `id`=?  AND {$this->is_delete} ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($r_id == $id || $result['relid'] == $r_id) {

                return 'mobile';
            } else {
                return 'close_this_mobile';
            }

        } else {

            return 'close_this_mobile';
        }


    }


//-----------------category------------------


    function add_category($id = 0)
    {
        $this->checkPermit('add_category', 'mobile');
        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        $breadcumbs = $this->Breadcumbs($this->category, $id);
        $this->adminHeaderController($this->lang('mobile'), $id);
        $data['title'] = '';
        $data['order_cat'] = '';
        $data['code_cat'] = '';
        $data['files'] = '';

        if (isset($_POST['submit'])) {
            try {
                $form = new Form();
                $form->post('title')
                    ->val('is_empty', 'العنوان فارغ')
                    ->val('strip_tags');

                $form->post('order_cat')
                    ->val('strip_tags');

                $form->post('code_cat')
                    ->val('strip_tags');


                $form->post('files')
                    ->val('strip_tags');

                $form->submit();
                $data = $form->fetch();
                $data['relid'] = $id;
                $data['date'] = time();
                $file = new Files();

                $this->db->insert($this->category, array_diff_key($data, ['files' => "delete"]));
//             h27
//             	هنا ناخذ آيدي الفئة المضافة حتى نضيفها بعدين لجدول المزامنة
				$id_cat_h = $this->db->lastInsertId();
                if (!empty($data['files'])) {
                    $img = $file->insert_file($this->folder . '_cat', $this->db->lastInsertId(), json_decode($data['files'], True));
                    $this->db->update($this->category, array('img' => $img), "id={$this->db->lastInsertId()}");
                }

//  هنا صارت اضافة الايدي حتى ما ناثر ولا نتاثر باضافة الصورة
				$this->Add_to_sync_schedule($id_cat_h,'mobile','add_category');
                $this->lightRedirect(url . '/' . $this->folder . "/admin_category/{$id}", 0);
            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = json_decode($e->getMessage(), true);
            }

        }


        require($this->render($this->folder, 'cat', 'add', 'php'));
        $this->adminFooterController();

    }


    function edit_category($id)
    {

        $this->checkPermit('edit_category', 'mobile');
        $data = $this->db->select("SELECT * from {$this->category} WHERE `id`=:id LIMIT 1 ", array(':id' => $id));
        $data = $data[0];
        $breadcumbs = $this->Breadcumbs($this->category, $id);
        $this->adminHeaderController($this->lang($data['title']), $id);
        $idImg = 0;
        if ($data['img'] != 0) {
            $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $data['img'], ':module' => $this->folder . '_cat'));
            $get_file = $get_file[0];
            $idImg = $get_file['id'];
        }
        if (isset($_POST['submit'])) {

            try {
                $form = new Form();
                $form->post('title')
                    ->val('is_empty', 'عنوان القسم فارغ')
                    ->val('strip_tags');


                $form->post('order_cat')
                    ->val('strip_tags');

                $form->post('code_cat')
                    ->val('strip_tags');

                $form->post('files')
                    ->val('strip_tags');

                $form->submit();
                $data = $form->fetch();
                if (!empty($data['files'])) {
                    if ($idImg != 0) {
                        @unlink($this->root_file . $get_file['rand_name']);
                        $this->db->delete('files', "id={$get_file['id']}");
                    }
                    $file = new Files();
                    $data['img'] = $file->insert_file($this->folder . '_cat', $id, json_decode($data['files'], True));
                } else {
                    $data['img'] = $idImg;
                }
                if ($this->permit('save_edit_catg', $this->folder)) {
                    $this->db->update($this->category, array_diff_key($data, ['files' => "delete"]), "id={$id}");
					//                 h27
					$this->Add_to_sync_schedule($id,'mobile','add_category');
                    $this->lightRedirect(url . '/' . $this->folder . "/admin_category", 0);
                }
            } catch (Exception $e) {
                $this->error_form = json_decode($e->getMessage(), true);
            }
        }
        require($this->render($this->folder, 'cat', 'edit', 'php'));
        $this->adminFooterController();
    }


    public function visible($v_, $id_)
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


    function delete($id)
    {


        if ($this->handleLogin()) {

            $trace = new trace_site();
            $oldData = $trace->trace_category($id, $this->category);
            $trace->add($id, $this->category, 'delete', $trace->inforow($id, $this->category, 'title'), '', $oldData, '');

            // $response = $this->db->delete($this->category,"`id`={$id}");
            // echo $response;


            $this->update_is_delete($this->category, 'id = ' . $id . '');
            $stmt_item = $this->db->prepare("SELECT id FROM `mobile` where id_cat = $id ");

            $stmt_item->execute();
            if ($stmt_item->rowCount() > 0) {
                while ($row_item = $stmt_item->fetch()) {

                    $this->update_is_delete('mobile', 'id = ' . $row_item['id'] . '');
                    $this->update_is_delete('color', 'id_item = ' . $row_item['id'] . '');

                    $stmt_codes = $this->db->prepare("SELECT code FROM `code` where id_color in (select id from `color` where id_item =? )");
                    $stmt_codes->execute(array($row_item['id']));


                    while ($row_codes = $stmt_codes->fetch(PDO::FETCH_ASSOC)) {
                        $this->update_is_delete($this->code, 'code = ' . $row_codes['code'] . '');
                    }


                }
            }

            $stmt_child_cate = $this->db->prepare("SELECT id FROM `$this->category` where relid = $id AND is_delete = 0 ");
            $stmt_child_cate->execute();
            while ($row_cate = $stmt_child_cate->fetch(PDO::FETCH_ASSOC)) {
                $this->delete($row_cate['id']);
            }
            // $response = $this->db->delete($this->category,"`id`={$id}");
            $this->Add_to_sync_schedule($id, 'mobile', 'delete_category');

        }

    }


    function delete_image_cat($id)
    {

        $response = $this->db->update($this->category, array('img' => 0), "`id`={$id}");
        echo $response;
    }


    public function get_all_category()
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE  `active` =? AND `relid`=0  AND {$this->is_delete} ORDER BY `id` ASC ");
        $stmt->execute(array(1));
        return $stmt;
    }

    public function getAllmobileFromContent($id_cat = array(), $limit)
    {


        $Id_cat = implode(',', $id_cat);

        $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE   {$this->table}.`id_cat`  !=0 AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->table}.`bast_it` = 1  AND {$this->table}.is_delete=0 group by   {$this->table}.`id`  ORDER BY {$this->table}.`id` DESC  LIMIT $limit  ");


        $stmt->execute();
        return $stmt;
    }

    public function getAllContent()
    {
        //TODO   جيك اذا المادة بيها سعر لو لا او موجود الباركود مالتها
        $stmt = $this->db->prepare("SELECT * FROM `{$this->table}` WHERE   `active` = 1  AND {$this->is_delete} ORDER BY `id` DESC LIMIT 5");
        $stmt->execute();
        return $stmt;
    }


    public function getImage($id, $limit)
    {
        $stmt = $this->db->prepare("SELECT `id`,`img`,`code_color` FROM `{$this->color}` WHERE   `id`= ?   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getImageAndColor($id, $limit)
    {
        $stmt = $this->db->prepare("SELECT *FROM `{$this->color}` WHERE   `id_item`= ?   LIMIT $limit ");
        $stmt->execute(array($id));
        return $stmt;
    }


    public function getPrice($id, $limit, $price_dollars)
    {

        $stmt = $this->db->prepare("SELECT `code`,`size` FROM `{$this->code}` WHERE   `id_color`= ?     ");
        $stmt->execute(array($id));

        $arr_code = array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $arr_code[] = $row;
        }

		/*AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0    */
        $stop = false;
        foreach ($arr_code as $code) {
            $stmt2 = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?  AND    `quantity` <> '' AND  `quantity` <> 0   AND  `quantity`  >  0      LIMIT 1 ");
            $stmt2->execute(array($code['code']));
            if ($stmt2->rowCount() > 0) {
                $stop = true;
                $result_ = $stmt2->fetch(PDO::FETCH_ASSOC);

                if ($this->loginUser()) {

                    $price = $this->price_dollarsAdmin($result_['price_dollars']);

                    return array('price' => $price, 'price_dollars' => $result_['price_dollars'], 'size' => $code['size'], 'code' => $code['code'], 'quantity' => $result_['quantity']);
                } else {
                    if ($price_dollars == 1) {
                        $price = $this->price_dollars($result_['price_dollars']);
                    } else {
                        $price = $result_['price'];
                    }

                    return array('price' => $price, 'price_dollars' => $result_['price_dollars'], 'size' => $code['size'], 'code' => $code['code'], 'quantity' => $result_['quantity']);

                }
                break;
            } else {
                continue;
            }

        }

        if ($stop == false) {
            $stmt = $this->db->prepare("SELECT `code`,`size` FROM `{$this->code}` WHERE   `id_color`= ?   LIMIT 1 ");
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            $stmt2 = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?   LIMIT 1 ");
            $stmt2->execute(array($result['code']));
            $result_ = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($this->loginUser()) {
                $price = $this->price_dollarsAdmin($result_['price_dollars']);
                return array('price' => $price, 'price_dollars' => $result_['price_dollars'], 'size' => $result['size'], 'code' => $result['code'], 'quantity' => $result_['quantity']);
            } else {
                if ($price_dollars == 1) {
                    $price = $this->price_dollars($result_['price_dollars']);
                } else {
                    $price = $result_['price'];
                }
                return array('price' => $price, 'price_dollars' => $result_['price_dollars'], 'size' => $result['size'], 'code' => $result['code'], 'quantity' => $result_['quantity']);
            }

        }


    }



    public function smt_ch_q($code)
    {

        $stmt = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?   AND  `quantity` > 0");
        $stmt->execute(array($code));
        return $stmt;
    }

    public function smt_ch_code($code)
    {

        $stmt = $this->db->prepare("SELECT *FROM `{$this->excel}` WHERE   `code`= ?    ");
        $stmt->execute(array($code));
        if($stmt->rowCount()>0)
        {
			return true;
        }else{
            return false;
        }

    }

    public function select_category_mobile_public($id)
    {
        $stmt = $this->db->prepare("SELECT * from  `$this->category` WHERE `relid`=?  AND `active`=1  AND {$this->is_delete} ORDER BY `order_cat` ASC ");
        $stmt->execute(array($id));
        return $stmt;
    }

    public function select_category_mobile_publicAll()
    {
        $stmt = $this->db->prepare("SELECT * from  `$this->category` WHERE      `active`=1  AND {$this->is_delete} ");
        $stmt->execute();
        return $stmt;
    }

    public function ck_sub_cat_public($id)
    {
        $stmt = $this->db->prepare("SELECT * from   `$this->category`  WHERE `relid`=?  AND `active`=1   AND {$this->is_delete} ORDER BY `order_cat` ASC");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function listSubCategoryMenu($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?   AND `active`=1  AND {$this->is_delete} ORDER BY `order_cat` ASC");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {


            if ($this->ck_sub_cat_public($row['id'])) { ?>

                <li class="dropdown-submenu rotate_this_active">
                    <a class="dropdown-item dropdown-toggle"
                       href="<?php echo url . '/' . $this->folder ?>/list_view/<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a>
                    <ul class="dropdown-menu">
                        <?php $this->listSubCategoryMenu($row['id']); ?>
                    </ul>
                </li>
            <?php } else { ?>
                <li class="dropdown-submenu">
                    <a class="dropdown-item"
                       href="<?php echo url . '/' . $this->folder ?>/list_view/<?php echo $row['id'] ?>"><?php echo $row['title'] ?></a>
                </li>
            <?php }
        } ?>


        <?php

    }


    public function listSubCategoryMenu2($relid)
    {
        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?   AND `active`=1  AND {$this->is_delete}  ORDER BY `order_cat` ASC");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {


            if ($this->ck_sub_cat_public($row['id'])) { ?>


                <div class="sub_cat">
                    <div class="custom-control custom-checkbox">
                        <input value="<?php echo $row['id'] ?>" type="checkbox" id="cat_<?php echo $row['id'] ?>"
                               name="id_cat[]" class="custom-control-input">
                        <label class="custom-control-label"
                               for="cat_<?php echo $row['id'] ?>"><?php echo $row['title'] ?></label>
                    </div>

                    <?php $this->listSubCategoryMenu2($row['id']); ?>
                </div>

            <?php } else { ?>
                <div class="sub_cat">
                    <div class="custom-control custom-checkbox">
                        <input value="<?php echo $row['id'] ?>" type="checkbox" id="cat_<?php echo $row['id'] ?>"
                               name="id_cat[]" class="custom-control-input">
                        <label class="custom-control-label"
                               for="cat_<?php echo $row['id'] ?>"><?php echo $row['title'] ?></label>
                    </div>
                </div>

            <?php }
        } ?>


        <?php

    }


    public function listSubCategoryMenu_acc($relid)
    {

        $stmt = $this->db->prepare("SELECT * FROM `{$this->category}` WHERE relid = ?   AND `active`=1  AND {$this->is_delete} ORDER BY `order_cat` ASC");
        $stmt->execute(array($relid));
        while ($row = $stmt->fetch()) {


            if ($row['img'] != 0) {
                $get_file = $this->db->select("SELECT * from `files` WHERE `id`=:id AND `module`=:module LIMIT 1 ", array(':id' => $row['img'], ':module' => 'mobile_cat'));
                $get_file = $get_file[0];
                $row['image'] = '<img class="ion_catg" src="' . $this->save_file . $get_file['rand_name'] . '">';

            } else {
                $row['image'] = '<i class="fa fa-mobile"></i>';
            }

            if ($this->ck_sub_cat_public($row['id'])) { ?>


                <div id="accordion_sub_<?php echo $row['id'] ?>">
                    <div class="card row_accordion">
                        <div class="card-header" id="headingOne1<?php echo $row['id'] ?>">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-<?php if ($this->ck_sub_cat_public($row['id'])) echo 8; else echo 12; ?>">
                                    <a class="list_link"
                                       href="<?php echo url ?>/mobile/list_view/<?php echo $row['id'] ?>">
                                        <div class="row align-items-center">
                                            <div class="col-auto"
                                                 style="padding-left: 3px">  <?php echo $row['image'] ?> </div>
                                            <div class="col-8"
                                                 style="padding-right: 3px"> <?php echo $row['title'] ?> </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-4">
                                    <button class="btn btn_open_accordion collapsed" data-toggle="collapse"
                                            href="#collapseOne1<?php echo $row['id'] ?>" aria-expanded="false"
                                            aria-controls="collapseOne1<?php echo $row['id'] ?>">
                                        <i class="fa fa-caret-left"></i>
                                    </button>
                                </div>
                            </div>

                            <div id="collapseOne1<?php echo $row['id'] ?>" class="collapse"
                                 data-parent="#accordion_sub_<?php echo $row['id'] ?>"
                                 aria-labelledby="headingOne1<?php echo $row['id'] ?>">
                                <div class="card-body">

                                    <div class="card row_accordion">

                                        <?php $this->listSubCategoryMenu_acc($row['id']); ?>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php } else { ?>


                <div id="accordion_sub_<?php echo $row['id'] ?>">
                    <div class="card row_accordion">
                        <div class="card-header" id="headingOne1<?php echo $row['id'] ?>">
                            <div class="row justify-content-between align-items-center">
                                <div class="col-<?php if ($this->ck_sub_cat_public($row['id'])) echo 8; else echo 12; ?>">
                                    <a class="list_link"
                                       href="<?php echo url ?>/mobile/list_view/<?php echo $row['id'] ?>">
                                        <div class="row align-items-center">
                                            <div class="col-auto"
                                                 style="padding-left: 3px"> <?php echo $row['image'] ?></div>
                                            <div class="col-<?php if ($this->ck_sub_cat_public($row['id'])) echo 8; else echo 10 ?>"
                                                 style="padding-right: 3px">  <?php echo $row['title'] ?> </div>
                                        </div>
                                    </a>
                                </div>
                                <?php if ($this->ck_sub_cat_public($row['id'])) { ?>
                                    <div class="col-4">
                                        <button class="btn btn_open_accordion collapsed" data-toggle="collapse"
                                                href="#collapseOne1<?php echo $row['id'] ?>" aria-expanded="false"
                                                aria-controls="collapseOne1<?php echo $row['id'] ?>">
                                            <i class="fa fa-caret-left"></i>
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>

                        </div>
                    </div>
                </div>

            <?php }
        } ?>


        <?php

    }


    function getAllItemByIdCat($id, $limit = 5)
    {

    }


    function remove_row_database($id)
    {
        if ($this->handleLogin()) {
            // $c = $this->db->prepare("DELETE FROM `$this->color`  WHERE  `id`=?");
            // $c->execute(array($id));

            // $c = $this->db->prepare("DELETE FROM `$this->code`  WHERE  `id_color`=?");
            // $c->execute(array($id));
         	 $this->update_is_delete($this->color, 'id = '.$id.'');
			 $this->update_is_delete($this->code, 'id_color = '.$id.'');

            echo true;
        }
    }


    function remove_sub_row_database($id)
    {
        if ($this->handleLogin()) {

            // $c = $this->db->prepare("DELETE FROM `$this->code`  WHERE  `id`=?");
            // $c->execute(array($id));

        	  $this->update_is_delete($this->code, 'id = '.$id.'');

            echo true;
        }
    }


    public function getAllContentFromCar_new($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`offers`,`id_offer` FROM `{$this->cart_shop}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `id_item`, `table`,`number_bill`  ORDER BY `id`  DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }


    function car_item($id, $count)
    {


        $error = array();

        if (!is_numeric($id)) {
            $error = new Errors();
            $error->index();
        }
        if (!is_numeric($count)) {
            $error = new Errors();
            $error->index();
        }


        if (!empty($_POST['size'])) {
            $size = strip_tags($_POST['size']);
        } else {
            $error['size'] = 'يجب تحديد القياس';
        }


        if (!empty($_POST['color'])) {
            $color = strip_tags($_POST['color']);
        } else {
            $error['color'] = 'يجب تحديد الون';
        }


        $data['id_item'] = $id;
        if (!$this->isDirect()) {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        } else {
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }
        $data['number'] = $count;
        $data['date'] = time();


        if (empty($error)) {
            $number = preg_replace('~\D~', '', $data['number']);
            $stmt_ch = $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `id`=?  AND `quantity` >= {$number}  AND `quantity` <> 0  AND `quantity` <> '' ");
            $stmt_ch->execute(array($size));


            if ($stmt_ch->rowCount() > 0) {

                $stmt = $this->db->prepare("SELECT * from `{$this->excel}` WHERE  `id`=?  ");
                $stmt->execute(array($size));
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop` WHERE `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?");
                $stmt_order->execute(array($result['code'], $this->table, $data['id_member_r']));
                $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
                $q = $result['quantity'] - $only_order['num'];

                if ($q >= $number) {


                    $stmt_code = $this->db->prepare("SELECT * from `{$this->code}` WHERE  `code`=?  ");
                    $stmt_code->execute(array($result['code']));
                    $result_code = $stmt_code->fetch(PDO::FETCH_ASSOC);


					$stmt_color = $this->db->prepare("SELECT * from `{$this->color}` WHERE  `img`=?  ");
					$stmt_color->execute(array($color));
					$result_color = $stmt_color->fetch(PDO::FETCH_ASSOC);


                    $data['code'] = $result_code['code'];
                    $data['size'] = $result_code['size'];
                    $data['image'] = $color;
                    $data['color'] = $result_color['code_color'];
                    $data['name_color'] = $result_color['color'];


                    $stmt_item = $this->db->prepare("SELECT * from `{$this->table}` WHERE  `id`=?  ");
                    $stmt_item->execute(array($id));
                    $result_item = $stmt_item->fetch(PDO::FETCH_ASSOC);


                    if ($result_item['cuts'] == 1) {
                        $data['price'] = $result_item['price_cuts'];
                    } else {
                        if ($this->loginUser()) {

                            $data['price'] = $this->price_dollarsAdmin($result['price_dollars']);


                        } else {
                            if ($result_item['price_dollars'] == 1) {
                                $data['price'] = $this->price_dollars($result['price_dollars']);
                            } else {
                                $data['price'] = $result['wholesale_price'];
                            }

                        }

                    }


					$dollar=new Dollar_price();
					$data['dollar_exchange']=$dollar->dollar_get();

					$dollar=new Dollar_price();
					$data['dollar_exchange']=$dollar->dollar_get();
					$data['price_dollars'] = $result['price_dollars'];
                    $data['table'] = $this->table;

					$stmt_chx = $this->db->prepare("SELECT   *FROM `cart_shop` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?  AND  price_type=0 ");
					$stmt_chx->execute(array($data['id_item'],$data['code'], $this->table, $data['id_member_r']));
					if ($stmt_chx->rowCount() > 0)
					{
						$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop` SET `number`=number+? WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?  AND  price_type=0 ");
						$stmtUpdate_cart->execute(array($data['number'],$data['id_item'],$data['code'], $this->table, $data['id_member_r']));
					}else{
						$this->db->insert($this->cart_shop, $data);
					}


                 } else {
                    echo json_encode(array(3 => "الكمية غير متوفرة الان تتوفر قريبا ."), 1);
                }

            } else {

                echo json_encode(array(3 => "الكمية غير متوفرة الان تتوفر قريبا ."), 1);
            }
        } else {
            echo json_encode(array(1 => $error), 1);
        }


    }


    function cart_order()
    {

        $data = json_decode($_GET['jsonData'], true);

        if (!$this->isDirect()) {
            $data['id_member_r'] = $_SESSION['id_member_r'];
        } else {
            $data['id_member_r'] = $this->isUuid();
            $data['user_direct'] = $this->userid;
        }

        if (isset($data['number']))
        {
            if (is_numeric($data['number']))
            {
                $data['number'] =strip_tags($data['number']);
            }else
            {
                $data['number'] = 1;
            }
        }else
        {
            $data['number'] = 1;
        }

        $data['date'] = time();

        $stmt_ch = $this->db->prepare("SELECT * from `{$this->excel}` WHERE    `code`= ?    AND  `quantity` > 0  AND `quantity` <> 0  AND `quantity` <> '' ");
        $stmt_ch->execute(array($data['code']));
        if ($stmt_ch->rowCount() > 0) {


            $price_2D = $stmt_ch->fetch(PDO::FETCH_ASSOC);
            $stmt_order = $this->db->prepare("SELECT   SUM(`number`)as num,`dollar_exchange`  FROM `cart_shop` WHERE `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?");
            $stmt_order->execute(array($data['code'], $this->table, $data['id_member_r']));
            $only_order = $stmt_order->fetch(PDO::FETCH_ASSOC);
            $q = $price_2D['quantity'] - $only_order['num'];

            if ($q >= $data['number']) {

                $data['table'] = $this->table;
                $stmt_item = $this->db->prepare("SELECT * from `{$this->table}` WHERE  `id`=?   AND {$this->is_delete}");
                $stmt_item->execute(array($data['id_item']));
                $result_item = $stmt_item->fetch(PDO::FETCH_ASSOC);


                if ($this->loginUser()) {

                    $data['price'] = $this->price_dollarsAdmin($price_2D['price_dollars']);

                } else {
                   $data['price'] = $this->price_dollars($price_2D['price_dollars']);
                }


                $stmt_id_color = $this->db->prepare("SELECT  {$this->color}.*,{$this->code}.size from `{$this->code}` INNER  JOIN  {$this->color} ON {$this->color}.id ={$this->code}.id_color WHERE  `code`=?  ");
                $stmt_id_color->execute(array($data['code']));
                $result_id_color = $stmt_id_color->fetch(PDO::FETCH_ASSOC);

                $data['size'] = $result_id_color['size'];
                $data['image'] = $result_id_color['img'];

                $data['color'] = $result_id_color['code_color'];
                $data['name_color'] = $result_id_color['color'];

				$dollar=new Dollar_price();
				$data['dollar_exchange']=$dollar->dollar_get();


				if ($this->ch_wcprice())
                {

                    if ($data['price_type'] == 1) {
                        $data['price_dollars'] = $price_2D['wholesale_price'];

                    } else if ($data['price_type'] == 2) {
                        $data['price_dollars'] = $price_2D['wholesale_price2'];

                    } else if ($data['price_type'] == 3) {
                        $data['price_dollars'] = $price_2D['cost_price'];
                    } else {
                        $data['price_dollars'] = $price_2D['price_dollars'];
                    }
                }else
                {
                    $data['price_dollars'] = $price_2D['price_dollars'];
                }


				$stmt_chx = $this->db->prepare("SELECT   * FROM `cart_shop` WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ?  AND  price_type=?  ");
				$stmt_chx->execute(array($data['id_item'],$data['code'], $this->table, $data['id_member_r'],$data['price_type']));
                if ($stmt_chx->rowCount() > 0)
                {
					$stmtUpdate_cart=$this->db->prepare("UPDATE `cart_shop` SET `number`=number+1 WHERE `id_item` =?  AND `code` =?  AND  `buy` = 0 AND `status` = 0    AND `table`=?  AND  `id_member_r` = ? AND  price_type=?");
					$stmtUpdate_cart->execute(array($data['id_item'],$data['code'], $this->table, $data['id_member_r'],$data['price_type']));
                }else{
					$this->db->insert($this->cart_shop, $data);
                }


                if ($this->isDirect()) {
                    $id = $this->isUuid();
                } else {
                    $id = $_SESSION['id_member_r'];
                }

             } else {
                echo 'finish';
            }

        } else {
            echo 'finish';
        }


    }


    function count_c()
    {

        if ($this->isDirect()) {
            $id = $this->isUuid();
        } else {
            $id = $_SESSION['id_member_r'];
        }

        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`, `number`,`buy`,`date` FROM `{$this->cart_shop}` WHERE `id_member_r` =?  AND `buy` = 0 GROUP BY `offers`,`id_offer`,`date`,`date`  ORDER BY `id`  DESC  ");
        $stmt->execute(array($id));
        $car = array();
        $count = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $count = $count + $row['number'];
        }

        echo $count;

    }


//    ------------edit buy---------

    public function getAllContentFromCar($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`number_bill`,`dollar_exchange` FROM `{$this->cart_shop}` WHERE `id_member_r` =?  AND   `buy` = 1 AND `status` =0  GROUP BY `id_item`,`table`,`code`,`color` ORDER BY `id` DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }

    public function getAllContentFromCar_old($id_member_r)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_req`,`mpx`,`dollar_exchange` FROM `{$this->cart_shop}` WHERE `id_member_r` =?  AND `buy` = 2  AND  `status`=1 GROUP BY `id_item`,`table`,`code`,`color`  ORDER BY `id` DESC  ");
        $stmt->execute(array($id_member_r));
        return $stmt;
    }

//    --------------------------


    public function getAllContentFromCarMost_req($id_member_r, $bill)
    {

        $stmt = $this->db->prepare("SELECT * FROM `{$this->cart_shop}` WHERE    `buy` = 2 AND `status` =1 AND `delivered` =0 AND `id_member_r`=? AND `number_bill`=?     ORDER BY `date_d_r` ASC ");
        $stmt->execute(array($id_member_r, $bill));

        return $stmt;


    }




//    -----------delivery_user  in class register ---------

    public function getAllContentFromCar_details_client_delivery_user_date_d_r($id_user)
    {
        $stmt = $this->db->prepare("SELECT  `date_req`,`date_d_r`,`number_bill`,`id_member_r`  FROM `{$this->cart_shop}` WHERE `delivery_user` =?  AND   `buy` = 2 AND `status` =1 AND `delivered`=0 AND `delivery_user` <> 0 AND `number_bill` <> 0  GROUP BY `date_d_r`,`id_member_r`  ORDER BY `date_d_r` ASC ");
        $stmt->execute(array($id_user));
        return $stmt;
    }

    public function getAllContentFromCar_details_client_delivery_user($id_member_r, $date_d_r, $id_user)
    {
        $stmt = $this->db->prepare("SELECT `id`, `id_item`,`size`,`price`,`price_dollars`,`image`,`color`,`name_color`,`code`,`table`,SUM(`number`)as number,`buy`,`date`,`date_d_r`,`mpx` FROM `{$this->cart_shop}` WHERE `id_member_r` =?  AND   `buy` = 2 AND `status` =1   AND `date_d_r`= ?  AND `delivery_user` =?  GROUP BY `id_item`,`table`,`code`,`date_d_r`,`id_member_r`  ORDER BY `id` DESC  ");
        $stmt->execute(array($id_member_r, $date_d_r, $id_user));
        return $stmt;
    }

//    -----------delivery_user  in class register ---------


    /*---------------------prepared_requests in class delivery_user ------------*/
    public function getAllContentFromCar_details_client_done_prepared_requests()
    {

        if ($this->permit('customize_requests_for_delivery_staff', 'delivery_user')) {
            if (Session::get('role') == 'admin') {
                $stmt = $this->db->prepare("SELECT  `date_d_r`,`id_member_r`,`delivery_user`,`number_bill`  FROM `{$this->cart_shop}` WHERE    `buy` = 2 AND `status` =1 AND `delivered` =0  GROUP BY `number_bill`,`id_member_r`   ORDER BY `date_d_r` ASC ");
                $stmt->execute();
            } else {

                $stmt = $this->db->prepare("SELECT  `date_d_r`,`id_member_r`,`delivery_user`,`number_bill`  FROM `{$this->cart_shop}` WHERE    `buy` = 2 AND `status` =1 AND `delivered` =0 AND `delivery_user`=? GROUP BY `number_bill`,`id_member_r`   ORDER BY `date_d_r` ASC ");
                $stmt->execute(array(Session::get('userid')));
            }

        } else {
            $stmt = $this->db->prepare("SELECT  `date_d_r`,`id_member_r`,`delivery_user`,`number_bill`  FROM `{$this->cart_shop}` WHERE    `buy` = 2 AND `status` =1 AND `delivered` =0  GROUP BY `number_bill`,`id_member_r`   ORDER BY `date_d_r` ASC ");
            $stmt->execute();
        }

        return $stmt;
    }

    /*------------------*/


    public function like_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $stmt = $this->db->prepare("INSERT INTO  `{$this->like_mobile}` (`id_device`,`id_member_r`,`like`,`date`) value (?,?,?,?)  ");
            $stmt->execute(array($id, $_SESSION['id_member_r'], 1, time()));
            echo 'done';
        } else {
            echo '404';
        }
    }

    public function unlike_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $stmt = $this->db->prepare("DELETE FROM  `{$this->like_mobile}` WHERE `id_device`=? AND `id_member_r`=? ");
            $stmt->execute(array($id, $_SESSION['id_member_r']));
            echo 'done';
        } else {
            echo '404';
        }
    }

    public function ckeckLick($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            $stmt = $this->db->prepare("SELECT * FROM `{$this->like_mobile}` WHERE `id_member_r` =?  AND `id_device` =  ? ");
            $stmt->execute(array($_SESSION['id_member_r'], $id));
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }


    function range()
    {

		$mix=0;
		$max=0;

        $max_range =str_replace($this->comma,'', $_POST['max_range']);
        $min_range = str_replace($this->comma,'', $_POST['min_range']);
        $catRg = $_POST['catRg'];

        if (is_numeric($max_range) && is_numeric($min_range)) {

            if($min_range==0)
            {
				$mix =  '1';
            }
            else{
				$mix =  $min_range.'000';
            }

             $max =  $max_range.'000';
        }


		$stmt = $this->db->prepare("SELECT  `code` FROM `{$this->excel}` WHERE   (`range1`>= {$mix}  AND range1 <= {$max})  OR  (`range2`>= {$mix}  AND range2 <= {$max}) ");
		$stmt->execute();
		$code = array();
		$code_color = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

			$stmtColor = $this->db->prepare("SELECT  `id_color` FROM `{$this->code}` WHERE  `code`   = ?   ");
			$stmtColor->execute(array($row['code']));
			if ($stmtColor->rowCount() > 0){
				$list_id_color=$stmtColor->fetch(PDO::FETCH_ASSOC);
				$code_color[] = $list_id_color['id_color'];
			}
			$code[]=$row['code'];

		}


        $id_color = implode(',', $code_color);
        $stmtItem = $this->db->prepare("SELECT  `id_item` FROM `{$this->color}` WHERE  `id`  IN ({$id_color})  ");
        $stmtItem->execute();
        $id_item = array();
        while ($rowC = $stmtItem->fetch(PDO::FETCH_ASSOC)) {
            $id_item[] = $rowC['id_item'];
        }


        $Id_item = implode(',', $id_item);

        if (abs(is_numeric($catRg)) && abs(is_numeric($catRg))) {
            $Id_cat = implode(',', $this->getLoopId($catRg));
            $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id`  IN ({$Id_item})   AND `active` = 1  AND `id_cat`  IN ({$Id_cat}) AND {$this->bast_it} AND {$this->is_delete}  ORDER BY `id` DESC  ");
        } else {
            $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id`  IN ({$Id_item})   AND `active` = 1 AND {$this->bast_it} AND {$this->is_delete} ORDER BY `id` DESC  ");
        }
        $stmt->execute();

        $data_view = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $idItemC = array();

            $stmtIdItC = $this->numberItems($row['id']);
            while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
                $idItemC[] = $rowiIdIt;
            }

            if (!empty($idItemC)) {

                foreach ($idItemC as $idItc) {
                    $stmt_img_id = $this->getImage($idItc['id'], 1);

                    $row['image'] = $this->save_file . $stmt_img_id['img'];

                    $stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);

                    if (in_array($stmt_price['code'], $code)) {

						if ($this->smt_ch_code($stmt_price['code'])) {
							$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
							if ($smt_ch_q->rowCount() > 0) {
								$row['q'] = 1;
							} else {
								$row['q'] = 0;
							}


							$row['priceC'] = $stmt_price['price'];
							$row['price'] = $stmt_price['price'] . ' د.ع ';

							$row['size'] = $stmt_price['size'];
							$row['code'] = $stmt_price['code'];
							$row['code_color'] = $stmt_img_id['code_color'];
							$row['nameImage'] = $stmt_img_id['img'];

							$row['like'] = $this->ckeckLick($row['id']);
							$row['comparison'] = $this->check_comparison($row['id']);
							$data_view[$row['id']] = $row;
							if ($smt_ch_q->rowCount() > 0) {
								break;
							}
						}
                    }
                }

            }


        }


        require($this->render($this->folder, 'html', 'range', 'php'));


    }


    public function comparison_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $stmt = $this->db->prepare("INSERT INTO  `{$this->comparison}` (`id_device`,`id_member_r`,`comparison`,`date`) value (?,?,?,?)  ");
            $stmt->execute(array($id, $_SESSION['id_member_r'], 1, time()));
            echo 'done';
        } else {
            echo '404';
        }
    }

    public function un_comparison_d($id)
    {
        if (isset($_SESSION['username_member_r'])) {

            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }
            $stmt = $this->db->prepare("DELETE FROM  `{$this->comparison}` WHERE `id_device`=? AND `id_member_r`=? ");
            $stmt->execute(array($id, $_SESSION['id_member_r']));
            echo 'done';
        } else {
            echo '404';
        }
    }

    public function check_comparison($id)
    {
        if (isset($_SESSION['username_member_r'])) {
            $stmt = $this->db->prepare("SELECT * FROM `{$this->comparison}` WHERE `id_member_r` =?  AND `id_device` =  ? ");
            $stmt->execute(array($_SESSION['id_member_r'], $id));
            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

    }


    public function filter()
    {

        if (isset($_REQUEST['specifications'])) {
            $myArray = $_REQUEST['specifications'];


            $arrayIds = array();
            foreach ($myArray as $xidz) {
                $arrayIds[] = $xidz[0];
            }

            $id_cat = $_POST['catgFilter'];


            $fieldDetails = null;
            foreach ($arrayIds as $w) {
                if (abs($w)) {
                    $fieldDetails .= " specifications LIKE '%{$w}%' AND ";
                }

            }

            $fieldDetails = rtrim($fieldDetails, 'AND ');
            if ($id_cat == 'all') {

                $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE  ({$fieldDetails})   AND  `active` = 1 AND {$this->bast_it} AND {$this->is_delete} ORDER BY `id` DESC  ");
                $stmt->execute();
            } else {
                $Id_cat = implode(',', $this->getLoopId($id_cat));
                $stmt = $this->db->prepare("SELECT *FROM `{$this->table}` WHERE `id_cat`  IN ({$Id_cat})  AND   ({$fieldDetails})  AND  `active` = 1 AND {$this->bast_it}  AND {$this->is_delete} ORDER BY `id` DESC  ");
                $stmt->execute(array($id_cat));
            }


            $data_view = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

                $idItemC = array();

                $stmtIdItC = $this->numberItems($row['id']);
                while ($rowiIdIt = $stmtIdItC->fetch(PDO::FETCH_ASSOC)) {
                    $idItemC[] = $rowiIdIt;
                }

                if (!empty($idItemC)) {

                    foreach ($idItemC as $idItc) {
                        $stmt_img_id = $this->getImage($idItc['id'], 1);

                        $row['image'] = $this->save_file . $stmt_img_id['img'];

                        $stmt_price = $this->getPrice($stmt_img_id['id'], 1, $row['price_dollars']);


						if ($this->smt_ch_code($stmt_price['code'])) {
							$smt_ch_q = $this->smt_ch_q($stmt_price['code']);
							if ($smt_ch_q->rowCount() > 0) {
								$row['q'] = 1;
							} else {
								$row['q'] = 0;
							}

							$row['priceC'] = $stmt_price['price'];
							$row['price'] = $stmt_price['price'] . ' د.ع ';


							$row['size'] = $stmt_price['size'];
							$row['code'] = $stmt_price['code'];
							$row['code_color'] = $stmt_img_id['code_color'];
							$row['nameImage'] = $stmt_img_id['img'];

							$row['like'] = $this->ckeckLick($row['id']);
							$row['comparison'] = $this->check_comparison($row['id']);

							$data_view[$row['id']] = $row;
							if ($smt_ch_q->rowCount() > 0) {
								break;
							}
						}
                    }

                }


            }

            if (!empty($arrayIds)) {
                require($this->render($this->folder, 'html', 'range', 'php'));

            }

        }

    }


    function quantity()
    {

		$this->checkPermit('export_excel', $this->folder);
		$this->adminHeaderController($this->langControl($this->folder).' '.date('Y-m-d',time()));


        $stmt = $this->db->prepare("SELECT * from  {$this->category} WHERE    {$this->is_delete}");
        $stmt->execute();
        $data_cat=array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

            $data_cat[] = $row;
        }

        $id='all';
        $from_price=null;
        $to_price=null;

        if (isset($_GET['id']))
        {
            $id=$_GET['id'];
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



    public function processing_quantity($id)
    {
        $this->checkPermit('view_quantity', $this->folder);
        $table = $this->code;
        $primaryKey = $table . '.id';
        $tableJoin = $table . '.';

        $columns = array(


            array('db' => $this->category.'.id', 'dt' => 0,
              'formatter' => function( $d, $row ) {
                return  $this->name_category($d,$this->category);
            }
            ),
            array('db' => $this->category.'.title', 'dt' => 1),
            array('db' => $this->table.'.title', 'dt' => 2),
            array('db' => $this->color.'.color', 'dt' => 3),
            array('db' => $tableJoin . 'code', 'dt' => 4),
            array('db' => $tableJoin . 'serial', 'dt' =>5  ,
                'formatter' => function( $d, $row ) {
                    return  str_replace(',','-',$d);
                }
            ),
            array('db' => $this->excel.'.quantity', 'dt' => 6),
            array('db' => $this->excel.'.price_dollars', 'dt' => 7),
            array('db' =>$this->color.'.img', 'dt' => 8,
               'formatter' => function( $d, $row ) {
                   return "<img  src='".$this->save_file.$d."' style='width: 150px;border: 1px solid gainsboro;'>";
               }
            ),
            array(
                'db' =>   $this->table.'.id',
                'dt' => 9,
                'formatter' => function ($id, $row) {
                    return "

                   <div style='text-align: center;font-size: 23px;'>
                    <a href=" . url .'/'.$this->folder. "/edit_".$this->folder."/$id> <i class='fa fa-pencil-square-o' aria-hidden='true'></i> </a>
                    </div> ";
                }
            ),
            array(
                'db' =>   $this->table.'.id_device',
                'dt' => 10,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>    'menu_link_device_acc_cover.name_device','dt' => 11  ),

            array(
                'db' =>   $this->table.'.specifications',
                'dt' => 12,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>   $this->table.'.description',
                'dt' => 13,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>   $this->table.'.tags',
                'dt' => 14,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
                }
            ),
            array(
                'db' =>   $this->table.'.bast_it',
                'dt' => 15,
                'formatter' => function ($id, $row) {
                    if (trim($id))
                    {
                        return "<span style='color: green;font-size: 30px;font-weight: bold;'>√</span>";
                    }else
                    {
                        return "<span  style='color: red;font-size: 24px;font-weight: bold'>Χ</span>";

                    }
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


        if ($id=='all' && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {
            $join = " inner JOIN {$this->color} ON {$this->code}.id_color = {$this->color}.id  inner JOIN {$this->table} ON {$this->color}.id_item = {$this->table}.id   inner JOIN {$this->category} ON {$this->category}.id = {$this->table}.id_cat     LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = {$this->table}.id_device     LEFT JOIN {$this->excel} ON {$this->code}.code = {$this->excel}.code ";
            $whereAll = array(" {$this->table}.is_delete = 0 ");
        }else if ($id=='all' && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $join = " inner JOIN {$this->color} ON {$this->code}.id_color = {$this->color}.id  inner JOIN {$this->table} ON {$this->color}.id_item = {$this->table}.id    inner JOIN {$this->category} ON {$this->category}.id = {$this->table}.id_cat   LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = {$this->table}.id_device   LEFT JOIN {$this->excel} ON {$this->code}.code = {$this->excel}.code ";
            $whereAll = array(" {$this->table}.is_delete = 0 ","{$this->excel}.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");
        }else if (is_numeric($id)  && empty($_GET['from_price']) && empty($_GET['to_price']) )
        {

           $ids=implode(',', $this->getLoopId($id));

            $join = " inner JOIN {$this->color} ON {$this->code}.id_color = {$this->color}.id  inner JOIN {$this->table} ON {$this->color}.id_item = {$this->table}.id    inner JOIN {$this->category} ON {$this->category}.id = {$this->table}.id_cat   LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = {$this->table}.id_device  LEFT JOIN {$this->excel} ON {$this->code}.code = {$this->excel}.code ";
            $whereAll = array(" {$this->table}.is_delete = 0 ","{$this->table}.id_cat IN({$ids})");
        }else   if (is_numeric($id)  && !empty($_GET['from_price']) && !empty($_GET['to_price']) )
        {
            $ids=implode(',', $this->getLoopId($id));

            $join = " inner JOIN {$this->color} ON {$this->code}.id_color = {$this->color}.id  inner JOIN {$this->table} ON {$this->color}.id_item = {$this->table}.id    inner JOIN {$this->category} ON {$this->category}.id = {$this->table}.id_cat   LEFT JOIN  menu_link_device_acc_cover ON menu_link_device_acc_cover.id = {$this->table}.id_device  LEFT JOIN {$this->excel} ON {$this->code}.code = {$this->excel}.code ";
            $whereAll = array(" {$this->table}.is_delete = 0 ","{$this->table}.id_cat IN({$ids})","{$this->excel}.price_dollars BETWEEN {$_GET['from_price']} AND {$_GET['to_price']}");
        }





            echo json_encode(

            SSP::complex_join($_GET, $sql_details, $table, $primaryKey, $columns, $join, null, $whereAll));

    }




//    function check_specifications($id)
//    {
//
//
//        $stmt=$this->db->prepare("SELECT  specifications.id  FROM `specifications` INNER  JOIN specifications_item ON specifications_item.id_specif  = specifications.id  WHERE `specifications_item`.item = ? AND `specifications`.model = ? LIMIT 1");
//        $stmt->execute(array($id,$this->folder));
//        if ($stmt->rowCount()>0)
//        {
//            return true;
//        }else
//        {
//            return false;
//        }
//
//    }



    function name_accessories()
    {
        if ($this->handleLogin())
        {
			$q=trim(strip_tags($_GET['q']));
			$q = '%' . $q . '%';
			$stmt=$this->db->prepare("SELECT *FROM `category_accessories` WHERE `title` LIKE ? AND `active`=1 LIMIT 15");
			$stmt->execute(array($q));

			$html=null;

			while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
				$html.="<a href='#' onclick='thisCatAcc(this)' data-id='{$row['id']}'  data-title='{$row['title']}' class='list-group-item list-group-item-action'>{$row['title']}</a>";
            }

			echo $html;

        }

    }




    function name_savers()
    {
        if ($this->handleLogin())
        {
			$q=trim(strip_tags($_GET['q']));
			$q = '%' . $q . '%';
			$stmt=$this->db->prepare("SELECT *FROM `type_device` WHERE `title` LIKE ? AND `active`=1 LIMIT 15");
			$stmt->execute(array($q));

			$html=null;

			while ($row=$stmt->fetch(PDO::FETCH_ASSOC))
            {
				$html.="<a href='#' onclick='thisCatSav(this)' data-id='{$row['id']}'  data-title='{$row['title']}' class='list-group-item list-group-item-action'>{$row['title']}</a>";
            }

			echo $html;

        }

    }





    function acc()
    {
        $stmt=$this->db->prepare("SELECT  id,title FROM mobile WHERE  {$this->is_delete}");
		$stmt->execute();

		$data=array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {

			$q='%' . $row['title'] . '%';
            $ac= $this->db->prepare("SELECT id,title FROM category_accessories WHERE  title LIKE ? ");
            $ac->execute(array($q));
            if ($ac->rowCount() > 0 )
            {
				$xcco=$ac->fetch(PDO::FETCH_ASSOC);
				$row['id_acc']=$xcco['id'];
				$row['title_acc']=$xcco['title'];


				$stmtUp=$this->db->prepare("UPDATE mobile SET id_accessories=? ,name_accessories=? WHERE `id` = ?");
				$stmtUp->execute(array($row['id_acc'],$row['title_acc'],$row['id']));
				if ($stmtUp->rowCount()>0)
                {
					$data[]=$row;
                }
            }

        }


    }


    function rprice()
    {

        if (isset($_POST['submit']))
        {
            $idExcel=$_POST['idExcel'];
            $qr=$_POST['qr'];

            $stmtqr=$this->db->prepare("SELECT *FROM user WHERE hash=?");
            $stmtqr->execute(array($qr));
            if ($stmtqr->rowCount() > 0)
            {


				$stmt=$this->db->prepare("SELECT  {$this->excel}.price_dollars  FROM {$this->excel} WHERE id=?  LIMIT 1 ");
				$stmt->execute(array($idExcel));
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




	function  unknown()
	{
		$this->checkPermit('unknown',$this->folder);
		$this->adminHeaderController($this->langControl('add'));
		$data_cat = $this->db->select("SELECT * from  {$this->category}");
		foreach ($data_cat as $key => $d_cat) {

			$data_cat[$key] = $d_cat;
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


                            if (count($rowData[0])  >= 5  ) {


                                $point='';
                                if (isset($rowData[0][5]))
                                {
                                    $point =$rowData[0][5];
                                }


                                $ch_code = $this->db->prepare("SELECT * FROM  {$this->code}   WHERE `code`=? ");
                                $ch_code->execute(array($rowData[0][2]));
                                if ($ch_code->rowCount() < 1) {




                                    $stmt = $this->db->prepare("SELECT * FROM {$this->table}  WHERE `title`=?");
                                    $stmt->execute(array($rowData[0][0]));
                                    if ($stmt->rowCount() > 0) {
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);



                                        $stmtc = $this->db->prepare("SELECT * FROM {$this->color}  WHERE `id_item`=? AND color=?");
                                        $stmtc->execute(array($result['id'], trim($rowData[0][1])));
                                        if ($stmtc->rowCount() > 0) {
                                            $resultc = $stmtc->fetch(PDO::FETCH_ASSOC);

                                            $stmt_in = $this->db->prepare("INSERT INTO  {$this->code} (`code`,`size`,`id_color`,`date`,`point`) VALUES(?,?,?,?,?)");
                                            $stmt_in->execute(array($rowData[0][2], $rowData[0][3], $idc, time() + 1,$point));

                                        } else {


                                            $stmt_in_c = $this->db->prepare("INSERT INTO  {$this->color}  (`color`,`id_item`,`img`,`date`) VALUES(?,?,?,?)");
                                            $stmt_in_c->execute(array($rowData[0][1], $result['id'], 'alixcol' . $this->uuid(55) . '.png', time() + 1));
                                            if ($stmt_in_c->rowCount() > 0) {
                                                $idc = $this->db->lastInsertId();

                                                $stmt_in = $this->db->prepare("INSERT INTO  {$this->code} (`code`,`size`,`id_color`,`date`,`point`) VALUES(?,?,?,?,?)");
                                                $stmt_in->execute(array($rowData[0][2], $rowData[0][3], $idc, time() + 1,$point));

                                            }

                                        }
                                        $trace=new trace_site();
                                        $newData=$trace->neaw($result['id'],$this->folder);
                                        $trace->add($result['id'],$this->folder,'رفع سريع','',$rowData[0][0],'',$newData);

                                    } else {

                                        $stmt_in_m = $this->db->prepare("INSERT INTO {$this->table}  (`id_cat`,`title`,`description`,`active`,`price_dollars`,`date`,`userid`) VALUES(?,?,?,?,?,?,?)");
                                        $stmt_in_m->execute(array($data['cat'], $rowData[0][0], $rowData[0][4], 1, 1, time() + 1,$this->userid));
                                        if ($stmt_in_m->rowCount() > 0) {
                                            $idm = $this->db->lastInsertId();



                                            $stmt_in_c = $this->db->prepare("INSERT INTO  {$this->color}  (`color`,`id_item`,`img`,`date`) VALUES(?,?,?,?)");
                                            $stmt_in_c->execute(array($rowData[0][1], $idm, 'alixcol' . $this->uuid(55) . '.png', time() + 1));
                                            if ($stmt_in_c->rowCount() > 0) {
                                                $idc = $this->db->lastInsertId();

                                                $stmt_in = $this->db->prepare("INSERT INTO  {$this->code} (`code`,`size`,`id_color`,`date`,`point`) VALUES(?,?,?,?,?)");
                                                $stmt_in->execute(array($rowData[0][2], $rowData[0][3], $idc, time() + 1,$point));

                                            }
                                            $trace=new trace_site();
                                            $newData=$trace->neaw($idm,$this->folder);
                                            $trace->add($idm,$this->folder,'رفع سريع','',$rowData[0][0],'',$newData);


                                        }

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
					$this->lightRedirect(url.'/'.$this->folder."/list_".$this->folder."/".$data['cat']);

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','unknown','php'));
		$this->adminFooterController();
	}




	function  barcode()
	{
		$this->checkPermit('other_barcode',$this->folder);
		$this->adminHeaderController($this->langControl('other_barcode'));

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

					$stmtserial = $this->db->prepare("UPDATE  code SET  `serial`= '' ");
					$stmtserial->execute();


					//  Loop through each row of the worksheet in turn

					for ($row = 1; $row <= $highestRow; $row++) {
						//  Read a row of data into an array
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
							NULL,
							TRUE,
							TRUE);


						if (count($rowData[0])  >= 2)
						{

							$rowData[0][0];
							$stmtc=$this->db->prepare("SELECT *FROM code WHERE code=?  ");
							$stmtc->execute(array(trim($rowData[0][0])));
							if ($stmtc->rowCount()>0)
							{

//							    if ($rowData[0][1])
//                                {
//                                    $stmtcode = $this->db->prepare("UPDATE  code SET  `serial`= case WHEN  serial = '' THEN  {$rowData[0][1]}  WHEN  serial <> '' THEN CONCAT(serial,',',{$rowData[0][1]}) END  WHERE  code=?");
//                                    $stmtcode->execute(array($rowData[0][0]));
//                                }



                                $serial=trim($rowData[0][1]);
                                if ($serial)
                                {
                                    $stmtcode = $this->db->prepare("UPDATE  code SET  `serial`=  {$serial}    WHERE  code=?");
                                    $stmtcode->execute(array($rowData[0][0]));
                                }



                            }else
                            {
                                continue;
                            }

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
					$this->lightRedirect(url.'/'.$this->folder."/list2_mobile");

				}


			} catch (Exception $e) {
				$data =$form -> fetch();
				$this->error_form=$e -> getMessage();

			}


		}

		require ($this->render($this->folder,'html','barcode','php'));
		$this->adminFooterController();
	}



    public function list_model_connect()
    {

        $this->checkPermit('list_model_connect', $this->folder);
        $this->adminHeaderController($this->langControl('list_model_connect'));


        require($this->render($this->folder, 'connect', 'index', 'php'));
        $this->adminFooterController();

    }



    public function processing_connect()
    {


        $table = $this->category_connect;
        $primaryKey = 'id';

        $columns = array(


            array('db' => 'title', 'dt' => 0),

            array(
                'db' => 'id',
                'dt' => 1,
                'formatter' => function ($id, $row) {
                    if ($this->permit('visible_connect',$this->folder)) {
                        return "
                <div style='text-align: center'>
                  <input {$this->ch_connect($id)} class='toggle-demo' onchange='visible_connect(this,$id)' type='checkbox' data-on='On' data-off='Off' id='toggle-event'    data-toggle='toggle' data-style='ios' data-onstyle='success' data-size='small'>
                 </div>
             ";  }
                    else
                    {
                        return $this->langControl('forbidden');
                    }
                }
            ),


            array('db' => 'date', 'dt' =>2,
                'formatter' => function ($d, $row) {
                    return date('Y-m-d ', $d);
                }

            ),

            array(
                'db' => 'id',
                'dt' => 3,
                'formatter' => function ($id, $row) {
                    if ($this->permit('delete_connect_connect',$this->folder)) {
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
            array('db' => 'id', 'dt' => 4)


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

    public function ch_connect($id)
    {

        $stmt = $this->db->prepare("SELECT * FROM {$this->category_connect} WHERE `id` = ? AND `active` = 1 ");
        $stmt->execute(array($id));
        if ($stmt->rowCount() > 0) {
            return 'checked';
        } else {
            return '';
        }
    }

    public function visible_connect($v_, $id_)
    {
        if (is_numeric($v_) && is_numeric($id_)) {
            $v = $v_;
            $id = $id_;
        } else {
            $v = 0;
            $id = 0;
        }
        $data = $this->db->update($this->category_connect, array('active' => $v), "`id`={$id}");
    }

    public function add_connect()
    {


        $this->checkPermit('add_connect', $this->folder);
        $this->adminHeaderController($this->langControl('add_connect'));


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

                        $stmt = $this->db->prepare("SELECT `title` FROM `{$this->category}` WHERE  `id`=? AND  {$this->is_delete} ");
                        $stmt->execute(array($d));
                        $dev = $stmt->fetch(PDO::FETCH_ASSOC);
                        $title[] = $dev['title'];

                    }


                    $data['title'] = implode(' // ', $title);
                    $data['ids'] = implode(',', $ids);


                    $id_add=$this->db->insert($this->category_connect,$data);

                }
                $this->lightRedirect(url.'/'.$this->folder."/list_model_connect",0);


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


    function search()
    {
        if ($this->handleLogin()) {
            $data = $_GET['q'];
            $data = '%' . $data . '%';
            $stmt = $this->db->prepare("SELECT * FROM `{$this->category}`  WHERE title LIKE ?   AND  {$this->is_delete}   ");
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

    function catg_info($id)
    {
        if ($this->handleLogin()) {
            if (!is_numeric($id)) {
                $error = new Errors();
                $error->index();
            }

            $stmt = $this->db->prepare("SELECT `title` FROM `{$this->category}` WHERE  `id`=?  AND  {$this->is_delete} ");
            $stmt->execute(array($id));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $result['title'];
        }
    }


    function delete_connect($id)
    {
        if ($this->handleLogin() ) {
            $response = $this->db->delete($this->category_connect, "`id`={$id}");
        }
    }


    function index_data($id)
    {
        if (!is_numeric($id))
        {
            die('404');
        }

        $category_mobile=array();


        $c=1;
        $this->ids=array();
        $row['content']=array();

            $stmt_content = $this->getAllmobileFromContent($this->getLoopId($id), 4);



            while ($row_cont = $stmt_content->fetch(PDO::FETCH_ASSOC)) {


                $stmtIdItC = $this->get_color($row_cont['id']);
                if ($stmtIdItC->rowCount() > 0) {

                    $details= $stmtIdItC->fetch(PDO::FETCH_ASSOC);

                    if ($this->loginUser()) {
                        $row_cont['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                        $row_cont['price'] =$row_cont['priceC'] . ' د.ع ';

                        $row_cont['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                        $row_cont['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                        $row_cont['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';


                    } else {
                        if ($row_cont['price_dollars'] == 1) {
                            $row_cont['priceC'] = $this->price_dollars($details['price_dollars']);
                            $row_cont['price'] =  $row_cont['priceC']  . ' د.ع ';

                            $row_cont['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                            $row_cont['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                            $row_cont['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';

                        } else {
                            $row_cont['priceC'] = $details['price'];
                            $row_cont['price'] = $details['price'] . ' د.ع ';
                        }
                    }

                    if (trim($details['quantity']) > 0) {
                        $row_cont['q'] = 1;
                    } else {
                        $row_cont['q'] = 0;
                    }

                    $row_cont['size'] = $details['size'];
                    $row_cont['code'] = $details['code'];
                    $row_cont['code_color'] = $details['code_color'];
                    $row_cont['nameImage'] = $details['img'];
                    $row_cont['like'] = $this->ckeckLick($row_cont['id']);
                    $row_cont['comparison'] = $this->check_comparison($row_cont['id']);
                    $row_cont['image'] = $this->save_file . $details['img'];

                    $row['content'][$row_cont['id']] = $row_cont;

                }

            }
            $row['content'] = array_chunk($row['content'], 4);
            $category_mobile[] = $row;



                require($this->render($this->folder, 'html', 'index_data', 'php'));


    }




    function load_desc($id=null)
    {

        $item_per_page = 8;

        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);


        if (is_numeric($id)) {

            $stmt_ch = $this->db->prepare("SELECT `ids` FROM `{$this->category_connect}` WHERE   FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
            $stmt_ch->execute(array($id));
            if ($stmt_ch->rowCount()>0)
            {
                $result2 = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                $Id_cat=$result2['ids'];
                $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE     {$this->table}.`id_cat`  IN ({$Id_cat}) AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND  {$this->table}.is_delete=0  group by   {$this->table}.`id`  ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))  DESC   LIMIT $position,$item_per_page");
                $stmt->execute();

            }else{

                $Id_cat = implode(',', $this->getLoopId($id));
                $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE     {$this->table}.`id_cat`  IN ({$Id_cat}) AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND   {$this->table}.is_delete=0   group by   {$this->table}.`id`   ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))  DESC  LIMIT $position,$item_per_page");
                $stmt->execute(array($id));

            }


        } else {
            $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE      {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND  {$this->table}.is_delete=0   group by   {$this->table}.`id`  ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))  DESC  LIMIT $position,$item_per_page");
            $stmt->execute();
        }


        $table = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmtIdItC = $this->get_color($row['id']);
            if ($stmtIdItC->rowCount() > 0) {

                $details= $stmtIdItC->fetch(PDO::FETCH_ASSOC);

                if ($this->loginUser()) {
                    $row['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                    $row['price'] =$row['priceC'] . ' د.ع ';


                    $row['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                    $row['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                    $row['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';




                } else {
                    if ($row['price_dollars'] == 1) {
                        $row['priceC'] = $this->price_dollars($details['price_dollars']);
                        $row['price'] =  $row['priceC']  . ' د.ع ';


                        $row['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                        $row['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                        $row['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';



                    } else {
                        $row['priceC'] = $details['price'];
                        $row['price'] = $details['price'] . ' د.ع ';
                    }
                }

                if (trim($details['quantity']) > 0) {
                    $row['q'] = 1;
                } else {
                    $row['q'] = 0;
                }

                $row['size'] = $details['size'];
                $row['code'] = $details['code'];
                $row['code_color'] = $details['code_color'];
                $row['nameImage'] = $details['img'];
                $row['like'] = $this->ckeckLick($row['id']);
                $row['comparison'] = $this->check_comparison($row['id']);
                $row['image'] = $this->save_file . $details['img'];

                $table[] = $row;

            }

        }


        require ($this->render($this->folder,'html','data','php'));

    }




    function load_asc($id=null)
    {

        $item_per_page = 8;

        //sanitize post value
        $page_number = filter_var($_POST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

        if(!is_numeric($page_number)){
            header('HTTP/1.1 500 Invalid page number!');
            exit();
        }
        $position = (($page_number-1) * $item_per_page);


        if (is_numeric($id)) {

            $stmt_ch = $this->db->prepare("SELECT `ids` FROM `{$this->category_connect}` WHERE   FIND_IN_SET(?,`ids`)  AND  active=1 LIMIT 1");
            $stmt_ch->execute(array($id));
            if ($stmt_ch->rowCount()>0)
            {
                $result2 = $stmt_ch->fetch(PDO::FETCH_ASSOC);
                $Id_cat=$result2['ids'];
                $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE     {$this->table}.`id_cat`  IN ({$Id_cat}) AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND   {$this->table}.is_delete=0   group by   {$this->table}.`id`  ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))  ASC   LIMIT $position,$item_per_page");
                $stmt->execute();

            }else{

                $Id_cat = implode(',', $this->getLoopId($id));
                $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE     {$this->table}.`id_cat`  IN ({$Id_cat}) AND  {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it} AND   {$this->table}.is_delete=0   group by   {$this->table}.`id`   ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))  ASC  LIMIT $position,$item_per_page");
                $stmt->execute(array($id));

            }


        } else {
            $stmt=$this->db->prepare("SELECT {$this->table}.id, {$this->table}.price_dollars,{$this->table}.stop,{$this->table}.title,{$this->table}.price_cuts,{$this->table}.bast_it,{$this->table}.cuts,{$this->table}.description  FROM {$this->table} INNER JOIN {$this->color} ON  {$this->color}.id_item={$this->table}.id INNER JOIN {$this->code} ON {$this->code}.id_color= {$this->color}.id INNER JOIN {$this->excel} ON {$this->excel}.code = {$this->code}.code WHERE      {$this->table}.`active` = 1  AND {$this->table}.`stop`=0     AND {$this->bast_it}  AND  {$this->table}.is_delete=0   group by   {$this->table}.`id`  ORDER BY CAST({$this->excel}.`price_dollars` as DECIMAL(25,15))  ASC  LIMIT $position,$item_per_page");
            $stmt->execute();
        }


        $table = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $stmtIdItC = $this->get_color($row['id']);
            if ($stmtIdItC->rowCount() > 0) {

                $details= $stmtIdItC->fetch(PDO::FETCH_ASSOC);

                if ($this->loginUser()) {
                    $row['priceC'] = $this->price_dollarsAdmin($details['price_dollars']);
                    $row['price'] =$row['priceC'] . ' د.ع ';

                    $row['wholesale_price'] = $this->price_dollarsAdmin($details['wholesale_price']). ' د.ع ';
                    $row['wholesale_price2'] = $this->price_dollarsAdmin($details['wholesale_price2']). ' د.ع ';
                    $row['cost_price'] = $this->price_dollarsAdmin($details['cost_price']). ' د.ع ';


                } else {

                        $row['priceC'] = $this->price_dollars($details['price_dollars']);
                        $row['price'] =  $row['priceC']  . ' د.ع ';


                        $row['wholesale_price'] = $this->price_dollars($details['wholesale_price']). ' د.ع ';
                        $row['wholesale_price2'] = $this->price_dollars($details['wholesale_price2']). ' د.ع ';
                        $row['cost_price'] = $this->price_dollars($details['cost_price']). ' د.ع ';

                }

                if (trim($details['quantity']) > 0) {
                    $row['q'] = 1;
                } else {
                    $row['q'] = 0;
                }

                $row['size'] = $details['size'];
                $row['code'] = $details['code'];
                $row['code_color'] = $details['code_color'];
                $row['nameImage'] = $details['img'];
                $row['like'] = $this->ckeckLick($row['id']);
                $row['comparison'] = $this->check_comparison($row['id']);
                $row['image'] = $this->save_file . $details['img'];

                $table[] = $row;

            }
        }


        require ($this->render($this->folder,'html','data','php'));

    }


    function check_code()
    {

        if($this->handleLogin())
        {
            $code=trim($_GET['code']);
            $stmt=$this->db->prepare("SELECT *FROM {$this->code} WHERE code =? ");
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



    public function active()
    {

        $this->checkPermit('active_location_and_enter_serial',$this->folder);
        $this->adminHeaderController($this->langControl('active'));
        $data_cat=$this->db->select("SELECT * from  {$this->category} WHERE   {$this->is_delete} ");
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
                $stmt=$this->db->prepare("UPDATE {$this->table} SET location=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE {$this->table}  SET enter_serial=?,userId=?  ");
                $stmt->execute(array($ls,$this->userid));
            }

        }else
        {


            $Id_cat = implode(',', $this->getLoopId($cat));

            if ($type=='location')
            {
                $stmt=$this->db->prepare("UPDATE {$this->table} SET location=? ,userId=? WHERE id_cat IN({$Id_cat})");
                $stmt->execute(array($ls,$this->userid));
            }else if ($type=='serial'){
                $stmt=$this->db->prepare("UPDATE {$this->table} SET enter_serial=? ,userId=?  WHERE id_cat IN({$Id_cat})");
                $stmt->execute(array($ls,$this->userid));
            }

        }

        echo 1;

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


                            $stmtc = $this->db->prepare("SELECT * FROM {$this->code}  WHERE  `code`=?");
                            $stmtc->execute(array(trim($rowData[0][0])));
                            if ($stmtc->rowCount() > 0) {

                                $stmt_point = $this->db->prepare("UPDATE {$this->code}  SET  point=?   WHERE code = ?  ");
                                $stmt_point->execute(array($rowData[0][1], $rowData[0][0]));
                                if ($stmt_point->rowCount() > 0 )
                                {


                                    $stmt = $this->db->prepare("SELECT  {$this->table}.* FROM {$this->table} INNER  JOIN  {$this->color} ON  {$this->color}.id_item  = {$this->table}.id  INNER  JOIN  {$this->code} ON  {$this->code}.id_color  = {$this->color}.id WHERE  {$this->code}.code=? LIMIT 1");
                                    $stmt->execute(array($rowData[0][0] ));
                                    if ($stmt->rowCount() > 0) {
                                        $result = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $trace=new trace_site();
                                        $newData=$trace->neaw($result['id'],$this->folder);
                                        $trace->add($result['id'],$this->folder,'رفع نقاط المادة','',$result['title'],'',$newData);

                                    }



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
                    $this->lightRedirect(url.'/'.$this->folder."/list2_".$this->folder);

                }


            } catch (Exception $e) {
                $data =$form -> fetch();
                $this->error_form=$e -> getMessage();

            }


        }

        require ($this->render($this->folder,'html','point','php'));
        $this->adminFooterController();
    }





}




