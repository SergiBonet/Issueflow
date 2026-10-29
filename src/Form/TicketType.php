<?php
declare(strict_types=1);
namespace App\Form;

use App\Entity\Category;
use App\Entity\User;
use App\Form\Model\TicketCreateData;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Describe los campos necesarios para crear un Ticket.
 * El Form Type no guardanada en la base de datos.
 * Solo define como se transforma y prensentan los datos en el formulario
 */

final class TicketType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('code',TextType::class,[ //TexType indica que es un campo de texto en el formulario
                'label'=>'Codigo',//etiqueta del campo de texto
                'attr'=> [
                    'placeholder' => 'INC-1234', //sugerencia de entrada
                    'pattern' => 'INC-[0-9]{4}', //Patron de entrada esperado
                    'maxlength' => 8 //Longitud maxima aceptada
                ]
            ])
            ->add('title',TextType::class,[ //TexType indica que es un campo de texto en el formulario
                'label'=>'Titulo',//etiqueta del campo de texto
                'attr'=> [
                    'maxlength' => 180 //Longitud maxima aceptada
                ]
            ])
            ->add('priority',EnumType::class,[ //EnumType Construye un selector basado en un enum PHP
                'class' => TicketPriority::class, //Indicamos el enum que se va a usar para construir el selector
                'label' => 'Prioridad',
                'choice_label' => static fn (TicketPriority $priority): string => $priority->getLabel()
                
            ])
            ->add('status',EnumType::class,[ //EnumType Construye un selector basado en un enum PHP
                'class' => TicketStatus::class, //Indicamos el enum que se va a usar para construir el selector
                'label' => 'Estado',
                'choice_label' => static fn (TicketStatus $status): string => $status->getLabel()
                
            ])
            ->add('category', EntityType::class,[//EntityType construye un selector basado en una clase PHP, una entidad Doctrine
                'class' => Category::class, //Indicamos aqui la entidad que se va a usar para construir el selector
                'label' => 'Categoria',
                'choice_label' => 'name',//Indicamos el atributo de la entidad que se mostrara en las opciones del selector
                'required' => false,
                'placeholder'=> 'Sin Asignar'
            ])
            ->add('assigne', EntityType::class,[//EntityType construye un selector basado en una clase PHP, una entidad Doctrine
                'class' => User::class, //Indicamos aqui la entidad que se va a usar para construir el selector
                'label' => 'Asignado a ',
                'choice_label' => 'name',//Indicamos el atributo de la entidad que se mostrara en las opciones del selector
                'required' => false,
                'placeholder'=> 'Sin Asignar'
            ])
            ->add('save', SubmitType::class,[//Submmit crea un boton de envio 
                'label'=> 'Crear incidencia',
            ]);
    }

    //Para que Symfony sepa que el objeto de datos esperado es TicketCreateData
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => TicketCreateData::class,
        ]);
    }
}
?>