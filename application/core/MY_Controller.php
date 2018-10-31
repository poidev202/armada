<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	private $layouts = "layouts";
	
	protected $response;
	var $user;
	var $user_role;
	var $userData;
	var $data = array(
        "all"  => array(),
        "header" => array(),
        "view" => array(),
        "footer" => array()
    );  // for view data

	function __construct()
	{
		parent::__construct();
		// $this->data["title"] = $this->router->class;
		$this->user = $this->session->admin;
		if ($this->user != null) {
			$this->user_role = $this->dataUser()->role;
			$this->userData = $this->dataUser();
		}
		
		$this->response = new stdClass();
		$this->response->status = false;
		$this->response->message = "";
		$this->response->data = new stdClass();
	}

	public function checkLoginUser()
	{
		$this->load->model("master/Users_model","usersModel");
		if ($this->user == null) {
			redirect("auth");
            // echo "<script> window.location.href = '".site_url('auth')."'; </script>";
		} else {
            $checkStatusUser = $this->usersModel->getById($this->user->id);
            
        }

		if ($this->user != null && $checkStatusUser->active != 1) {
			$this->session->set_flashdata("status_user","Akun anda telah di hapus sementara, silahkan hubungi owner.!");
			redirect("auth");
            // echo "<script> window.location.href = '".site_url('auth')."'; </script>";
		} else {
			if ($this->user != null && $checkStatusUser->status != 1) {
                $this->response->restrict_session = true;

				$this->session->set_flashdata("status_user","Akun anda tidak aktif, silahkan hubungi owner.!!");
				redirect("auth");
                // echo "<script> window.location.href = '".site_url('auth')."'; </script>";
			}
		}
	}

    public function checkUserRoleMaster()
    {
        if ($this->user != null && ($this->user_role == "owner"  || $this->user_role == "dev" )) {
        } else {
            redirect('/');
        }
    }

    public function checkUserRoleSupervisor()
    {
        if ($this->user != null && ( $this->user_role == "supervisor"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) {
        } else {
            redirect('/');
        }
    }

    public function checkUserRoleKasir()
    {
        if ($this->user != null && ( $this->user_role == "kasir"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) {
        } else {
            redirect('/');
        }
    }

    public function checkUserRoleBengkel()
    {
        if ($this->user != null && ( $this->user_role == "bengkel"  || $this->user_role == "owner"  ||  $this->user_role == "dev" )) {
        } else {
            redirect('/');
        }
    }

	public function view($directory = false,$use_layout = true)
    { 
        /*$folder = array("test","coba");
        $this->subfolder = implode("/", $folder);*/ // for content subfolder view

        if ($directory) {
            $subfolder = $directory;
        } else {
        	$subfolder = "";
        }

        $className  = $this->router->fetch_class();   //  for folder directory name view
        $methodName = $this->router->fetch_method();  //  for files name view

        if ($use_layout) {  // menggunakan template header dan footer
            // for view header
            $header = implode("/", array(
                                        $this->layouts,"header"
                        ));
            $this->load->view($header,array_merge($this->data["all"],$this->data["header"]));

            //for view data content
            $content = implode("/", array(
                  isset($subfolder)?$subfolder:"",$className,$methodName
            ));

            // $this->viewContent(array("openBox" => $this->openBox()));
            $this->load->view($content,array_merge($this->data["all"],$this->data["view"]));

            // for view footer
            $footer = implode("/", array(
              $this->layouts,"footer"
            ));
            $this->load->view($footer,array_merge($this->data["all"],$this->data["footer"]));
            
        } else {   // tidak meneggunakan template header dan footer
          //for view data content
          $content = implode("/", array(
              isset($subfolder)?$subfolder:"",$this->router->class,$this->router->method
          ));

          $this->load->view($content,$this->data["view"]);
        }
    }

    public function viewMaster($directory=true,$use_layout=true)
    {
    	$folder = "master";
    	if ($directory) {
    		if (is_string($directory)) {
    			$folder = $directory;
    		}
    	} else {
    		$folder = "";
    	}
    	self::view($folder,$use_layout);
    }

    public function viewTransaksi($directory=true,$use_layout=true)
    {
        $folder = "transaksi";
        if ($directory) {
            if (is_string($directory)) {
                $folder = $directory;
            }
        } else {
            $folder = "";
        }
        self::view($folder,$use_layout);
    }

    public function viewLaporan($directory=true,$use_layout=true)
    {
        $folder = "laporan";
        if ($directory) {
            if (is_string($directory)) {
                $folder = $directory;
            }
        } else {
            $folder = "";
        }
        self::view($folder,$use_layout);
    }

    public function viewPerforma($directory=true,$use_layout=true)
    {
        $folder = "performa";
        if ($directory) {
            if (is_string($directory)) {
                $folder = $directory;
            }
        } else {
            $folder = "";
        }
        self::view($folder,$use_layout);
    }

    public function viewPendapatan($directory=true,$use_layout=true)
    {
        $folder = "pendapatan";
        if ($directory) {
            if (is_string($directory)) {
                $folder = $directory;
            }
        } else {
            $folder = "";
        }
        self::view($folder,$use_layout);
    }

	public function headerTitle($halamanTitle = "",$title = "Empty Header Title",$smallTitle = "")
    {

        $this->data["header"] = array(
        								"header_title" => $title,
        								"small_title" => $smallTitle,
        								"halaman_title"	=> $halamanTitle,
        							);
    }

	public function pageTitle($item)
    {
        if ($item) {
        	$data = $item;
        } else {
            $data = $this->router->fetch_class();
        }
        
        $this->data["header"]["page_title"] = $data;
    }

	public function breadcrumbs($item)
    {
        $this->data["header"]["breadcrumbs"] = $item;
    }

	public function viewContent($content)
    {
        $this->data['view'] = $content;
    }

	public function isPost()
	{
		if (strtoupper($this->input->server("REQUEST_METHOD")) == "POST") {
			return true;
		} else {
			$this->response->message = "Not allowed get request!";
			$this->response->data = null;
			return false;
		}
	}

	public function json($data = null)
	{
    	$this->output->set_header("Content-Type: application/json; charset=utf-8");
    	$data = isset($data) ? $data : $this->response;
    	$this->output->set_content_type('application/json');
	    $this->output->set_output(json_encode($data));
    	// echo json_encode($data);
	}

    public function jsonp($data = null)
    {
        $this->output->set_header("Content-Type: application/json; charset=utf-8");
        $data = isset($data) ? $data : $this->response;
        $this->output->set_content_type('application/jsonp');
        $this->output->set_output(json_encode($data));
        // echo json_encode($data);
    }

	public function dataUser()
	{
		$this->load->model("master/Users_model","usersModel");
		$where = array("users.id" => $this->user->id);
		$join = array(
						array("user_roles","user_roles.id = users.user_role_id","LEFT")
					);
		$userData = $this->usersModel->getByWhere($where,false,$join);
		return $userData;
	}

    public function roleOwner0()
    {
        return var_dump("created dev users.");
    }
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */