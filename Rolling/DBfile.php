<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RollingBD extends mysqli {

    // single instance of self shared among all instances
    private static $instance = null;
    // db connection config vars
    private $user = "root";
    private $pass = "";
    private $dbName = "rolling";
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

    public function get_size_id($sizeid) {
        $sizeid = $this->real_escape_string($sizeid);

        $size1 = $this->query("SELECT sizename FROM size WHERE id = " . $sizeid);
        //echo $size[0];

        if ($size1->num_rows > 0) {
            $row = $size1->fetch_row();
            // print_r($row );die;
            return $row[0];
        } else
            return 0;
        //return $this->query("SELECT id FROM size WHERE sizename = " . $m1size);
    }
     
    

 public function get_department_id($department) {
        $department = $this->real_escape_string($department);

           
        $size = $this->query("SELECT dname FROM department WHERE departmentid = " . $department);
        //echo $size[0];

        if ($size->num_rows > 0) {
            $row = $size->fetch_row();
            // print_r($row );die;
            return $row[0];
        } else
            return 0;
        //return $this->query("SELECT id FROM size WHERE sizename = " . $m1size);
    }
    public function get_person_id($responsible_person) {
        $responsible_person = $this->real_escape_string($responsible_person);

        $size = $this->query("SELECT name FROM person WHERE personid = " . $responsible_person);
        //echo $size[0];

        if ($size->num_rows > 0) {
            $row = $size->fetch_row();
            // print_r($row );die;
            return $row[0];
        } else
            return 0;
        //return $this->query("SELECT id FROM size WHERE sizename = " . $m1size);
    }
     public function get_location_id($location_code) {
        $location_code = $this->real_escape_string($location_code);

        $size = $this->query("SELECT locationname FROM location WHERE locationid = " . $location_code);
        //echo $size[0];

        if ($size->num_rows > 0) {
            $row = $size->fetch_row();
            // print_r($row );die;
            return $row[0];
        } else
            return 0;
        //return $this->query("SELECT id FROM size WHERE sizename = " . $m1size);
    }
    
    public function get_reason_id($reasonid) {
        $reasonid = $this->real_escape_string($reasonid);

        $size = $this->query("SELECT reason_code FROM reason WHERE reasonid = " . $reasonid);
        //echo $size[0];

        if ($size->num_rows > 0) {
            $row = $size->fetch_row();
            // print_r($row );die;
            return $row[0];
        } else
            return 0;
        //return $this->query("SELECT id FROM size WHERE sizename = " . $m1size);
    }

    
    public function get_roughing_mr_prod_mill1($kpidate,$heatnumber,$m1s) {
        $kpi_date = $this->real_escape_string($kpidate);
         $heatnumber = $this->real_escape_string($heatnumber);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        echo $show_date;
      
       $m1s= $this->real_escape_string($m1s);
        echo "<br>";
        $s1 = $this->query("SELECT sum(mr_production) FROM  breakdown  WHERE 
                date ='".$show_date."'and m1s='".$m1s."' and location_code in(7,8,12)and heat_number='".$heatnumber."' ");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }
    
      public function get_roughing_mr_prod_mill2($kpidate,$heatnumber,$m2s) {
        $kpi_date = $this->real_escape_string($kpidate);
        $heatnumber = $this->real_escape_string($heatnumber);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        echo $show_date;
      
       $m2s= $this->real_escape_string($m2s);
        echo "<br>";
        $s1 = $this->query("SELECT sum(mr_production) FROM  breakdown  WHERE 
               date ='".$show_date."' and  m2s='".$m2s."' and  location_code in(9,10,13,14) and heat_number='".$heatnumber."' ");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }
    
    public function get_cutting_prod_mill1($kpidate,$heatnumber,$m1s) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
          $heatnumber = $this->real_escape_string($heatnumber);
        echo $show_date;
      
       $m1s= $this->real_escape_string($m1s);
        echo "<br>";
        $s1 = $this->query("SELECT sum(cutting_wt) FROM breakdown   WHERE 
          date ='".$show_date."'and m1s= '".$m1s."' and heat_number='".$heatnumber."' and location_code in(7,8,12) ");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }
    public function get_cutting_prod_mill2($kpidate,$heatnumber,$m2s) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
          $heatnumber = $this->real_escape_string($heatnumber);
        echo $show_date;
       $m2s= $this->real_escape_string($m2s);
        echo "<br>";
        $s1 = $this->query("SELECT sum(cutting_wt) FROM breakdown  WHERE 
                 date ='".$show_date."' and m2s='".$m2s."' and heat_number='".$heatnumber."' and  location_code in(9,10,13) ");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }
    
    
    public function get_heat_count($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        echo "<br>";
        $s1 = $this->query("SELECT count(`heat-number`) FROM per_heat_production WHERE perheatdate = '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
           
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else
            return 0;
    }
     public function get_rolling_prod($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       // echo $kpi_date;
        //echo $show_date;
        echo "<br>";
        $s1 = $this->query("SELECT sum(rollingprod) FROM per_heat_production WHERE perheatdate = '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
           
            $r1 = $s1->fetch_row();
            
            return $r1[0];
           
        } else{
            return 0;
        }
    }

    public function get_ccm_prod($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       // echo $kpi_date;
        //echo $show_date;
        echo "<br>";
        $s1 = $this->query("SELECT sum(ccmprod) FROM per_heat_production WHERE perheatdate = '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();   
            return $r1[0];
           
        } else{
            return 0;
        }
            }
//TIME_FORMAT((SUM(`total-heat-time`)),'%H:%i')
    
            //select  TIME_FORMAT((SUM(`bd_total_time`)),'%H:%i') from breakdown where date ='".$reading_date."'
            
           public function get_heat_running_time($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       // echo $kpi_date;
        //echo $show_date;
        echo "<br>";
        $s1 = $this->query("select SEC_TO_TIME(SUM(TIME_TO_SEC(`total-heat-time`))) from per_heat_production WHERE perheatdate = '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();   
            return $r1[0];
           
        } else{
            return 0;
        }
            
           } 
            
         public function get_billets_bypass($kpidate, $department) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        $department = $this->real_escape_string($department);
       
        echo "<br>";
        $s1 = $this->query("select sum(total)from breakdown WHERE date= '" . $show_date . "' and department='" . $department . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }    
    
      public function get_3rdstand_bypass_3mtr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(3st3mtrbbp)from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
         
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
       
    public function get_3rdstand_bypass_6mtr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(3st6mtrbbp) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
      public function get_billets_bypass_3mtr_ccm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(ccm3mtrbbp) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
     public function get_billets_bypass_6mtr_ccm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(ccm6mtrbbp) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    
     public function billets_bypass_prod_3rdstand ($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(bbprod3st) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    
    
    
    
    
    public function get_bl_8mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(8mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    public function get_bl_10mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(10mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
       public function get_bl_12mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(12mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    public function get_bl_16mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(16mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    }    
    
    public function get_bl_20mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(20mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    public function get_bl_25mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(25mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    public function get_bl_28mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(28mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    public function get_bl_32mm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(32mm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    
     public function get_mr_prod($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(mr_production) from breakdown WHERE date= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
    
    
    public function get_mr_prod_mill($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(mr_production) from breakdown WHERE date= '" . $show_date . "' and department in(3,4,4)");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }
    } 
   public function get_total_mr_ina_day($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(total_mr) from breakdown WHERE date= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}


        public function get_total_mr($kpidate,$department) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
         $department = $this->real_escape_string($department);
       
        echo "<br>";
        $s1 = $this->query("select sum(total_mr)from breakdown b WHERE date= '" . $show_date . "' and department='" . $department . "'");
      
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}



  public function get_depen_mr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(dependent_mr) from breakdown WHERE date= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}

public function get_indepen_mr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(independent_mr) from breakdown WHERE date= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}

public function get_total_cutting($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(no_of_cutting) from breakdown WHERE date= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}

public function get_total_cutting_mill($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(no_of_cutting) from breakdown b ,department d  WHERE  b.department=d.departmentid and
                date= '" . $show_date . "' and d.dname in ('Mill','Mechanical','Electrical')");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}

public function get_total_cutting_ccm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(no_of_cutting) from breakdown b ,department d  WHERE  b.department=d.departmentid and
                date= '" . $show_date . "' and d.dname ='CCM'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}

public function get_total_cutting_fnce($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(no_of_cutting) from breakdown b ,department d  WHERE  b.department=d.departmentid and
                date= '" . $show_date . "' and d.dname ='Furnace'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}


public function get_total_cutting_mpeb($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
   
        echo "<br>";
        $s1 = $this->query("select sum(no_of_cutting) from breakdown b ,department d  WHERE  b.department=d.departmentid and
                date= '" . $show_date . "' and d.dname ='MPEB'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}

public function get_prod_down_time($kpidate,$department) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        $department = $this->real_escape_string($department);
        echo "<br>";
        $s1 = $this->query("select TIME_FORMAT((SUM(`bd_total_time`)),'%H:%i') from breakdown b WHERE date= '" . $show_date . "' and department='" . $department . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            $test=$r1[0];
          $test1= date('H', strtotime($test))*60 + date('i', strtotime($test));
            return $test1;
            echo "test"; echo"<br>";
            echo $test1;
            
        } else {
            return 0;
        }   
    
}
public function get_bypass_prod($kpidate,$department) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
          $department = $this->real_escape_string($department);
        echo "<br>";
        $s1 = $this->query("select sum(total_bbp_production) from breakdown b WHERE date= '" . $show_date . "' and department='" . $department . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}
public function billets_by_pass_prod_due_ccm($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
         
        echo "<br>";
        $s1 = $this->query("select sum(bbprodccm) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}




/**public function get_total_rfmr_prod($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        
        echo "<br>";
        $s1 = $this->query("select sum(totalrfmrprod) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}


public function get_total_cutting_prod($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        
        echo "<br>";
        $s1 = $this->query("select sum(cuttingprod) from per_heat_production WHERE perheatdate= '" . $show_date . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}**/
//TIME_FORMAT((SUM(`bd_total_time`)),'%H:%i')

public function get_prod_down_time_reason($kpidate,$reason) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        $reason = $this->real_escape_string($reason);
        
        echo "<br>";
        $s1 = $this->query("select TIME_FORMAT((SUM(`bd_total_time`)),'%H:%i') from breakdown  WHERE date= '" . $show_date . "' and reasonid='" . $reason . "'");
         $r11=0;
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            $test=$r1[0];
            echo $test;
          $test1= date('H', strtotime($test))*60 + date('i', strtotime($test));
            return $test1;
            
        } else {
            return 0;
        }   
    
}


public function get_bypass_prod_reason($kpidate,$reason) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
         $reason = $this->real_escape_string($reason);
        echo "<br>";
        $s1 = $this->query("select sum(total_bbp_production) from breakdown  WHERE date= '" . $show_date . "' and reasonid='" . $reason . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            return $r1[0];
            
        } else {
            return 0;
        }   
    
}



  public function get_billets_bypass_reason($kpidate, $reason) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
        $reason = $this->real_escape_string($reason);
       
        echo "<br>";
        $s1 = $this->query("select sum(total)from breakdown WHERE date= '" . $show_date . "' and reasonid='" . $reason . "'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }   

    public function get_8_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(8rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
    public function get_10_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(10rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
    public function get_12_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(12rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
    public function get_16_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(16rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    public function get_20_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(20rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    public function get_25_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(25rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    public function get_28_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(28rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    public function get_32_rfmr($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(32rfmr)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
   public function get_8_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(8cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_10_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(10cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_12_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(12cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_16_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(16cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_20_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(20cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_25_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(25cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_28_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(28cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
      public function get_32_cut($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(32cut)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
    
     public function get_total_rolled_pcs($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       
        echo "<br>";
        $s1 = $this->query("select sum(totalrolledpcs)from per_heat_production WHERE perheatdate= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo "rolledpcs";
            return $r1[0];
        } else {
            return 0;
        }
    }  
     public function get_total_billets_bypass($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       echo $show_date;
        echo "<br>";
        $s1 = $this->query("select sum(total) from breakdown WHERE date= '" . $show_date ."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo "billetsbypass";
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
    
    public function get_total_hotrolling_of_shift($kpidate,$shift) {
        $kpi_date = $this->real_escape_string($kpidate);
        $shift = $this->real_escape_string($shift);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       echo $show_date;
       echo "shift";
       echo $shift;
        echo "<br>";
        $s1 = $this->query("select sum(`hotrolling`)/count(`heat-number`) from per_heat_production WHERE perheatdate= '" . $show_date ."' and shift='".$shift."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
    
    
public function get_total_missroll_of_shift($kpidate,$shift) {
        $kpi_date = $this->real_escape_string($kpidate);
        $shift = $this->real_escape_string($shift);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       echo $show_date;
       echo "shift";
       echo $shift;
        echo "<br>";
        $s1 = $this->query("select sum(`missroll`) from per_heat_production WHERE perheatdate= '" . $show_date ."' and shift='".$shift."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            
            return $r1[0];
        } else {
            return 0;
        }
    }  
    
  public function get_total_missroll_of_dept_in_shift($kpidate,$shift,$department) {
        $kpi_date = $this->real_escape_string($kpidate);
        $shift = $this->real_escape_string($shift);
        $department = $this->real_escape_string($department);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       echo $show_date;
       echo "shift";
       echo $shift;
        echo "<br>";
        $s1 = $this->query("select sum(`total_mr`) from breakdown WHERE date= '" . $show_date ."' and shift='".$shift."' and department='".$department."'");
        if ($s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            
            return $r1[0];
        } else {
            return 0;
        }
    }    
    
    
    
    /** public function get_First_Heat_Start_Time($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       echo $show_date;
        echo "<br>";
        $s1 = $this->query("select `heat-start-time` from per_heat_production WHERE `heat-number` = 1 and perheatdate = '".$show_date."'");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            echo "heatstarttime";
            return $r1[0];
        } else {
            return 0;
        }
    }  
    public function get_Last_Heat_End_Time($kpidate) {
        $kpi_date = $this->real_escape_string($kpidate);
        $show_date = DateTime::createFromFormat('d/m/Y', $kpi_date)->format('Y-m-d');
       echo $show_date;
        echo "<br>";
        $s1 = $this->query("select `heat-end-time` from per_heat_production WHERE perheatdate='".$show_date."' and  `heat-number` in (select max(`heat-number`) from per_heat_production where perheatdate='".$show_date."')");
        if ( $s1->num_rows > 0) {
            $r1 = $s1->fetch_row();
            echo $r1[0];
            echo "heatendtime";
            return $r1[0];
        } else {
            return 0;
        }
    }  */
    
    
        }
        
   
 