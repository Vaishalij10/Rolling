<?php

require_once("..\Connection.php");
//
require_once("..\DBfile.php");
// TO SEND MESAGE TO THE SLACK CHANNEL
require_once("..\postMessagesToSlack.php");

function lz($num) {
    return (strlen($num) < 2) ? "0{$num}" : $num;
}

$NightELECMR=$NightMPEBMR=0;
$heatcount=$HOTROLLING24HR=$Tperbypassccm=$Tperbypassmill=$Tbypsprodmpeb=$Tbypsprodmpeb=$Tmissrols=$Tmrmill=$Tmrmech=$Tmrelect=$Tmrccm=$NightMillMR=$NightMECHMR=0;
   $Tmrccm=$Tmrmpeb=$DayHotrolling=$DayMillMR=$DayMECHMR=$DayMECHMR=$DayELECMR=$DayMPEBMR=$NightHotrolling=$NightMissroll=$NightMillMR=0;
$heatcount=$hotrolling24hr=$rollingprod=$Tccmproduction=$NETTMT=0;
//Perton Power Consumption
$pertonpower=$_POST['pertonpower'];
$endcut8wt=$_POST['endcut8mm'];
$endcut10wt=$_POST['endcut10mm'];
$endcut12wt=$_POST['endcut12mm'];
$endcut16wt=$_POST['endcut16mm'];
$endcut20wt=$_POST['endcut20mm'];
$endcut25wt=$_POST['endcut25mm'];
$endcut28wt=$_POST['endcut28mm'];
$endcut32wt=$_POST['endcut32mm'];
$endcutmrwt=$_POST['endcutmrwt'];

//total heatcount of the day
$heatcount = RollingBD::getInstance()->get_heat_count($_POST['kpidate']);
echo 'heatcount:'; echo $heatcount;

//gross tmt production
$TROLLINGPROD = RollingBD::getInstance()->get_rolling_prod($_POST['kpidate']);
echo 'grosstmt:'; echo $TROLLINGPROD;

//total ccm productiom
$Tccmproduction = RollingBD::getInstance()->get_ccm_prod($_POST['kpidate']);
echo 'ccmprod:'; echo $Tccmproduction;

//total heat running time 
$HEATRUNTIME = RollingBD::getInstance()->get_heat_running_time($_POST['kpidate']);



echo 'heat runtime:'; echo $HEATRUNTIME;
echo "<br>";

$date_1 = strtr($_REQUEST['kpidate'], '/', '-');
//echo $date_ph;
$pres_mon_value= date('m', strtotime($date_1));
echo "monthvalue :"; echo $pres_mon_value;

$kpidate=date('Y-m-d', strtotime($date_1));
echo "kpidate:"; echo $kpidate;


  echo "<br>";
  
  //Burning Loss Calculation  OF SIZE WISE 
 
  $T8mmprod=RollingBD::getInstance()->get_bl_8mm($_POST['kpidate']);
  $BL8mm= ($T8mmprod*1.35)/100;
  
  $T10mmprod=RollingBD::getInstance()->get_bl_10mm($_POST['kpidate']);
  $BL10mm= ($T10mmprod*1.25)/100; 
  
  $T12mmprod=RollingBD::getInstance()->get_bl_12mm($_POST['kpidate']);
  $BL12mm= ($T12mmprod*1.15)/100;
  
  $T16mmprod=RollingBD::getInstance()->get_bl_16mm($_POST['kpidate']);
  $BL16mm= ($T16mmprod*0.85)/100;
  
  $T20mmprod=RollingBD::getInstance()->get_bl_20mm($_POST['kpidate']);
  $BL20mm= ($T20mmprod*0.75)/100;
    
  $T25mmprod=RollingBD::getInstance()->get_bl_25mm($_POST['kpidate']);
  $BL25mm= ($T25mmprod*0.7)/100;
  
  $T28mmprod=RollingBD::getInstance()->get_bl_28mm($_POST['kpidate']);
  $BL28mm= ($T28mmprod*1.2)/100;
  
  $T32mmprod=RollingBD::getInstance()->get_bl_32mm($_POST['kpidate']);
  $BL32mm= ($T32mmprod*0.55)/100;
  
  
  
  
  echo "<br>";
  
  //TOTAL BURNING LOSS CALCULATION
$TBL=$BL8mm+$BL10mm+$BL12mm+$BL16mm+$BL20mm+$BL25mm+$BL28mm+$BL32mm;
 
//roughing Production calculated size wise and overall

$rfmr8=RollingBD::getInstance()->get_8_rfmr($_POST['kpidate']);
$rfmr10=RollingBD::getInstance()->get_10_rfmr($_POST['kpidate']);
$rfmr12=RollingBD::getInstance()->get_12_rfmr($_POST['kpidate']);
$rfmr16=RollingBD::getInstance()->get_16_rfmr($_POST['kpidate']);
$rfmr20=RollingBD::getInstance()->get_20_rfmr($_POST['kpidate']);
$rfmr25=RollingBD::getInstance()->get_25_rfmr($_POST['kpidate']);
$rfmr28=RollingBD::getInstance()->get_28_rfmr($_POST['kpidate']);
$rfmr32=RollingBD::getInstance()->get_32_rfmr($_POST['kpidate']);
$Trfmrprod=$rfmr8+$rfmr10+$rfmr12+$rfmr16+$rfmr20+$rfmr25+$rfmr28+$rfmr32;

//cutting production calculated size wise and overall
$cut8=RollingBD::getInstance()->get_8_cut($_POST['kpidate']);
$cut10=RollingBD::getInstance()->get_10_cut($_POST['kpidate']);
$cut12=RollingBD::getInstance()->get_12_cut($_POST['kpidate']);
$cut16=RollingBD::getInstance()->get_16_cut($_POST['kpidate']);
$cut20=RollingBD::getInstance()->get_20_cut($_POST['kpidate']);
$cut25=RollingBD::getInstance()->get_25_cut($_POST['kpidate']);
$cut28=RollingBD::getInstance()->get_28_cut($_POST['kpidate']);
$cut32=RollingBD::getInstance()->get_32_cut($_POST['kpidate']);
$Tcuttingprod=$cut8+$cut10+$cut12+$cut16+$cut12+$cut16+$cut20+$cut25+$cut32;
  




$net8mm=number_format((float)$T8mmprod-($rfmr8+$cut8+$BL8mm+($endcut8wt/1000)),3,'.','');
$net10mm=number_format((float)$T10mmprod-($rfmr10+$cut10+$BL10mm+($endcut10wt/1000)),3,'.','');
$net12mm=number_format((float)$T12mmprod-($rfmr12+$cut12+$BL12mm+($endcut12wt/1000)),3,'.','');


$net16mm=number_format((float)$T16mmprod-($rfmr16+$cut16+$BL16mm+($endcut16wt/1000)),3,'.','');
$net20mm=number_format((float)$T20mmprod-($rfmr20+$cut20+$BL20mm+($endcut20wt/1000)),3,'.','');
$net25mm=number_format((float)$T25mmprod-($rfmr25+$cut25+$BL25mm+($endcut25wt/1000)),3,'.','');
$net28mm=number_format((float)$T28mmprod-($rfmr28+$cut28+$BL28mm+($endcut28wt/1000)),3,'.','');
$net32mm=number_format((float)$T32mmprod-($rfmr32+$cut32+$BL32mm+($endcut32wt/1000)),3,'.','');

//Final (net tmtproduction)
$NETTMT= number_format((float)($net8mm+$net10mm+$net12mm+$net16mm+$net20mm+$net25mm+$net28mm+$net32mm)-($endcutmrwt/1000),3,'.','');


echo "net tmt"; echo $NETTMT;
//Per ton Power consumption
$PERTONUNITS=number_format((float)$pertonpower/$NETTMT,2,'.','');
//Total number of pieces rollied in rolling mill

  
//TOTAL MISSROLLS OF THAT PARTICULAR DAY  
 $Tmissrols= RollingBD::getInstance()->get_total_mr_ina_day($_POST['kpidate']);
  
 //total missroll due to mill
$Tmrmill= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],5);

//Total missrolls due to Electrical
$Tmrelect= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],3);

//Total missrolls due to Mechanical
$Tmrmech= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],4);

//Total missrolls due to ccm
$Tmrccm= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],2);

//Total missrolls due to furnace 
$Tmrfnce= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],1);

//Total missrolls due to mpebpowercut
$Tmrmpeb= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],7);


//TOTAL DEPENDENT MISSROLLS
$Tdependmr=RollingBD::getInstance()->get_depen_mr($_POST['kpidate']);

//TOTAL INDEPENDENT MISSROLLS
$Tindependmr=RollingBD::getInstance()->get_indepen_mr($_POST['kpidate']);

 //total missroll production
$Tmrprod=RollingBD::getInstance()->get_mr_prod($_POST['kpidate']);

//Total Missroll production in percentage
echo "mrprod:"; echo $Tmrprod;
$Tpermrprod =($Tmrprod/$NETTMT)*100;
echo "final:"; echo $Tpermrprod; 
//total missroll production due to mill
$Tmrprodmill=RollingBD::getInstance()->get_mr_prod_mill($_POST['kpidate']);
//percentage of miss roll production due to mill

$Tperprodmill=$Tmrprodmill/$NETTMT;
// Total mill missroll production divided by ccm 

$Tpermrprodmillccm=number_format((float)$Tmrprod/$Tccmproduction*100,2,'.','');




//TOTAL NUMBER OF CUTTING
$Tcutting=RollingBD::getInstance()->get_total_cutting($_POST['kpidate']);
//TOTAL CUTTING WEIGHT IN PERCENTAGE
$Tpercutprod =(($Tcutting*.100)/$NETTMT)*100;
echo "cutting:"; echo $Tpercutprod;
//Total cutting due to mill , mechanical and electrical
$Tcuttingmill=RollingBD::getInstance()->get_total_cutting_mill($_POST['kpidate']);
//TOTAL CUTTING IN PERCENTAGE DUE TO MILL.
$percutinmill=(($Tcuttingmill*.100)/$NETTMT)*100;
//TOTAL CUTTING DUE TO MPEB
$Tcuttingmpeb=RollingBD::getInstance()->get_total_cutting_mpeb($_POST['kpidate']);
//TOTAL CUTTING IN PERCENTAGE DUE TO MPEB
$percutinmpeb=(($Tcuttingmpeb*.100)/$NETTMT)*100;
//TOTAL CUTTING DUE TO CCM
$Tcuttingccm=RollingBD::getInstance()->get_total_cutting_ccm($_POST['kpidate']);
//TOTAL CUUTING DUE TO CCM IN PERCENTAGE 
$percutinccm=(($Tcuttingccm*.100)/$NETTMT)*100;
//TOTAL CUTTING DUE TO FURNACE 
$Tcuttingfnce=RollingBD::getInstance()->get_total_cutting_fnce($_POST['kpidate']);
//TOTAL CUTTING IN PERCENTAGE DUE TO FURNACE 
$percutinfnce=(($Tcuttingfnce*.100)/$NETTMT)*100;
/**
 //Total Bypass due to CCM
 $Tbbypassccm=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],2);
 echo $Tbbypassccm;
 
 //Total Bypass due to Furnace
 $Tbbypassfurnace=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],1);
 echo $Tbbypassfurnace;
  
//Total Bypass due to MPEB
 $Tbbypassmpeb=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],7);
  echo $Tbbypassmpeb;
 **/
  //Total bypass 3rd stand 3mtr
  $Tbbypass3st3mtr=RollingBD::getInstance()->get_3rdstand_bypass_3mtr($_POST['kpidate']);
  echo $Tbbypass3st3mtr;
  
  //Total bypass 3stnad 6mtt
  $Tbbypass3st6mtr=RollingBD::getInstance()->get_3rdstand_bypass_6mtr($_POST['kpidate']);
  echo $Tbbypass3st6mtr;
  
  
  //Totalbypass of the 3rd stand
  //$Tperbbypass3st=($Tbbypass3st3mtr + $Tbbypass3st6mtr)/$Tccmproduction;
  //echo $Tperbbypass3st;


//Total billets bypass

$Tbbypass= RollingBD::getInstance()->get_total_billets_bypass($_POST['kpidate']);

$Tbbypassccm3mtr= RollingBD::getInstance()->get_billets_bypass_3mtr_ccm($_POST['kpidate']);
$Tbbypassccm6mtr= RollingBD::getInstance()->get_billets_bypass_6mtr_ccm($_POST['kpidate']);

//Total missroll(%) clculated as SUM OF totalcutting weight production and miss roll production

$TcuttingMRPRODINPERCENT= number_format((float)($Tpercutprod+$Tpermrprod),2,'.','');
// ok pieces rolled in rolling
$Tokpcsrolledinrolling= RollingBD::getInstance()->get_total_rolled_pcs($_POST['kpidate']);
//pieces count inccm
$Tpiecescountinccm=$Tmissrols+$Tokpcsrolledinrolling+$Tbbypass+$Tbbypass3st3mtr+$Tbbypass3st6mtr+$Tbbypassccm3mtr+$Tbbypassccm6mtr;

echo $Tmissrols;echo $Tokpcsrolledinrolling; echo $Tbbypass;
echo "ccm:";
echo $Tpiecescountinccm;
//24hours hotrolling
$HOTROLLING24HR= number_format(((float)($Tokpcsrolledinrolling/$Tpiecescountinccm)*100),2,'.','');

//ENDCUT MISSROLL CALCULATION
$encutmrweight=($endcutmrwt/1000);
$ENDCUTMRINPER=number_format((float)($encutmrweight/$NETTMT)*100,3,'.','');
echo "<br>";
echo $ENDCUTMRINPER;
//Total missroll(%) clculated as SUM OF totalcutting weight production and miss roll production

$TcuttingMRPRODINPERCENT= number_format((float)($Tpercutprod+$Tpermrprod+$ENDCUTMRINPER),2,'.','');

//TOTAL BILLETS BYPASS DUE TO CCM
$bbypassccm=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],5);
//total bypass due to ccm 
$Tbbypassccm=$bbypassccm+$Tbbypassccm3mtr+$Tbbypassccm6mtr;
//Total Bypass production due to  Mill
$BYPASSPRODCCM= RollingBD::getInstance()->billets_by_pass_prod_due_ccm($_POST['kpidate']);
//Final Production
$PERBYPASSPRODCCM=number_format((float)($BYPASSPRODCCM/$Tccmproduction)*100,2,'.','');
//Total production down time due to Mill
$Tdntimeccmmin= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],5);
//Total Production down time in hours
$Tdntimeccmhr=$Tdntimeccmmin/60;



//Total Billets Bypass due to Mill
$Tbbypassmill=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],5);
//Total Bypass production due to  Mill
$BYPASSPRODMILL= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],5);
//Final Production
$PERBYPASSPRODMILL=($BYPASSPRODMILL/$Tccmproduction)*100;
//Total production down time due to Mill
$Tdntimemillmin= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],5);
//Total Production down time in hours
$Tdntimemillhr=$Tdntimemillmin/60;

//Total production down time due to Mechanical
$Tdntimemechmin= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],4);
//Production down time in hr
$Tdntimemechhr=$Tdntimemechmin/60;
//Total Bypass production due to  Mechanical
$BYPASSPRODMECH= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],4);
//PERCENTAGE OF BYPASS DUE TO MECH
$PERBYPASSPRODMECH=($BYPASSPRODMECH/$Tccmproduction)*100;
//Total Bypass due to Mechanical
$Tbbypassmech=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],4);

//Total production down time due to Electrical
$Tdntimeelecmin= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],3);
//Total Production down time in hours
$Tdntimeelechr=$Tdntimeelecmin/60;
//Total Bypass production due to  Electrical
$BYPASSPRODELEC= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],3);
//PERCENTAGE OF BYPASS PRODUCTION DUE TO ELECTRICAL
$PERBYPASSPRODELEC=($BYPASSPRODELEC/$Tccmproduction)*100;
//Total Bypass due to Electrical
 $Tbbypasselec=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],3);
 

//Total production down time due to MPEB
$Tdntimempebmin= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],7);
//Total Production down time in hours
$Tdntimempebhr=$Tdntimempebmin/60;
//Total Bypass production due to  MPEB
$BYPASSPRODMPEB= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],7);
//PERCEBTNGE OF BBYPASSPROD DUE TO MPEB
$PERBYPASSPRODMPEB=number_format((float)($BYPASSPRODMPEB/$Tccmproduction)*100,2,'.','');
  //Total Bypass due to MPEB
$Tbbypassmpeb=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],7);
 
 
 
//Porduction down time due to passchange
$Tdntimepchmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],37);
//down time due to passchange in hours
$Tdntimepchhr=$Tdntimepchmin/60;
// total bypass production due to pass change
$bypsprodpc=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],37);
$Tbypsprodpc=($bypsprodpc/$Tccmproduction)*100;
//total bypass due to pass change
$Tbbypasspc=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],37);

// total production down time due to size change
$Tdntimescmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],52);
// down time due to size change in hours
$Tdntimeschr=$Tdntimescmin/60;
// total bypass production due to size change
$bypsprodsc=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],52);
//TOTAL PERCENTAGE OF BYPASS PRODUCTION DUE TO SIZE CHANGE
$Tbypsprodsc=($bypsprodsc/$Tccmproduction)*100;
// total bypass due to size change
$Tbbypasssc=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],52);


// total production down time due to Roll change in min
$Tdntimercmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],47);
// down time due to size change in hours
$Tdntimerchr=$Tdntimercmin/60;
// total bypass production due to size change
$bypsprodrc=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],47);
$Tbypsprodrc=($bypsprodrc/$Tccmproduction)*100;
// total bypass due to size change
$Tbbypassrc=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],47);


// total production down time due to lahar
$Tdntimelrmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],26);
//Total Production downtimr in hr
$Tdntimelrhr=$Tdntimelrmin/60;
// total bypass production due to lahar
$bypsprodlr=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],26);
$Tbypsprodlr=($bypsprodlr/$Tccmproduction)*100;
// total bypass due to lahar
$Tbbypasslr=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],26);


// total down time due to quality chill in min
$Tdntimechillimin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],10);
// total down time in hr in due toquality chill
$Tdntimechillihr=$Tdntimechillimin/60;
// total bypass production due to qualitychilli
$bypsprodch=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],10);
$Tbypsprodch=($bypsprodch/$Tccmproduction)*100;
// total bypass due to qualitychilli
$Tbbypasschilli=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],10);


// total down time due to mIlll chill in min
$Tdntimemillchill= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],60);
// total down time in hr in due mIlll chill
$Tdntimemillchillhr=$Tdntimemillchill/60;
// total bypass production due to mIlll CHILLI
$bypsprodmillchill=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],60);
$Tbypsprodmillchill=($bypsprodmillchill/$Tccmproduction)*100;
// total bypass due to mIlll CHILLI
$Tbbypassmillchill=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],60);

//total down time due to crack
$Tdntimecrackmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],4);
// total down time in hr in due to crack
$Tdntimecrackhr=$Tdntimecrackmin/60;
// total bypass production due to crack
$bypsprodck=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],4);

$Tbypsprodck=($bypsprodck/$Tccmproduction)*100;
// total bypass  due to crack
$Tbbypasscrack=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],4);

//total down time due to piping
$Tdntimepipingmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],41);
// total down time in hr in due to piping
$Tdntimepipinghr=$Tdntimepipingmin/60;
// total bypass production due to piping
$bypsprodpp=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],41);

$Tbypsprodpp=($bypsprodpp/$Tccmproduction)*100;
// total bypass due to piping
$Tbbypasspiping=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],41);

// production down time due to ccd composition
$Tdntimeccdmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],45);
// production down time in hr due to ccd composition
$Tdntimeccdhr=$Tdntimeccdmin/60;
// bypass production due to ccd composition
$bypsprodccd=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],45);

$Tbypsprodccd=($bypsprodccd/$Tccmproduction)*100;
// total bypass due to ccd composition
$Tbbypassccd=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],45);


// production down time due to Maintenance
$Tdntimementmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],30);
// production down time in hr due to Maintenance
$Tdntimementhr=$Tdntimementmin/60;
// bypass production due to Maintenance
$bypsprodment=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],30);
$Tbypsprodment=($bypsprodment/$Tccmproduction)*100;
// total bypass due to Maintenance
$Tbbypassment =RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],30);

// production down time due to MOUTHOPEN
$Tdntimemopenmin= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],33);
// production down time in hr due to MOUTHOPEN
$Tdntimemopenhr=$Tdntimemopenmin/60;
// bypass production due to MOUTHOPEN
$bypsprodmopen=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],33);
$Tbypsprodmopen=($bypsprodmopen/$Tccmproduction)*100;
// total bypass due to MOUTHOPEN
$Tbbypassmopen =RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],33);

//
echo "mouthopen";
echo $Tbbypassmopen;
//Total number of bypass due to MILL 
$FINALPERBYPASSMILL=number_format((float)($PERBYPASSPRODELEC+$PERBYPASSPRODMECH+$PERBYPASSPRODMILL),2,'.','');

echo "bypassmill:";

echo $Tbypassduetomill=$Tbbypassmill+$Tbbypassmech+$Tbbypasselec;

echo $Tbypassduetomill;




//Total Bypass Production due to Mill ,Mechinacal and Electrical
//$Tperbypassmill=number_format(((float)$Tbypsprodmech+$Tbypsprodelec+$Tbypsprodmill+$Tbypsprodlr+$Tbypsprodpc+$Tbypsprodsc+$Tbypsprodrc+$Tbypsprodment+$Tbypsprodmillchill),2,'.','');

//Total Bypass Production due to CCM
//$Tperbypassccm=number_format(((float)$Tbypsprodpp+$Tbypsprodch+$Tbypsprodck+$Tbypsprodmopen),2,'.','');


// CHANGES DONE ON 16-TH NOVEMBER 2017
$perbbypass3st=RollingBD::getInstance()->billets_bypass_prod_3rdstand($_POST['kpidate']);

$Tperbypass3st=number_format(((float)($perbbypass3st/$Tccmproduction)*100),2,'.','');

$DayHotrolling=number_format(((float)RollingBD::getInstance()->get_total_hotrolling_of_shift($_POST['kpidate'],'Day')),2,'.','');
$DayMisrroll=RollingBD::getInstance()->get_total_missroll_of_shift($_POST['kpidate'],'Day');
$DayCCMMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Day',2);
$DayELECMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Day',3);
$DayMECHMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Day',4);
$DayMillMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Day',5);
$DayMPEBMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Day',7);

$NightHotrolling=number_format(((float)RollingBD::getInstance()->get_total_hotrolling_of_shift($_POST['kpidate'],'Night')),2,'.','');
$NightMisroll=RollingBD::getInstance()->get_total_missroll_of_shift($_POST['kpidate'],'Night');
$NightCCMMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Night',2);
$NightELECMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Night',3);
$NightMECHMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Night',4);
$NightMillMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Night',5);
$NightMPEBMR=RollingBD::getInstance()->get_total_missroll_of_dept_in_shift($_POST['kpidate'],'Night',7);



/*
 * TOTAL BYPASS PERCENT DUE TO MILL  AND CCM
 * 
 * 
 * 
 */




//$test2= date('H:i', strtotime($HEATRUNTIME));


//$date = date('H:m', strtotime('-24 hours', $test2));

//echo $date;
/**
//Start Time of the First heat 
$firstheatsttime = RollingBD::getInstance()->get_First_Heat_Start_Time($_POST['kpidate']);
// End time of the Last heat
$lastheatendtime = RollingBD::getInstance()->get_Last_Heat_End_Time($_POST['kpidate']);

//Difference of the Lastheat end time and first heat start time
$totaltime= abs(strtotime($lastheatendtime) - strtotime($firstheatsttime))/3600;
$seconds_ph = ($totaltime * 3600);
$hours_ph = floor($totaltime);
$seconds_ph -= $hours_ph * 3600;
$minutes_ph = floor($seconds_ph / 60);
$seconds_ph -= $minutes_ph * 60;
// Converting  them in to hh:mm format
$totalheatime = lz($hours_ph) . ":" . lz($minutes_ph);
echo "<br>";

                                                                                            
**/

/**$THH=24;
$TMM=00;
echo $THH;echo "<br>"; echo $TMM;

echo "<br>";                                                                                                                                
$RHH=date('H', strtotime($HEATRUNTIME));
$RMM=date('i', strtotime($HEATRUNTIME));

echo $RHH; echo $RMM;

$hourdiff=$THH-$RHH;
$mindiff=$TMM-$RMM;




if($mindiff =0){
    $heatgap= lz($hourdiff).":".lz($mindiff);
$heatgap;
    
}


 if($mindiff < 0){
    $Amindiff = abs($mindiff);
    $Mmindiff=60-$Aindiff;
    $hourdiff= $hourdiff-1;
    $heatgap=lz($hourdiff).":".lz($Mmindiff);
    echo $heatgap;
}**/

$res_1 = mysqli_query($link,"select `kpidate` from `rollingkpi` where kpi_id in(select max(kpi_id) from rollingkpi)");

$row_1=mysqli_fetch_row($res_1);
$prev_kpi_date=$row_1[0];

//echo $date_ph;
$prev_mon_value= date('m', strtotime($prev_kpi_date));


if($prev_mon_value !=$pres_mon_value){
    $monthlynettmt=$NETTMT;
    $monthlyhotrolling= number_format((float)(($TROLLINGPROD/$Tccmproduction)*100),2,'.','');
   
}
else{
  
   $row_2 = mysqli_fetch_row(mysqli_query($link, "select sum(`nettmt`) ,sum(grosstmt), sum(totalccmprod) from `rollingkpi`"));
   $prev_grosstmt=$row_2[1];
   $prev_ccmprod=$row_2[2];
   $prev_nettmt=$row_2[0];
   $monthlynettmt= number_format((float)($prev_nettmt+$NETTMT),2,'.','');
  
   $monthlyhotrolling= number_format((float)(($prev_grosstmt+$TROLLINGPROD)/($prev_ccmprod+$Tccmproduction)*100),2,'.','');
   
   
}
$sql_kpi= "INSERT INTO `rollingkpi` ( `kpidate`, `heatcount`, `grosstmt`, `totalccmprod`, `heatruntime`, `pertonpowerunits`, 
        `endcutwt8`, `endcutwt10`, `endcutwt12`, `endcutwt16`, `endcutwt20`, `endcutwt25`, `endcutwt28`, `endcutwt32`, 
        `T8mm`, `T10mm`, `T12mm`, `T16mm`, `T20mm`, `T25mm`, `T28mm`, `T32mm`, `bl8mm`, `bl10mm`, `bl12mm`, `bl16mm`, `bl20mm`, 
        `bl25mm`, `bl28mm`, `bl32mm`, `rfmr8`, `rfmr10`, `rfmr12`, `rfmr16`, `rfmr20`, `rfmr25`, `rfmr28`, `rfmr32`, `cutting8`, 
        `cutting10`, `cutting12`, `cutting16`, `cutting20`, `cutting25`, `cutting28`, `cutting32`, `net8mm`, `net10mm`, `net12mm`, 
        `net16mm`, `net20mm`, `net25mm`, `net28mm`, `net32mm`, `totalcuttingprod`, `totalrfmrprod`, `totalblossprod`, `nettmt`, 
        `Tprolledrolling`, `Tpfromccm`, `24hrshotrolling`, `monthlyhotrolling`, `monthlynettmt`, `Tendcutmrpercent`, 
        `Tmrpercent`, `Tmilmrpercent`, `Tmissroll`, `Tmillmissroll`, `Telecmissroll`, `Tmechmissroll`, 
        `Tccmqltymissroll`, `Tfncemissroll`, `Tmpebmissroll`, `Indepmissroll`, `depmissroll`, `Tcuttingpercent`, 
        `Tcutting`, `Tcuttingmillpercent`, `Tcuttingmill`, `Tcuttingccmpercent`, `Tcuttingccm`, `Tcuttingccdpercent`,
        `Tcuttingccd`, `Tcuttingmpebpercent`, `Tcuttingmpeb`, `pdtimemillmin`, `pdtimemillhr`, `Tbypassmill`,
        `Tperbbyprodmill`, `pdtimemillmechmin`, `pdtimemechhr`, `Tbypassmech`, `Tperbyprodmech`, `pdtimemillelecmin`, 
        `pdtimemillelechr`, `Tbypasselec`, `Tperbbyprodelec`, `pdtimepcmin`, `pdtimepchr`, `Tbypasspc`, `Tperbyprodpc`, 
        `pdtimescmin`, `pdtimeschr`, `Tbypasssc`, `Tperbyprodsc`, `pdtimementmin`, `pdtimementhr`, `Tbypassment`,
        `Tperprodment`, `pdtimempebmin`, `pdtimempebhr`, `Tbypassmpeb`, `Tperprodmpeb`, `pdtimelaharmin`, `pdtimelaharhr`, 
        `Tbypasslahar`, `Tperprodlahar`, `pdtimecrackmin`, `pdtimecrackhr`, `Tbypasscrack`, `Tperprodcrack`, `pdtimepipingmin`, 
        `pdtimepipinghr`, `Tbypasspiping`, `Tperprodpiping`, `pdtimechillimin`, `pdtimechillihr`, `Tbypasschill`, `Tperprodchill`,
        `pdtimeccdmin`, `pdtimeccdhr`, `Tbypassccd`, `Tperprodccd`, `Tperbyprodmill`, `Tperbyprodccm`,`Tpermissrollcuttingprod`,
        `totalbypassduetomill`,`totalbypassduetoccm`,`pdtimemopenmin`,`pdtimemopenhr`,`Tbypassmopen`,`Tperprodmopen`,
        `pertonpowerconsumption`,`Tperbypass3st`,`Tpermillmissrollccm`) 
          VALUES 
          ('".$kpidate."','".$heatcount."','".$TROLLINGPROD."','".$Tccmproduction."','".$HEATRUNTIME."',"
         . "'".$PERTONUNITS . "','".$endcut8wt."','".$endcut10wt."','".$endcut12wt."','".$endcut16wt."',"
        . "'".$endcut20wt."','".$endcut25wt."','".$endcut28wt."','".$endcut32wt."','".$T8mmprod."',"
        . "'".$T10mmprod."','".$T12mmprod."','".$T16mmprod."','".$T20mmprod."','".$T25mmprod."',"
        ."'".$T28mmprod."','".$T32mmprod."','".$BL8mm."','".$BL10mm."','".$BL12mm."',"
        . "'".$BL16mm."','".$BL20mm."','".$BL25mm."','".$BL28mm."','".$BL32mm."',"
        ."'".$rfmr8."','".$rfmr10."','".$rfmr12."','".$rfmr16."','".$rfmr20."',"
        . "'".$rfmr25."','".$rfmr28."','".$rfmr32."','".$cut8."','".$cut10."',"
        . "'".$cut12."','".$cut16."','".$cut20."','".$cut25."','".$cut28."',"
        . "'".$cut32."','".$net8mm."','".$net10mm."','".$net12mm."','".$net16mm."',"
        . "'".$net20mm."','".$net25mm."','".$net28mm."','".$net32mm."','".$Tcuttingprod."',"
        . "'".$Trfmrprod."','".$TBL."','".$NETTMT."','".$Tokpcsrolledinrolling."','".$Tpiecescountinccm."',"
        . "'".$HOTROLLING24HR."','".$monthlyhotrolling."','".$monthlynettmt."','".$ENDCUTMRINPER."','".$Tpermrprod."',"
        . "'".$Tmrprodmill."','".$Tmissrols."','".$Tmrmill."','".$Tmrelect."','".$Tmrmech."',"
        . "'".$Tmrccm."','".$Tmrfnce."','".$Tmrmpeb."','".$Tindependmr."','".$Tdependmr."',"
        . "'".$Tpercutprod."','".$Tcutting."','".$percutinmill."','".$Tcuttingmill."',"
        . "'".$percutinccm."','".$Tcuttingccm."','".$percutinfnce."','".$Tcuttingfnce."','".$percutinmpeb."',"
        . "'".$Tcuttingmpeb."','".$Tdntimemillmin."','".$Tdntimemillhr."','".$Tbbypassmill."','".$PERBYPASSPRODMILL."',"
        . "'".$Tdntimemechmin."','".$Tdntimemechhr."','".$Tbbypassmech."','".$PERBYPASSPRODMECH."','".$Tdntimeelecmin."',"
        . "'".$Tdntimeelechr."','".$Tbbypasselec."','".$PERBYPASSPRODELEC."','".$Tdntimepchmin."','".$Tdntimepchhr."',"
        . "'".$Tbbypasspc."','".$Tbypsprodpc."',"
        . "'".$Tdntimescmin."','".$Tdntimeschr."','".$Tbbypasssc."','".$Tbypsprodsc."',"
        . "'".$Tdntimementmin."','".$Tdntimementhr."','".$Tbbypassment."','".$Tbypsprodment."','".$Tdntimempebmin."',"
        . "'".$Tdntimempebhr."','".$Tbbypassmpeb."','".$PERBYPASSPRODMPEB."','".$Tdntimelrmin."','".$Tdntimelrhr."',"
        . "'".$Tbbypasslr."','".$Tbypsprodlr."','".$Tdntimecrackmin."','".$Tdntimecrackhr."','".$Tbbypasscrack."',"
        . "'".$Tbypsprodck."','".$Tdntimepipingmin."','".$Tdntimepipinghr."','".$Tbbypasspiping."','".$Tbypsprodpp."',"
        . "'".$Tdntimechillimin."','".$Tdntimechillihr."','".$Tbbypasschilli."','".$Tbypsprodch."','".$Tdntimeccdmin."','".$Tdntimeccdhr."',"
        . "'".$Tbbypassccd."','".$Tbypsprodccd."','".$FINALPERBYPASSMILL."','".$PERBYPASSPRODCCM."','".$TcuttingMRPRODINPERCENT."',"
        . "'".$Tbypassduetomill."','".$Tbbypassccm."','".$Tdntimemopenmin."','".$Tdntimemopenhr."','".$Tbbypassmopen."',"
        . "'".$Tbypsprodmopen."','".$pertonpower."','".$Tperbypass3st."','".$Tpermrprodmillccm."')";



$result_kpi = (mysqli_query($link, $sql_kpi) or die(mysqli_error($link)));


// CHECKING THAT EITHER VALUES ARE INSERTED PROPERLY OR NOT
if ($result_kpi) {
    echo"record added";
    //echo $row_cum;
} else {
    echo 'not added';
}
$varA='';
$var8="8mm"; $var10="10mm"; $var12="12mm"; $var16="16mm";$var20="20mm";$var25="25mm";$var28="28mm";$var32="32mm";

if ($net8mm!= 0) {
    $varA =$var8 . ' = ' .  $net8mm . ' ' . "\n";
}
if ($net10mm != 0) {
    $varA = $varA.''.$var10 . ' = ' . $net10mm . '' . "\n";
}
if ($net12mm != 0) {
    $varA = $varA.''. $var12 . ' = ' . $net12mm . '' . "\n";
}
if ($net16mm != 0) {
    $varA = $varA.''.$var16 . ' = ' . $net16mm . '' . "\n";
}
if ($net20mm != 0) {
    $varA = $varA.''.$var20 . ' = ' . $net20mm . '' . "\n";
}
if ($net25mm != 0) {
    $varA = $varA.''.$var25 . ' = ' . $net25mm . '' . "\n";
}
if ($net28mm != 0) {
    $varA = $varA.''.$var28 . ' = ' . $net28mm . '' . "\n";
}
if ($net32mm != 0) {
    $varA = $varA.''.$var32 . ' = ' . $net32mm. '' . "\n";
}
mysqli_close($link);
//POSt Message to Slack CHANNEL ROLLING
 Slack::getInstance()->postMessagesToSlack_rollingkpi("
 *Date* - `$kpidate` 
 *24 Hours Hot Rolling %*  = *$HOTROLLING24HR*
 *Monthly hot rolling %*   = *$monthlyhotrolling*
 *Running Time* = `$HEATRUNTIME`
 *Total Miss roll %* =`$TcuttingMRPRODINPERCENT`
 *End Cut Miss roll %* = `$ENDCUTMRINPER`
 *Per ton units* = `$PERTONUNITS`
*$NETTMT* (_*`$monthlynettmt`*_)
 $varA
        ", "Test");
echo "Mechanical";
echo "$Tmrmech";

if ($Tmrmech === null) {
    $Tmrmech = 0;
}if ($Tmrelect === null) {
    $Tmrelect = 0;
}
if ($Tmissrols === null) {
    $Tmissrols = 0;
}
if ($Tmrccm === null) {
    $Tmrccm = 0;
}if ($Tmrmpeb ===null ) {
    $Tmrmpeb = 0;
}
if ($DayMisrroll === null) {
    $DayMisrroll = 0;
} if ($DayMillMR ===null) {
    $DayMillMR = 0;
}if ($DayMECHMR === null) {
    $DayMECHMR = 0;
}if ($DayELECMR === null) {
    $DayELECMR = 0;
}if ($DayMPEBMR === null) {
    $DayMPEBMR = 0;
}
if($DayCCMMR=== null){
    $DayCCMMR=0;
}

if ($NightMissroll === null) {
    $NightMissroll = 0;
} if ($NightMillMR === null) {
    $NightMillMR = 0;
}
if ($NightMECHMR === null) {
    $NightMECHMR = 0;
}if ($NightELECMR === null) {
    $NightELECMR = 0;
}if ($NightMPEBMR === null) {
    $NightMPEBMR = 0;
}
if($NightCCMMR===null){
    $NightCCMMR=0;
}
$postMessagesToSlack_productionreport = Slack::getInstance()->postMessagesToSlack_productionreport("
 *Date =*   `$kpidate`
*Total Heat-*          `$heatcount`
 *Total Hot Rolling%*  `$HOTROLLING24HR`
 *CCM ByPass %-*       `$PERBYPASSPRODCCM`    
 *MILL ByPass %-*      `$FINALPERBYPASSMILL`
 *PowerCut By MPEB%*- ` $PERBYPASSPRODMPEB`   
 *Bypass 3rd Stand%-*  `$Tperbypass3st`
 *Mill Missroll%*     `$Tpermrprodmillccm`
 *Total Missroll-*    `$Tmissrols`    
 *Mill Missroll-*     `$Tmrmill` 
 *Mech Missroll-*     `$Tmrmech` 
 *Elec Missroll-*     `$Tmrelect`    
 *CCM  Missroll-*     `$Tmrccm`
 *MPEB Missroll-*     `$Tmrmpeb`
 _*`DAY SHIFT`*_
 *Hot Rolling%=*     `$DayHotrolling`
 *Total Missroll-*   `$DayMisrroll`
 *Mill Missroll-*    `$DayMillMR`
 *Mech Missroll-*    `$DayMECHMR`
 *Elec Missroll-*    `$DayELECMR`
 *CCM Missroll-*     `$DayCCMMR`     
 *MPEB Missroll-*   `$DayMPEBMR`
_*`NIGHT SHIFT`*_
 *Hot Rolling%=*    `$NightHotrolling`
 *Total Missroll-*  `$NightMissroll`
 *Mill Missroll-*   `$NightMillMR`
 *Mech Missroll-*   `$NightMECHMR`
 *Elec Missroll-*   `$NightELECMR`
 *CCM Missroll-*    `$NightCCMMR`      
 *MPEB Missroll-*   `$NightMPEBMR`      
   
         ","Test");
// ON FORM SUBMITTED REDIRECTED TO THE HOME.PHP
//header("Location:http://192.168.2.141/Rolling/Home.php");**/

exit();
