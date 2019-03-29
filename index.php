<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="refresh" content="1"; url="<?php echo $_SERVER['PHP_SELF']; ?>">
<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="A front-end template that helps you build fast, modern mobile web apps.">

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Customer Service</title>
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="Material Design Lite">
    
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:regular,bold,italic,thin,light,bolditalic,black,medium&lang=en">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://code.getmdl.io/1.3.0/material.cyan-light_blue.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

<style>
#header-fixed {
    position: fixed;

}
</style>

 <!-- admin custom CSS -->
</head>
<body>
    <!-- container -->
<?php
$json_url = "https://vcc-na10b.8x8.com/api/rtstats/stats/agents.json";  
$crl = curl_init();
$username="gbsenterprisesllc01";
$password ="1e82f5d90806386a4bf3dd7ce41c86342e8485871a6865535f4e9a9034b17355";
curl_setopt($crl, CURLOPT_USERPWD, "$username:$password");
curl_setopt($crl, CURLOPT_URL, $json_url);
curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, FALSE); 

try{
$json = curl_exec($crl);
curl_close($crl);
$emp = json_decode($json, TRUE);
}
catch(Exception $e)
{
  echo "Message :".$e->getMessage();
}
?>
<div  class="content container"> 

<table class="table table-striped table-dark no-warp">
  <thead >
  <tr>
  <td class="align-items-center">GBS AGENT STATUS</td>
  </tr>
    <tr>
      <th scope="col position: fixed colspan='2'">Agent Name</th>
      <th scope="col position: fixed">Status</th>
      <th scope="col position: fixed colspan='2'">Phone 1</th>
      <th scope="col position: fixed">Time in Status</th>
     
    </tr>
  </thead>
  <tbody>
<?php

/* Associative arrays used has a short cut to filter and group Vcc agents*/
$agentGroups = array(126=>"Customer Service",191=>"Customer Service- Reno ", 242=>"Customer Service- Reno Spanish",194=> "Customer Service -Spanish");
$agentStatus = array("Logged Out"=>9,"Offered Call"=>1, "On Call"=>2, "Work Offline"=>5,"On Break"=>4,"Post Processing"=>3,"Available"=>0);
/* 0: available
1: transaction offered
2: busy
3: post processing
4: on break
5: work offline
9: logged out */
$agentLine1 =array("on hold"=>1,"on mute"=>2, "call offered"=>3,"Monitoring"=>4,"Busy"=>5);
/* agentLine1
0: idle or at post-processing
1: on hold
2: on mute
3: being offered with transaction
4: monitoring5: busy */

$buildRow="";
try{
foreach($agentGroups as $groupKey =>$groupValue)
{  
echo'<tr><td class="bg-primary" colspan="4"  align ="center">'.$groupValue.'</td></tr>';// Group Heading
$count=0;
  foreach ($emp['agent'] as $j => $v) {     
    if($v['group-id']==$groupKey && $v['agent-status'] != 9)
    { 
      foreach ($v as $k => $w) { 
        switch($k){
          case  "agent-name":
          $buildRow = '<tr><th>'.$w.'</th>';  
          break; 
          case  "agent-status":
          $buildRow = $buildRow. '<td>'.array_search($w,$agentStatus).'</td>';    
          break;
          case  "phone-line1-status-time":
          $buildRow = $buildRow. '<td>'.($v['phone-line1-status-time']<=0 ?'n/a':'('.gmdate("H:i:s", $v['phone-line1-status-time']).')').array_search($v['phone-line1-status'],$agentLine1).'</td>';    
          break; 
          case  "time-in-status":
          $buildRow  =  $buildRow.'<td '.($v['time-in-status'] >=600 ?'class="bg-danger"':'class="bg-default"').'>'.gmdate("H:i:s", $w).'</td>';  
          break;
          $buildRow =$buildRow.'</tr>';
        }
      } 
      $count++;     
      echo  $buildRow ;
    }
  }
  echo'<tr><td class="bg-secondary text-white" colspan="4"  align ="center">You have '.$count.' person/s here  </td></tr><tr> </tr>';
}
}
  catch(Exception $e)
  {
    echo "Message :".$e->getMessage();
  }
?>
  </tbody>
</table>
</div>
    <!-- /container -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script>
sessionStorage.scrollDirection = 1;

var pageScroll = function() {
  window.scrollBy ({
  top: sessionStorage.scrollDirection ,
  left: 0,
  behavior: 'smooth'
  });

  if($(window).scrollTop() + $(window).height() > $(document).height() - 1)
  {    
    sessionStorage.scrollDirection= Number(sessionStorage.scrollDirection )-300;
    setTimeout(pageScroll,50);
  }
  else{
  sessionStorage.scrollDirection=    Number(sessionStorage.scrollDirection )+1
  setTimeout(pageScroll,300); 
  }
};
pageScroll();

</script>
<!-- end the HTML page -->
</body>
</html>
