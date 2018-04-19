<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
use Aws\S3\S3Client as S3Client;
class Ngo_c extends CI_Controller{


    public function logout(){
  					$this->session->sess_destroy();
  					redirect(base_url());
  		}

    //register
		public function ngo_register(){

			$data= array('success_msg' => $this->session->flashdata('success'));

			$this->load->view('users/ngo_registration');

		}

		public function	ngo_registerprocess(){
    $config['upload_path']   = './uploads/';// relative to the root of this project
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']      = 5000;
    $config['max_width']     = 2048;
    $config['max_height']    = 2048;
    $this->upload->initialize($config);

		$this->form_validation->set_rules('form_name',            'Name', 'trim|required');
		$this->form_validation->set_rules('form_contact_person',   'Contact person', 'trim|required');
    $this->form_validation->set_rules('form_contact_email',    'Email','trim|required|valid_email|is_unique[ngos.contact_email]');
    $this->form_validation->set_rules('form_fields_activity',  'Fields of activity', 'trim|required');
		$this->form_validation->set_rules('form_website',          'Website','trim');
    $this->form_validation->set_rules('form_username',         'Username','required|trim|min_length[5]');
    $this->form_validation->set_rules('form_password',         'Password','required|trim|min_length[7]');
		$this->form_validation->set_rules('form_con_password',     'password Confirmation','trim|required|matches[form_password]');
		// $this->form_validation->set_rules('form_email',       'Email', 'required|valid_email|is_unique[users.email]');

       
     $isFileUploaded = $this->upload->do_upload('form_profile_photo');
        
        if ($isFileUploaded) {
            $uploaded_file = $this->upload->data();
            //var_dump($upload_picture);exit;
            // amazon upload code
            $s3 = new S3Client([
              'version' => 'latest',
              'region'  => 'eu-central-1'
            ]);
            $bucket = getenv('S3_BUCKET')?: die('No S3_BUCKET env var found');

             $s3_upload = $s3->upload(
              $bucket, // s3 bucket to upload towards
              $uploaded_file['file_name'], // filename you want to give on s3 for this upload
              fopen($uploaded_file['full_path'], 'rb'), // read the content of the picture
              'public-read' // make it readable / public
            );
            
             $photo = $s3_upload['ObjectURL']; // get the actual file url of s3 file
          } else {
            $photo = NULL;
          }
        
      if ($this->form_validation->run() == FALSE || $isFileUploaded == FALSE)
      {
            $this->load->view('users/ngo_registration');
      }
      else
      {
      $photo = $this->upload->data();
			$this->load->model('ngo_model');
			$data = array(
				'c_name'              => $this->input->post('form_name',true),
				'c_contact_person'    => $this->input->post('form_contact_person',true),
				'c_contact_email'    => $this->input->post('form_contact_email',true),
        'c_fields_activity'   => $this->input->post('form_fields_activity',true),
				'c_website'           => $this->input->post('form_website',true),
        'c_username'          => $this->input->post('form_username',true),
        'c_password'          => $this->input->post('form_password',true),
        'c_ngo_photo'     => $photo,
        );

			$this->session->set_flashdata('success', 'Welcome to the community!');
			$this->ngo_model->add_ngo( $data );
			redirect(base_url('ngo/registration'));
        }
	 }

    public function add_question(){
       $config['upload_path']   = './uploads/';// relative to the root of this project
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']      = 5000;
    $config['max_width']     = 2048;
    $config['max_height']    = 2048;
    $this->upload->initialize($config);


      $this->form_validation->set_rules('title', 'title', 'trim|required');
			$this->form_validation->set_rules('q_content', 'description', 'trim|required');
      $this->form_validation->set_rules('when_needed', 'when needed', 'trim|required');
     

      $isFileUploaded = $this->upload->do_upload('attachment');
        if ($isFileUploaded) {
            $uploaded_file = $this->upload->data();
            //var_dump($upload_picture);exit;
            // amazon upload code
            $s3 = new S3Client([
              'version' => 'latest',
              'region'  => 'eu-central-1'
            ]);
            $bucket = getenv('S3_BUCKET')?: die('No S3_BUCKET env var found');

             $upload = $s3->upload(
              $bucket, // s3 bucket to upload towards
              $uploaded_file['file_name'], // filename you want to give on s3 for this upload
              fopen($uploaded_file['full_path'], 'rb'), // read the content of the picture
              'public-read' // make it readable / public
            );

             $photo = $upload['ObjectURL']; // get the actual file url of s3 file
          } else {
            $photo = NULL;
          }
        if ($this->form_validation->run() == FALSE || $isFileUploaded == FALSE)
        {
          
          
          $this->session->set_flashdata('error', 'invalid data');
          $this->load->view('users/add_question', array('photo' => $photo));
        }
        else
        {
      if($this->form_validation->run() == FALSE || $isFileUploaded == FALSE){
        $this->load->view('/users/add_question');
      }
      else{
        $this->load->model('Ngo_model');
				$cUser = $this->session->userdata('currentUser');

        $question = array(
          'c_title' => $this->input->post('title'),
        'c_content' => $this->input->post('q_content'),
          'c_when_needed' =>$this->input->post('when_needed'),
          'c_attachment' => $photo,
          'cUser_id' => $cUser['id']
        );

        $this->Ngo_model->m_add_question($question);
        $this->session->set_flashdata('success', 'Thank you for adding your question.');
        redirect('/');
      }
    }}


    //14-11-2017 mohamed
    public function c_add_comment_ngo(){
        $comment_text = $this->input->post('comment_text');
        $a_id = $this->input->post('a_id');
        $ngo_user = $this->session->userdata('currentuser');
        $ngo_id = $ngo_user['id'];
        $this->load->model('main-model');
        $data = array( 'c_comment_text' =>$comment_text,
                       'a_id' =>$a_id,
                       'ngo_id' =>$ngo_id);

        $this->main_model->m_add_comment($data);
        redirect("/home");
        }


        //15-11-2017 mohamed
            public function ngo_edit_profile(){
              // $this->load->model('ngo_model');
              $this->load->model('main_model');
              $cUser = $this->session->userdata('currentUser');
              $ngo_id = $cUser['id'];
              // $result = $this->ngo_model->select_one_ngo($ngo_id);
              $result = $this->main_model->m_ngo_details($ngo_id);
              $data = array(
                    'ngo'    => $result,
                    'cUser'		=> $cUser
                      );
              $this->load->view('users/ngo_edit_profile', $data);
            }

  public function c_update_ngo(){

    $this->load->model('main_model');
    $config['upload_path']   = './uploads/';// relative to the root of this project
    $config['allowed_types'] = 'gif|jpg|png';
    $config['max_size']      = 5000;
    $config['max_width']     = 2048;
    $config['max_height']    = 2048;
    $this->upload->initialize($config);
      $cUser = $this->session->userdata('currentUser');
       $ngo =$this->main_model->m_ngo_details($cUser['id']);

    $this->form_validation->set_rules('form_name', 'Name', 'trim|required');
    $this->form_validation->set_rules('form_contact_person', 'Contact person', 'trim|required');
    if ($ngo['contact_email'] !== $this->input->post('form_contact_email')) {
        $this->form_validation->set_rules('form_contact_email', 'Email', 'trim|required|valid_email|is_unique[ngos.contact_email]');
      }
    
    $this->form_validation->set_rules('form_fields_activity','Fields of activity', 'trim|required');
    $this->form_validation->set_rules('form_website','Website', 'trim');

    if($ngo['username'] !== $this->input->post('form_username')){
      $this->form_validation->set_rules('form_username','Username','required|trim|min_length[5]|is_unique[ngos.username]');
    }

        $isFileUploaded = $this->upload->do_upload('form_photo');
        
        if ($isFileUploaded) {
            $uploaded_file = $this->upload->data();
            //var_dump($upload_picture);exit;
            // amazon upload code
            $s3 = new S3Client([
              'version' => 'latest',
              'region'  => 'eu-central-1'
            ]);
            $bucket = getenv('S3_BUCKET')?: die('No S3_BUCKET env var found');

             $upload = $s3->upload(
              $bucket, // s3 bucket to upload towards
              $uploaded_file['file_name'], // filename you want to give on s3 for this upload
              fopen($uploaded_file['full_path'], 'rb'), // read the content of the picture
              'public-read' // make it readable / public
            );

             $photo = $upload['ObjectURL']; // get the actual file url of s3 file
          } else {
            $photo = NULL;
          }
        if ($this->form_validation->run() == FALSE || $isFileUploaded == FALSE)
        {
          $this->session->set_flashdata('error', 'invalid data');
          $this->load->view('users/ngo_update_profile', array('photo' => $photo));
        }
        else
        {
         $this->load->model('Ngo_model');

          $data = array(
    				'c_name'              => $this->input->post('form_name',true),
    				'c_contact_person'    => $this->input->post('form_contact_person',true),
    				'c_contact_email'     => $this->input->post('form_contact_email',true),
            'c_fields_activity'   => $this->input->post('form_fields_activity',true),
    				'c_website'           => $this->input->post('form_website',true),
            'c_username'          => $this->input->post('form_username',true),
            'c_photo'             => $photo,
            'id'                  => $this->session->currentUser['id'],

            );

           
            $this->session->set_flashdata('success', 'Data successfully updated');
            $this->Ngo_model->m_update_ngo( $data );
            redirect('/user/ngo/profile');
        }
      }


  public function ngo_delete_profile() {
    $this->load->model('Ngo_model');
    $this->Ngo_model->m_delete_ngo($this->session->currentUser['id']);
    session_destroy();
    redirect('/');
  }

  public function c_share_request_ngo(){
    //$this->output->enable_profiler(TRUE);

$this->load->model('main_model');
  $ngo_id = $this->session->currentUser['id'];
  $result =$this->main_model->get_all_share_request_ngo($ngo_id);
  $view_data =  array('share_requests' => $result);

  $this->load->view('users/ngo_share_request', $view_data);

}



}
