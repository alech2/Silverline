<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Homepage extends CI_Controller {

	/**
	*	Index page for magazine controller
	*/
	public function index(){

		$this->load->view('homepage');

	}


	/**
	*	Index page for magazine controller
	*/
	public function upload(){

		$this->load->view('upload');

	}


	/**
	*	Index page for magazine controller
	*/
	public function craateMsg(){

		$this->load->view('create_message');

	}



} 