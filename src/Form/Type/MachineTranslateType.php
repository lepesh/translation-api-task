<?php
declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Language;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MachineTranslateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('language', EntityType::class, [
                'class' => Language::class,
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
        ;
    }
}
