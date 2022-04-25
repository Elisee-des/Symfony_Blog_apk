<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditUsersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "contraints" => [
                    new NotBlank(["Mreci de saisir l'email"])
                ],
                'required' => true,
                'attr' => [
                    'class' => "form-control"
                ]
            ])
            ->add('roles', ChoiceType::class, [
                "choices" => [
                    "Utilisateur" => "ROLE_USER",
                    "Editeur" => "ROLE_EDITOR",
                    "Moderateur" => "ROLE_MODERATEUR",
                    "Administrateur" => "ROLE_ADMIN"
                ],
                "expanded" => true,
                "multiple" => true,
                "label" => "Role"
            ])
            ->add("Valider", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
