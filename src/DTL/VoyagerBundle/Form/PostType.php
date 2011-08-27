<?php

namespace DTL\VoyagerBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class PostType extends AbstractType
{
    public function getName()
    {
        return 'post';
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder->add('date');
        $builder->add('title');
        $builder->add('content', 'textarea');
    }
}

