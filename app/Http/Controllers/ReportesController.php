<?php

namespace App\Http\Controllers;

// <Modelos>
use App\CargoUser;
use App\Hora;
use App\Solicitud;
use App\Http\Controllers\Controller;
use DateTime;
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
    public function reportes(Request $request)
    {
        $dato = $request->all();
        if (($dato['select_f'] == '') || ($dato['select_mes'] == '') || ($dato['select_año'] == '')) {
            $msg = "Verifique si esta seleccionando un mes, un funcionario y un año";
            return redirect()->back()->with('warning', $msg);
        }
        if (isset($dato['lhe']) && (isset($dato['sa']))) {
            $msg = "Por favor, seleccione solo un tipo de reporte a la vez";
            return redirect()->back()->with('warning', $msg);
        }
        if (!isset($dato['lhe']) && (!isset($dato['sa']))) {
            $msg = "No has seleccionado algun reporte";
            return redirect()->back()->with('warning', $msg);
        }

        if (isset($dato['sa'])) {
            $solicitud = $this->solicitudAutorizacion($dato);
            if ($solicitud == 1) {
                $msg = "No se encontraron solicitudes para el mes seleccionado";
                return redirect()->back()->with('actualizado', $msg);
            }
        }
        if (isset($dato['lhe'])) {
            $legalizacion = $this->legalizacionHoras($dato);
            if ($legalizacion == 1) {
                $msg = "No se encontraron horas extras para el mes seleccionado";
                return redirect()->back()->with('actualizado', $msg);
            }
        }
       
       
    }
    // Reporte de solicitud
    public function solicitudAutorizacion($dato)
    {
        $dato['select_f'] = str_replace('{"id":', '', $dato['select_f']);
        $dato['select_f'] = str_replace('}', '', $dato['select_f']);
        setlocale(LC_ALL, '');
        $id = $dato['select_f'];
        $mes = $dato['select_mes'];
        $año = $dato['select_año'];
        $dateObj   = DateTime::createFromFormat('!m', $mes);
        $nombre_mes = strftime('%B', $dateObj->getTimestamp());
        $solicitudes = Solicitud::join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
            ->join('presupuestos', 'presupuestos.id', '=', 'solicitudes.presupuesto_id')
            ->join('users', 'users.id', '=', 'cargo_user.user_id')
            ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
            ->where('cargo_user_id', $id)->where('presupuestos.mes', '=', $mes)->where('presupuestos.año', '=', $año)
            ->where('solicitudes.autorizacion', '!=', '0')
            ->get();
        // dd($solicitudes);
        if (count($solicitudes) > 0) {

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
            // dd($solicitudes);
            $escritor->getActiveSheet()->setShowGridLines(false);
            $usuario = [];
            $consolidado = [];
            foreach ($solicitudes as $solicitud) {
                $usuario['nombre_completo'] = $solicitud->nombres . ' ' . $solicitud->apellidos;
                $usuario['documento'] = $solicitud->documento;
                $usuario['cargo'] = $solicitud->nombre;
                $usuario['centro'] = $solicitud->centro;
                $usuario['año'] = $solicitud->created_at;
                $usuario['tipo_hora_id'] = $solicitud->tipo_hora_id;
                $usuario['hora_inicio'] = $solicitud->hora_inicio;
                $usuario['total_horas'] = $solicitud->total_horas;
                $usuario['hora_fin'] = $solicitud->hora_fin;
                $usuario['actividades'] = $solicitud->actividades;
                $consolidado[] = $usuario;
            }

            $año = strftime('%Y', strtotime($consolidado[0]['año']));

            $worksheet->getCell('B7')->setValue($consolidado[0]['nombre_completo']);
            $worksheet->getCell('D7')->setValue($consolidado[0]['documento']);
            $worksheet->getCell('G7')->setValue($consolidado[0]['centro']);
            $worksheet->getCell('I7')->setValue($consolidado[0]['cargo']);
            $worksheet->getCell('M7')->setValue($nombre_mes . ' ' . $año);

            $index = 10;
            // $consolidado
            foreach ($consolidado as $key) {
                // dd(date("Y",strtotime($key['año'])));
                $worksheet->getCell('B' . $index)->setValue($nombre_mes);
                $escritor->getActiveSheet()->getStyle('B' . $index)->applyFromArray($styleArray3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $worksheet->getCell('C' . $index)->setValue(date("Y", strtotime($key['año'])));
                $escritor->getActiveSheet()->getStyle('C' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                if ($key['tipo_hora_id'] == 1) {
                    $intervalo = $key['total_horas'];                    // dd($intervalo);
                    $worksheet->getCell('D' . $index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } elseif ($key['tipo_hora_id'] == 2) {
                    $intervalo = $key['total_horas'];
                    $worksheet->getCell('D' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E' . $index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } elseif ($key['tipo_hora_id'] == 3) {
                    $intervalo = $key['total_horas'];
                    $worksheet->getCell('D' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F' . $index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                } elseif ($key['tipo_hora_id'] == 4) {
                    $intervalo = $key['total_horas'];
                    $worksheet->getCell('D' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('E' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F' . $index)->setValue('');
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('G' . $index)->setValue($intervalo);
                    $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                }

                $worksheet->getCell('H' . $index)->setValue($key['hora_inicio']);
                $escritor->getActiveSheet()->getStyle('H' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $worksheet->getCell('I' . $index)->setValue($key['hora_fin']);
                $escritor->getActiveSheet()->getStyle('I' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $worksheet->mergeCells('J' . $index . ':N' . $index)->getCell('J' . $index)->setValue($key['actividades']);
                $escritor->getActiveSheet()->getStyle('J' . $index . ':N' . $index)->applyFromArray($styleArray2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $index++;
            }
            for ($i = 0; $i < 2; $i++) {
                $worksheet->getCell('B' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('B' . $index)->applyFromArray($styleArray3);
                $worksheet->getCell('C' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('C' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('D' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('E' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('E' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('F' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('G' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('G' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('H' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('H' . $index)->applyFromArray($styleArray);
                $worksheet->getCell('I' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('I' . $index)->applyFromArray($styleArray);
                $worksheet->mergeCells('J' . $index . ':N' . $index)->getCell('J' . $index)->setValue('');
                $escritor->getActiveSheet()->getStyle('J' . $index . ':N' . $index)->applyFromArray($styleArray2);

                $index++;
            }
            $worksheet->mergeCells('B' . $index . ':N' . $index)->getCell('B' . $index)->setValue('Nota: Como ordenador del pago certifico que existe la disponibilidad presupuestal para pagar el tiempo suplementario aquí autorizado.');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':N' . $index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('JEFE INMEDIATO');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('DIRECTOR AREA O REGIONAL/SUBDIRECTOR');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('AUTORIZACIÓN ORDENAR DEL GASTO');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER)->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('Firma:');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('Firma');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('Firma');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray6);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('Nombres y apellidos completos:');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('Nombres y apellidos completos:');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('Nombres y apellidos completos:');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray6);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('Cargo:');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('Cargo:');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('Cargo: Secretaria General  (Solo aplica para Dirección General)');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray5)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $index++;

            $worksheet->mergeCells('B' . $index . ':E' . $index)->getCell('B' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('B' . $index . ':E' . $index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('F' . $index . ':H' . $index)->getCell('F' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('F' . $index . ':H' . $index)->applyFromArray($styleArray6);
            $worksheet->mergeCells('I' . $index . ':N' . $index)->getCell('I' . $index)->setValue('');
            $escritor->getActiveSheet()->getStyle('I' . $index . ':N' . $index)->applyFromArray($styleArray6)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            $index++;

            $file = "GTH_F_061_" . $consolidado[0]['nombre_completo'] . '-' . $nombre_mes . "-" . $año . ".xlsx"; //Nombre del archivo

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($escritor, 'Xlsx');

            header('Content-Type: application/application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file . '"');

            $writer->save("php://output"); //Descarga el archivo del reporte
        } else {
            $msg = 1;
            return ($msg);
        }
    }
    // Reporte de legalización
    public function legalizacionHoras($dato)
    {
        $dato['select_f'] = str_replace('{"id":', '', $dato['select_f']);
        $dato['select_f'] = str_replace('}', '', $dato['select_f']);
        setlocale(LC_ALL, '');
        $id = $dato['select_f'];
        $mes = $dato['select_mes'];
        $año = $dato['select_año'];
        $dateObj   = DateTime::createFromFormat('!m', $mes);
        $nombre_mes = strftime('%B', $dateObj->getTimestamp());
        $horas = Hora::join('solicitudes', 'solicitudes.id', '=', 'horas.solicitud_id')
            ->join('cargo_user', 'cargo_user.id', '=', 'solicitudes.cargo_user_id')
            ->join('presupuestos', 'presupuestos.id', '=', 'solicitudes.presupuesto_id')
            ->join('users', 'users.id', '=', 'cargo_user.user_id')
            ->join('cargos', 'cargos.id', '=', 'cargo_user.cargo_id')
            ->where('cargo_user_id', $id)->where('presupuestos.mes', '=', $mes)->where('presupuestos.año', '=', $año)
            ->where('solicitudes.autorizacion', '!=', '0')
            ->orderBy('fecha')
            ->get();
        // dd($solicitudes);
        if (count($horas) > 0) {

            //Estilo del reporte (Bordes de cada celda)
            $styleArray = [
                'font' => [
                    'bold' => false,
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
            //Carga la plantilla para generar el reporte
            $pathTemplate = getcwd() . '\formatos\GTH_F_060__FORMATO_LEGALIZACION_DE_HORAS_EXTRAS_RECARGOS_NOCTURNOS_DOMINICALES.xlsx';
            //Selecciona la hoja en la que va a escribir el reporte
            $escritor = IOFactory::load($pathTemplate);
            $worksheet = $escritor->getActiveSheet(0);
            // dd($solicitudes);
            $escritor->getActiveSheet()->setShowGridLines(false);
            $usuario = [];
            $consolidado = [];
            foreach ($horas as $hora) {
                $usuario['nombre_completo'] = $hora->nombres . ' ' . $hora->apellidos;
                $usuario['documento'] = $hora->documento;
                $usuario['cargo'] = $hora->nombre;
                $usuario['sueldo'] = $hora->sueldo;
                $usuario['centro'] = $hora->centro;
                $usuario['regional'] = $hora->regional;
                $usuario['tipo_hora_id'] = $hora->tipo_hora_id;
                $usuario['hora_inicio'] = $hora->hi_registrada;
                $usuario['total_horas'] = $hora->horas_trabajadas;
                $usuario['hora_fin'] = $hora->hf_registrada;
                $usuario['fecha'] = $hora->fecha;
                $usuario['dia'] = date('d', strtotime($usuario['fecha']));

                $consolidado[] = $usuario;
            }


            $worksheet->getCell('B7')->setValue($consolidado[0]['nombre_completo']);
            $worksheet->getCell('J7')->setValue($consolidado[0]['documento']);
            $worksheet->getCell('Q7')->setValue($consolidado[0]['centro']);
            $worksheet->getCell('B9')->setValue($consolidado[0]['regional']);
            $worksheet->getCell('G9')->setValue($consolidado[0]['cargo']);
            $worksheet->getCell('O9')->setValue($consolidado[0]['sueldo']);
            $worksheet->getCell('T9')->setValue($mes . '/' . $año);

            $index = 13;
            // $consolidado
            foreach ($consolidado as $key) {
                $worksheet->getCell('B' . $index)->setValue($key['dia']);
                $escritor->getActiveSheet()->getStyle('B' . $index)->applyFromArray($styleArray3)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                if ($key['tipo_hora_id'] == 1) {

                    $worksheet->getCell('C' . $index)->setValue($key['hora_inicio']);
                    $escritor->getActiveSheet()->getStyle('C' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('D' . $index)->setValue($key['hora_fin']);
                    $escritor->getActiveSheet()->getStyle('D' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('F' . $index)->setValue($key['total_horas']);
                    $escritor->getActiveSheet()->getStyle('F' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $index++;
                } elseif ($key['tipo_hora_id'] == 2) {
                    $worksheet->getCell('I' . $index)->setValue($key['hora_inicio']);
                    $escritor->getActiveSheet()->getStyle('I' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('J' . $index)->setValue($key['hora_fin']);
                    $escritor->getActiveSheet()->getStyle('J' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('L' . $index)->setValue($key['total_horas']);
                    $escritor->getActiveSheet()->getStyle('L' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $index++;
                } elseif ($key['tipo_hora_id'] == 3) {
                    $worksheet->getCell('O' . $index)->setValue($key['hora_inicio']);
                    $escritor->getActiveSheet()->getStyle('O' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('P' . $index)->setValue($key['hora_fin']);
                    $escritor->getActiveSheet()->getStyle('P' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('R' . $index)->setValue($key['total_horas']);
                    $escritor->getActiveSheet()->getStyle('R' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $index++;
                } elseif ($key['tipo_hora_id'] == 4) {
                    $worksheet->getCell('U' . $index)->setValue($key['hora_inicio']);
                    $escritor->getActiveSheet()->getStyle('U' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('V' . $index)->setValue($key['hora_fin']);
                    $escritor->getActiveSheet()->getStyle('V' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $worksheet->getCell('X' . $index)->setValue($key['total_horas']);
                    $escritor->getActiveSheet()->getStyle('X' . $index)->applyFromArray($styleArray)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                    $index++;
                }
            }
            $index++;
            $file = "GTH_F60_" . $consolidado[0]['nombre_completo'] . '-' . $nombre_mes . "-" . $año . ".xlsx"; //Nombre del archivo
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($escritor, 'Xlsx');
            header('Content-Type: application/application/vnd.ms-excel');
            header('Content-Disposition: attachment; filename="' . $file . '"');
            $writer->save("php://output"); //Descarga el archivo del reporte
        } else {
            $msg = 1;
            return ($msg);
        }
    }
}
