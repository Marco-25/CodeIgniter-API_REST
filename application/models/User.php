<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Model
{
	private $table = 'user';
	public function __construct()
	{
		$this->load->database();
	}

	public function JsonEncode($array){ return json_encode($array); }

	public function setResponse($code, $message, $data)
	{
		$this->output->set_status_header($code, $message)
			->set_content_type('application/json')
			->set_output($this->JsonEncode($data));
	}

	public function get_user($id)
	{
		if(!empty($id)) $data = $this->db->get_where( $this->table,['id' => $id])->result();
		else $data = $this->db->get($this->table)->result();

		$this->setResponse(200,'SUCCESS',$data);
	}

	public function get_user_name($name)
	{
		if ($data = $this->db->get_where( $this->table,['name' => $name])->result()) {
			$this->setResponse(200,'success',$data);
			return;
		}
		$this->setResponse(200,'NO_CONTENT',"nada encontrado");

	}

	public function post_user()
	{
		$data = $this->input->post();

		$this->name = $data['name'];
		$this->db->where('name', $this->name);

		$this->pass = password_hash($data['pass'], PASSWORD_BCRYPT);

		if ($this->db->get($this->table)->result() ){
			$this->setResponse(201,'WARNING',"usuario ja cadastrado.");
			return;
		}

		if ($this->db->insert($this->table ,$this)){
			$this->setResponse(200,'SUCCESS',"usuario cadastrado.");
			return;
		}
		$this->setResponse(404,'ERROR',"Houve um erro inesperado");
	}

	public function put_user($id)
	{
		$data = $this->input->input_stream();

		$this->name = $data['name'];
		$this->db->where('name', $this->name);

		$this->pass = password_hash($data['pass'], PASSWORD_BCRYPT);

		if ($this->db->get($this->table)->result() ){
			$this->setResponse(201,'WARNING',"usuario ja cadastrado.");
			return;
		}

		if ($this->db->update( $this->table, $this, ['id'=>$id])) {
			$this->setResponse(200,'SUCCESS',  "Alterado com sucesso.");
			return;
		}
		$this->setResponse(404,'ERROR',"Houve um erro inesperado");

	}

	public function delete_user($id)
	{
		if ($this->db->delete( $this->table , ['id'=>$id])){
			$this->setResponse(200,'SUCCESS',"Excluido com sucesso");
			return;
		}
		$this->setResponse(404,'ERROR',"Houve um erro inesperado");

	}


}
