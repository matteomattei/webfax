<?php
class Menu extends Controller
{
	function index()
	{
		$data['title']='WebFax';
		$data['addressbook']='Rubrica';
		$data['received']='Fax Ricevuti';
		$data['sent']='Fax Inviati';
		$data['send']='Invia Fax';

		$this->load->view('header',$data);
		$this->load->view('menuview',$data);
		$this->load->view('footer');
	}
}
?>
