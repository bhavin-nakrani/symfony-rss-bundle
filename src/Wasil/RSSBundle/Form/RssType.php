<?php

namespace Wasil\RSSBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RssType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('link')
            ->add('description')
            ->add('author')
            ->add('pubDate')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Wasil\RSSBundle\Entity\Rss'
        ));
    }

    public function getName()
    {
        return 'wasil_rssbundle_rsstype';
    }
}
