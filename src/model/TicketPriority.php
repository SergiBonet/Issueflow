<?php
declare (strict_types=1);

namespace App\Model;

/*Definir con un enum las prioridades permitidas
*/

enum TicketPriority :string {

    case Urgent = 'urgent';
    case High = 'high';
    case Normal = 'normal';
    case Low = 'low';
    
    public function getLabel():string{
        return match($this){
            self::Urgent => 'Urgente',
            self::High => 'Alta',
            self::Normal => 'Normal',
            self::Low => 'Baja',

        };
    }
    /*$this sera la prioridad que se quiere comparar,
    contra el valor constante del enum Self::Urgent*/
    public function isUrgent():bool{
        return $this  === Self::Urgent;
    }
}




?>