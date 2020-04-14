<?php

namespace App\Http\Controllers;

// <Modelos>
use App\CargoUser;
use App\Hora;
use App\Http\Controllers\Controller;
// </Modelos>

// <phpOffice>
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
// </phpOffice>

class ReportesController extends Controller
{
    // Vista de descargar reportes y trae todos los usuarios con su cargo vigente
    public function index()
    {
        $usuarios = CargoUser::where('estado', 1)->get();
        return view('reportes.index', compact('usuarios'));
    }

    // Descarga el reporte de solicitud de autorización
    public function solicitudAutorizacion(Request $request)
    {
        // $meses=[1=>'1',2=>'Febrero',3=>'Marzo',4=>'Abril',5=>'Mayo',6=>'Junio',7=>'Julio',8=>'Agosto',9=>'Septiembre',10=>'Octubre',11=>'Noviembre',12=>'Diciembre'];
        setlocale(LC_ALL,'');
        $dato = $request->all();
        $id = $dato['select_f'];
        $mes = $dato['select_mes'];
        $nombre_mes=strftime('%B',$mes);
        $inicio = '2020-' . $mes . '-01';
        $fin = date("Y-m-t", strtotime($inicio));
        if (($id == '') || ($mes == '')) {
            $msg="Verifique si esta seleccionando un mes y un funcionario";
            return redirect()->back()->with('warning', $msg);
        }
        $horas = Hora::join('cargo_user', 'cargo_user.id', '=', 'horas.id_user_cargo')
                     ->join('users', 'users.id', '=', 'cargo_user.user_id')
                     ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
                     ->where('id_user_cargo', $id)->where('fecha', '>=', $inicio)->where('fecha', '<=', $fin)->get();
        // dd($horas);
        if (count($horas) > 0) {

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
            $styleArray1 = [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ],
                
            ];
            $styleArray2 = [
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
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ],
                
            ];
            $styleArray3 = [
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                
            ];
            $styleArray4 = [
                'font' => [
                    'bold' => true,
                    'size' => 8,
                ],
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ],
                
            ];
            $styleArray5 = [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ],
                
            ];
            $styleArray6 = [
                'borders' => [
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE,
                    ],
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    ],
                ],
                
            ];

            //Carga la plantilla para generar el reporte
            $pathTemplate = getcwd() . '\formatos\GTH_F_061_SOLICITUD_DE_AUTORIZACION_DE_HORAS_EXTRAS.xlsx';
            //Selecciona la hoja en la que va a escribir el reporte
            $escritor = IOFactory::load($pathTemplate);
            $worksheet = $escritor->getActiveSheet(0);
            // dd($horas);
            $escritor->getActiveSheet()->setShowGridLines(false);
            $usuario = [];
            $consolidado = [];
            foreach ($horas as $hora) {
                $usuario['nombre_completo'] = $hora->nombres . ' ' . $hora->apellidos;
                $usuario['documento'] = $hora->documento;
                $usuario['cargo'] = $hora->nombre;
                $usuario['centro'] = $hora->centro;
                $usuario['año'] = $hora->created_at;
                $usuario['tipo_hora'] = $hora->tipo_hora;
                $usuario['hora_inicio'] = $hora->hora_inicio;
                $usuario['hora_fin'] = $hora->hora_fin;
                $usuario['justificacion'] = $hora->justificacion;
                $consolidado[] = $usuario;
            }
            
            $año=strftime('%Y',strtotime($consolidado[0]['año']));

            $worksheet->getCell('B7')->setValue($consolidado[0]['nombre_completo']);
            $worksheet->getCell('D7')->setValue($consolidado[0]['documento']);
            $worksheet->getCell('G7')->setValue($consolidado[0]['centro']);
            $worksheet->getCell('I7')->setValue($consolidado[0]['cargo']);
            $worksheet->getCell('M7')->setValue($nombre_mes.' '.$año);

            $index=10;
            // $consolidado
            foreach ($consolidado as $key) {
                // dd(date("Y",strtotime($key['año'])));
                $worksheet->getCell('B'.$index)->setValue($nombre_mes);
                $escritor->getActiveSheet()->getStyle('B' . $index)->applyFromArray($styleArray3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $worksheet->getCell('C'.$index)->setValue(date("Y",strtotime($key['año'])));
                $escritor->getActiveSheet()->getStyle('C' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                if ($key['tipo_hora']==1) {
                    $intervalo =$key['hora_fin']-$key['hora_inicio'];
                    // dd($intervalo);
                    $worksheet->getCell('D'.$index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }elseif ($key['tipo_hora']==2) {
                    $intervalo = $key['hora_fin']-$key['hora_inicio'];
                    $worksheet->getCell('D'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E'.$index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }elseif ($key['tipo_hora']==3) {
                    $intervalo = $key['hora_fin']-$key['hora_inicio'];
                    $worksheet->getCell('D'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F'.$index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }elseif ($key['tipo_hora']==4) {
                    $intervalo = $key['hora_fin']-$key['hora_inicio'];
                    $worksheet->getCell('D'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F'.$index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G'.$index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                $worksheet->getCell('H'.$index)->setValue($key['hora_inicio']);
                $escritor->getActiveSheet()->getStyle('H' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $worksheet->getCell('I'.$index)->setValue($key['hora_fin']);
                $escritor->getActiveSheet()->getStyle('I' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $worksheet->mergeCells('J'.$index.':N'.$index)->getCell('J'.$index)->setValue($key['justificacion']);
                $escritor->getActiveSheet()->getStyle('J'.$index.':N'.$index)->applyFromArray($styleArray2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $index++;

                
            }
            for ($i=0; $i<2 ; $i++) { 
                $worksheet->getCell('B'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('B' . $index)->applyFromArray($styleArray3);
                $worksheet->getCell('C'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('C' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('D'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('E'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('F'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('G'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('H'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('H' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('I'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('I' . $index)->applyFromArray($styleArray);
                $worksheet->mergeCells('J'.$index.':N'.$index)->getCell('J'.$index)->setValue('');
                $escritor->getActiveSheet()->getStyle('J'.$index.':N'.$index)->applyFromArray($styleArray2);

                $index++;
            }
            $worksheet->mergeCells('B'.$index.':N'.$index)->getCell('B'.$index)->setValue('Nota: Como ordenador del pago certifico que existe la disponibilidad presupuestal para pagar el tiempo suplementario aquí autorizado.');
            $escritor->getActiveSheet()->getStyle('B'.$index.':N'.$index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;
            
            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('JEFE INMEDIATO');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('DIRECTOR AREA O REGIONAL/SUBDIRECTOR');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('AUTORIZACIÓN ORDENAR DEL GASTO');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('Firma:');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('Firma');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('Firma');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray6);
            $index++;

            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('Nombres y apellidos completos:');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('Nombres y apellidos completos:');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('Nombres y apellidos completos:');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray6);
            $index++;

            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('Cargo:');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('Cargo:');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('Cargo: Secretaria General  (Solo aplica para Dirección General)');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B'.$index.':E'.$index)->getCell('B'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('B'.$index.':E'.$index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('F'.$index.':H'.$index)->getCell('F'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('F'.$index.':H'.$index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('I'.$index.':N'.$index)->getCell('I'.$index)->setValue('');
            $escritor->getActiveSheet()->getStyle('I'.$index.':N'.$index)->applyFromArray($styleArray6)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $index++;
            
            $file = "GTH_F_061_" . $consolidado[0]['nombre_completo'] . '-' . $nombre_mes . ".xlsx"; //Nombre del archivo

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($escritor, 'Xlsx');

            header('Content-Type: application/application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file . '"');

            $writer->save("php://output"); //Descarga el archivo del reporte

            die;
        }else{
            $msg="No se encontraron horas extras para el mes seleccionado";

            return redirect()->back()->with('actualizado', $msg);
        }

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
