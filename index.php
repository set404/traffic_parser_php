<?php
  header("Content-tupe: text/html; charset=utf-8");

  print "
<HTML>
<HEAD>

<TITLE>
Parcer</TITLE>
<style>
* {
  box-sizing:border-box;
}
body {
  margin:20px;
  background-color: #fafafa;
}
textarea {
  width:100%;
  resize: vertical;
  padding:15px;
  border-radius:15px;
  border:0;
  box-shadow:4px 4px 10px rgba(0,0,0,0.06);
  height:150px;
}
body {
  margin:30px;
  font-size:18px;
}

/* container */
label {
  position: relative; /* to contain absolute elements */
  padding-left:30px; /* free space for custom checkbox */
  cursor: pointer;
}
/* hide default checkbox  */
label input[type=checkbox] {
  position: absolute; /* prevent taking any space */
  /* cross-browser hidingg */
  opactiy: 0;
  width:0;
  height:0;
}
/* custom checkbox */
label span {
  position: absolute;
  /* position to the free space in <label> */
  top:0;
  left:0;
  width:20px;
  height:20px;
  background-color: #ddd;
  transition: .3s background-color; /* slight transition */
}
/* the check icon */
label span:after {
  content: '';
  position: absolute;
  display: none;

  /* check icon */
  left: 6px;
  top: 2px;
  width: 4px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  transform: rotate(45deg);
}
label:hover span {
  background-color: #ccc;
}

/**** Here's the trick ***/
label input:checked ~ span {
  background-color: #2eaadc;
}
label input:checked ~ span:after {
  display:block;
}
input {
  display:block;
  width:100%;
  margin:10px 0;
  padding:10px;
}
.type-1 {
  border-radius:10px;
  border: 1px solid #eee;
  transition: .3s border-color;

}
.type-1:hover {
  border: 1px solid #aaa;
}

.type-2 {
  background-color: #fafafa;
  border:0;
  box-shadow:0 0 4px rgba(0,0,0,0.3);
  transition: .3s box-shadow;
}
.type-2:hover {
  box-shadow:0 0 4px rgba(0,0,0,0.5);
}
.type-3 {
  border:1px solid #111;
  transition: .3s background-color;
}
.type-3:hover {
  background-color: #fafafa;
}

.button {
  /* remove default behavior */
  appearance:none;
  -webkit-appearance:none;
  /* usual styles */
  padding:10px;
  border:none;
  background-color:#2eaadc;
  color:#fff;
  font-weight:600;
  border-radius:5px;
  width:100%;
}
</style>
</HEAD>
<BODY>
<FORM method='POST' action='index.php'>

<br>

<br>

<textarea style='font-size:16px' placeholder='Result' name='keyword' cols='70' rows='30'>";




  if ($_POST['keyword'] == "1") {

    include('./parce/simple_html_dom.php');

    $campaigns = array( "campaign1", "campaign2", "campaign3", "campaign4...");
    $t = strtotime('-1 day 00:00:00');

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'https://main.trafficfactory.biz/campaigns');
    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cook.txt');
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'cook.txt');
    curl_setopt($curl, CURLOPT_USERAGENT, "Opera/10.00 (Windows NT 5.1; U; ru) Presto/2.2.0");
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    curl_setopt($curl, CURLOPT_REFERER, 'https://main.trafficfactory.biz/campaigns');
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'https://main.trafficfactory.biz/campaigns');
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $html = curl_exec($curl);
    curl_close($curl);

    $html = str_get_html($html);
    $inputs = $html->find("input[id=signin__csrf_token]");
    $input = $inputs[0];
    $token = $input->value;

    $curl = curl_init();

    curl_setopt($curl, CURLOPT_URL, 'https://main.trafficfactory.biz/stats/campaigns/2022-06-06-00-00/2022-06-06-23-59?campaign_name=cl');
    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cook.txt');
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'cook.txt');
    curl_setopt($curl, CURLOPT_USERAGENT, "Opera/10.00 (Windows NT 5.1; U; ru) Presto/2.2.0");
    curl_setopt($curl, CURLOPT_FAILONERROR, 1);
    curl_setopt($curl, CURLOPT_REFERER, 'https://main.trafficfactory.biz/campaigns');
    curl_setopt($curl, CURLOPT_TIMEOUT, 3);
    curl_setopt($curl, CURLOPT_POST, 1);

    //Add USERLOGIN & PASSWORD to next line
    curl_setopt($curl, CURLOPT_POSTFIELDS, 'https://main.trafficfactory.biz/campaigns&signin[_csrf_token]='.$token.'&signin[login]=USERLOGIN&signin[password]=PASSWORD&signin[remember]=on');
    curl_setopt($curl, CURLOPT_HEADER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $a = curl_exec($curl);

    for ($i = 0; $i < count($campaigns); $i++) {
      curl_setopt($curl, CURLOPT_URL, "https://main.trafficfactory.biz/stats/campaigns/".date('Y-m-d', $t)."-00-00/".date('Y-m-d', $t)."-23-59?campaign_name=".$campaigns[$i]);
      $html = str_get_html(curl_exec($curl));
      $tr = $html->find('tr.hg-admin-row-total', 0);
      $clicks = str_replace(' ', '', trim($rt->find('td.hg-admin-list-td-deliveries', 0)->innertext));
      $cost = str_replace(' ', '', trim($rt->find('td.hg-admin-list-td-total', 0)->innertext));
      $cost = str_replace('$', '', $cost);
      echo $clicks."	".$cost."\n";
    }
    curl_close($curl);
  }

  echo "
    </textarea>
    <BR>
    <BR>
    <BR>
    <INPUT class='button' style='font-size:16px;' type='submit'  value='Done'>
    </FORM>
    </BODY>
    </HTML>";
?>
