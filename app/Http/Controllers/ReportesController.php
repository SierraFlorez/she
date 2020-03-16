<?php

namespace App\Http\Controllers;

// <Modelos>
use App\Hora;
use App\User;
use App\CargoUser;
// </Modelos>

// <phpOffice>
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// </phpOffice>

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportesController extends Controller
{
    // Vista de descargar reportes y trae todos los usuarios con su cargo vigente
    public function index()
    {
        $usuarios=CargoUser::where('estado',1)->get();
        return view('reportes.index', compact('usuarios'));
    }

    // Descarga el reporte de solicitud de autorización
    public function solicitudAutorizacion(Request $request)
    {
        $dato = $request->all();
        $id=$dato['select_f'];
        $mes=$dato['select_mes'];
        $inicio='2020-'.$mes.'-01';
        $fin= date("Y-m-t", strtotime($inicio));
        if(($id=='') || ($mes=='')){
            return 'Verifique si esta seleccionando un mes y un funcionario';
        }
        $horas=Hora::join('cargo_user','cargo_user.id','=','horas.id_user_cargo')->join('users','users.id','=','cargo_user.user_id')->join('cargos','cargos.id','=','cargo_user.cargo_id')->where('id_user_cargo',$id)
        ->where('fecha','>=',$inicio)->where('fecha','<=',$fin)->get();

         //Estilo del reporte (Bordes de cada celda)
         $styleArray = [
            'font' => [
                'bold' => false,
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        
       
        //Carga la plantilla para generar el reporte
        $pathTemplate = getcwd().'\formatos\GTH_F_061_SOLICITUD_DE_AUTORIZACION_DE_HORAS_EXTRAS.xlsx';
        //Selecciona la hoja en la que va a escribir el reporte
        $escritor = IOFactory::load($pathTemplate);
        $worksheet = $escritor->getActiveSheet(0);
        // dd($horas);
        $escritor->getActiveSheet()->setShowGridLines(false);
        $usuario=[];
        $consolidado=[];
        foreach ($horas as $hora){
            $usuario['nombre_completo']=$hora->nombres.' '.$hora->apellidos;
            $usuario['documento']=$hora->documento;
            $usuario['cargo']=$hora->nombre;
            $usuario['centro']=$hora->centro;
            $consolidado[]=$usuario;
            break;
        }
        $worksheet->getCell('B7')->setValue($consolidado[0]['nombre_completo']);

        $worksheet->getCell('D7')->setValue($consolidado[0]['documento']);

        $worksheet->getCell('G7')->setValue($consolidado[0]['centro']);

        $worksheet->getCell('I7')->setValue($consolidado[0]['cargo']);

        
        // dd($escritor);
        $file="legalizacionHorasExtras-".$consolidado[0]['nombre_completo'].'-'.$mes.".xlsx";//Nombre del archivo
        
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($escritor, 'Xlsx');

        header('Content-Type: application/application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="'.$file.'"');

        $writer->save("php://output");//Descarga el archivo del reporte

        die;
        
    }

   
    public function store(Request $request)
    {
        //
    }

   
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    
    public function update(Request $request, $id)
    {
        //
    }

    
    public function destroy($id)
    {
        //
    }
}
