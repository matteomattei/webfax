<?php
class Received extends Controller
{
	function index($pag=null)
	{
		$this->load->library('pagination');
		$received = get_dir_file_info(FAX_RECEIVED);
		$recv = array();
		foreach($received as $key=>$value)
		{
			$tmparray = explode('.',$key);
			$filename = $tmparray[0];
			$extension = (isset($tmparray[(count($tmparray)-1)])) ? $tmparray[(count($tmparray)-1)] : '';
			if($extension != 'tif')
				continue;
$keynumber=preg_replace('/[a-z.]/','',$filename);
			$recv[$keynumber]=array(
				'size' => (int)($value['size']/1024),
				'name' => $filename.'.pdf',
				'date' => date('d/m/Y H:i:s',filemtime($value['server_path'])),
				'filename' => $filename
			);
		}
		krsort($recv,SORT_NUMERIC);

		$config['base_url'] = site_url('received/index');
		$config['total_rows'] = count($recv);
		$config['per_page'] = FILE_PER_PAGE;
		$config['full_tag_open'] = '<p class="pagination">';
		$config['full_tag_close'] = '</p>';

		$this->pagination->initialize($config);

		for($i=0;$i<$pag;$i++)
		{
			array_shift($recv);
		}
		$res=array();
		$i=0;
		foreach($recv as $key=>$value)
		{
			if($i >= $config['per_page'])
				break;
			$res[$i]=$value;
			$i++;
		}
		$data['received'] = $res;
		$data['title']='Fax Ricevuti';

		$this->load->view('header',$data);
		$this->load->view('receivedview',$data);
		$this->load->view('footer');
	}

	function show($filename)
	{
		$output = md5(uniqid());
		exec(TIFF2PDF.' '.FAX_RECEIVED.'/'.$filename.'.tif -o /tmp/'.$output.'.pdf',$out,$retval);
		if($retval==0)
		{
			$buf = read_file("/tmp/".$output.".pdf");
			$statinfo = stat("/tmp/".$output.".pdf");
			header("Content-type: application/pdf");
			header("Content-length: ".$statinfo['size']);
			header("Content-Disposition: filename=".$filename.".pdf");
			header("Content-Description: Fax ricevuto");
			print $buf;
			unlink('/tmp/'.$output.'.pdf');
		}
	}

	function download($filename)
	{
		$output = md5(uniqid());
		exec('/usr/bin/tiff2pdf '.FAX_RECEIVED.'/'.$filename.'.tif -o /tmp/'.$output.'.pdf',$out,$retval);
		if($retval==0)
		{
			$buf = read_file("/tmp/".$output.".pdf");
			$statinfo = stat("/tmp/".$output.".pdf");
			header("Content-type: application/pdf");
			header("Content-length: ".$statinfo['size']);
			header("Content-Disposition: attachment;filename=".$filename.".pdf");
			header("Content-Description: Fax ricevuto");
			print $buf;
			unlink('/tmp/'.$output.'.pdf');
		}
	}
}
?>
