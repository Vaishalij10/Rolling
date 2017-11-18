<?php
// THIS PAGE IS TO GET THE DETAIS OF THE PERHEATPRODUCTION THE EXCEL
/** FETCH THE DATA FROM THE PER HEAT PRODUCTION TABLE AND FORMATTED IN THE EXCEL FORMAT
/**DATE        CHANGESINTHESECTION                  USERNAME 
 * 2017-09-12   CODE IS COMPLETED IN THE PROD       VAISHALI JAIN 
 * 
 * 
 * 
 * 
 * 
 */
include ('../Connection.php');

session_start();
$date1 = $_SESSION["date1"];
$date2 = $_SESSION["date2"];

 $res_ex = mysqli_query($link,"SELECT  `kpidate`, `heatcount`, `grosstmt`, `totalccmprod`, `heatruntime`, `heatgap`, `pertonpowerunits`,  
        `net8mm`, `net10mm`, `net12mm`, `net16mm`, `net20mm`, `net25mm`, `net28mm`, `net32mm`, 
        `nettmt`, `monthlynettmt`,`Tprolledrolling`, 
        `Tpfromccm`, `24hrshotrolling`, `monthlyhotrolling`,`Tendcutmrpercent`, 
        `Tmrpercent`, `Tmilmrpercent`, `Tmissroll`, `Tmillmissroll`, `Telecmissroll`, `Tmechmissroll`, 
        `Tccmqltymissroll`, `Tfncemissroll`, `Tmpebmissroll`, `Indepmissroll`, `depmissroll`, 
        `Tcuttingpercent`, `Tcutting`, `Tcuttingmillpercent`, `Tcuttingmill`, `Tcuttingccmpercent`, 
        `Tcuttingccm`, `Tcuttingccdpercent`, `Tcuttingccd`, `Tcuttingmpebpercent`, `Tcuttingmpeb`,
        `Tpermissrollcuttingprod`, `pdtimemillmin`, `pdtimemillhr`, `Tbypassmill`, `Tperbbyprodmill`, 
        `pdtimemillmechmin`, `pdtimemechhr`, `Tbypassmech`, `Tperbyprodmech`, `pdtimemillelecmin`, 
        `pdtimemillelechr`, `Tbypasselec`, `Tperbbyprodelec`, `pdtimepcmin`, `pdtimepchr`, 
        `Tbypasspc`, `Tperbyprodpc`, `pdtimescmin`, `pdtimeschr`, `Tbypasssc`, `Tperbyprodsc`, 
        `pdtimementmin`, `pdtimementhr`, `Tbypassment`, `Tperprodment`, `pdtimempebmin`, `pdtimempebhr`, `Tbypassmpeb`, 
        `Tperprodmpeb`, `pdtimelaharmin`, `pdtimelaharhr`, `Tbypasslahar`, `Tperprodlahar`, `pdtimecrackmin`, `pdtimecrackhr`,
        `Tbypasscrack`, `Tperprodcrack`, `pdtimepipingmin`, `pdtimepipinghr`, `Tbypasspiping`, `Tperprodpiping`, `pdtimemopenmin`, 
        `pdtimemopenhr`, `Tbypassmopen`, `Tperprodmopen`, `pdtimechillimin`, `pdtimechillihr`, `Tbypasschill`, `Tperprodchill`, 
        `pdtimeccdmin`, `pdtimeccdhr`, `Tbypassccd`, `Tperprodccd`, `Tperbyprodmill`, `Tperbyprodccm`, `totalbypassduetomill`,
        `totalbypassduetoccm` FROM `rollingkpi` 
            where kpidate >= '$date1' and kpidate <= '$date2' order by kpidate");
 
 
 
$columnHeader = '';
$columnHeader = "kpidate" . "\t" . "heatcount" . "\t" ."grosstmt" . "\t" . "totlccmprod" . "\t" .
        "heatruntime " . "\t" . "heatgap" . "\t" .  "pertonunits" . "\t" .
        "net8mm" . "\t"."net10mm" . "\t". "net12mm" . "\t". "net16mm" . "\t". "net20mm" . "\t". "net25mm" . "\t". "net28mm" . "\t". "net32mm" . "\t".
        "nettmt" ."\t"."monthlynettmt" . "\t"."OKpiecesrolled" . "\t".
        "Tpiecesfromccm" . "\t"."24hrshotrolling" . "\t".  "monthlyhotrolling" .  "\t"."Tendcutmissrol(%)" . "\t".
        "Missroll(%)" . "\t"."MillMissroll(%)" . "\t"."Total Missroll" . "\t".  "Total Mill Missroll" . "\t". "Total elec Missroll" . "\t"."Total Mech Missroll" . "\t".
        "Total CCM/qlty missroll" . "\t"."Total Furnace Missroll" . "\t"."Total MPEB Missroll" . "\t".  "Independent Missroll" . "\t". "Dependent Missroll" . "\t".
        "Tcutting(%)" . "\t"."Tcutting" ."\t"."TcuttingMill(%)" . "\t"."TcuttingMill" . "\t".  "TcuttingMPEB(%)" . "\t". "TcuttingMPEB" . "\t".
        "TcuttingCCM(%)" . "\t"."TcuttingCCM" ."\t"."TcuttingCDD(%)" . "\t"."TcuttingCCD" . "\t".  "Tmissrollccuttingprod(%)" . "\t". 
        "Bypass prod due to MILL(min)" . "\t"."Bypass prod due to MILL(HR)" ."\t"."Tbypass due to MILL" . "\t"."Tbypass prod due to MILL(%)" . "\t".  
        "Bypass prod due to MECH(min)" . "\t"."Bypass prod due to MECH(HR)" ."\t"."Tbypass due to MECH" . "\t"."Tbypass prod due to MECH(%)" . "\t".  
        "Bypass prod due to ELEC(min)" . "\t"."Bypass prod due to ELEC(HR)" ."\t"."Tbypass due to ELEC" . "\t"."Tbypass prod due to ELEC(%)" . "\t".  
        "Bypass prod due to PC(min)" . "\t"."Bypass prod due to PC(HR)" ."\t"."Tbypass due to PC" . "\t"."Tbypass prod due to PC(%)" . "\t".  
        "Bypass prod due to SC(min)" . "\t"."Bypass prod due to SC(HR)" ."\t"."Tbypass due to SC" . "\t"."Tbypass prod due to SC(%)" . "\t".  
        "Bypass prod due to MAINTENCE(min)" . "\t"."Bypass prod due to MAINTENCE(HR)" ."\t"."Tbypass due to MAINTENCE" . "\t"."Tbypass prod due to MAINTENCE(%)" . "\t".  
        "Bypass prod due to MPEB(min)" . "\t"."Bypass prod due to MPEB(HR)" ."\t"."Tbypass due to MPEB" . "\t"."Tbypass prod due to MPEB(%)" . "\t".
        "Bypass prod due to LAHAR(min)" . "\t"."Bypass prod due to LAHAR(HR)" ."\t"."Tbypass due to LAHAR" . "\t"."Tbypass prod due to LAHAR(%)" . "\t".
        "Bypass prod due to CRACK(min)" . "\t"."Bypass prod due to CRACK(HR)" ."\t"."Tbypass due to CRACK" . "\t"."Tbypass prod due to CRACK(%)" . "\t".
        "Bypass prod due to PIPING(min)" . "\t"."Bypass prod due to PIPING(HR)" ."\t"."Tbypass due to PIPING" . "\t"."Tbypass prod due to PIPING(%)" . "\t".
        "Bypass prod due to MOUTHOPEN(min)" . "\t"."Bypass prod due to MOUTHOPEN(HR)" ."\t"."Tbypass due to MOUTHOPEN" . "\t"."Tbypass prod due to MOUTHOPEN(%)" . "\t".
        "Bypass prod due to CHILLI(min)" . "\t"."Bypass prod due to CHILLI(HR)" ."\t"."Tbypass due to CHILLI" . "\t"."Tbypass prod due to CHILLI(%)" . "\t".
        "Bypass prod due to CCD(min)" . "\t"."Bypass prod due to CCD(HR)" ."\t"."Tbypass due to CCD" . "\t"."Tbypass prod due to CCD(%)" . "\t".
        "TOTAL BYPASS PROD MILL(%)" . "\t"."TOTAL BYPASS PROD CCM(%)" ."\t"."TOTAL BYPASS DUE TO MILL(NO.)" . "\t"."TOTAL BYPASS DUE TO CCM (NO.)" ."\t".
        
$setData = '';

while ($rec_ex = mysqli_fetch_row($res_ex)) {
    $rowData = '';
    foreach ($rec_ex as $value) {
        $value = '"' . $value . '"' . "\t";
        $rowData .= $value;
    }
    $setData .= trim($rowData) . "\n";
}


header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=RollingKPI.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo ucwords($columnHeader) . "\n" . $setData . "\n";
?> 