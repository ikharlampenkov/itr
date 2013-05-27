<?php
include_once '/home/y/yurgadoc/public_html/private/classes/VL.php';
$smarty = new vl_smarty();
$o_gbook = new vlm_guestbook();

$o_catalog = new vlm_catalog();
$catalog = $o_catalog->getRootRubric(false);
$smarty->assign('catalog', $catalog);

$rubrics = $o_catalog->getRootRubric(true);
$smarty->assign('rubrics', $rubrics);

$smarty->assign('ans_count', $o_gbook->getAnswerCount());

$o_doctors = new vlm_doctors();
$doctor = $o_doctors->getDoctorsArray();

$smarty->assign('doctor', $doctor);
//$smarty->assign('title', 'Вопрос-ответ. Кузбасский технопарк. Кемерово');

if (vl_pin::isLogin($smarty) && !isset($_GET['view'])) {
  $command_list = array('open', 'id', 'del');
  $command = '';
  if (isset($_GET)){
    foreach ($_GET as $name => $value){
      if (in_array($name, $command_list))  {
        $command = $name;
        break;
      }
    }
  }

  switch ($command){
  	case 'open':
  	  $smarty->assign('rubric',  $o_catalog->getRubric($_GET['open']));
      $smarty->assign('doctor', $o_doctors->getDoctorsArray($_GET['open']));
  	
  	  $smarty->assign('gmsgs', $o_gbook->getAllMsg($_GET['open']));
  	  
  	  $smarty->assign('openid', $_GET['open']);
  	
  	  $smarty->display('private/consult/rubric.tpl');
  		
  	  break;
    case 'id':
      if (is_numeric($_GET['id']) && $gmsg = $o_gbook->getMsg($_GET['id'])) {
        if (isset($_POST['data'])) {
          $_POST['data']['date'] = date('Y-m-d');
          if (isset($_POST['date']) && !empty($_POST['date'])) $_POST['data']['date'] = $_POST['date'];
          $o_gbook->addAnswer($_GET['id'],$_POST['data']);
          header('Location: ' . $__cfg['site.url'] . 'consult/');
          exit;
        }
        //$spaw1 = new SpawEditor('data[message]',$gmsg['message'],'ru','mini', '', '100%', '400');
        //$smarty->assign('spaw_show1',$spaw1->getHtml());
        
        //$spaw2 = new SpawEditor('data[answer]',$gmsg['answer'],'ru','mini', '', '100%', '400');
        //$smarty->assign('spaw_show2',$spaw2->getHtml());
        
        $smarty->assign('doctor', $o_doctors->getDoctorsArray($_GET['open']));
        $smarty->assign('gmsg', $gmsg);
        $smarty->display('private/consult/edit.tpl');
      } else {
        header('Location: ' . $__cfg['site.url'] . 'consult/');
      }

      break;

    case 'del':
      if (is_numeric($_GET['del'])) $o_gbook->delMsg($_GET['del']);
      header('Location: ' . $__cfg['site.url'] . 'consult/');
      break;

    default:
	  $smarty->display('private/consult/index.tpl');

  }
} else {

  if (isset($_GET['open'])) {

      if (isset($_POST['data'])) {

           //&& isset($_POST['data']['name']) && isset($_POST['data']['message']))

  	  $o_gbook->addMsg($_POST['data']);
      }


  	$smarty->assign('rubric',  $o_catalog->getRubric($_GET['open']));
    $smarty->assign('doctor', $o_doctors->getDoctorsArray($_GET['open']));
  	
  	$smarty->assign('gmsgs', $o_gbook->getModerateMsg($_GET['open']));
  	
  	$smarty->assign('openid', $_GET['open']);
  	
  	if (isset($_GET['doctor'])) {
  		$smarty->assign('doctorid', $_GET['doctor']);
  	} else {
	    $smarty->assign('doctorid', -1);
	}
  	
  	$smarty->display('public/consult/rubric.tpl');
  	exit;
  }
  
  
  //$gmsg=$o_gbook->getModerateMsg();
  //$smarty->assign('gmsgs',$gmsg);
  $smarty->display('public/consult/index.tpl');
}
?>