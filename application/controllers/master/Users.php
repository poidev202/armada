<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {

	public function __construct()
	{
		parent::__construct();

		$this->load->model('master/Users_model',"usersModel");
	}

	public function index()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		parent::headerTitle("Pengguna","Pengguna");

		parent::breadcrumbs("pengguna");

		parent::viewMaster();
	}

	public function ajax_list()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$where = array("role_status" => 1);
			$select = array("users.*","users.id","user_roles.role");
			$columns = array(null,null,'full_name','username','role','status');
			$search = array("full_name","username","role");
			$join = array(
						array("user_roles","user_roles.id = users.user_role_id","LEFT")
					);
			$result = $this->usersModel->findDataTable($where,$select,$columns,$search,$join);
			$data = array();
			foreach ($result as $item) {
				/* show for status */
				$textColor = $item->status == 1 ? "green" : "red";
				$btnColor = $item->status == 1 ? "success" : "secondary";
				$btnText = $item->status == 1 ? " Aktif" : " Tidak Aktif";
				$styleColor = $item->status == 1 ? "white" : "red";
				$fontCheck = $item->status == 1 ? "fa-check-square-o" : "fa-square-o";
					
				if ($this->user_role == "owner" || $this->user_role == "dev") {
					if ($item->id == $this->user->id || ($item->role == "owner" || $item->role == "dev")) {
						$item->status = "<span style='color:".$textColor.";'><i class='fa ".$fontCheck."'></i>".$btnText."</span>";
					} else {
						if ($this->user_role != "owner" || $this->user_role != "dev") {
							$item->status = "<button type='button' onclick='btnStatus(".$item->id.")' title='klik untuk ganti status' class='btn  btn-outline-".$btnColor." btn-xs'><i class='fa ".$fontCheck."'></i>".$btnText."</button>";
						} else {
							$item->status = "<span style='color:".$textColor.";'><i class='fa ".$fontCheck."'></i>".$btnText."</span>";
						}
					}
				} else {
					$item->status = "<span style='color:".$textColor.";'><i class='fa ".$fontCheck."'></i>".$btnText."</span>";
				}

				/* show photo users */
				$srcPhoto = $item->photo == "" ? "/assets/images/default/user_image.png" : "/uploads/admin/users/".$item->photo;
				$item->photo = '<div class="img-thumbnail"><center><img src="'.$srcPhoto.'" class="img img-responsive" style="width:60px; height:60px;"></center></div>';
				/* end show photo users */

				/* show button action */
				$btnAction = '';

				if($this->user_role == "owner") {
					if(($item->id != $this->user->id) && ($item->role != "owner" && $item->role != "dev")) {
						$btnAction .= '<button type="button" onclick="edit('.$item->id.')" class="btn btn-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
				
						$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete
					}
				} elseif (($this->user_role == "owner" && $this->user->role_status == 0) || ($this->user_role == "dev"  && $this->user->role_status == 0)) {
					$btnAction .= '<button type="button" onclick="edit('.$item->id.')" class="btn btn btn-outline-warning btn-xs"><i class="fa fa-pencil-square-o"></i> Edit</button> &nbsp;&nbsp;'; // update
				
					$btnAction .='<button type="button" onclick="btnDelete('.$item->id.')" class="btn btn-outline-danger btn-xs"><i class="fa fa-trash-o"></i> Hapus</button>'; // delete
				}

				$item->button_action = $btnAction;
				/* end button action */

				$data[] = $item;
			}
			return $this->usersModel->findDataTableOutput($data,$where,$search,$join);
		}
		parent::json();
	}

	public function inputValidate()
	{
		$this->form_validation->set_rules("full_name","Nama Lengkap","trim|required");
		// $this->form_validation->set_rules("password","Password","required");
		$this->form_validation->set_rules("role","Role","required");
	}

	public function add()
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$full_name = $this->input->post("full_name");
			$username = $this->input->post("username");
			$role = $this->input->post("role");
			$password = $this->input->post("password");

			self::inputValidate();
			$this->form_validation->set_rules("password","Password","required|min_length[6]");
			$this->form_validation->set_rules("confirm_password","Confirm Password","required|matches[password]");
			$this->form_validation->set_rules("username","Username","trim|required|is_unique[users.username]");

			/* check kode akhir */
			if ($this->form_validation->run() == true) {
				
				// config upload photo
				self::_do_upload();
				$data = array(
							"full_name"	=>	$full_name,
							"username"	=>	$username,
							"password"	=>	sha1($password),
							"user_role_id"	=>	$role,
						);

				if (!empty($_FILES["photo"]["name"])) {
					if (!$this->upload->do_upload("photo")) {
						$this->response->message = "Error photo";
						$this->response->error = ["photo" => spanRed("<b>Error photo :</b>".$this->upload->display_errors())];
					} else {
						$photoUser = $this->upload->data();
						$data["photo"]	= $photoUser["file_name"];
						$insert = $this->usersModel->insert($data);
						if ($insert) {
							$this->response->status = true;
							$this->response->message = alertSuccess("Data berhasil di tambah..");
							$this->response->data = $data;
						}
					}
				} else {
					$data["photo"]	= "";
					$insert = $this->usersModel->insert($data);
					if ($insert) {
						$this->response->status = true;
						$this->response->message = alertSuccess("Data berhasil di tambah..");
						$this->response->data = $data;
					}
				}
			} else {
				$this->response->message = "error validate form";
				$this->response->error = array(
									"full_name"	=> form_error("full_name",'<span style="color:red;">','</span>'),
									"username"	=> form_error("username",'<span style="color:red;">','</span>'),
									"password"	=> form_error("password",'<span style="color:red;">','</span>'),
									"confirm_password"	=> form_error("confirm_password",'<span style="color:red;">','</span>'),
									"role"	=> form_error("role",'<span style="color:red;">','</span>'),
								);
			}
		}
		parent::json();
	}

	public function _do_upload()
	{
		$config['upload_path']      = 	'uploads/admin/users/';
        $config['allowed_types']    = 	'gif|jpg|jpeg|png';
        $config['max_size']         = 	2048; // 2mb
        $config['max_width']        = 	2000;
        $config['max_height']       =	1500;
        $config['encrypt_name']		=	true;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);
	}

	public function status($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			
			$bacaid = $this->usersModel->getById($id);
			$data = array(
					"id" => $id,
				);
			$bacaid->status == 1 ? $data['status'] = 0 : $data['status'] = 1;
			$changeStatus = $this->usersModel->update($data);
			if ($changeStatus) {
				$this->response->status = true;
				$this->response->message = "success";
				$this->response->data = $bacaid->status;
			}
		}
		parent::json();
	}

	public function getbyid($id)
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$join = array(
							array("user_roles","user_roles.id = users.user_role_id","LEFT"),
						);
			$data = $this->usersModel->getByWhere(array("users.id" => $id),array("users.*","user_roles.role"),$join);
			if ($data) {				
				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			} else {
				$this->response->message = alertDanger("Data not found.");
			}
		}
		parent::json();
	}

	public function userRoles()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$role = $this->usersModel->getRoles(); // for combo box drop down role/level
			if ($role) {
				$this->response->status = true;
				$this->response->data = $role;
			} else {
				$this->response->message = spanRed("Data table user_roles tidak ada.!");
			}
		}
		parent::json();
	}

	public function infoProfile()
	{
		parent::checkLoginUser(); // otoritas authentic function

		if ($this->isPost()) {
			$join = array(
							array("user_roles","user_roles.id = users.user_role_id","LEFT"),
						);
			$data = $this->usersModel->getByWhere(array("users.id" => $this->user->id),array("users.*","user_roles.role"),$join);
			if ($data) {				
				$this->response->status = true;
				$this->response->message = "data get By Id";
				$this->response->data = $data;
			}
		}
		parent::json();
	}

	public function update($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			self::inputValidate();	// set_rules()
			$this->form_validation->set_rules("password","Password","min_length[6]");
			$this->form_validation->set_rules("confirm_password","Confirm Password","matches[password]");
			if ($this->form_validation->run() == true) {
				// config upload photo
				self::_do_upload();

				$getById = $this->usersModel->getById($id); // check user id;
				if ($getById) {
					$full_name = $this->input->post("full_name");
					$password = $this->input->post("password");
					$role = $this->input->post("role");
					$data = array(
								"id"		=>	$id,
								"full_name"	=>	$full_name,
								"user_role_id"	=>	$role,
								"updated_at"	=>	date("Y-m-d H:i:s"),
							);
					if (!empty(trim($password))) {
						$data["password"] = sha1($password);
					}
					if (!empty($_FILES["photo"]["name"])) {
						if (!$this->upload->do_upload("photo")) {
							$this->response->message = "Error Upload photo";
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
								$this->response->message = alertWarning("Data berhasil di update..");
								$this->response->data = $data;
							}
						}
					} else {
						if ($this->input->post("is_delete") == 1) {
							$data["photo"]	= "";
							if (file_exists("uploads/admin/users/".$getById->photo) && $getById->photo) {
								unlink("uploads/admin/users/".$getById->photo);
							}
						}
						$update = $this->usersModel->update($data);
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
				$this->response->message = "error validate form";
				$this->response->error = array(
									"full_name"	=> form_error("full_name",'<span style="color:red;">','</span>'),
									"role"	=> form_error("role",'<span style="color:red;">','</span>'),
									"password"	=> form_error("password",'<span style="color:red;">','</span>'),
									"confirm_password"	=> form_error("confirm_password",'<span style="color:red;">','</span>')
								);
			}
		}
		parent::json();
	}

	public function delete($id)
	{
		parent::checkLoginUser(); // otoritas authentic function
		parent::checkUserRoleMaster(); // check role atau level function

		if ($this->isPost()) {
			$data = $this->usersModel->getById($id);
			if($data){
				$delete = $this->usersModel->delete($id);
				if ($delete) {
					$this->response->status = true;
					$this->response->message = alertSuccess("Data berhasil di hapus..");
					if (file_exists("uploads/admin/users/".$data->photo) && $data->photo) {
						unlink("uploads/admin/users/".$data->photo);
					}
				} else {
					$this->response->status = false;
					$this->response->message = alertDanger("Opps, terjadi kesalahan.<br>Mungkin sudah dihapus pengguna lain");
				}
			} else {
				$this->response->message = alertDanger("Data tidak ada.");
			}
		}
		parent::json();
	}

}

/* End of file Users.php */
/* Location: ./application/controllers/master/Users.php */