<?php
declare (strict_types=1);

namespace App\Model;

/*Definir con un enum las prioridades permitidas
*/

enum TicketStatus :string {

    case Open = 'open';
    case InProgres = 'in_progres';
    case Closed = 'closed';
    
    /*$this sera la prioridad que se quiere comparar,
    contra el valor constante del enum Self::Urgent*/
    public function isOpen():bool{
        return $this  === Self::Open;
    }
}




?>