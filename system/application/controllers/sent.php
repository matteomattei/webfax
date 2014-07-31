<?php
class Sent extends Controller
{
	function index($pag=null)
	{
		$this->load->library('pagination');
		$sent = get_dir_file_info(FAX_SENT);
		$sentar = array();
		foreach($sent as $key=>$value)
		{
			$tmparray = explode('.',$key);
			$filename = $tmparray[0];
			$extension = (isset($tmparray[(count($tmparray)-1)])) ? $tmparray[(count($tmparray)-1)] : '';
			if($extension != 'pdf')
				continue;
			$keynumber=preg_replace('/[a-z.]/','',$key);
			$sentar[$keynumber]['size'] = (int)($value['size']/1024);
			$sentar[$keynumber]['date'] = date('d/m/Y H:i:s',filemtime($value['server_path']));
			$sentar[$keynumber]['filename'] = $filename;
		}
		krsort($sentar,SORT_NUMERIC);

		$config['base_url'] = site_url('sent/index');
		$config['total_rows'] = count($sentar);
		$config['per_page'] = FILE_PER_PAGE;
		$config['full_tag_open'] = '<p class="pagination">';
		$config['full_tag_close'] = '</p>';

		$this->pagination->initialize($config);

		for($i=0;$i<$pag;$i++)
		{
			array_shift($sentar);
		}
		$res=array();
		$i=0;
		foreach($sentar as $key=>$value)
		{
			if($i >= $config['per_page'])
				break;
			$res[$i]=$value;
			$i++;
		}
		$data['sent'] = $res;
		$data['title']='Fax Inviati';

		$this->load->view('header',$data);
		$this->load->view('sentview',$data);
		$this->load->view('footer');
	}

	function show($filename)
	{
		$buf= read_file(FAX_SENT."/".$filename);
		$statinfo = stat(FAX_SENT."/".$filename);
		header("Content-type: application/pdf");
		header("Content-length: ".$statinfo['size']);
		header("Content-Disposition: filename=".$filename);
		header("Content-Description: Fax inviato");
		print $buf;
	}

	function download($filename)
	{
		$buf= read_file(FAX_SENT."/".$filename);
		$statinfo = stat(FAX_SENT."/".$filename);
		header("Content-type: application/pdf");
		header("Content-length: ".$statinfo['size']);
		header("Content-Disposition: attachment;filename=".$filename);
		header("Content-Description: Fax inviato");
		print $buf;
	}
}
?>
