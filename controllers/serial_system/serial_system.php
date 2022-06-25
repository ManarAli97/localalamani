<?php
require_once "report_serial_entry/report_serial_entry.php";
require_once "report_serial_cases/report_serial_cases.php";
require_once "spare_code/spare_code.php";
require_once "serial_conform/serial_conform.php";
require_once "serial_material_inventory/serial_material_inventory.php";
require_once "jard/jard.php";
class serial_system extends Controller
{

    protected $list_serial_system='';

    use report_serial_entry,report_serial_cases,spare_code,serial_conform,serial_material_inventory,jard;
    function __construct()
    {
        parent::__construct();
        $this->table='serial_system';
        $this->serial_page='serial_page';
        $this->serial='serial';
        $this->serial_delete='serial_delete';
        $this->spare_code='spare_code';
        $this->serial_conform='serial_conform';
        $this->jard='jard';
        $this->jard_page='jard_page';
        $this->jard_delete ='jard_delete';
        $this->setting=new Setting();

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
          `serial_system` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
          `length` int(11) NOT NULL ,
           `lang` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
           `type` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");





        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_page}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");





        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `time_taken` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_delete}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `bill` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->spare_code}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `color` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `size` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `spare_code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `id_item` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->serial_conform}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `type` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");






        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard_page}` (
           `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");




        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `excel_quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `from_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `to_date` bigint(10) COLLATE utf8_unicode_ci NOT NULL,  
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->jard_delete}` (
          `id` int(10) NOT NULL AUTO_INCREMENT ,
           `page` int(11) NOT NULL ,
           `code` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `serial` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `type_enter` varchar(250) COLLATE utf8_unicode_ci NOT NULL,   
           `quantity` bigint(20) NOT NULL,
           `excel_quantity` bigint(20) NOT NULL,
           `model` varchar(250) COLLATE utf8_unicode_ci NOT NULL,  
           `userId` int(11) NOT NULL ,
           `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");



        return  $this->db->cht(array($this->table,$this->serial,$this->serial_delete,$this->spare_code,$this->serial_conform,$this->jard_page,$this->jard,$this->jard_delete));

    }

    public function index(){ $index =new Index(); $index->index();}




    function list_serial_system()
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }


    function generation_serial()
    {

        $this->checkPermit('generation_serial',$this->folder);

        $this->adminHeaderController($this->langControl($this->folder));

        require ($this->render($this->folder,'html','list','php'));
        $this->adminFooterController();

    }


    function generation()
    {

        $this->checkPermit('generation',  $this->folder);
        $this->adminHeaderController($this->langControl('generation'));

        $data['length'] = '';
        $data['number'] = '';
        $data['code'] = '';

        if (isset($_POST['submit'])) {
            try {

                $form = new  Form();


                $form->post('code')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');
                $form->post('length')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('number')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');

                $form->post('type')
                    ->val('digit', $this->langControl('required'))
                    ->val('strip_tags');


                $form->submit();
                $data = $form->fetch();

                $num=$data['number'];

                $data['userid'] = $this->userid;
                $data['date'] = time();

                for($i=1 ; $i <=$num ; $i++)
                {

                    if ($data['type'] == 1)
                    {
                        $srel= $this->generateNumber($data['length']);
                    }else if ($data['type'] == 2)
                    {
                        $srel= $this->generateChar($data['length']);
                    }else
                    {
                        $srel= $this->generateCharNumb($data['length']);
                    }

                    $stmtCh=$this->db->prepare("SELECT * FROM serial_system WHERE serial_system =? ");
                    $stmtCh->execute(array($srel));
                    if ($stmtCh->rowCount() <= 0)
                    {
                        $stmt=$this->db->prepare("INSERT INTO `serial_system` (`code`,`serial_system`,`length`,`userid`,`date`,`type`) VALUE (?,?,?,?,?,?) ");
                        $stmt->execute(array($data['code'],$srel,$data['length'],$this->userid,time(),$data['type']));
                    }

                }

                $this->lightRedirect(url . '/' . $this->folder . "/generation_serial", 0);


            } catch (Exception $e) {
                $data = $form->fetch();
                $this->error_form = $e->getMessage();
            }

        }
        require($this->render($this->folder, 'html', 'add', 'php'));
        $this->adminFooterController();

    }





    function generateNumber($h)
    {

        $alphabet = '0123456789';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    function generateChar($h)
    {

        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }


    function generateCharNumb($h)
    {

        $alphabet = 'abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $h; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }



    public function processing()
    {


        $table = $this->table;
        $primaryKey = $table.'.id';

        $columns = array(

            array( 'db' => $table.'.code', 'dt' => 0 ),
            array( 'db' => $table.'.serial_system', 'dt' => 1 ),
            array( 'db' => $table.'.length', 'dt' => 2 ),
            array( 'db' => 'user.username', 'dt' => 3 ),

            array( 'db' =>  $table.'.date', 'dt' => 4 ,
                'formatter' => function ($id, $row) {
                    return date('Y-m-d h:i:s a',$id);
                }
            ),

            array(  'db' =>   $table.'.id', 'dt'=> 5)


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


    function delete_all()
    {
        if ($this->handleLogin()) {
            $this->checkPermit('delete_all', $this->folder);
            $stmt = $this->db->prepare("TRUNCATE TABLE `{$this->table}` ");
            $stmt->execute();
            echo 1;
        }
    }




    function print_serial()
    {

        $this->checkPermit('print_serial', $this->folder);
        $this->adminHeaderController($this->langControl($this->folder));

        $stmt = $this->db->prepare("SELECT *FROM serial_system ");
        $stmt->execute();
        $print = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $print[]=$row;
        }

        $print=array_chunk($print,4);

        require ($this->render($this->folder,'html','print','php'));
        $this->adminFooterController();

    }







}