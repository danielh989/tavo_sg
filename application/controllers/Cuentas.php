<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cuentas extends CI_Controller
{
    
    public function __construct() {
        parent::__construct();
        //$this->output->enable_profiler(TRUE);
        $this->load->model('cuentas_model', 'cuentas');
    }
    
    public function index() {

    		$fecha = $this->input->post('fecha');

    		if (!$fecha) {
    				//Si no se establece la fecha se asume que es hoy
            $fecha = date('Y-m-d'); //Formato SQL
        } 
        else {
        		//En este caso se toma la fecha del input y se convierte a formato MySQL
            $fecha = DateTime::createFromFormat('d/m/Y', $fecha)->format('Y-m-d');
        }
        

        $data['cuentas'] = $this->cuentas->index($fecha);
        $data['totales']=$this->cuentas->totales($fecha);

        //Se revierte el formato SQL a VE para el input
        $data['fecha_input'] = DateTime::createFromFormat('Y-m-d', $fecha)->format('d/m/Y');


        $this->load->view('common/header');
        $this->load->view('cuentas', $data);
    }

}
