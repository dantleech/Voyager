<?php

namespace DTL\VoyagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class TourType extends AbstractType
{
    public function getName()
    {
        return 'tour';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('description', 'textarea');
    }
}

