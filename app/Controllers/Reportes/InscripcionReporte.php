<?php

namespace App\Controllers\Reportes;

use FPDF;

class InscripcionReporte extends FPDF
{
    public function formularioInscripcion($doc)
    {
        $this->AddPage('P', 'Letter');
        // $this->AddFont('Rubik', '', 'Rubik-Regular.php');
        // $this->AddFont('RubikB', '', 'Rubik-Medium.php');
        $this->SetMargins(30, 20, 20);
        $this->SetFillColor(255, 250, 142);
        $this->Image(FCPATH . "/imagenes/membrete.jpg", 0, 0, 216, 279);
        // $this->Image('https://chart.googleapis.com/chart?chs=100x100&cht=qr&chl=' . str_replace(' ', '_', ($doc['id_inscripcion_online'] . '/' . $doc['id_publicacion'] . '/' . $doc['ci'] . $doc['expedido'] . '/' . $doc['paterno'] . '/' . $doc['nombre'] . '.png')), 180, 230, 20);
        $this->Image('http://localhost/gen_qr/qr_generator.php?code=' . str_replace(' ', '_', ($doc['id_inscripcion_online'] . '/' . $doc['id_publicacion'] . '/' . $doc['ci'] . $doc['expedido'] . '/' . $doc['paterno'] . '/' . $doc['nombre'] . '&.png')), 180, 230, 20);
        // $this->Image('http://barcode.tec-it.com/barcode.ashx?data=' . ($doc['id_inscripcion_online'] . '/' . $doc['id_publicacion'] . '/' . $doc['ci'] . $doc['expedido']) . '&code=Code128&dpi=96&dataseparator=', 120, 235, 50, 0, 'GIF');

        $this->SetFont('Arial', '', 18);
        $this->Cell(0, 8, utf8_decode('DIRECCIÓN DE POSGRADO'), '', 1, 'R');
        $this->Cell(0, 8, 'CEFORPI - UPEA', '', 1, 'R');
        $this->Ln();
        $this->SetFont('Arial', '', 24);
        $this->Cell(0, 8, 'FORMULARIO DE', ', 1', 1, 'R');
        $this->Cell(0, 8, utf8_decode('INSCRIPCIÓN'), ', 1', 1, 'R');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 8, 'Fecha de Registro: ' . utf8_decode(fechaLiteral($doc['fecha_registro'], 2)), ', 1', 1, 'R');
        $this->SetFont('Arial', '', 14);
        $this->Cell(0, 8, 'DATOS DEL PROGRAMA', '', 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(36, 8, utf8_decode('DENOMINACIÓN: '), '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 8, utf8_decode($doc['grado_academico'] . ' EN ' . $doc['nombre_programa']), '', 'L', TRUE);
        $this->Ln(1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 8, 'MODALIDAD: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(30, 8, utf8_decode($doc['modalidad']), '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(23, 8, utf8_decode('VERSIÓN: '), '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(17, 8, $doc['numero_version'], '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(18, 8, 'SEDE: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(48, 8, utf8_decode($doc['sede']), '', 1, 'L', TRUE);
        $this->Ln(4);
        $this->SetFont('Arial', '', 14);
        $this->Cell(0, 8, 'DATOS PERSONALES', '', 1, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 8, 'NOMBRES Y APELLIDOS: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 8, utf8_decode($doc['nombre'] . ' ' . $doc['paterno'] . ' ' . $doc['materno']), '', 'L', TRUE);
        $this->Ln(1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 8, 'FECHA DE NACIMIENTO: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(48, 8, utf8_decode(fechaLiteral($doc['fecha_nacimiento'], 1)), '', 0, 'L', TRUE);
        // $this->SetFont('Arial', '', 10);
        // $this->Cell(20, 8, 'LUGAR: ', '', 0, 'L', TRUE);
        // $this->SetFont('Arial', '', 10);
        // $this->Cell(53, 8, $doc['lugar_nacimiento'], '', 1, 'L', TRUE);
        $this->Ln(1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 8, utf8_decode('TELÉFONO CELULAR: '), '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(38, 8, $doc['celular'], '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(18, 8, 'EMAIL: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->Cell(65, 8, utf8_decode($doc['correo']), '', 1, 'L', TRUE);
        $this->Ln(1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 8, 'OFICIO DE TRABAJO: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 8, utf8_decode($doc['oficio_trabajo']), '', 'L', TRUE);
        $this->Ln(1);
        // $this->SetFont('Arial', '', 10);
        // $this->Cell(45, 8, 'CIUDAD DONDE VIVE: ', '', 0, 'L', TRUE);
        // $this->SetFont('Arial', '', 10);
        // $this->MultiCell(0, 8, $doc['ciudad_donde_vive'], '', 'L', TRUE);
        // $this->Ln(1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(45, 8, 'DOMICILIO ACTUAL: ', '', 0, 'L', TRUE);
        $this->SetFont('Arial', '', 10);
        $this->MultiCell(0, 8, utf8_decode($doc['domicilio']), '', 'L', TRUE);
        $this->Ln(4);
        $this->SetFont('Arial', '', 14);
        $this->SetFont('Arial', '', 10);
        foreach ($doc['pagos'] as $key => $value) {
            $this->Cell(0, 8, utf8_decode($key), '', 1, 'L');
            foreach ($value as $k => $v) {
                $this->Cell(40, 8, utf8_decode('NRO. DE DEPÓSITO: '), '', 0, 'L', TRUE);
                $this->Cell(33, 8, $v['numero_deposito'], '', 0, 'L', TRUE);
                $this->Cell(40, 8, utf8_decode('FECHA DE DEPÓSITO: '), '', 0, 'L', TRUE);
                $this->Cell(53, 8, utf8_decode(fechaLiteral($v['fecha_deposito'], 1)), '', 1, 'L', TRUE);
                $this->Cell(40, 8, utf8_decode('MONTO DEPOSITO: '), '', 0, 'L', TRUE);
                $this->Cell(53, 8, $v['monto_deposito'], '', 1, 'L', TRUE);
                $this->Ln(4);
            }
        }

        $this->Ln(4);
        $this->SetFont('Arial', '', 7);
        $this->Cell(0, 8, utf8_decode('Este formulario, junto a toda la documentación correspondiente, deben presentarse al término de la emergencia sanitaria actual.'), '', 1, 'L');
        $this->SetFont('Arial', '', 9);
        $this->SetXY(30, 235);
        $this->Cell(0, 4, utf8_decode($doc['nombre'] . ' ' . $doc['paterno'] . ' ' . $doc['materno']), '', 1, 'L');
        $this->Cell(0, 4, utf8_decode($doc['ci'] . ' ' . $doc['expedido']), '', 1, 'L');
        return $this->Output('S');
    }

    public function formulario02($doc)
    {
        $this->AddPage('P', 'Legal');
        $this->SetMargins(20, 20, 20);
        // $this->Image(APPPATH . '../public_html/img/marca_agua.jpg', 0, 0, 216, 360, 'jpg');
        $this->Image(APPPATH . '../public_html/img/upea.png', 20, 7, 20, 21);
        $this->Image(APPPATH . '../public_html/img/posgrado.png', 170, 10, 30, 11, 'png', '');
        $this->AddFont('EdwardianScriptITC', 'I', 'EdwardianScriptITC.php');
        $this->AddFont('helvetica', 'I', 'helvetica.php');
        $this->AddFont('FrankfurterPlain', 'B', 'FrankfurterPlain.php');
        $this->AddFont('Elephant', '', 'Elephant.php');
        $this->AliasNbPages();
        // $this->SetTextColor(20, 55, 175);
        // $this->SetDrawColor(20, 55, 200);
        $this->SetFont('EdwardianScriptITC', 'I', 20);
        $this->Cell(0, 0, utf8_decode('Universidad Pública de El Alto'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('FrankfurterPlain', 'B', 10);
        $this->Cell(0, 0, 'VICERRECTORADO', 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('helvetica', 'B', 9);
        $this->Cell(0, 0, utf8_decode('CENTRO DE ESTUDIOS V FORMACIÓN DE POSGRADO E INVESTIGACIÓN'), 0, 1, 'C');
        $this->Ln(5);
        $this->SetFont('Elephant', '', 9);
        $this->Cell(0, 0, utf8_decode('DATOS PERSONALES DE MATRICULACIÓN POSTGRADUAL'), 0, 1, 'C');
        $this->Ln(4);
        $this->Cell(0, 0, '________________________________________________________________________________________________________________________', 0, 1, 'C');
        $this->SetFont('helvetica', 'B', 10);
        $this->Ln(7);
        $this->Cell(0, 0, 'A. DATOS PERSONALES', 0, 1);
        $this->Ln(3);
        $alto = 39;
        $altoRectangulo = 4;
        $this->SetFont('helvetica', 'B', 9);
        /**Inicio 1 */
        $this->Text(30, $alto += 4, 'APELLIDO PATERNO');
        $this->Text(105, $alto, 'APELLIDO MATERNO');
        $this->RoundedRect(170, $alto, 25, 25, 5, '');

        $this->Rect(20, $alto += 1, 60, $altoRectangulo);
        $this->Rect(92, $alto, 60, $altoRectangulo);

        $this->SetFont('helvetica', '', 9);
        $this->Text(21, $alto += 3, $doc['paterno']);
        $this->Text(93, $alto, $doc['materno']);
        /**Fin 1 */
        /**Inicio 2 */
        $this->SetFont('helvetica', 'B', 9);
        $this->Text(45, $alto += 5, 'NOMBRE (S)');
        $this->Text(100, $alto, utf8_decode('Nº DE CÉDULA DE IDENTIDAD'));
        $this->Text(158, $alto, 'EXP');

        $this->Rect(15, $alto += 1, 80, $altoRectangulo);
        $this->Rect(100, $alto, 46, $altoRectangulo);
        $this->Rect(156, $alto, 10, $altoRectangulo);

        $this->SetFont('helvetica', '', 9);
        $this->Text(16, $alto += 3, $doc['nombre']);
        $this->Text(101, $alto, $doc['ci']);
        $this->Text(157, $alto, $doc['expedido']);
        /**Fin 2 */
        /**Inicio 3 */
        $this->Rect(37, $alto += 3, 30, $altoRectangulo);
        $this->Rect(85, $alto, 81, $altoRectangulo);

        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, 'FECHA NAC.:');
        $this->Text(72, $alto, 'LUGAR:');
        $this->SetFont('helvetica', '', 9);
        $this->Text(38, $alto, $doc['fecha_nacimiento']);
        $this->Text(86, $alto, $doc['lugar_nacimiento']);
        /**Fin 3 */
        /**Inicio 4 */
        $this->Rect(37, $alto += 3, 129, $altoRectangulo);
        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, 'DOMICILIO:');
        $this->SetFont('helvetica', '', 9);
        $this->Text(38, $alto, utf8_decode($doc['domicilio']));
        /**Fin 4 */
        /**Inicio 5 */
        $this->Rect(37, $alto += 3, 30, $altoRectangulo);
        $this->Rect(90, $alto, 30, $altoRectangulo);
        $this->Rect(162, $alto, 4, $altoRectangulo);

        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, utf8_decode('TELÉFONO:'));
        $this->Text(72, $alto, 'CELULAR:');
        $this->Text(150, $alto, 'SEXO:');
        $this->SetFont('helvetica', '', 9);
        $this->Text(38, $alto, $doc['telefono']);
        $this->Text(91, $alto, $doc['celular']);
        $this->Text(163, $alto, $doc['genero']);
        /**Fin 5 */
        /**Inicio 6 */
        $this->Rect(37, $alto += 3, 129, $altoRectangulo);
        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, 'E-Mail:');
        $this->SetFont('helvetica', '', 9);
        $this->Text(38, $alto, $doc['email']);
        /**Fin 6 */
        /**Inicio 7 */
        $this->Rect(42, $alto += 3, 30, $altoRectangulo);
        $this->Rect(125, $alto, 41, $altoRectangulo);

        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, 'NACIONALIDAD:');
        $this->Text(100, $alto, 'ESTADO CIVIL:');
        $this->SetFont('helvetica', '', 9);
        $this->Text(43, $alto, $doc['nombre_pais']);
        $this->Text(126, $alto, utf8_decode($doc['estado_civil']));
        /**Fin 7 */
        $this->RoundedRect(10, 40, 195, $alto - 38, 5, '1234');

        /**---Inicio Seccion 2---*/
        $this->Ln(60);
        $this->SetFont('helvetica', 'B', 10);
        $this->Text(20, $alto += 10, utf8_decode('B. DATOS DE MATRICULACIÓN'));
        $this->RoundedRect(10, $alto += 3, 195, 18, 5, '1234');
        /**Inicio 1*/
        $this->Rect(37, $alto += 3, 20, $altoRectangulo);
        $this->Rect(100, $alto, 30, $altoRectangulo);
        $this->Rect(162, $alto, 35, $altoRectangulo);

        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, utf8_decode('Gestión:'));
        $this->Text(62, $alto, utf8_decode('Fecha de Matriculación:'));
        $this->Text(150, $alto, 'Grado:');
        $this->SetFont('helvetica', '', 9);
        $this->Text(37, $alto, '2020');
        $this->Text(101, $alto, '04-01-2020');
        $this->Text(163, $alto, utf8_decode($doc['descripcion_grado_academico']));
        /**Fin 1*/
        /**Inicio 2*/
        $this->Rect(37, $alto += 3, 160, $altoRectangulo);
        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, 'Programa:');
        $this->SetFont('helvetica', '', 7);
        $this->Text(38, $alto, utf8_decode($doc['nombre_programa']));
        /**Fin 2*/
        /**---Fin Seccion 2---*/

        /**---Inicio Seccion 3---*/
        $this->Ln(60);
        $this->SetFont('helvetica', 'B', 10);
        $this->Text(20, $alto += 12, utf8_decode('C. DATOS DE FORMACIÓN ACADÉMICA (PREGRADO)'));
        /**Inicio 1*/
        if (!empty($doc['pregrado']))
            foreach ($doc['pregrado'] as $key => $value) {

                $this->SetFont('helvetica', 'B', 9);
                $this->Text(60, $alto += 5, 'UNIVERSIDAD');
                $this->Text(145, $alto, utf8_decode('MODALIDAD DE TITULACIÓN'));

                $this->Rect(15, $alto += 1, 120, $altoRectangulo);
                $this->Rect(140, $alto, 58, $altoRectangulo);

                $this->SetFont('helvetica', '', 9);
                $this->Text(15, $alto += 3, utf8_decode($value['nombre_unidad_academica']));
                $this->Text(140, $alto, utf8_decode($value['nombre_modalidad_titulacion']));

                /**Fin 1*/
                /**Inicio 2*/
                $this->Rect(50, $alto += 3, 20, $altoRectangulo);
                $this->Rect(134, $alto, 64, $altoRectangulo);

                $this->SetFont('helvetica', 'B', 9);
                $this->Text(15, $alto += 3, utf8_decode('AÑO DE TITULACIÓN:'));
                $this->Text(92, $alto, utf8_decode('Nº DIPLOMA ACADÉMICO:'));
                $this->SetFont('helvetica', '', 9);
                $this->Text(50, $alto, $value['fecha_emision']);
                $this->Text(134, $alto, $value['numero_titulo']);
            }
        else {
            $this->RoundedRect(10, $alto += 3, 195, 34, 5, '1234');
            /**Inicio 1 */
            $this->Text(22, $alto += 7, utf8_decode('UNIVERSIDAD'));
            $this->Text(87, $alto, utf8_decode('MODALIDAD DE TITULACIÓN'));
            $this->Text(180, $alto, utf8_decode('AÑO'));
            $this->Rect(172, $alto + 1, 26, $altoRectangulo);
            $this->Text(168, $alto + 10, utf8_decode('AÑO DE TITULACIÓN'));
            $this->Rect(172, $alto + 11, 26, $altoRectangulo);
            $this->Text(174, $alto + 20, utf8_decode('Nº DIP. ACAD.'));
            $this->Rect(172, $alto + 21, 26, $altoRectangulo);
            /**Fin 1 */
            $this->SetFont('helvetica', 'B', 8);
            foreach ([['UNIVERSIDAD ESTATAL', 'TESIS', 'TRABAJO DIRIGIDO'], ['UNIVERSIDAD PRIVADA', 'EXAMEN DE GRADO', 'PROYECTO DE GRADO'], ['', 'INTERNADO ROTATORIO', 'PETAE'], ['', '', 'OTRA MODALIDAD']] as $key => $value) {
                /**Inicio 2 */
                if (!empty($value[0])) {
                    $this->Rect(13, $alto += 2.5, 5, $altoRectangulo);
                } else $alto += 2.5;

                if (!empty($value[1])) $this->Rect(70, $alto, 5, $altoRectangulo);
                if (!empty($value[2])) $this->Rect(120, $alto, 5, $altoRectangulo);

                if (!empty($value[0])) {
                    $this->Text(19, $alto += 2.7, utf8_decode($value[0]));
                } else $alto += 2.7;
                $this->Text(76, $alto, utf8_decode($value[1]));
                $this->Text(126, $alto, utf8_decode($value[2]));
                /**Fin 2 */
            }
        }
        /**Fin 2*/

        /**---Fin Seccion 3---*/

        /**---Inicio Seccion 4---*/
        $this->Ln(60);
        $this->SetFont('helvetica', 'B', 10);
        $this->Text(20, $alto += 12, utf8_decode('D. DATOS DEL PROGRAMA QUE CURSA'));
        $this->RoundedRect(10, $alto += 3, 195, 22, 5, '1234');
        /**Inicio 1*/
        $this->SetFont('helvetica', 'B', 9);
        $this->Rect(71, $alto += 3, 129, $altoRectangulo);
        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, 'NOMBRE DEL CURSO/PROGRAMA:');
        $this->SetFont('helvetica', '', 7);
        $this->Text(72, $alto, utf8_decode($doc['nombre_programa']));
        /**Fin 1*/
        /**Inicio 2*/
        $this->SetFont('helvetica', 'B', 9);
        $this->Rect(86, $alto += 3, 114, $altoRectangulo);
        $this->Text(15, $alto += 3, utf8_decode('UNIDAD ACADÉMICA QUE DICTA EL CURSO:'));
        $this->SetFont('helvetica', '', 9);
        $this->Text(87, $alto, utf8_decode($doc['nombre_unidad']));
        /**Fin 2*/
        /**Inicio 3*/
        $this->Rect(80, $alto += 3, 120, $altoRectangulo);
        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, utf8_decode('DEPENDIENTE DE LA FACULTAD / ÁREA:'));
        $this->SetFont('helvetica', '', 9);
        $this->Text(81, $alto, utf8_decode($doc['sede']));
        /**Fin 3*/
        /**---Fin Seccion 4---*/

        /**---Inicio Seccion 5---*/
        $this->Ln(60);
        $this->SetFont('helvetica', 'B', 10);
        $this->Text(20, $alto += 12, utf8_decode('E. DATOS DE OTROS ESTUDIOS POSTGRADUALES'));
        // $this->RoundedRect(10, $alto += 3, 195, 22, 5, '1234');
        /**Inicio 1*/
        if (!empty($doc['postgrado']))
            foreach ($doc['postgrado'] as $key => $value) {
                $this->SetFont('helvetica', 'B', 9);
                $this->Text(45, $alto += 5, '');
                $this->Text(100, $alto, utf8_decode('UNIDAD ACADÉMICA'));
                $this->Text(191, $alto, utf8_decode('AÑO'));

                $this->Rect(15, $alto += 1, 80, $altoRectangulo);
                $this->Rect(100, $alto, 80, $altoRectangulo);
                $this->Rect(190, $alto, 10, $altoRectangulo);

                $this->SetFont('helvetica', '', 9);
                $this->Text(16, $alto += 3, utf8_decode($value['descripcion_grado_academico']));
                $this->Text(101, $alto, utf8_decode($value['nombre_unidad_academica']));
                $this->Text(191, $alto, strftime('%Y', strtotime($value['fecha_emision'])));
            }
        else {
            $this->RoundedRect(10, $alto += 3, 195, 46, 5, '1234');
            /**Inicio 1*/
            $this->SetFont('helvetica', 'B', 9);
            $this->Text(15, $alto += 6, 'NOMBRE DEL CURSO');
            /**Fin 1*/
            foreach (['DIPLOMADO' => 4, 'ESPECIALIDAD' => 8, 'MAESTRÍA' => 8, 'DOCTORADO' => 8] as $key => $value) {
                /**Inicio 2 */
                $this->Text(46, $alto += $value, utf8_decode($key));
                $this->Text(137, $alto, utf8_decode('UNIDAD ACADÉMICA'));
                $this->Text(193, $alto, utf8_decode('AÑOS'));

                $this->Rect(13, $alto += 1, 100, $altoRectangulo);
                $this->Rect(117, $alto, 73, $altoRectangulo);
                $this->Rect(195, $alto, 6, $altoRectangulo);
                /**Fin 2 */
            }
        }


        /**Fin 1*/
        /**---Fin Seccion 5---*/

        /**---Inicio Seccion 6---*/
        $this->Ln(60);
        $this->SetFont('helvetica', 'B', 10);
        $this->Text(20, $alto += 14, utf8_decode('F. DATOS DE CONOCIMIENTO DE IDIOMAS'));
        // $this->RoundedRect(10, $alto += 3, 195, 22, 5, '1234');
        /**Inicio 1*/
        if (!empty($doc['idioma'])) {
        } else {
            $this->RoundedRect(10, $alto += 3, 195, 20, 5, '1234');
            $this->SetFont('helvetica', 'B', 8);
            foreach ([['LENGUA NATIVA:', 'Aymara', 'Quechua', 'Guarani'], ['LENGUA EXTRANJERA:', 'Ingles', 'Francés', 'Alemán']] as $key => $value) {
                /**Inicio 2 */
                $alto += 2.5;
                $this->Rect(70, $alto, 5, $altoRectangulo);
                $this->Rect(120, $alto, 5, $altoRectangulo);
                $this->Rect(170, $alto, 5, $altoRectangulo);

                $this->Text(19, $alto += 2.7, utf8_decode($value[0]));
                $this->Text(76, $alto, utf8_decode($value[1]));
                $this->Text(126, $alto, utf8_decode($value[2]));
                $this->Text(176, $alto, utf8_decode($value[3]));
                /**Fin 2 */
            }
            $this->Text(136, $alto += 8, utf8_decode('OTROS:.................................................................'));
        }
        /**---Fin Seccion 6---*/

        /**---Inicio Seccion 7---*/
        $this->Ln(60);
        $this->SetFont('helvetica', 'B', 10);
        $this->Text(20, $alto += 10, utf8_decode('G. DATOS DE DÉPOSITO BANCARIO'));
        $this->RoundedRect(10, $alto += 3, 195, 16, 5, '1234');
        /**Inicio 1*/
        $this->Rect(44, $alto += 3, 30, $altoRectangulo);
        $this->Rect(111, $alto, 22, $altoRectangulo);
        $this->Rect(176, $alto, 25, $altoRectangulo);

        $this->SetFont('helvetica', 'B', 9);
        $this->Text(15, $alto += 3, utf8_decode('Nº Comprobante:'));
        $this->Text(80, $alto, utf8_decode('Fecha de Déposito:'));
        $this->Text(140, $alto, utf8_decode('Monto Depositado Bs.-'));
        $this->SetFont('helvetica', '', 9);
        $this->Text(45, $alto, '23423');
        $this->Text(112, $alto, '01/04/2020');
        $this->Text(177, $alto, '200');
        /**Fin 1*/
        /**---Fin Seccion 7---*/
        // $this->Text($this->w / 2, $alto += 16, );
        $this->Ln($alto - 385);
        $this->Cell(0, 0, 'El Alto, ' . date('d M Y'), 0, 0, 'C');
        $this->Ln(12);
        $this->Cell(0, 0, '....................................................................................', 0, 0, 'C');
        $this->Ln(5);
        $this->Cell(0, 0, 'FIRMA DEL POSTULANTE', 0, 0, 'C');
        return $this->Output('S');
    }
    function Footer()
    {
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial', 'I', 6);
        // Número de página
        $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->AliasNbPages();
    }
    public function cartaCompromisoInscripcion($doc)
    {
        $referencia = utf8_decode('Ref.: COMPROMISO Y CUMPLIMIENTO DE LAS ACTIVIDADES ACADÉMICAS Y PAGOS DE COLEGIATURA.');
        // $this->AddFont('Rubik', '', 'Rubik-Regular.php');
        // $this->AddFont('RubikB', '', 'Rubik-Medium.php');
        $this->SetMargins(30, 30, 30);
        $this->AddPage('P', 'Letter');
        $this->Image(FCPATH . 'imagenes/solicitud.jpg', 0, 0, 216, 279);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'El Alto, ' . fechaLiteral($doc['fecha_registro'], 1), 0, 1, 'R');
        $this->Cell(0, 8, utf8_decode('Señor:'), 0, 1, 'L');
        $this->Cell(0, 8, 'Dr. Richard Jorge Torrez Juaniquina Ph. D.', 0, 1, 'L');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 8, 'DIRECTOR DE POSGRADO - UPEA', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'Presente.-', 0, 1, 'L');
        $this->Ln(16);
        $this->SetFont('Arial', 'BU', 12);
        // $this->Cell(0,10, $referencia, 0, 1,'R');
        $this->SetX(60);
        $this->MultiCell(0, 7, $referencia, 0, 'R');
        // strlen($referencia) >= 69 ? $this->Cut_String($referencia, 45, 'R', 0) : $this->Cell(0, 10, $referencia, 0, 1, 'R');
        $this->SetFont('Arial', '', 12);
        $this->Ln(+16);
        $this->Cell(0, 8, 'Distinguido Director:', 0, 1, 'L');
        $this->Ln(5);
        $this->MultiCell(0, 8, utf8_decode('A tiempo de saludarle, me dirijo a su autoridad para hacer conocer que mi persona ' . $doc['nombre'] . ' ' . $doc['paterno'] . ' ' . $doc['materno'] . ' con Carnet de Identidad ' . $doc['ci'] . ' ' . $doc['expedido'] . ' se compromete a CUMPLIR CON LAS ACTIVIDADES ACADÉMICAS Y PAGOS DE COLEGIATURA, según establece la convocatoria de la presente gestión para el programa: "' . $doc['grado_academico'] . ' EN ' . $doc['nombre_programa'] . ' - VERSIÓN ' . $doc['numero_version'] . '".'), '', 'J');
        $this->Ln(5);
        $this->Cell(0, 8, utf8_decode('Sin otro particular me despido con las consideraciones más distinguidas.'), 0, 1, 'L');
        $this->Ln(5);
        $this->Cell(156, 8, 'Atentamente,', 0, 1, 'L');
        $this->Ln(20);
        $this->SetX(30);
        $y = $this->GetY();
        // $y += 20;
        $lengthString = $this->GetStringWidth(utf8_decode($doc['nombre'] . ' ' . $doc['paterno'] . ' ' . $doc['materno']));
        $x1 = 105 - ($lengthString / 2);
        $x2 = $x1 + $lengthString + 3;
        $this->Line($x1, $y, $x2, $y);
        $this->Cell(0, 8, utf8_decode($doc['nombre'] . ' ' . $doc['paterno'] . ' ' . $doc['materno']), 0, 1, 'C');
        $this->Cell(0, 4, trim($doc['ci'] . ' ' . $doc['expedido']), 0, 1, 'C');
        return $this->Output('S');
    }
    public function solicitudInscripcion($doc)
    {
        $referencia = utf8_decode('Ref.: SOLICITUD DE INSCRIPCIÓN AL PROGRAMA "' . $doc['nombre_programa'] . ' - VERSIÓN ' . $doc['numero_version'] . '"');
        // $this->AddFont('Rubik', '', 'Rubik-Regular.php');
        // $this->AddFont('RubikB', '', 'Rubik-Medium.php');
        $this->SetMargins(30, 30, 30);
        $this->AddPage('P', 'Letter');
        $this->Image(FCPATH . 'imagenes/solicitud.jpg', 0, 0, 216, 279);
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'El Alto, ' . fechaLiteral($doc['fecha_registro'], 1), 0, 1, 'R');
        $this->Cell(0, 8, utf8_decode('Señor:'), 0, 1, 'L');
        $this->Cell(0, 8, 'Dr. Richard Jorge Torrez Juaniquina Ph. D.', 0, 1, 'L');
        $this->SetFont('Arial', '', 11);
        $this->Cell(0, 8, 'DIRECTOR DE POSGRADO - UPEA', 0, 1, 'L');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'Presente.-', 0, 1, 'L');
        $this->Ln(16);
        $this->SetFont('Arial', 'U', 12);
        strlen($referencia) >= 69 ? $this->Cut_String($referencia, 45, 'R', 0) : $this->Cell(0, 10, $referencia, 0, 1, 'R');
        $this->SetFont('Arial', '', 12);
        $this->Ln(16);
        $this->Cell(0, 8, 'Distinguido Director:', 0, 1, 'L');
        $this->Ln(5);
        $this->MultiCell(0, 8, utf8_decode('Me es grato hacerle llegar un saludo cordial y fraterno a nombre mío, deseándole mis mejores deseos de éxitos en las labores que desempeña.'), '', 'FJ');
        $this->Ln(5);
        $this->MultiCell(0, 8, utf8_decode('El motivo de la presente es para solicitar a su autoridad la INSCRIPCIÓN AL PROGRAMA: ' . $doc['grado_academico'] . ' EN ' . $doc['nombre_programa'] . ' - VERSIÓN ' . $doc['numero_version'] . '.'), '', 'J');
        $this->Ln(5);
        $this->Cell(0, 8, utf8_decode('Sin otro particular me despido con las consideraciones más distinguidas.'), 0, 1, 'L');
        $this->Ln(5);
        $this->Cell(156, 8, 'Atentamente,', 0, 1, 'L');
        $this->Ln(20);
        $this->Cell(30, 8, '', 0, 0);
        $this->Cell(100, 8, utf8_decode($doc['nombre'] . ' ' . $doc['paterno'] . ' ' . $doc['materno']), 'T', 1, 'C');
        $this->Cell(0, 4, $doc['ci'] . ' ' . $doc['expedido'], 0, 1, 'C');
        return $this->Output('S');
    }
    function Cut_String($string, $corte, $direction, $width)
    {
        while (strlen($string) > $corte) {
            switch (substr(substr($string, 0, $corte), -1)) {
                case ' ':
                    $this->Cell($width);
                    $this->Cell(0, 5, (substr($string, 0, $corte)), 0, 1, $direction);
                    $string = substr($string, $corte);
                    break;
                default:
                    $corte++;
                    break;
            }
        }
        $this->Cell($width);
        $this->Cell(0, 5, (substr($string, 0, $corte)), 0, 1, $direction);
    }
    function RoundedRect($x, $y, $w, $h, $r, $corners = '1234', $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));

        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        if (strpos($corners, '2') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $y) * $k));
        else
            $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);

        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '3') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);

        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        if (strpos($corners, '4') === false)
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - ($y + $h)) * $k));
        else
            $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);

        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $yc) * $k));
        if (strpos($corners, '1') === false) {
            $this->_out(sprintf('%.2F %.2F l', ($x) * $k, ($hp - $y) * $k));
            $this->_out(sprintf('%.2F %.2F l', ($x + $r) * $k, ($hp - $y) * $k));
        } else
            $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c ',
            $x1 * $this->k,
            ($h - $y1) * $this->k,
            $x2 * $this->k,
            ($h - $y2) * $this->k,
            $x3 * $this->k,
            ($h - $y3) * $this->k
        ));
    }
}
