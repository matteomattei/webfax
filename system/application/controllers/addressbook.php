<?php
class Addressbook extends Controller
{
	function index($pag=null)
	{
		$this->load->library('pagination');
		$this->load->helper('form');
		$xml = simplexml_load_file(base_url().ADDRESSBOOK_FILE);

		$config['base_url'] = site_url('addressbook/index');
		$config['total_rows'] = count($xml->account);
		$config['per_page'] = CONTACTS_PER_PAGE;
		$config['full_tag_open'] = '<p class="pagination">';
		$config['full_tag_close'] = '</p>';
		$this->pagination->initialize($config);

		$account = array();
		foreach($xml->account as $row)
		{
			$number = (string)$row->number;
			$name = (string)$row->name;
			$account[$number]=$name;
		}
		asort($account);

		$data['per_page'] = $config['per_page'];
		$data['thispage'] = $pag;
		$data['account'] = $account;
		$data['title']='Rubrica';

		$this->load->view('header',$data);
		$this->load->view('addressbookview',$data);
		$this->load->view('footer');
	}

	function update()
	{
		if(!$this->input->post('update'))
			redirect('addressbook/index');

		//$this->load->helper('file');
		$name = $this->input->post('name',TRUE);
		$number = $this->input->post('number',TRUE);

		$doc = new DOMDocument('1.0');
		$doc->formatOutput = true;
		$accounts = $doc->createElement('accounts');
		for($i=0;$i<count($name);$i++)
		{
			if( $i==0 )
			{
				if(trim($name[$i])=='NUOVO CONTATTO' || trim($name[$i])=='' || trim($number[$i])=='NUMERO' || trim($number[$i])=='')
					continue;
			}
			elseif(trim($name[$i])=='' || trim($number[$i])=='' || !preg_match('/^[0-9]+$/',trim($number[$i])))
			{
				continue;
			}
			$account = $doc->createElement('account');

			$elem_name = $doc->createElement('name');
			$text_name = $doc->createTextNode($name[$i]);
			$elem_name->appendChild($text_name);

			$elem_number = $doc->createElement('number');
			$text_number = $doc->createTextNode($number[$i]);
			$elem_number->appendChild($text_number);

			$account->appendChild($elem_name);
			$account->appendChild($elem_number);
			$accounts->appendChild($account);
		}
		$accounts = $doc->appendChild($accounts);
		$output = $doc->saveXML();
		$fp = fopen(ADDRESSBOOK_FILE,'w');
		flock($fp, LOCK_EX);
		fwrite($fp,$output);
		flock($fp, LOCK_UN);
		fclose($fp);
		redirect('addressbook/index');
	}
}
?>
