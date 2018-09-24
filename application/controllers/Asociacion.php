<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Asociacion extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('asociacion_model');
	}

	public function index(){
		$data['tipo_asociacion'] = $this->asociacion_model->obtener_tipo_asociacion();
		$data['sector_asociacion'] = $this->asociacion_model->obtener_sector_asociacion();
		$data['clase_asociacion'] = $this->asociacion_model->obtener_clase_asociacion();
		$data['municipio_asociacion'] = $this->asociacion_model->obtener_municipio_asociacion();
		$data['estado_asociacion'] = $this->asociacion_model->obtener_estado_asociacion();
		$this->load->view('templates/header');
		$this->load->view('asociaciones/asociacion', $data);
		$this->load->view('templates/footer');
	}

	public function tabla_asociacion(){
		$this->load->view('asociaciones/asociacion_ajax/tabla_asociacion');
	}

	public function convertir_fecha($fecha){
		if($fecha == "" || $fecha == "0000-00-00"){
			return "0000-00-00";
		}else{
			return date("Y-m-d",strtotime($fecha));
		}
	}

	public function gestionar_asociacion(){
		$data = array(
		    'ID_ASOCIACION' => $this->input->post('ID_ASOCIACION'),
			
			'NOMBRE_ASOCIACION' => mb_strtoupper($this->input->post('NOMBRE_ASOCIACION')),
			'SIGLAS_ASOCIACION' => mb_strtoupper($this->input->post('SIGLAS_ASOCIACION')),
			'DEPENDENCIA_ASOCIACION' => mb_strtoupper($this->input->post('ID_DEPENDENCIA_ASOCIACION')),
			'TELEFONO_ASOCIACION' => mb_strtoupper($this->input->post('TELEFONO_ASOCIACION')),
			'EMAIL_ASOCIACION' => mb_strtoupper($this->input->post('EMAIL_ASOCIACION')),
			'DIRECCION_ASOCIACION' => mb_strtoupper($this->input->post('DIRECCION_ASOCIACION')),
			'INSTITUCION_PERTENECE_ASOCIACION' => mb_strtoupper($this->input->post('INSTITUCION_PERTENECE_ASOCIACION')),
			'ID_MUNICIPIO_ASOCIACION' => mb_strtoupper($this->input->post('ID_MUNICIPIO_ASOCIACION')),
			'HOMBRES_ASOCIACION' => mb_strtoupper($this->input->post('HOMBRES_ASOCIACION')),
			'MUJERES_ASOCIACION' => mb_strtoupper($this->input->post('MUJERES_ASOCIACION')),
			'ID_TIPO_ASOCIACION' => mb_strtoupper($this->input->post('ID_TIPO_ASOCIACION')),
			'ID_SECTOR_ASOCIACION' => mb_strtoupper($this->input->post('ID_SECTOR_ASOCIACION')),
			'ID_CLASE_ASOCIACION' => mb_strtoupper($this->input->post('ID_CLASE_ASOCIACION')),
			'FOLIO_ASOCIACION' => mb_strtoupper($this->input->post('FOLIO_ASOCIACION')),
			'LIBRO_ASOCIACION' => mb_strtoupper($this->input->post('LIBRO_ASOCIACION')),
			'REG_ASOCIACION' => mb_strtoupper($this->input->post('REG_ASOCIACION')),
			'ARTICULO_ASOCIACION' => mb_strtoupper($this->input->post('ARTICULO_ASOCIACION')),
			'FECHA_CONSTITUCION_ASOCIACION' => $this->convertir_fecha($this->input->post('FECHA_CONSTITUCION_ASOCIACION')),
			'FECHA_RESOLUCION_FINAL_ASOCIACION' => $this->convertir_fecha($this->input->post('FECHA_RESOLUCION_FINAL_ASOCIACION')),
			'ESTADO_ASOCIACION' => 3
		);
		if($this->input->post('band') == "save"){
			$data['NUMERO_ASOCIACION'] = cargarCorrelativo($this->input->post('ID_TIPO_ASOCIACION'),$this->input->post('ID_SECTOR_ASOCIACION'),$this->input->post('ID_DEPENDENCIA_ASOCIACION'));
      		echo $this->asociacion_model->insertar_oficina($data);
		}else if($this->input->post('band') == "edit"){
			$data['NUMERO_ASOCIACION']=$this->input->post('NUMERO_ASOCIACION');
			echo $this->asociacion_model->editar_oficina($data);
		}else if($this->input->post('band') == "delete"){
			echo $this->asociacion_model->eliminar_oficina($data);
		}
	}

	function excel(){
		//echo "VISTA NO DISPONIBLE ACTUALMENTE (AUN EN DESARROLLO)";
		$data = array(
			'fecha_inicio' => $this->input->post('fecha_inicio'),
			'fecha_fin' => $this->input->post('fecha_fin'),
			'id_clase' => $this->input->post('id_clase'),
			'id_tipo' => $this->input->post('id_tipo'),
			'id_sector' => $this->input->post('id_sector'),
			'id_estado' => $this->input->post('id_estado')
		);

		$this->load->library('phpe');
		error_reporting(E_ALL);
		ini_set('display_errors', TRUE);
		ini_set('display_startup_errors', TRUE);
		date_default_timezone_set('America/Mexico_City');
		$estilo = array( 'borders' => array( 'outline' => array( 'style' => PHPExcel_Style_Border::BORDER_THIN ) ) );

		if (PHP_SAPI == 'cli')
			die('Este reporte solo se ejecuta en un navegador web');

		// Create new PHPExcel object
		$this->objPHPExcel = new Phpe();

		// Set document properties
		$this->objPHPExcel->getProperties()->setCreator("Sistema de establecimientos")
									 ->setLastModifiedBy("Sistema de establecimientos")
									 ->setTitle("Office 2007 XLSX Test Document")
									 ->setSubject("Office 2007 XLSX Test Document")
									 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
									 ->setKeywords("office 2007 openxml php");

		$titulo = 'Consolidado de asociaciones';

		$f=1;
		$letradesde = 'A';
		$letrahasta = 'T';

		/*********************************** 	INICIO ANCHO DE LAS COLUMNAS	****************************************/
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(5);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(10);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(15);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(70);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(50);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(15);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(10);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(10);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(30);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(15);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(15);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(15);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(15);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(10);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(10);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(10);
		$this->objPHPExcel->getActiveSheet()->getColumnDimension('T')->setWidth(10);
		/*********************************** 	  FIN ANCHO DE LAS COLUMNAS 	 ****************************************/


		/*********************************** 	INICIO DE LOS TITULOS 		****************************************/
		$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, "MINISTERIO DE TRABAJO Y PREVISION SOCIAL");
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells($letradesde.$f.':'.$letrahasta.$f);	$f++;

		$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, "DIRECCIÓN GENERAL DE INSPECCIÓN DE TRABAJO");
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells($letradesde.$f.':'.$letrahasta.$f);	$f++;

		$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, "OFICINA DE REGISTRO DE ESTABLECIMIENTOS");
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells($letradesde.$f.':'.$letrahasta.$f);	$f+=2;

		$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, $titulo);
		$this->objPHPExcel->getActiveSheet()->getStyle('A'.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells($letradesde.$f.':'.$letrahasta.$f);	$f+=2;
		
		/*********************************** 	   FIN DE LOS TITULOS 		****************************************/
		

		/*********************************** 	  INICIO ENCABEZADOS DE LA TABLAS	****************************************/
		foreach(range($letradesde,$letrahasta) as $columnID) {	//APLICA BORDES A LAS CELDAS
		    $this->objPHPExcel->getActiveSheet()->getStyle($columnID.$f)->applyFromArray($estilo);
		    $this->objPHPExcel->getActiveSheet()->getStyle($columnID.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, "#");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$f, "N° Asociación");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$f, "Fecha constitución");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$f, "Nombre Asociación");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$f, "Siglas");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$f, "Municipio");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$f, "Dirección");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$f, "Correo");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$f, "Teléfono");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$f, "# Hombres");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$f, "# Mujeres");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$f, "Institución");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$f, "Tipo");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$f, "Clase");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$f, "Sector");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$f, "Estado");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$f, "Folio");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$f, "Libro");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$f, "Registro");
	 	$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$f, "Artículo");
	 	/*********************************** 	   FIN ENCABEZADOS DE LA TABLA   	****************************************/
	 	$this->objPHPExcel->getActiveSheet()->setAutoFilter($letradesde.$f.":".$letrahasta.$f);
	 	$f++;


	 	/*********************************** 	   INICIO DE LOS REGISTROS DE LA TABLA   	****************************************/
		$inscripciones = $this->asociacion_model->obtener_personas_inscritas($data);
		$correlativo = 0;
		if($inscripciones->num_rows()>0){
			foreach ($inscripciones->result() as $filas) {
				$correlativo++;
				foreach(range($letradesde,$letrahasta) as $columnID) {	//APLICA BORDES A LAS CELDAS
				    $this->objPHPExcel->getActiveSheet()->getStyle($columnID.$f)->applyFromArray($estilo);
				}

				// DEFIENDO VALORES DE LAS CELDAS (EXTRAYENDO LOS DATOS DE LA BASE)
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, $correlativo);
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$f, ($filas->NUMERO_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$f, date("d/m/Y",strtotime($filas->FECHA_CONSTITUCION_ASOCIACION)));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$f, ($filas->NOMBRE_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$f, ($filas->SIGLAS_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$f, ($filas->municipio));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$f, ($filas->DIRECCION_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$f, ($filas->EMAIL_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('I'.$f, ($filas->TELEFONO_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$f, ($filas->HOMBRES_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$f, ($filas->MUJERES_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$f, ($filas->INSTITUCION_PERTENECE_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$f, ($filas->tipo));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$f, ($filas->clase));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$f, ($filas->sector));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$f, ($filas->estado));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$f, ($filas->FOLIO_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$f, ($filas->LIBRO_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$f, ($filas->REG_ASOCIACION));
				$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$f, ($filas->ARTICULO_ASOCIACION));
				$f++;
			}
		}else{ //SINO HAY REGISTROS
			foreach(range($letradesde,$letrahasta) as $columnID) {  //APLICA BORDES A LAS CELDAS
			    $this->objPHPExcel->getActiveSheet()->getStyle($columnID.$f)->applyFromArray($estilo);
			    $this->objPHPExcel->getActiveSheet()->getStyle($columnID.$f)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			}
			$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$f, 'No hay registros disponibles...');
			$this->objPHPExcel->setActiveSheetIndex(0)->mergeCells($letradesde.$f.':'.$letrahasta.$f);
			$f++;
		}
		/*********************************** 	   FIN DE LOS REGISTROS DE LA TABLA   	****************************************/
		

		$f+=3;

	 	$fecha=strftime( "%d-%m-%Y - %H:%M:%S", time() );
		$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$f,"Fecha y Hora de Creación: ".$fecha); $f++;
		$this->objPHPExcel->setActiveSheetIndex(0)->setCellValue("A".$f,"Usuario: ".$this->session->userdata('usuario'));
		
		// Rename worksheet
		$this->objPHPExcel->getActiveSheet()->setTitle($titulo);
		// Redirect output to a client’s web browser (Excel5)
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$titulo.'.xls"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');

		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0

		 

    	$writer = new PHPExcel_Writer_Excel5($this->objPHPExcel);
		header('Content-type: application/vnd.ms-excel');
		$writer->save('php://output');
	}


	public function cargarCorrelativo($tipo,$sector,$afiliacion)
	{
		//$this->load->helper('url');

		//$this->load->model('Asociacion_model', 'AM',true);
		
		$data=$this->asociacion_model->getCorrelativo($sector,$tipo,$afiliacion);
		//echo $data;
		if($data === 0)
		{
			if($sector == 1)
			{			
					switch($tipo)
					{
						case 1:
								$correlativo = 'C-1 S.P.';

							break;

						case 2:
								 $correlativo = 'F.S.P. 1';
								
						break;

						case 3: $correlativo = '1 S.P.';
								
						break;

						case 4:
								if($afiliacion>0)
									{
										$aux = explode(" ", $this->asociacion_model->getNumeroAsoc($afiliacion));
										$correlativo = $aux[0].' S-1';
									}else{
									//	echo 0;
										return 0;
									}
								
						break;
					}	
				 return $correlativo;
			}
			else {
					switch($tipo)
					{
						case 1:
								$correlativo = 'C-1';
							break;

						case 2:
								 $correlativo = 'F-1';
								
						break;

						case 3: $correlativo = '1';
								 
						break;

						case 4:
								if($afiliacion>0)
									{
										$aux = explode(" ", $this->asociacion_model->getNumeroAsoc($afiliacion));
										$correlativo = $aux[0].' S-1';
									}else{
										//echo 0;
										return 0;
									}
								
						break;
					}
					 return $correlativo;	
			}
			

		}
		else{
			if($sector == 1)
			{			
					switch($tipo)
					{
						case 1:
								$aux = explode(" ", $data);
								//echo $aux[0];
								$aux2=explode("-", $aux[0]);
								//echo $aux2[1];
								$aux2[1]=$aux2[1]+1;
								//echo $aux2[1];
								$correlativo = $aux2[0].'-'.($aux2[1]).' '.($aux[1]);
								//echo $correlativo;

							break;

						case 2:
								$aux = explode(" ", $data);
								$correlativo = $aux[0].' '.($aux[1]+1);
								
						break;

						case 3: $aux = explode(" ", $data);
								$correlativo = ($aux[0]+1).' '.$aux[1];
								
						break;

						case 4:
								$aux = explode(" ", $data);
								$aux2=explode("-", $aux[1]);
								$correlativo = ($aux[0]).' '.$aux2[0].'-'.($aux2[1]+1);
								
						break;
					}	
				 return $correlativo;
			}
			else {
					switch($tipo)
					{
						case 1:
								$aux=explode("-", $data);
								$correlativo = $data[0].'-'.($aux[1]+1);
							break;

						case 2:
								$aux=explode("-", $data);
								$correlativo = $data[0].'-'.($aux[1]+1);
								
						break;

						case 3: $correlativo = $data+1;
								 
						break;

						case 4:
								$aux = explode(" ", $data);
								$aux2=explode("-", $aux[1]);
								$correlativo = ($aux[0]).' '.$aux2[0].'-'.($aux2[1]+1);
								
						break;
					}
					 return $correlativo;	
			}

		}
	}

public function cargarDependencia()
	{
		
		$tipo = $this->input->post('tipo');
		
		$data=$this->asociacion_model->getDependencias($tipo);
		if($data==0)
		{
			echo "<option class='m-l-50' value='NULL'>[No aplica]</option>";
		}
		else{
			if($data==-1)
			{
				$tipo--;
				echo "<option class='m-l-50' value='NULL'>[Ninguna]</option>";
				//echo "<option value='0'>No hay ".$this->AM->verTipoAsoc($tipo)."</option>";
			}
			else{
				echo "<option class='m-l-50' value='NULL'>[Seleccione una dependencia]</option>";
				foreach ($data as $item) {
			 		echo "<option class='m-l-50' value='".$item['ID_ASOCIACION']."'>".$item['NOMBRE_ASOCIACION']."</option>";
				 }
			}
			
		}

	}

	public function cargarSelect()
	{
		$data=$this->asociacion_model->getClasesAsociacion($this->input->post('tipo'));
		echo '<option class="m-l-50" value="">[Seleccione la clase]</option>';
		foreach ($data as $item) {
		 	echo "<option class='m-l-50'  value='".$item['ID_CLASE_ASOCIACION']."'>".$item['NOMBRE_CLASE_ASOCIACION']."</option>";
		 }
	}

	public function saveAfiliado()
	{
		  $config['upload_path'] = './assets/docs/';
		        
		       //Tipos de ficheros permitidos
		        $config['allowed_types'] = 'xls|xlsx';
		         
		       //Se pueden configurar aun mas parámetros.
		       //Cargamos la librería de subida y le pasamos la configuración 

		        $this->load->library('upload', $config);
		      if(!$this->upload->do_upload()){
            /*Si al subirse hay algún error lo meto en un array para pasárselo a la vista*/
                $error= $this->upload->display_errors();
                echo $error;
       			 }
		         $datos=$this->upload->data();
			//obtenemos el archivo subido mediante el formulario
		    $file = $datos['full_path'];
		 
		    //comprobamos si existe un directorio para subir el excel
		    //si no es así, lo creamos
		    if(!is_dir("./assets/docs/")) 
		      mkdir("./assets/docs/", 0777);
		 
		    //comprobamos si el archivo ha subido para poder utilizarlo
		    if ($file==$file)
		    {
		 
		      //queremos obtener la extensión del archivo
		     // $trozos = explode(".", $file);
		 
		      //solo queremos archivos excel
		     // if($trozos[1] != "xlsx" && $trozos[1] != "xls") return;
		 
		      /** archivos necesarios */
		      require_once APPPATH . 'libraries/Classes/PHPExcel.php';
		      require_once APPPATH . 'libraries/Classes/PHPExcel/Reader/Excel2007.php';
		 
		      //creamos el objeto que debe leer el excel
		      $objReader = new PHPExcel_Reader_Excel2007();
		      $objPHPExcel = $objReader->load($file);
		 
		      //número de filas del archivo excel
		      $rows = $objPHPExcel->getActiveSheet()->getHighestRow();   
		 
		      //obtenemos el nombre de la tabla que el usuario quiere insertar el excel
		      $table_name = trim($this->security->xss_clean('sap_afiliado'));  
		 
		      //obtenemos los nombres que el usuario ha introducido en el campo text del formulario,
		      //se supone que deben ser los campos de la tabla de la base de datos.
		      $fields='NOMBRES_AFILIADO,APELLIDOS_AFILIADO,DUI_AFILIADO,SEXO_AFILIADO,MENOR_EDAD_AFILIADO';
		      $fields_table = explode(",", $fields);
		 	
		      //inicializamos sql como un array
		      $sql = array();
		 
		      //array con las letras de la cabecera de un archivo excel
		      $letras = array(
		        "A","B","C","D","E","F","G",
		        "H","I","J","Q","L","M","N",
		        "O","P","Q","R","S","T","U",
		        "V","W","X","Y","Z"
		      );
		 
		      //recorremos el excel y creamos un array para después insertarlo en la base de datos
		      for($i = 9;$i <= $rows; $i++)
		      {
		        //ahora recorremos los campos del formulario para ir creando el array de forma dinámica
		       
		        	if($objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue()=='')
		        		{
		        			break;
		        		}
		          $sql[$i]['NOMBRES_AFILIADO'] = $objPHPExcel->getActiveSheet()->getCell('A'.$i)->getCalculatedValue();
		          $sql[$i]['APELLIDOS_AFILIADO'] = $objPHPExcel->getActiveSheet()->getCell('B'.$i)->getCalculatedValue();
		          $sql[$i]['DUI_AFILIADO'] = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getCalculatedValue();
		          $sql[$i]['SEXO_AFILIADO'] = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getCalculatedValue();
		          $sql[$i]['MENOR_EDAD_AFILIADO'] = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getCalculatedValue();
		        
		      }   
		 
		      /*echo "<pre>";
		      var_dump($sql); exit();
		      */
		 
		      //cargamos el modelo
		    //$this->load->model('Asociacion_model', 'AM',true);
		    $i=$i-1;
		      //insertamos los datos del excel en la base de datos
		      $import_excel = $this->asociacion_model->excel($table_name,$sql,$i,$this->input->post('ID_ASOCIACION'));
		      
		      //comprobamos si se ha guardado bien
		     
		 
		      //finalmente, eliminamos el archivo pase lo que pase
		      //unlink("./docs/".$file);
		 
		    }else{
		      echo "Debes subir un archivo";
		    }
		  
	}

}
?>
