<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Umum extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('master/Users_model',"usersModel");
		$this->load->model('Umum_model',"umumModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Pengaturan > Umum","Umum");

		$breadcrumbs = array(
								"Pengaturan"	=>	site_url('umum'),
								"Umum"			=>	"",
						);
		parent::breadcrumbs($breadcrumbs);

		parent::view();
	}

	public function profile()
	{
		parent::checkLoginUser(); // otoritas authentic function

		parent::headerTitle("Profile","Profile");

		parent::breadcrumbs("Profile");

		parent::view();
	}

	public function getIdUser()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$join = array(
							array("user_roles","user_roles.id = users.user_role_id","LEFT"),
						);
			$data = $this->usersModel->getByWhere(array("users.id" => $this->user->id),array("users.*","user_roles.role"),$join);
			if ($data) {	
				/* show photo users */
				$data->photo = $data->photo == "" ? "/assets/images/default/user_image.png" : "/uploads/admin/users/".$data->photo;			
				$this->response->status = true;
				$this->response->message = "data get By Id user profile";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data not found.");
			}
		}
		parent::json();
	}

	public function updateProfile()
	{
		parent::checkLoginUser(); // otoritas authentic function
		$id = $this->user->id;
		if ($this->isPost()) {
			$full_name = $this->input->post("nama_lengkap");
			$this->form_validation->set_rules("nama_lengkap","Nama Lengkap","trim|required");

			$passwordLama = $this->input->post("password_lama");
			$passwordBaru = $this->input->post("password_baru");
			if (!empty($passwordLama)) {
				$this->form_validation->set_rules("password_baru","Password","required|min_length[6]");
				$this->form_validation->set_rules("confirm_password","Confirm Password","required|matches[password_baru]");
			}
			if ($this->form_validation->run() == true) {
				// config upload photo
				$config['upload_path']      = 	'uploads/admin/users/';
		        $config['allowed_types']    = 	'gif|jpg|jpeg|png';
		        $config['max_size']         = 	2048; // 2mb
		        $config['encrypt_name']		=	true;

		        $this->load->library('upload', $config);
		        $this->upload->initialize($config);

				$getById = $this->usersModel->getById($id); // check user id;
				if ($getById) {
					$checkPassLama = $this->usersModel->getByWhere(array("username" => $this->user->username,"password" => sha1($passwordLama)));
					if (!empty(trim($passwordLama)) && !$checkPassLama) {
						$this->response->message = alertDanger("Password Lama tidak benar..!");
					} else {
						$data = array(
									"id"		=>	$id,
									"full_name"	=>	$full_name,
									"updated_at"	=>	date("Y-m-d H:i:s"),
								);
						if (!empty($passwordBaru)) {
							$data["password"] = sha1($passwordBaru);
						}
						if (!empty($_FILES["photo"]["name"])) {
							if (!$this->upload->do_upload("photo")) {
								$this->response->message = "error_photo";
								$this->response->error = ["photo" => spanRed("<b>Error photo :</b>".$this->upload->display_errors())];
							} else {
								$photoUser = $this->upload->data();
								$data["photo"]	= $photoUser["file_name"];
								if (file_exists("uploads/admin/users/".$getById->photo) && $getById->photo) {
									unlink("uploads/admin/users/".$getById->photo);
								}
								$update = $this->usersModel->update($data);
								if ($update) {
									$this->response->status = true;
									$this->response->message = alertWarning("Data profile berhasil di update..");
									$this->response->data = $data;
								}
							}
						} else {
							if ($this->input->post("is_delete_profile") == 1) {
								$data["photo"]	= "";
								if (file_exists("uploads/admin/users/".$getById->photo) && $getById->photo) {
									unlink("uploads/admin/users/".$getById->photo);
								}
							}
							$update = $this->usersModel->update($data);
							if ($update) {
								$this->response->status = true;
								$this->response->message = alertWarning("Data profile berhasil di update..");
								$this->response->data = $data;
							}
						}
					}
				} else {
					$this->response->message = alertDanger("Data sudah tidak ada..!");
				}
			} else {
				$formValidate = $this->response->message = validation_errors('<li class="pull-left"><span class="text-danger">', '</span></li><br>');
				$this->response->message = $formValidate;
			}
		}
		parent::json();
	}

	public function getIdUmum()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			
			$data = $this->umumModel->getById(1);
			if ($data) {	
				/* show photo logo */
				$data->logo_icon = $data->logo_icon == "" ? "/assets/images/default/no_image.jpg" : "/uploads/admin/logo/".$data->logo_icon;			
				$this->response->status = true;
				$this->response->message = "data get By Id umum";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data not found.");
			}
		}
		parent::json();
	}

	public function getNamaPerusahaan()
	{
		if ($this->isPost()) {
			
			$data = $this->umumModel->getById(1,array("nama_perusahaan"));
			if ($data) {	
				$this->response->status = true;
				$this->response->message = "data get By Id umum";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data not found.");
			}
		}
		parent::json();
	}


	public function updatePengaturan()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster();
		$id = 1;
		if ($this->isPost()) {
			$this->form_validation->set_rules("nama_perusahaan","Nama Perusahaan","trim|required");
			$this->form_validation->set_rules("telephone","Telephone","trim|required");
			$this->form_validation->set_rules("email","Email","trim|required|valid_email");
			$this->form_validation->set_rules("alamat","Alamat","trim|required");

			$nama_perusahaan = $this->input->post("nama_perusahaan");
			$telephone = $this->input->post("telephone");
			$email = $this->input->post("email");
			$alamat = $this->input->post("alamat");
			
			if ($this->form_validation->run() == true) {
				// config upload photo
				$config['upload_path']      = 	'uploads/admin/logo/';
		        $config['allowed_types']    = 	'gif|jpg|jpeg|png';
		        $config['max_size']         = 	2048; // 2mb
		        $config['encrypt_name']		=	true;

		        $this->load->library('upload', $config);
		        $this->upload->initialize($config);

				$getById = $this->umumModel->getById($id); // check user id;
				if ($getById) {
					$data = array(
									"id"				=>	$id,
									"nama_perusahaan"	=>	$nama_perusahaan,
									"telephone"			=>	$telephone,
									"email"				=>	$email,
									"alamat"			=>	$alamat,
									"updated_at"		=>	date("Y-m-d H:i:s"),
								);
						
					if (!empty($_FILES["logo"]["name"])) {
						if (!$this->upload->do_upload("logo")) {
							$this->response->message = "error_photo";
							$this->response->error = ["photo" => spanRed("<b>Error logo :</b>".$this->upload->display_errors())];
						} else {
							$photoLogo = $this->upload->data();
							$data["logo_icon"]	= $photoLogo["file_name"];
							if (file_exists("uploads/admin/logo/".$getById->logo_icon) && $getById->logo_icon) {
								unlink("uploads/admin/logo/".$getById->logo_icon);
							}
							$update = $this->umumModel->update($data);
							if ($update) {
								$this->response->status = true;
								$this->response->message = alertWarning("Data berhasil di update..");
								$this->response->data = $data;
							}
						}
					} else {
						if ($this->input->post("is_delete") == 1) {
							$data["logo_icon"]	= "";
							if (file_exists("uploads/admin/logo/".$getById->logo_icon) && $getById->logo_icon) {
								unlink("uploads/admin/logo/".$getById->logo_icon);
							}
						}
						$update = $this->umumModel->update($data);
						if ($update) {
							$this->response->status = true;
							$this->response->message = alertWarning("Data berhasil di update..");
							$this->response->data = $data;
						}
					}
					
				} else {
					$this->response->message = alertDanger("Data sudah tidak ada..!");
				}
			} else {
				$formValidate = $this->response->message = validation_errors('<li class="pull-left"><span class="text-danger">', '</span></li><br>');
				$this->response->message = $formValidate;
			}
		}
		parent::json();
	}
}

/* End of file Umum.php */
/* Location: ./application/controllers/Umum.php */