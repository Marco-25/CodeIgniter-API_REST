<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Usuarios extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user');
	}

	public function getMethod() { return $this->input->method();}

	public function index($id = 0)
	{
		if ($this->getMethod() !== 'get') {
			echo 'Use o method GET para realizar uma busca.' ;
			return;
		}
		$id = intval($this->uri->segment(3));
		 $this->user->get_user($id);
	}

	public function buscar()
	{
		if ($this->getMethod() !== 'get') {
			echo 'Use o method GET para realizar uma busca.' ;
			return;
		}
		$name = $this->uri->segment(4);
		$name_replace = str_replace('%20', '+',$name);
		
		$this->user->get_user_name($name_replace);
	}

	public function adicionar()
	{
		if ($this->getMethod() !== 'post') {
			echo 'Use o method POST para realizar um cadastro.' ;
			return;
		}
		$this->user->post_user();

	}

	public function editar($id)
	{
		if ($this->getMethod() !== 'put') {
			echo 'Use o method PUT para altera um usuario.' ;
			return;
		}
		$id = intval($this->uri->segment(4));
		$this->user->put_user($id);
	}
	
	public function remover($id)
	{
		if ($this->getMethod() !== 'delete') {
			echo 'Use o method DELETE para excluir um usuario.' ;
			return;
		}
		$id = intval($this->uri->segment(4));
		$this->user->delete_user($id);
	}
	
}
