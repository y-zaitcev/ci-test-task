<?php

/**
 * Authorization controller
 */
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        redirect('auth/login');
    }

    /**
     * Login user 
     */
    public function login()
    {
        if ($this->input->post())
        {
            //set validation rules
            $this->form_validation->set_rules($this->_set_valid_rules_login());

            //check if data is valid
            if ($this->form_validation->run())
            {
                $input_data = $this->input->post();

                //try to find user
                if ($user = $this->user->findForLogin($input_data['email'], $input_data['password']))
                {
                    $this->session->set_userdata('user_id', $user['id']);

                    set_flash('success', 'You logged in as ' . $user['email']);

                    redirect('dashboard');
                }
                set_flash('error', 'Not correct email/password');
            }
        }
        $this->load->view('login', array(
            'title' => 'Login'
        ));
    }

    /**
     * Registration 
     */
    public function registration()
    {
        if ($this->input->post())
        {
            //set validation rules
            $this->form_validation->set_rules($this->_set_valid_rules_register());

            //check if data is valid
            if ($this->form_validation->run())
            {
                $input_data = $this->input->post();

                try
                {
                    // create user
                    $user_id = $this->user->register(array(
                        'email' => $input_data['email'],
                        'password' => $input_data['password']
                            ));

                    // authorize user
                    $this->session->set_userdata('user_id', $user_id);

                    // send email
                    $this->load->helper('email');
                    send_email($input_data['email'], 'Registration success', 'You was successfully registered! Your login: ' . $input_data['email'] . '. Your password: ' . $input_data['password']);

                    set_flash('success', 'You was successfully registered');
                    redirect('dashboard');
                }
                catch (Exception $e)
                {
                    set_flash('error', 'Error occured while cteating your account. Please contact us and report a bug');
                    redirect('auth/registration');
                }
            }
        }
        $this->load->view('registration', array(
            'title' => 'Registration'
        ));
    }

    /**
     * Set validation rules for login
     * @return array 
     */
    private function _set_valid_rules_login()
    {
        return array
            (
            array
                (
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required|valid_email|xss-clean'
            ),
            array
                (
                'field' => 'password',
                'label' => 'password',
                'rules' => 'trim|required'
            )
        );
    }

    /**
     * Set validation rules for registration
     * @return array 
     */
    private function _set_valid_rules_register()
    {
        return array
            (
            array
                (
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required|valid_email|callback_email_unique|xss-clean'
            ),
            array
                (
                'field' => 'password',
                'label' => 'password',
                'rules' => 'trim|required|min_length[5]'
            ),
            array
                (
                'field' => 'confirm_password',
                'label' => 'Confirm password',
                'rules' => 'trim|required|matches[password]'
            )
        );
    }

    /**
     * Callback function for checking if email is unique
     * 
     * @param string $email
     * @return boolean
     */
    public function email_unique($email)
    {
        if (!$this->user->emailExists($email))
            return TRUE;

        $this->form_validation->set_message('email_unique', 'The %s is not unique.');
        return FALSE;
    }

}