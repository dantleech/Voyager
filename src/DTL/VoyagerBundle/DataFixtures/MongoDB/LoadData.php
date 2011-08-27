<?php

namespace DTL\VoyagerBundle\DataFixtures\ODM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use DTL\VoyagerBundle\Document\Post;

class LoadData implements FixtureInterface
{
    public function load($manager)
    {
        $date = new \DateTime();
        $day = new \DateInterval('P1D');
        $date->add(new \DateInterval('P100D'));
    
        for ($i = 100; $i >= 0; $i--) {
            $post = new Post;
            $post->setTitle('Post '.$i);
            $post->setContent("Quand la sonnerie a encore rententi, que la porte du box s'est ouverte, c'est le silence, et cette singuliére sesation que j'ai eue lorsque j'ai constaté que le jeunne journaliste avait détourné les yeux.\n\nJe n'ai pas regardé du côte de Marie. Je n'en ai pas eu le temps parce que le président m'a dit dans une forme bozarre que j'aurais la tête tranchée sur une place publique au nom du peuple francais.");
            $post->setDate(clone $date);
            $date->sub($day);
            $manager->persist($post);
        }

        $manager->flush();
    }
}
