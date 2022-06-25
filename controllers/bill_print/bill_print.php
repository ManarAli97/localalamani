<?php

class bill_print extends Controller
{


    function __construct()
    {
        parent::__construct();
        $this->table = 'print';
        $this->menu = new Menu();

    }

    public function createTB()
    {

        $this->db->query("CREATE TABLE IF NOT EXISTS `{$this->table}` (
          `id` int(11)  NOT NULL AUTO_INCREMENT ,
          `bill` longtext COLLATE utf8_unicode_ci NOT NULL,
          `id_group` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `group` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `print` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
          `number_copy` int(11) NOT NULL,
          `userid` int(11) NOT NULL,
          `date` bigint(20) NOT NULL,
           PRIMARY KEY (`id`)
     ) ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


        return $this->db->cht(array($this->table ));


    }

    function index()
    {
        if ($this->handleLogin())
        {
           $html=$_POST['bill'];
           $stmt=$this->db->prepare("INSERT INTO {$this->table} (`bill`,`id_group`,`group`,`userid`,`print`,`date`,`number_copy`) VALUES(?,?,?,?,?,?,?)");
           $stmt->execute(array($html,Session::get('idGroup'),$this->check_other_code_in_cart_shop($this->userid),$this->userid,Session::get('print'),time(),Session::get('number_copy')));
            if ($stmt->rowCount() > 0)
            {
               echo 'true';
            }
        }
    }



}