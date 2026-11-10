<?php
declare(strict_types=1);

namespace App\Form;

use App\Entity\Category;
use App\Form\Model\TicketSearchCriteria;
use App\Model\TicketPriority;
use App\Model\TicketStatus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EnumType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulario GET para filtrar el formulario de tickets
 */
final class TicketFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('query', SearchType::class,[//SearchType  crea un campo de barra de busqueda
                'label'=> 'Buscar',
                'required' => false,
                'attr' =>[
                    'placeholder' => 'Codigo o titulo'
                ]
            ])
            ->add('priority',EnumType::class,[ //EnumType Construye un selector basado en un enum PHP
                'class' => TicketPriority::class, //Indicamos el enum que se va a usar para construir el selector
                'label' => 'Prioridad',
                'choice_label' => 'label',
                'required' => false,
                'placeholder'=> 'Todas'
            ])
            ->add('status',EnumType::class,[ //EnumType Construye un selector basado en un enum PHP
                'class' => TicketStatus::class, //Indicamos el enum que se va a usar para construir el selector
                'label' => 'Estado',
                'choice_label' => 'label',
                'required' => false,
                'placeholder'=> 'Todos'
            ])
            ->add('category',EntityType::class,[
                'class' => Category::class, //Indicamos el enum que se va a usar para construir el selector
                'label' => 'Categoria',
                'choice_label' => 'name',
                'required' => false,
                'placeholder'=> 'Todas'
            ])
            ->add('filter',SubmitType::class,[
                'label'=> 'Filtrar'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
         $resolver->setDefaults([
            'data_class' => TicketSearchCriteria::class,
            'method'=>'GET',
            'csrf_protection'=> false
        ]);
    }
}




?>