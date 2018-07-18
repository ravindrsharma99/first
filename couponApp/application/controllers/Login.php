<?php
error_reporting(0);
ini_set('display_errors',0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
		function __construct(){
		parent::__construct();
		$this->load->library('email');
		$this->email->initialize(array(
		'protocol' => 'smtp',
		'smtp_host' => 'smtp.sendgrid.net',
		'smtp_user' => 'osvinphp',
		'smtp_pass' => '@osvinphp12',
		'smtp_port' => 587,
		'crlf' => "\r\n",
		'newline' => "\r\n",
		'type'=>'html'
		));
		$session=$this->session->all_userdata();
		if (($session['email'])) {
			redirect('Admin');
		}
	}


	public function index()
	{
		$this->load->view('login');
	}

	public function checklogin(){

		if (empty($_POST['email']) || empty($_POST['password'])   ) {
			$this->session->set_flashdata('msg', 'Please fill valid field.');
			redirect('Login');
		}
		else{
			$query=$this->Common_model->selectrow('tblAdmin',array('email'=>$_POST['email'],'password'=>md5($_POST['password'])),'*');
			if (empty($query)) {
				$this->session->set_flashdata('msg', 'Email or password is invalid.');
				redirect('Login');
			}
			else{
				$arraydata = array(
				'email'  => $query->email,
				'id'     => $query->email,
				);
				$this->session->set_userdata($arraydata);
				redirect('Admin');
			}
		}

	}

	public function forgotPassword(){
		$email=$_POST['email'];
		// print_r("sdgjfdhgsldfl");die;
		$query=$this->db->query("SELECT * from tblAdmin where email='".$email."'")->row();
		if(empty($query)){
			echo 0;
		}
		else{
			$checkemail=$this->Common_model->forgotAdminpassword($email);
			$fromemail="couponapp@gmail.com";
			$toemail = "osvinphp@gmail.com";
			$subject = "Password reset Mail.";
			$data['data']=$checkemail;
			$mesg = $this->load->view('app/forgotAdminpassword',$data,true);
			$this->email->to('ravindrsharma99@gmail.com');
			$this->email->from($fromemail, "From Coupon App.");
			$this->email->subject($subject);
			$this->email->message($mesg);
			$mail = $this->email->send();
			$response= $this->Common_model->sucessResponse('Password reset mail send successfully');
			echo "1";die;
		}
	}



    function updateNewpassword(){
        $uid = $this->input->post('id');

        $static_key = "afvsdsdjkldfoiuy4uiskahkhsajbjksasdasdgf43gdsddsf";
        $id = $uid . "_" . $static_key;
        $id = base64_encode($id);
        $message = ['id' => $this->input->post('id') , 'password' => $this->input->post('password') , 'base64id' => $id];
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|md5');
        $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|matches[password]|md5');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('msg', '<span style="color:red">Please Enter Same Password</span>');
            redirect("api/Auth/newAdminpassword?id=" . $message['base64id']);
        }
        else
        {
            $this->updatepassword($message);
        }
    }

	public function updatepassword($message){
		$update_pwd = $this->db->where('id', 1);
		$this->db->update("tblAdmin", array(
		'password' => md5($message['password']))
		);
		$this->session->set_flashdata('msg', '<span style="color:green">Password Changed Successfully</span>');
		redirect("api/Auth/newAdminpassword?id=" . $message['base64id']);
	}




}
