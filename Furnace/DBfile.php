<?php

class ScrapRpt extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "furnace";
    private $dbHost = "localhost";

    public static function getInstance() {
        if (!self::$instance instanceof self) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    // The clone and wakeup methods prevents external instantiation of copies of the Singleton class,
    // thus eliminating the possibility of duplicate objects.
    public function __clone() {
        trigger_error("Clone is not allowed.", E_USER_ERROR);
    }

    public function __wakeup() {
        trigger_error("Deserializing is not allowed.", E_USER_ERROR);
    }

    // private constructor
    public function __construct() {
        parent::__construct($this->dbHost, $this->user, $this->pass, $this->dbName);
        if (mysqli_connect_error()) {
            exit('Connect Error (' . mysqli_connect_errno() . ') '
                    . mysqli_connect_error());
        }
        parent::set_charset('utf-8');
    }
    
    public function get_furnace_id($furnace) {
        $furnaceid = $this->real_escape_string($furnace);
         //echo $furnacename;
        $s1 = $this->query("SELECT furnacename FROM furnace WHERE furnaceid ='".$furnaceid."'");
        if ($s1->num_rows > 0) {
            
            $r1=$s1->fetch_row();
            return $r1[0];
        } else{
            return 0;
        }
        
    }
    
    public function get_Stock_value($scrapid,$date) {
        $scrap_id = $this->real_escape_string($scrapid);
        $scrap_date = $this->real_escape_string($date);
        $show_date = DateTime::createFromFormat('d/m/Y', $scrap_date)->format('Y-m-d');
        echo $show_date; echo $scrap_id;
            //echo $furnacename;
        $s1 = $this->query("SELECT stock FROM `scrap register` WHERE scrapid ='".$scrap_id."' and Date='".$show_date."'");
        if ($s1->num_rows > 0) {
            
            $r1=$s1->fetch_row();
            return $r1[0];
        } else{
            return 0;
        }
        
    }
    
    
     
}