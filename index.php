<?php
$jql1 = "";


if(isset($_GET['jql'])) {
    $jql1 = $_GET['jql'];
}
else{
    $jql1 = 'project = "Incident Management" and status = Done and created >= 2024-01-01';
}



$basicAuth = "BASE";
if(isset($_GET['base'])) {
    $basicAuth = $_GET['base'];
}






$totaldata = array();
$total_counted = 0;
$flag = 1;
$startAt = 0;


while($flag == 1)
{
$jql = urlencode($jql1) . '\n';
$jql = $jql."&maxResults=50&startAt=".$startAt;
$url = 'https://seriea.atlassian.net/rest/api/2/search?jql='.$jql.'';

$headers = array(
    "Authorization: Basic ".$basicAuth."",
    "Content-Type: application/json",
    "Content-Type: application/x-www-form-urlencoded"
);

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, 0);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($curl);

if ($response === false) {
    die('Curl error: ' . curl_error($curl));
}
curl_close($curl);
$data = json_decode($response, TRUE);
$total_record = $data['total'];
$data = $data['issues'];




if(count($data) < 50){
     for($a = 0; $a < count($data); $a++){
            
        $total_counted++;
        $issue_description = $data[$a]['fields']['summary'];
        $brand = $data[$a]['fields']['customfield_10073']['value'];
        $key = $data[$a]['key'];
        $created = $data[$a]['fields']['created'];
        $resolution = $data[$a]['fields']['resolution']['name'];
        $components = $data[$a]['fields']['customfield_10063']['value'];
        $severity_name = $data[$a]['fields']['priority']['name'];
        $severity = $data[$a]['fields']['priority']['id'];
        $assignee_email = $data[$a]['fields']['assignee']['emailAddress'];
        $assignee = $data[$a]['fields']['assignee']['displayName'];
        $updated = $data[$a]['fields']['updated'];
        $status = $data[$a]['fields']['status']['name'];
        $description = $data[$a]['fields']['description'];
        $reporter = $data[$a]['fields']['reporter']['displayName'];
        $sevv = $data[$a]['fields']['customfield_10057']['value'];
        
        $eachdata = array();
        $eachdata['issue_description'] = $issue_description;
        $eachdata['brand'] = $brand;
        $eachdata['key'] = $key;
        $eachdata['created'] = $created;
        $eachdata['resolution'] = $resolution;
        $eachdata['components'] = $components;
        $eachdata['severity_name'] = $severity_name;
        $eachdata['severity'] = $severity;
        $eachdata['assignee_email'] = $assignee_email;
        $eachdata['assignee'] = $assignee;
        $eachdata['updated'] = $updated;
        $eachdata['status'] = $status;
        $eachdata['description'] = $description;
        $eachdata['reporter'] = $reporter;
        $eachdata['sno'] = $total_counted;
        $eachdata['sevv'] = $sevv;
        array_push($totaldata,$eachdata);
    }

    $flag = 0;
}
else{
    
    for($a = 0; $a < count($data); $a++){
        
        $total_counted++;
        $issue_description = $data[$a]['fields']['summary'];
        $brand = $data[$a]['fields']['customfield_10073']['value'];
        $key = $data[$a]['key'];
        $created = $data[$a]['fields']['created'];
        $resolution = $data[$a]['fields']['resolution']['name'];
        $components = $data[$a]['fields']['customfield_10063']['value'];
        $severity_name = $data[$a]['fields']['priority']['name'];
        $severity = $data[$a]['fields']['priority']['id'];
        $assignee_email = $data[$a]['fields']['assignee']['emailAddress'];
        $assignee = $data[$a]['fields']['assignee']['displayName'];
        $updated = $data[$a]['fields']['updated'];
        $status = $data[$a]['fields']['status']['name'];
        $description = $data[$a]['fields']['description'];
        $reporter = $data[$a]['fields']['reporter']['displayName'];
        $sevv = $data[$a]['fields']['customfield_10057']['value'];
        
        $eachdata = array();
        $eachdata['issue_description'] = $issue_description;
        $eachdata['brand'] = $brand;
        $eachdata['key'] = $key;
        $eachdata['created'] = $created;
        $eachdata['resolution'] = $resolution;
        $eachdata['components'] = $components;
        $eachdata['severity_name'] = $severity_name;
        $eachdata['severity'] = $severity;
        $eachdata['assignee_email'] = $assignee_email;
        $eachdata['assignee'] = $assignee;
        $eachdata['updated'] = $updated;
        $eachdata['status'] = $status;
        $eachdata['description'] = $description;
        $eachdata['reporter'] = $reporter;
        $eachdata['sno'] = $total_counted;
        $eachdata['sevv'] = $sevv;
        array_push($totaldata,$eachdata);
    }
    
    $count = count($data);
    $count = (int)$count;
    $startAt = $startAt + 50;
}



}




?>
<!DOCTYPE html>
<html>
    <head>
    <title>Jira Metrics</title>
    <style type="text/css">
    html {
        -webkit-tap-highlight-color: rgba(0,0,0,0);
    	background: #e8e8e8;
    }
    
    .body{
        width: 100%;
    	height: auto;
    	min-height: 100%;
        background: #fff;
        font-family: Monospace;
    }
    
    .body >.table{
        width: 100%;
    	height: auto;
    	padding-top: 20px;
    }
    
    .body >.table >.header{
        width: 100%;
    	height: 40px;
    	display: flex;
    	color: #333;
    	line-height: 2.5;
    	font-size: 1.2em;
    	padding-left: 5px;
    	background: #d7dbdb;
    }
    
    .body >.table >.header >.sno{
        width: 2%;
    	height: 100%;
    }
    
    .body >.table >.header >.key{
        width: 5%;
    	height: 100%;
    	padding-left: 10px;
    }
    
    .body >.table >.header >.summary{
        width: 20%;
    	height: 100%;
    }.body >.table >.header >.assignee{
        width: 10%;
    	height: 100%;
    }.body >.table >.header >.time{
        width: 10%;
    	height: 100%;
    }
    .body >.table >.header >.sev{
        width: 10%;
    	height: 100%;
    }
    
    
    
    
    .body >.table >.content{
        width: 100%;
        height: auto;
        max-height: 100px;
    	display: flex;
    	color: #333;
    	font-size: 0.8em;
    	padding-left: 5px;
    	border-bottom: 1px solid #c1c9c9;
    	font-family: Sans-serif;
    	padding-top: 5px;
    }
    .body >.table >.content >.sno{
        width: 2%;
    	height: 100%;
    	line-height: 3.5;
    }
    
    .body >.table >.content >.key{
        width: 5%;
    	height: 100%;
    	padding-left: 10px;
    	line-height: 3.5;
    }
    
    .body >.table >.content >.summary{
        width: 20%;
    	height: 80%;
    	white-space: nowrap;
    	overflow-y: hidden;
    	/*text-overflow: ellipsis;*/
    	padding: 5px;
    	font-size: 1em;
    	font-weight: 600;
    }.body >.table >.content >.assignee{
        width: 10%;
    	height: 100%;
    	line-height: 3.5;
    }.body >.table >.content >.time{
        width: 10%;
    	height: 100%;
    	line-height: 3.5;
    }
    .body >.table >.content >.sev{
        width: 10%;
    	height: 100%;
    	white-space: nowrap;
    	overflow: hidden;
    	text-overflow: ellipsis;
    	line-height: 3.5;
    }
    
    
    
    .body >.jql{
        width: 100%;
        height: 35px;
    	color: #333;
    	text-align: center;
    	border: 1px solid #c1c9c9;
    	font-family: Sans-serif;
    	font-size: 1em;
    	line-height: 1.6;
    }
    
    .body >.jql1{
        width: 100%;
        height: 35px;
    	color: #333;
    	text-align: center;
    	border: 1px solid #c1c9c9;
    	font-family: Sans-serif;
    	font-size: 1em;
    	line-height: 1.7;
    }
    
    
    
    
    .body >.table >.summary{
        width: 100%;
        height: auto;
    	min-height: 30px;
    	color: #333;
    	padding-left: 5px;
    	border: 1px solid #c1c9c9;
    	font-family: Sans-serif;
    	display: flex;
    }
    .body >.table >.summary >.eachsum{
        width: 20%;
        height: 30px;
    	color: #333;
    	line-height: 2;
    	font-size: 1.1em;
    	text-align: center;
    }
    
    .body >.searchbox{
        width: 99%;
        height: 50px;
        color: #333;
        border: 1px solid #c1c9c9;
        font-family: Sans-serif;
        display: flex;
        padding-top: 10px;
        padding-left: 5px;
        padding-right: 5px;
    }
    .body >.searchbox >form{
        width: 100%;
        height: 100%;
        display: flex;
    }
    
    .body >.searchbox>.ibox{
        width: 56%;
        height: 80%;
    }
    
    .body >.searchbox >.ibox >input{
        width: 100%;
        height: 100%;
    	color: #333;
        font-size: 0.7em;
        text-align: center;
    }
    
     .body >.searchbox>.ibox1{
        width: 15%;
        height: 80%;
    }
    
    .body >.searchbox >.ibox1 >input{
        width: 100%;
        height: 100%;
    	color: #333;
        font-size: 0.7em;
        text-align: center;
    }
    
    .body >.searchbox >.searchbtn{
        width: 12%;
        height: 90%;
        font-size: 1em;
        margin-left: 3%;
    }
    .body >.searchbox >.searchbtn >input{
        width: 100%;
        height: 100%;
        font-size: 1em;
        cursor: pointer;
    }
    </style>

    </head>
    <body>
        <div class = "body">
            <div class = "searchbox">
                    <div class = "ibox"><input type = "text" placeholder = "ENTER JQL" name = "jql" id = "jql" value = 'project = "Incident Management" and status = Done and created >= 2024-01-01'></div>
                    <div class = "ibox1"><input type = "text" placeholder = "ENTER EMAIL" name = "username" id = "username"></div>
                    <div class = "ibox1"><input type = "text" placeholder = "ENTER TOKEN" name = "password" id = "password"></div>
                    <div class = "searchbtn"><input type="submit" name="submit"
                   value="Submit" id = "searchbtn"></div>
            </div>
            <div id = "tableclick" style = "height: 50px; width: 99.5%; border: 2px solid #68686e; font-size: 1.8em; line-height: 1.6; text-align: center; font-weight: 600; background: #45465c; color: #fff">ISSUES TABLE</div>
            <div class = "jql">
                TOTAL RECORD = <?php echo $total_record?> | JQL: [ <?php echo $jql1?> ]
            </div>
            <div class = "jql1">
                <div class = "dlink">
                    There has been <?php echo $total_record?> Incidents. Download data from <span style = "text-decoration: underline; color: blue; cursor: pointer;"  onclick = "tableToCSV();">here</span>
                </div>
            </div>
            
            
            
            
            
            
            <table id = "tablebox" border="1" cellspacing="0" cellpadding="12">
                <tr>
                    <th>#</th>
                    <th>KEY</th>
                    <th>SEVERITY</th>
                    <th style="white-space: nowrap; overflow-y: hidden; text-overflow: ellipsis;">SUMMARY</th>
                    <th>STATUS</th>
                    <th>BRAND</th>
                    <th>ASSIGNEE</th>
                    <th>REPORTER</th>
                    <th>CREATED</th>
                    <th>UPDATED</th>
                    <th>TIME SPENT (hrs)</th>
                    <th>TIME SPENT (mins)</th>
                </tr>
                
                
                <?php
                
                $sev1 = 0; $sev2 = 0; $sev3 = 0; $sev4 = 0; $sev5 = 0;
                $employee = array();
                $all_emp_sev = array();
                $total_issue = 0;
                $all_component = array();
                $all_sevtime = array();
                $all_sevtime_count = array();
                
                for($a = 0; $a < count($totaldata); $a++){
                    
                $i = $a + 1;
                $issue_description = $totaldata[$a]['issue_description'];
                $brand = $totaldata[$a]['brand'];
                $key = $totaldata[$a]['key'];
                $created = $totaldata[$a]['created'];
                $resolution = $totaldata[$a]['resolution'];
                $components = $totaldata[$a]['components'];
                $severity_name = $totaldata[$a]['severity_name'];
                $severity = $totaldata[$a]['severity'];
                $assignee_email = $totaldata[$a]['assignee_email'];
                $assignee = $totaldata[$a]['assignee'];
                $updated = $totaldata[$a]['updated'];
                $status = $totaldata[$a]['status'];
                $description = $totaldata[$a]['description'];
                $reporter = $totaldata[$a]['reporter'];
                
                
                
                
                
                
                
                $createdb = explode("T", $created);
                $createdb1 = explode(".", $createdb[1]);
                $created = $createdb[0]." ".$createdb1[0];
                
                
                
                $updatedb = explode("T", $updated);
                $updatedb1 = explode(".", $updatedb[1]);
                $updated = $updatedb[0]." ".$updatedb1[0];
                
                
                 
                $start_datetime = new DateTime($updated); 
                $diff = $start_datetime->diff(new DateTime($created)); 
                 
 // echo $diff->days.' Days total<br>'; // echo $diff->y.' Years<br>'; // echo $diff->m.' Months<br>'; // echo $diff->d.' Days<br>'; // echo $diff->h.' Hours<br>';  // echo $diff->i.' Minutes<br>'; // echo $diff->s.' Seconds<br><br><br>';
                
                $min = $diff->i;
                
                $days = $diff->days;
                $h1 = $days * 24;
                $h2 = $diff->h;
                
                $totalhrs = bcadd($h1, $h2);
                
                $mins = bcmul($totalhrs, 60);
                $totalmin = bcadd($mins, (int)$min);





                
                #Sorting Components
                if(array_key_exists($components,$all_component)) { 
                    $value = $all_component[''.$components.''];
                    $value = (int)$value;
                    $value++;
                    $all_component[''.$components.''] = $value;
                    
                    
                } else { 
                    $all_component[''.$components.''] = 1;
                } 
            
                
                $sevv = $totaldata[$a]['sevv'];
                $sevvb = explode(":", $sevv);
                $sevno = $sevvb[0];
                if($sevno == 1){$sev1++;}
                elseif($sevno == 2){$sev2++;}
                elseif($sevno == 3){$sev3++;}
                elseif($sevno == 4){$sev4++;}
                elseif($sevno == 5){$sev5++;}
                
                
                
                
                if($status == 'Done'){
                    
                    if(array_key_exists($assignee,$employee)) { 
                        $value = $employee[''.$assignee.''];
                        $value = (int)$value;
                        $value++;
                        $employee[''.$assignee.''] = $value;
                        
                        
                    } else { 
                        $employee[''.$assignee.''] = 1;
                    } 
                    
                    
                    #seperate severity for each employee
                    if(array_key_exists($assignee,$all_emp_sev)) { 
                        
                        $this_emp_sev = $all_emp_sev[''.$assignee.''];
                        
                        #checking if sev record has been created for employee
                        if(array_key_exists($sevno, $this_emp_sev)) { 
                        
                            $value = $this_emp_sev[$sevno];
                            $value = (int)$value;
                            $value++;
                            $all_emp_sev[''.$assignee.''][$sevno] = $value;
                        }
                        else{
                             $all_emp_sev[''.$assignee.''][$sevno] = 1;
                        }
                        
                        
                    } else { 
                        $employee[''.$assignee.''] = array();
                        $all_emp_sev[''.$assignee.''][$sevno] = 1;
                    } 
                    
                    
                    
                    
                    
                    
                    
                    #seperate severity lead hour;
                    if(array_key_exists($sevno, $all_sevtime)) { 
                    
                        $value = $all_sevtime[$sevno];
                        $value = (int)$value;
                        $value = bcadd($value, $totalmin);
                        $all_sevtime[$sevno] = $value;
                        
                        
                        $count = $all_sevtime_count[$sevno];
                        $count = (int)$count;
                        $count++;
                        $all_sevtime_count[$sevno] = $count;
                    }
                    else{
                         $all_sevtime[$sevno] = $totalmin;
                         $all_sevtime_count[$sevno] = 1;
                    }
                          
                }
                
                
                

                ?>
                <tr>
                    <td><?php echo $i?></td>
                    <td><?php echo $key?></td>
                    <td title = "<?php echo $description?>"><?php echo $sevv?></td>
                    <td style="white-space: nowrap; overflow-y: hidden; text-overflow: ellipsis;"><?php echo $issue_description?></td>
                    <td><?php echo $status?></td>
                    <td><?php echo $brand?></td>
                    <td><?php echo $assignee?></td>
                    <td><?php echo $reporter?></td>
                    <td><?php echo $created?></td>
                    <td><?php echo $updated?></td>
                    <?php if($totalhrs == 0){
                    ?>
                     <td><?php echo $min?> mins</td>
                    <?php
                    }
                    else{?>
                    <td><?php echo $totalhrs?> hrs</td>
                    <?php } ?>
                    <td><?php echo $totalmin?> mins</td>
                </tr>
                <?php $total_issue++; } ?>
                
                
                
                
                
               
                
                <?php
                
                
                
                
                #get Individual component ratio
                $dataPointComponentRatio = array();
                $total_component1 = 0;
                #get Individual component count
                $dataPointComponent = array();
                $total_component = 0;
                $ecomponent_names = array_keys($all_component);
                
                 for($h = 0; $h < count($ecomponent_names); $h++){
                    $thiskey = $ecomponent_names[$h];
                    $thisvalue = $all_component[''.$thiskey.''];
                    if($thiskey){
                        $total_component1 = bcadd($total_component1, (int)$thisvalue);
                    }
                    
                }
                
                
                
                for($h = 0; $h < count($ecomponent_names); $h++){
                    $thiskey = $ecomponent_names[$h];
                    $thisvalue = $all_component[''.$thiskey.''];
                    
                    $compperc = bcmul((int)$thisvalue, 100,2);
                    $compperc = bcdiv($compperc, $total_component1,2);
                    
                    if($thiskey){
                        $thisEmpData = array("label"=>$thiskey, "y"=>$thisvalue);
                        array_push($dataPointComponent,$thisEmpData);
                        
                        $thisEmpData1 = array("label"=>$thiskey." - ".$thisvalue."", "y"=>$compperc);
                        array_push($dataPointComponentRatio,$thisEmpData1);
                        
                        $total_component = bcadd($total_component, (int)$thisvalue);
                    }
                    
                }
                
                
                
                
                
                
                
                
                $dataPointemployee = array();
                $dataPointemployeeP = array();
                $total_task = 0;
                
                #get Individual task count for every employee
                $employee_names = array_keys($employee);
                for($b = 0; $b < count($employee_names); $b++){
                    $thiskey = $employee_names[$b];
                    $thisvalue = $employee[''.$thiskey.''];
                    
                    if($thiskey){
                        $thisEmpData = array("label"=>$thiskey, "y"=>$thisvalue);
                        array_push($dataPointemployee,$thisEmpData);
                        $total_task = bcadd($total_task, (int)$thisvalue);
                    }
                    
                }
                
                
                #calculate percentage for employee task ratio
                for($b = 0; $b < count($employee_names); $b++){
                    $thiskey = $employee_names[$b];
                    $thisvalue = $employee[''.$thiskey.''];
                    
                    if($thiskey){
                        $thisp = bcmul($thisvalue,100,2);
                        $thisp = bcdiv($thisp, (int)$total_task,2);
                        $thisEmpData = array("label"=>$thiskey." - ".$thisvalue."", "y"=>$thisp);
                        array_push($dataPointemployeeP,$thisEmpData);
                    }
                    
                }
                
                
                
                
                
                
                
                $dataPointLeadTime = array();
                $sev_leadtime_keys = array_keys($all_sevtime);
                #calculate average lead time for each severity
                for($b = 0; $b < count($all_sevtime); $b++){
                    $thiskey = $sev_leadtime_keys[$b];
                    $this_leadtimeav = $all_sevtime[$thiskey];
                    $this_leadtimecount = $all_sevtime_count[$thiskey];
                    
                    $lav = bcdiv($this_leadtimeav, $this_leadtimecount, 2);
                    $lavhour = bcdiv($lav, 60,2);
                    
                    $thisLtData = array("label"=> "SEV ".$thiskey, "y"=>$lavhour);
                    array_push($dataPointLeadTime,$thisLtData);
                    
                }
                
                
                
                
                
                
                $sev1 = (int)$sev1;
                $sev2 = (int)$sev2;
                $sev3 = (int)$sev3;
                $sev4 = (int)$sev4;
                $sev5 = (int)$sev5;
                
                $totalsev = $sev1+$sev2+$sev3+$sev4+$sev5;
                $sev1p = bcmul($sev1,100,2);
                $sev1p = bcdiv($sev1p, $totalsev,2);
                
                $sev2p = bcmul($sev2,100,2);
                $sev2p = bcdiv($sev2p, $totalsev,2);
                
                $sev3p = bcmul($sev3,100,2);
                $sev3p = bcdiv($sev3p, $totalsev,2);
                
                $sev4p = bcmul($sev4,100,2);
                $sev4p = bcdiv($sev4p, $totalsev,2);
                
                $sev5p = bcmul($sev5,100,2);
                $sev5p = bcdiv($sev5p, $totalsev,2);
                
                $dataPoints = array( 
                	array("label"=>"SEV1 - ".$sev1."", "y"=>$sev1p),
                	array("label"=>"SEV2 - ".$sev2."", "y"=>$sev2p),
                	array("label"=>"SEV3 - ".$sev3."", "y"=>$sev3p),
                	array("label"=>"SEV4 - ".$sev4."", "y"=>$sev4p),
                	array("label"=>"SEV5 - ".$sev5."", "y"=>$sev5p)
                );
                
                $dataPoints2 = array( 
                	array("label"=>"SEV1 Count", "y"=>$sev1),
                	array("label"=>"SEV2 Count", "y"=>$sev2),
                	array("label"=>"SEV3 Count", "y"=>$sev3),
                	array("label"=>"SEV4 Count", "y"=>$sev4),
                	array("label"=>"SEV5 Count", "y"=>$sev5)
                )
                
                
                
                
                
                ?>
            </tr> 
            
        </table>
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        <!--<div id = "sevclick" style = "height: 50px; width: 99.5%; border: 2px solid #68686e; font-size: 1.8em; font-family: Monospace; line-height: 1.6; text-align: center; font-weight: 600; background: #45465c; color: #fff">SEVERITY COUNT AND RATIO CHART</div>-->
        <div id = "sevbox" style = "height: auto; width: auto;">
            <div id="chartContainer" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>
            <!--<div id="chartContainer2" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>-->
        </div>
        
        
        <!--<div id = "sevltclick" style = "height: 50px; width: 99.5%; border: 2px solid #68686e; font-size: 1.8em; font-family: Monospace; line-height: 1.6; text-align: center; font-weight: 600; background: #45465c; color: #fff">AVERAGE SEVERITY LEAD TIME CHART</div>-->
        <div id = "sevltbox" style = "height: auto; width: auto;">
            <div id="chartContainerlt" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>
        </div>
        
        
        
        
        <div id = "compclick" style = "height: 50px; width: 99.5%; border: 2px solid #68686e; font-size: 1.8em; font-family: Monospace; line-height: 1.6; text-align: center; font-weight: 600; background: #45465c; color: #fff">COMPONENT COUNT AND RATIO CHART</div>
        <div id = "compbox" style = "height: auto;  width: auto;">
            <!--<div id="chartContainerCom1" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>-->
            <div id="chartContainerCom2" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>
        </div>
        
        
        <div id = "empclick" style = "height: 50px; width: 99.5%; border: 2px solid #68686e; font-size: 1.8em; line-height: 1.6; font-family: Monospace; text-align: center; font-weight: 600; background: #45465c; color: #fff">ALL EMPLOYEE TASK CONTRIBUTION CHART</div>
        <div id = "empbox" style = "height: auto; width: auto;">
            <div id="chartContainer3" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>
            <!--<div id="chartContainer4" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>-->
        </div>
        
        <div id = "iempclick" style = "height: 50px; width: 99.5%; border: 2px solid #68686e; font-size: 1.8em; line-height: 1.6; font-family: Monospace; text-align: center; font-weight: 600; background: #45465c; color: #fff">INDIVIDUAL EMPLOYEE SEVERITY CONTRIBUTION CHART</div>
        <div id = "iempbox" style = "height: auto; width: 100%;">
        <?php 
        for($d = 0; $d < count($all_emp_sev); $d++){
            ?>
            <div id="chartSevContainer<?php echo $d?>" style="height: 370px; width: 100%; border: 1px solid #babfbf; margin-bottom: 40px;"></div>
            <?php
        }
        ?>
        </div>
    </body>
</html>

<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script type="text/javascript">




$(document).on("click", "#searchbtn", function(){
    var jql = $("#jql").val();
    var username = $("#username").val();
    var password = $("#password").val();
    var stringToEncode = username+":"+password;
    var base = btoa(stringToEncode);
    window.location.search = '?jql='+jql+'&base='+base+'';
})



$("#compclick").click(function(){
    if($("#compbox").is(":hidden")){
        $("#compbox").show();
    }
    else{
        $("#compbox").hide();
    }
});


$("#sevclick").click(function(){
    if($("#sevbox").is(":hidden")){
        $("#sevbox").show();
    }
    else{
        $("#sevbox").hide();
    }
});


$("#sevltclick").click(function(){
    if($("#sevltbox").is(":hidden")){
        $("#sevltbox").show();
    }
    else{
        $("#sevltbox").hide();
    }
});


$("#empclick").click(function(){
    if($("#empbox").is(":hidden")){
        $("#empbox").show();
    }
    else{
        $("#empbox").hide();
    }
});


$("#iempclick").click(function(){
    if($("#iempbox").is(":hidden")){
        $("#iempbox").show();
    }
    else{
        $("#iempbox").hide();
    }
});


$("#tableclick").click(function(){
    if($("#tablebox").is(":hidden")){
        $("#tablebox").show();
    }
    else{
        $("#tablebox").hide();
    }
});



window.onload = function() {

 $("#tablebox").hide();
 




var chart = new CanvasJS.Chart("chartContainerCom2", {
	animationEnabled: true,
	title: {
		text: "Component %"
	},
	subtitles: [{
		text: "Total Component = <?php echo $total_component?>"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPointComponentRatio, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();





var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title: {
		text: "Severity %"
	},
	subtitles: [{
		text: "Percentage"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();





var chart = new CanvasJS.Chart("chartContainerlt", {
	animationEnabled: true,
	title: {
		text: "Average Lead Time Per Severity"
	},
	subtitles: [{
		text: "hrs"
	}],
	data: [{
		type: "pie",
// 		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPointLeadTime, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();






var chart = new CanvasJS.Chart("chartContainer3", {
	animationEnabled: true,
	title: {
		text: "Employee Task %"
	},
	subtitles: [{
		text: "Percentage"
	}],
	data: [{
		type: "pie",
		yValueFormatString: "#,##0.00\"%\"",
		indexLabel: "{label} ({y})",
		dataPoints: <?php echo json_encode($dataPointemployeeP, JSON_NUMERIC_CHECK); ?>
	}]
});
chart.render();




 
<?php
for($d = 0; $d < count($all_emp_sev); $d++){
    $keys = array_keys($all_emp_sev);
    for($e = 0; $e < count($keys); $e++){
        $thiskeyy = $keys[$e];
        $thi_emp_sev = $all_emp_sev[''.$thiskeyy.''];
        
        $keys1 = array_keys($thi_emp_sev);
        $thisdataPoints = array();
        for($f = 0; $f < count($keys1); $f++){
            $thisskey = $keys1[$f];
            $thissvalue = $thi_emp_sev[$thisskey];
            $thisdataPoints1 = array("label"=>"SEV ".$thisskey, "y"=>$thissvalue);
            array_push($thisdataPoints,$thisdataPoints1);
        }
        ?>
    
        var chart = new CanvasJS.Chart("chartSevContainer<?php echo json_encode($e)?>", {
    	animationEnabled: true,
    	title: {
    		text: "<?php echo $thiskeyy?> Severity Distribution"
    	},
    	subtitles: [{
    		text: ""
    	}],
    	data: [{
    		type: "pie",
        // 		yValueFormatString: "#,##0.00\"%\"",
    		indexLabel: "{label} ({y})",
    		dataPoints: <?php echo json_encode($thisdataPoints, JSON_NUMERIC_CHECK); ?>
    	}]
    });
    chart.render();
    <?php
    }
}


?>



 $("#compbox").hide();
//  $("#sevbox").hide();
//  $("#sevltbox").hide();
 $("#empbox").hide();
 $("#iempbox").hide();

}
</script>





<script type="text/javascript">
function tableToCSV() {

    // Variable to store the final csv data
    let csv_data = [];

    // Get each row data
    let rows = document.getElementsByTagName('tr');
    for (let i = 0; i < rows.length; i++) {

        // Get each column data
        let cols = rows[i].querySelectorAll('td,th');

        // Stores each csv row data
        let csvrow = [];
        for (let j = 0; j < cols.length; j++) {

            // Get the text data of each cell
            // of a row and push it to csvrow
            csvrow.push(cols[j].innerHTML);
        }

        // Combine each column value with comma
        csv_data.push(csvrow.join(","));
    }

    // Combine each row data with new line character
    csv_data = csv_data.join('\n');

    // Call this function to download csv file  
    downloadCSVFile(csv_data);

}

function downloadCSVFile(csv_data) {

    // Create CSV file object and feed
    // our csv_data into it
    CSVFile = new Blob([csv_data], {
        type: "text/csv"
    });

    // Create to temporary link to initiate
    // download process
    let temp_link = document.createElement('a');

    // Download csv file
    temp_link.download = "Incident Metrics.csv";
    let url = window.URL.createObjectURL(CSVFile);
    temp_link.href = url;

    // This link should not be displayed
    temp_link.style.display = "none";
    document.body.appendChild(temp_link);

    // Automatically click the link to
    // trigger download
    temp_link.click();
    document.body.removeChild(temp_link);
}
</script>