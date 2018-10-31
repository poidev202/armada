<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Users_model',"usersModel");
	}

	public function index()
	{
		if ($this->user != null) {
			$checkStatusUser = $this->usersModel->getById($this->user->id);

			if ($this->user != null && $checkStatusUser->status == 1 && $checkStatusUser->active == 1) {
				redirect("dashboard");
			}

		}
		$this->load->model('Umum_model',"umumModel");
		$data = $this->umumModel->getById(1,array("nama_perusahaan"));
		parent::viewContent(array("namaPerusahaan" => $data->nama_perusahaan));
		parent::view(false,false);
	}

	public function login()
	{
		if ($this->user != null) {
			redirect("dashboard");
		}

		parent::view(false,false);
	}

	public function login_ajax()
	{
		if ($this->isPost()) {
			$this->form_validation->set_rules("username","Username","required");
			$this->form_validation->set_rules("password","Password","required");

			$username = $this->input->post("username");
			$password = $this->input->post("password");

			if ($this->form_validation->run() == true) {

				$where = array(
								"username"	=>	$username,
								"password"	=>	sha1($password)
							);
				$checkAuthentic = $this->usersModel->getByWhere($where);
				if ($checkAuthentic) {
					// validate untuk check status aktif atau tidak aktif user
					if ($checkAuthentic->status == 1) {
						$this->response->status = true;
						$this->response->message = "<span style='color:blue; font-size: 30px;'><i class='fa fa-spinner fa-spin'></i> Mohon tunggu ....</span>";
						$this->usersModel->setTable("user_roles");
						$this->response->data = $this->usersModel->getById($checkAuthentic->user_role_id)->role;
						$this->session->set_userdata("admin",$checkAuthentic);
					} else {
						$this->response->message = "Status Acount tidak aktif.";
						$this->response->error = array(
												"account" => alertDanger("Akun anda tidak aktif, silahkan hubungi  owner.")
											);
					}
				} else {
					$this->response->message = "error check password";
					$this->response->error = array(
											"account"	=>	spanRed("Username atau Password yang dimasukan salah..!"),
										);
				}
			} else {
				$this->response->message = "error form data";
				$this->response->error = array(
										"username"	=>	form_error("username","<span style='color:red;'>","</span>"),
										"password"	=>	form_error("password","<span style='color:red;'>","</span>"),
									);
			}
		}
		parent::jsonp();
	}

	public function logout1()
	{
		$this->session->unset_userdata("admin");
		$this->session->sess_destroy();
		// $redirect = $this->input->get("redirect");
		redirect("auth");
	}

	public function logout2()
	{
		$this->session->unset_userdata("admin");
		$this->session->sess_destroy();
		// $redirect = $this->input->get("redirect");
		redirect("auth/login");
	}

	public function logoutAuto()
	{
		if ($this->user == null) {
			$this->response->status = true;
		}
		parent::json();
	}

}

/* End of file Auth.php */
/* Location: ./application/controllers/Auth.php */