<?php

class search_serial extends Controller
{

    public $ids = array();


    function __construct()
    {
        parent::__construct();
        $this->table = 'cart_shop';

    }



    function index()
    {
        $this->checkPermit('search_serial','search_serial');
        $this->adminHeaderController($this->langControl('search_serial'));




        require ($this->render($this->folder,'html','index','php'));
        $this->adminFooterController();
    }

    function get()
    {

        if ($this->handleLogin())
        {
            $val=$_GET['value'];
        }

		$q = '[[:<:]]'.$val.'[[:>:]]';

        $stmt=$this->db->prepare("SELECT *FROM `{$this->table}` WHERE `enter_serial`   REGEXP ?  ");
        $stmt->execute(array($q));
        $data=array();

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {


			if (!empty($this->cuts($row['id_item'],$row['table'])))
			{
				$row['price']=  $this->cuts($row['id_item'],$row['table']).' د.ع ';
			}else
			{
				$row['price']= $this->price_dollarsAdmin($row['price_dollars'],$row['dollar_exchange']).' د.ع ';
			}
            $data []=$row;
        }

        require ($this->render($this->folder,'html','data','php'));
    }


}