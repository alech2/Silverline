<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Magazine extends CI_Controller {

	/**
	*	Index page for magazine controller
	*/
	public function index(){

		$data = array();
		$this->load->model('Publication');
		$this->load->model('Issue');
		$publication = new Publication();
		$issue = new Issue();
		$publication->load(1);
		$data['publication'] = $publication;
		$issue->load(1);
		$data['issue'] = $issue;

		$this->load->view('magazines');
		$this->load->view('magazine', $data);


		// $this->load->model('Publication');
		// $this->Publication->publication_name = 'Sandy Shore';
		// $this->Publication->save();
		// echo '<tt><pre>' . var_export($this->Publication, TRUE) . '</tt></pre>';

		// $this->load->model('Issue');
		// $issue = new Issue();
		// $issue->publication_id = $this->Publication->publication_id;
		// $issue->issue_number = 2;
		// $issue->issue_date_publication = date('2013-02-01');
		// $issue->save();
		// echo '<tt><pre>' . var_export($issue, TRUE) . '</tt></pre>';
		// $this->load->view('magazines');
	}

	/**
	* Add a Magazine
	*/
	public function add() {
		
		// LOAD LIST OF PUBLICATIONS FROM DB
		$this->load->model('Publication');
		$publications = $this->Publication->get();
		$publication_form_options = array();
		foreach ($publications as $id => $publication) {
			$publication_form_options[$id] = $publication->publication_name;
		}

		// FORM VALIDATION INIT
		$this->load->library('form_validation'); 
		$this->form_validation->set_rules(array(
				array(
						'field' => 'publication_id',
						'label' => 'Publication',
						'rules' => 'required',
					),
				array(
						'field' => 'issue_number',
						'label' => 'Issue Number',
						'rules' => 'required|is_numeric',
					),
				array(
						'field' => 'issue_date_publication',
						'label' => 'Publication date',
						'rules' => 'required|callback_date_validation',
					),
			));
		$this->form_validation->set_error_delimiters('<div class=""alert alert-error">','</div>');
		
		// validate form if is success
		if (!$this->form_validation->run()) {
			// load form page - validation failed
			$this->load->view('magazine_form', array(
				'publication_form_options' => $publication_form_options,
			));	
		} else {
			$this->load->model('Issue');
			$issue = new Issue();
			$issue->publication_id = $this->input->post('publication_id');
			$issue->issue_number = $this->input->post('issue_number');
			$issue->issue_date_publication = $this->input->post('issue_date_publication');
			$issue->save();
			$this->load->view('magazine_form_success', array(
					'issue' => $issue,
				));
		}
	} 

	/**
	* Date Validation callback.
	* @param string $input
	* @return boolean 
	*
	*/
	public function date_validation($input) {
		$test_date = explode('-', $input);
		if (!@checkdate($test_date[1], $test_date[2], $test_date[0])) {
			$this->form_validation->set_message('date_validation', 'The %s files mus be in YYYY-MM-DD format');
			return FALSE;
		} else {
			return TRUE;
		}
	}

} 