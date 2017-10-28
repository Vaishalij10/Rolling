<?php

require_once("..\Connection.php");
//
require_once("..\DBfile.php");
// TO SEND MESAGE TO THE SLACK CHANNEL
require_once("..\postMessagesToSlack.php");


$heat_count=$hotrolling24hr=$rollingprod=$ccmproduction=0;
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
echo $heatcount;

//gross tmt production
$TROLLINGPROD = RollingBD::getInstance()->get_rolling_prod($_POST['kpidate']);
echo $TROLLINGPROD;

//total ccm productiom
$Tccmproduction = RollingBD::getInstance()->get_ccm_prod($_POST['kpidate']);
echo $ccmproduction;

//24 hours hot rolling percentahe 
$HOTROLLING24HR=($TROLLINGPROD/$Tccmproduction)*100;
echo $HOTROLLING24HR;

//total heat running time 
$HEATRUNTIME = RollingBD::getInstance()->get_heat_running_time($_POST['kpidate']);
echo $HEATRUNTIME;

//Per ton Power consumption
$PERTONUNITS=$pertonpower/$nettmt;


 //Total Bypass due to CCM
 $Tbbypassccm=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],2);
 echo $Tbbypassccm;
 
 //Total Bypass due to Furnace
 $Tbbypassfurnace=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],1);
 echo $Tbbypassfurnace;
  
//Total Bypass due to MPEB
 $Tbbypassmpeb=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],7);
  echo $Tbbypassmpeb;
 
  //Total bypass 3rd stand 3mtr
  $Tbbypass3st3mtr=RollingBD::getInstance()->get_3rdstand_bypass_3mtr($_POST['kpidate']);
  echo $Tbbypass3st3mtr;
  
  //Total bypass 3stnad 6mtt
  $Tbbypass3st6mtr=RollingBD::getInstance()->get_3rdstand_bypass_6mtr($_POST['kpidate']);
  echo $Tbbypass3st6mtr;
  
  
  //Totalbypass of the 3rd stand
  $Tbbypass3st=$Tbbypass3st3mtr + $Tbbypass3st6mtr;
  echo $Tbbypass3st;
  
  
  //Burning Loss Calculation  OF SIZE WISE 
 
  $T8mmprod=RollingBD::getInstance()->get_bl_8mm($_POST['kpidate']);
  $BL8mm= $T8mmprod*1.34;
  
  $T10mmprod=RollingBD::getInstance()->get_bl_10mm($_POST['kpidate']);
  $BL10mm= $T10mmprod*1.25; 
  
  $T12mmprod=RollingBD::getInstance()->get_bl_12mm($_POST['kpidate']);
  $BL12mm= $T12mmprod*1.15;
  
  $T16mmprod=RollingBD::getInstance()->get_bl_16mm($_POST['kpidate']);
  $BL16mm= $T8mmprod*0.85;
  
  $T20mmprod=RollingBD::getInstance()->get_bl_20mm($_POST['kpidate']);
  $BL20mm= $T20mmprod*0.74;
    
  $T25mmprod=RollingBD::getInstance()->get_bl_25mm($_POST['kpidate']);
  $BL25mm= $T25mmprod*0.7;
  
  $T28mmprod=RollingBD::getInstance()->get_bl_28mm($_POST['kpidate']);
  $BL28mm= $T28mmprod*1.2;
  
  $T32mmprod=RollingBD::getInstance()->get_bl_32mm($_POST['kpidate']);
  $BL32mm= $T32mmprod*0.56;
  
  //TOTAL BURNING LOSS CALCULATION
$TBL=$BL8mm+$BL10mm+$BL12mm+$BL16mm+$BL20mm+$BL25mm+$BL28mm+$BL32mm;
  ///on hold need to delete them furher
  //Total roughing production calculated from perheat of mill1 and mill2
$Trfmrprod=RollingBD::getInstance()->get_total_rfmr_prod($_POST['kpidate']);
  
  
   //Total cutting production calculated from perheat of mill1 and mill2
$Tcuttingprod=RollingBD::getInstance()->get_total_cutting_prod($_POST['kpidate']);
  
  
  //Final(net tmt )excluding cutting and mr production and burningloss
$nettmt=$Trollingprod-($Tcuttingprod+$Trfmrprod+$TBL);
  
//Perton Power Consumption  
 $pertonpowercons=$pertonpower/$nettmt;
 /*************
  * TOTAL MISSROLL PRODUCTION IN MT
  *TOTAL MISSROLL IN  PERCENTAGE 
  */ 
 //MR PRODUCTION CALCULATION
$Tmrprod=RollingBD::getInstance()->get_mr_prod($_POST['kpidate']);

//Total Missroll production in percentage
$Tpermrprod =$Tmrprod/$nettmt;
//total missroll production due to mill
$Tmrprodmill=RollingBD::getInstance()->get_mr_prod_mill($_POST['kpidate']);
//percentage of miss roll production due to mill

$Tperprodmill=$Tmrprodmill/$nettmt;
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
$Tmfnce= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],1);

//Total missrolls due to mpebpowercut
$Tmrmpeb= RollingBD::getInstance()->get_total_mr($_POST['kpidate'],7);


//TOTAL DEPENDENT MISSROLLS
$Tdependmr=RollingBD::getInstance()->get_depen_mr($_POST['kpidate']);

//TOTAL INDEPENDENT MISSROLLS
$Tindependmr=RollingBD::getInstance()->get_indepen_mr($_POST['kpidate']);

//TOTAL NUMBER OF CUTTING
$Tcutting=RollingBD::getInstance()->get_total_cutting($_POST['kpidate']);
//TOTAL CUTTING WEIGHT IN PERCENTAGE
$Tpercutprod =($Tcutting*.100)/$nettmt;
//Total cutting due to mill , mechanical and electrical
$Tcuttingmill=RollingBD::getInstance()->get_total_cutting_mill($_POST['kpidate']);
//TOTAL CUTTING IN PERCENTAGE DUE TO MILL.
$percutinmill=(($Tcuttingmill*.100)/$nettmt)*100;
//TOTAL CUTTING DUE TO MPEB
$Tcuttingmpeb=RollingBD::getInstance()->get_total_cutting_mpeb($_POST['kpidate']);
//TOTAL CUTTING IN PERCENTAGE DUE TO MPEB
$percutinmpeb=(($Tcuttingmpeb*.100)/$nettmt)*100;
//TOTAL CUTTING DUE TO CCM
$Tcuttingccm=RollingBD::getInstance()->get_total_cutting_ccm($_POST['kpidate']);
//TOTAL CUUTING DUE TO CCM IN PERCENTAGE 
$percutinccm=(($Tcuttingccm*.100)/$nettmt)*100;
//TOTAL CUTTING DUE TO FURNACE 
$Tcuttingfnce=RollingBD::getInstance()->get_total_cutting_fnce($_POST['kpidate']);
//TOTAL CUTTING IN PERCENTAGE DUE TO FURNACE 
$percutinfnce=(($Tcuttingfnce*.100)/$nettmt)*100;

//Total missroll(%) clculated as SUM OF totalcutting weight production and miss roll production
$TMRPRODINPERCENT=$Tpercutprod+$Tpermrprod;

//ENDCUT MISSROLL CALCULATION

$ENDCUTRINPERCENT=($endcut8wt+$endcut10wt+$endcut12wt+$endcut16wt+$endcut20wt+$endcut25wt+$endcut28wt+$endcut32wt+$endcutmrwt)/$nettmt;


//Total Billets Bypass due to Mill
$Tbbypassmill=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],5);
//Total production down time due to Mill
$Tdntimemill= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],5);
//Total Bypass production due to  Mill
$Tbbypassprodmill= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],5);
//Total Production down time in mill in minutes
$milldntimeinmin = date('H', strtotime($Tdntimemill))*60 + date('i', strtotime($Tdntimemill));
//Total Production down time in hours
$milldntimeinhr=$milldntimeinmin/60;

//Total production down time due to MPEB
$Tdntimempeb= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],7);
//Total Bypass production due to  MPEB
$Tbbypassprodmpeb= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],7);
  //Total Bypass due to MPEB
$Tbbypassmpeb=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],7);
//Total production downtime in minutes
$mpebdntimeinmin = date('H', strtotime($Tdntimempeb))*60 + date('i', strtotime($Tdntimempeb)); 
//Total Production down time in hours
$mpebdntimeinhr=$mpebdntimeinmin/60;

//Total production down time due to Mechanical
$Tdntimemech= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],4);
//Total Bypass production due to  Mechanical
$Tbbypassprodmech= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],4);
 //Total Bypass due to Mechanical
$Tbbypassmech=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],4);
 //Total production downtime in minutes
$mechdntimeinmin = date('H', strtotime($Tdntimemech))*60 + date('i', strtotime($Tdntimemech)); 
//Total Production down time in hours
$mechdntimeinhr=$mechdntimeinmin/60;
 
//Total production down time due to Electrical
$Tdntimeelec= RollingBD::getInstance()->get_prod_down_time($_POST['kpidate'],3);
//Total Bypass production due to  Mechanical
$Tbbypassprodelec= RollingBD::getInstance()->get_bypass_prod($_POST['kpidate'],3);
//Total Bypass due to Mechanical
 $Tbbypassmelec=RollingBD::getInstance()->get_billets_bypass($_POST['kpidate'],3);
 //TOTAL ELECTRICAL DOWNTIME IN HR
 $elecdntimeinmin = date('H', strtotime($Tdntimeelec))*60 + date('i', strtotime($Tdntimeelec)); 
//Total Production down time in hours
$elecdntimeinhr=$elecdntimeinmin/60;
 

//Porduction down time due to passchange
$Tdntimepch= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],37);
//down time due to passchange in minutes
$pcdntimemin=date('H', strtotime($Tdntimepch))*60 + date('i', strtotime($Tdntimepch));
//down time due to pass change in hours
$pcdntimeinhr=$pcdntimemin/60;
// total bypass production due to pass change
$Tbbyprodpc=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],37);
//total bypass due to pass change
$Tbbyppc=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],37);

// total production down time due to size change
$Tdntimesc= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],52);
//ttotal production down time in minutes
$scdntimemin=date('H', strtotime($Tdntimesc))*60 + date('i', strtotime($Tdntimesc));
// down time due to size change in hours
$scdntimeinhr=$scdntimemin/60;
// total bypass production due to size change
$Tbbyprodsc=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],52);
// total bypass due to size change
$Tbbypsc=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],52);

// total production down time due to lahar
$Tdntimelr= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],26);
//ttotal production down time due lahar in minutes
$lrdntimemin=date('H', strtotime($Tdntimelr))*60 + date('i', strtotime($Tdntimelr));
//ttotal production down time in hours due to lahar
$lrdntimeinhr=$lrdntimemin/60;
// total bypass production due to lahar
$Tbbyprodlr=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],26);
// total bypass due to lahar
$Tbbyplr=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],26);

//total down time due to chilli
$Tdntimechilli= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],10);
// total down time due to chill in min
$chillidntimemin=date('H', strtotime($Tdntimechilli))*60 + date('i', strtotime($Tdntimechill));
// total down time in hr in due to chill
$chillidntimeinhr=$chilldntimemin/60;
// total bypass production due to chilli
$Tbbyprodchilli=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],10);
// total bypass due to chilli
$Tbbypchilli=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],10);


//total down time due to crack
$Tdntimecrack= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],4);
// total down time due to crack in min
$crackdntimemin=date('H', strtotime($Tdntimecrack))*60 + date('i', strtotime($Tdntimecrack));
// total down time in hr in due to crack
$crackdntimeinhr=$chilldntimemin/60;
// total bypass production due to crack
$Tbbyprodcrack=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],4);
// total bypass  due to crack
$Tbbypcrack=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],4);

//total down time due to piping
$Tdntimepiping= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],41);
// total down time due to piping in min
$crackdntimemin=date('H', strtotime($Tdntimepiping))*60 + date('i', strtotime($Tdntimepiping));
// total down time in hr in due to piping
$pipingdntimeinhr=$chilldntimemin/60;
// total bypass production due to piping
$Tbbyprodpiping=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],41);
// total bypass due to piping
$Tbbyppiping=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],41);

// production down time due to ccd composition
$Tdntimeccd= RollingBD::getInstance()->get_prod_down_time_reason($_POST['kpidate'],45);
// production down time in mins due to ccd composition
$ccddntimemin=date('H', strtotime($Tdntimeccd))*60 + date('i', strtotime($Tdntimeccd));
// production down time in hr due to ccd composition
$ccddntimeinhr=$ccddntimemin/60;
// bypass production due to ccd composition
$Tbbyprodccd=RollingBD::getInstance()->get_bypass_prod_reason($_POST['kpidate'],45);
// total bypass due to ccd composition
$Tbbypccd=RollingBD::getInstance()->get_billets_bypass_reason($_POST['kpidate'],45);
//
$rfmr8=RollingBD::getInstance()->get_8_rfmr($_POST['kpidate']);
$rfmr10=RollingBD::getInstance()->get_10_rfmr($_POST['kpidate']);
$rfmr12=RollingBD::getInstance()->get_12_rfmr($_POST['kpidate']);
$rfmr16=RollingBD::getInstance()->get_16_rfmr($_POST['kpidate']);
$rfmr20=RollingBD::getInstance()->get_20_rfmr($_POST['kpidate']);
$rfmr25=RollingBD::getInstance()->get_25_rfmr($_POST['kpidate']);
$rfmr28=RollingBD::getInstance()->get_28_rfmr($_POST['kpidate']);
$rfmr32=RollingBD::getInstance()->get_32_rfmr($_POST['kpidate']);

$cut8=RollingBD::getInstance()->get_8_cut($_POST['kpidate']);
$cut10=RollingBD::getInstance()->get_10_cut($_POST['kpidate']);
$cut12=RollingBD::getInstance()->get_12_cut($_POST['kpidate']);
$cut16=RollingBD::getInstance()->get_16_cut($_POST['kpidate']);
$cut20=RollingBD::getInstance()->get_20_cut($_POST['kpidate']);
$cut25=RollingBD::getInstance()->get_25_cut($_POST['kpidate']);
$cut28=RollingBD::getInstance()->get_28_cut($_POST['kpidate']);
$cut32=RollingBD::getInstance()->get_32_cut($_POST['kpidate']);



$net8mm=$T8mmprod-($rfmr8+$cut8+$BL8mm);
$net10mm=$T10mmprod-($rfmr10+$cut10+$BL10mm);
$net12mm=$T12mmprod-($rfmr12+$cut12+$BL12mm);
$net16mm=$T16mmprod-($rfmr16+$cut16+$BL16mm);
$net20mm=$T20mmprod-($rfmr20+$cut20+$BL20mm);
$net25mm=$T25mmprod-($rfmr25+$cut25+$BL25mm);
$net28mm=$T28mmprod-($rfmr28+$cut28+$BL28mm);
$net32mm=$T32mmprod-($rfmr32+$cut32+$BL32mm);