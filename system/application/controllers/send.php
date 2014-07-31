<?php
class Send extends Controller
{
	function index()
	{
		$this->load->helper('form');
		$xml = simplexml_load_file(base_url().'/'.ADDRESSBOOK_FILE);
		$account = array('-1'=>'-Seleziona contatto-');
		foreach($xml->account as $row)
		{
			$number = (string)$row->number;
			$name = (string)$row->name;
			$account[$number]=$name;
		}
		asort($account);

		$data['contacts']=$account;
		$data['script'] = '<script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>';
		$data['js'] = '$(document).ready(function(){
			$("#adddocument").click(function(){
				var block = "<tr>";
				block += "<td>File</td>";
				block += "<td><input type=\"file\" name=\"filefax[]\"</td>";
				block += "</tr>";
				var position = parseInt($(".showtable tr").length-4);
				var lastfileinput = $(".showtable tr:eq("+position+")");
				$(block).insertAfter(lastfileinput);
			});
		});';
		$data['title']='Invia nuovo Fax';
		$this->load->view('header',$data);
		$this->load->view('sendview',$data);
		$this->load->view('footer');
	}

	function sendfax()
	{
		$size=0;
		$error = FALSE;
		$files = "";
		if(isset($_FILES))
		{
			foreach($_FILES['filefax']['type'] as $key=>$value)
			{
				if($value=="")
					continue;
				if(in_array($value,array("application/pdf","application/octet","application/x-download","application/force-download")) 
					&& $_FILES['filefax']['error'][$key]==0
					&& isset($_POST['faxnumber']) && strlen($_POST['faxnumber'])>0)
				{
					$size += $_FILES['filefax']['size'][$key];
					$files .= $_FILES['filefax']['tmp_name'][$key]." ";
				}
				else
				{
					$error = TRUE;
				}
			}
		}
		if($error===FALSE && $size<=$_POST['maxfilesize'] && isset($_POST['faxnumber']))
		{
			$command = "/usr/bin/sendfax -n ";
			if(isset($_POST['email']) && strlen(trim($_POST['email']))>0)
				$command .= "-D -f ".trim($_POST['email'])." ";
			$command .= "-d ".trim($_POST['faxnumber'])." ".$files;
			$output = array();
			$value = 0;
			exec($command,$output,$value);
			if($value==0)
			{
				$data['title'] = 'Fax Inviato';
				$data['result'] = 'Fax Inviato correttamente';
			}
			else
			{
				$data['title'] = 'Fax Non Inviato';
				$data['result'] = 'Invio fax: problemi durante l\'invio...<br />';
				$data['result'].= 'command='.$command.'<br /><br />';
				$data['result'].= print_r($output);
			}
		}
		else
		{
			$data['title'] = 'Fax Non Inviato';
			$data['result'] = 'Problemi durante l\'invio del fax';
			$data['result'].= print_r($_FILES);
			$data['result'].= print_r($_POST);
		}
		$this->load->view('header',$data);
		$this->load->view('sendview',$data);
		$this->load->view('footer');
	}
}
?>
