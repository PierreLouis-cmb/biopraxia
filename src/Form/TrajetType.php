<?php

namespace App\Form;

use App\Entity\Director;
use App\Entity\LieuTp;
use App\Entity\Trajet;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TrajetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date du trajet',
                'widget' => 'single_text'
            ])
            ->add('user', EntityType::class, [
                'label' => 'Conducteur',
                'placeholder' => 'Choisissez un conducteur',
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getUsername();
                }])
            ->add('lieuTp', EntityType::class, [
                'label' => 'Lieu du tp',
                'placeholder' => 'Choisissez un lieu',
                'class' => LieuTp::class,
                'choice_label' => function(LieuTp $lieuTp) {
                    return $lieuTp->getName();

                },
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')
                    ->orderBy('l.name', 'asc');
                    }
                ])
            ->add('commentaire', null, [
                'label' => 'Commentaire',
                'attr' => ['rows' => 6]
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trajet::class,
        ]);
    }
}
