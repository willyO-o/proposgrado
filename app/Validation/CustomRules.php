<?php

namespace App\Validation;

use DateTime;

class CustomRules
{
   public function fechaPasada(string $str, string &$error = null): bool
   {
      if ($this->fechaCorrecta($str))
         if ($str > date('Y-m-d')) {
            $error = lang('global.fechaPasada', ['field' => $error]);
            return false;
         } else return true;

      else {
         $error = lang('global.fechaInvalida', ['field' => $error]);
         return false;
      }
      return true;
   }
   public function fechaCorrecta(string $str, string &$error = null): bool
   {
      $d = DateTime::createFromFormat('Y-m-d', $str);
      if ($d && $d->format('Y-m-d') != $str) {
         $error = lang('global.fechaInvalida', ['field' => $error]);
         return false;
      }
      return true;
   }
   // function date_valid($date, $fecha_pasada = null)
   // {
   //    // echo $fecha_pasada;
   //    // exit;
   //    $d = DateTime::createFromFormat('Y-m-d', $date);
   //    // comprueba si es un formato de fecha valida
   //    if ($d && $d->format('Y-m-d') === $date) {
   //       if ($fecha_pasada != null) {
   //          switch ($fecha_pasada) {
   //             case 'f_pasada':
   //                if ($this->fecha_mayor_10_anios($date)) {
   //                   $this->form_validation->set_message('date_valid', 'El campo {field} no puede pasar de 10 años');
   //                   return false;
   //                } else {
   //                   return true;
   //                }
   //                return true;
   //                break;
   //             case 'f_nacimiento':
   //                if ($this->fecha_nacimiento($date)) {
   //                   return true;
   //                } else {
   //                   $this->form_validation->set_message('date_valid', '{field}: Ud. debe ser mayor a 18 años');
   //                   return false;
   //                }
   //                break;
   //             case 'f_deposito':
   //                ////caso: para controlar que las fechas de depostio no acepte fechas futuras
   //                if ($this->fecha_pasada($date)) {
   //                   return true;
   //                } else {
   //                   $this->form_validation->set_message('date_valid', 'El campo {field} no acepta fechas futuras');
   //                   return false;
   //                }
   //                break;
   //          }
   //       } else {
   //          if ($this->fecha_pasada($date)) {
   //             $this->form_validation->set_message('date_valid', 'El campo {field} es una fecha pasada');
   //             return false;
   //          } else {
   //             if ($this->fecha_mayor_10_anios($date)) {
   //                $this->form_validation->set_message('date_valid', 'El campo {field} no puede pasar de 10 años');
   //                return false;
   //             }
   //          }
   //          return true;
   //       }
   //       return true;
   //    } else {
   //       $this->form_validation->set_message('date_valid', 'El campo {field} no es una fecha válida' . $date);
   //       return false;
   //    }
   // }
   // public function fecha_pasada($date)
   // {
   //    //comprueba si no es una fecha pasada
   //    if ($date < date('Y-m-d')) {
   //       return true;
   //    } else {
   //       return false;
   //    }
   // }
   // public function fecha_mayor_10_anios($date)
   // {
   //    //comprueba si la fecha no pasa de los 10 años
   //    if ($date > (date('Y-m-d', strtotime(date('Y-m-d') . "+ 10 year")))) {
   //       return true;
   //    } else {
   //       return false;
   //    }
   // }
   // public function fecha_nacimiento($date)
   // {
   //    //comprueba si la fecha de nacimiento es menor a 18 años atras
   //    if ($date <= (date('Y-m-d', strtotime(date('Y-m-d') . "- 18 year")))) {
   //       return true;
   //    } else {
   //       return false;
   //    }
   // }
   // public function fecha_matricula($date)
   // {
   //    //comprueba que la fecha de deposito no pase de 1 año atras
   // }
}
