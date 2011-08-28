<?php

namespace DTL\VoyagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class StageType extends AbstractType
{
    public function getName()
    {
        return 'stage';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('title');
        $builder->add('tour');
        $builder->add('description', 'textarea');
        $builder->add('startDate');
    }
}

