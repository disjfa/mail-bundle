<?php

namespace Disjfa\MailBundle\Form\Type;

use Disjfa\MailBundle\Entity\MailTemplate;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class MailTemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('subject', TextType::class, [
            'label' => 'label.subject',
            'constraints' => new NotBlank(),
        ]);
        $builder->add('content', TextareaType::class, [
            'label' => 'label.content',
            'constraints' => new NotBlank(),
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => MailTemplate::class,
            'translation_domain' => 'disjfa-mail',
        ]);
    }
}
