<?php
declare(strict_types=1);

namespace App\Form\Type;

use App\Entity\Language;
use App\Entity\Translation;
use App\Entity\TranslationKey;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('translationKey', EntityType::class, [
                'class' => TranslationKey::class
            ])
            ->add('language', EntityType::class, [
                'class' => Language::class
            ])
            ->add('value', TextType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Translation::class,
        ]);
    }
}
