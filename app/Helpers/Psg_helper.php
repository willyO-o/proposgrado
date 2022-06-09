<?php
if (!function_exists('fecha_literal')) {
    function fechaLiteral($fecha, $formato = 0)
    {
        $dias = array("Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado");
        $meses = array(1 => "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
        $infofecha = getdate(strtotime($fecha));
        if (empty($fecha)) {
            return ('');
        } else {
            switch ($formato) {
                case 1:
                    return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'];
                    break;
                case 2:
                    return $dias[$infofecha['wday']] . ', ' . ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'];
                    break;
                case 3:
                    return $dias[$infofecha['wday']] . ', ' . ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'] . ' [Hrs. ' . ($infofecha['hours'] < 10 ? '0' : '') . $infofecha['hours'] . ':' . ($infofecha['minutes'] < 10 ? '0' : '') . $infofecha['minutes'] . ']';
                    break;
                case 5:
                    return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . ' de ' . $meses[$infofecha['mon']] . ' de ' . $infofecha['year'] . ' [Hrs. ' . ($infofecha['hours'] < 10 ? '0' : '') . $infofecha['hours'] . ':' . ($infofecha['minutes'] < 10 ? '0' : '') . $infofecha['minutes'] . ']';
                    break;
                case 9:
                    return ($infofecha['mday'] < 10 ? '0' : '') . $infofecha['mday'] . '/' . substr(strtolower($meses[$infofecha['mon']]), 0, 3);
                    break;
                case 10:
                    return $infofecha['year'];
                    break;
                case 20:
                    return $infofecha['mon'];
                    break;
                case 30:
                    return $infofecha['mday'];
                    break;
                default:
                    return date('Y-m-d H:i:s', strtotime($fecha));
                    break;
            }
        }
    }
    function numero_romano($integer, $upcase = true)
    {
        $table = array(
            'M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100,
            'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9,
            'V' => 5, 'IV' => 4, 'I' => 1
        );
        $return = '';
        while ($integer > 0) {
            foreach ($table as $rom => $arb) {
                if ($integer >= $arb) {
                    $integer -= $arb;
                    $return .= ($upcase ? $rom : strtolower($rom));
                    break;
                }
            }
        }
        return $return;
    }
}
