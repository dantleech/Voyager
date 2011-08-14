<?php

namespace DTL\VoyagerBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use DTL\VoyagerBundle\Entity\Voyage;
use DTL\VoyagerBundle\Entity\Tour;
use DTL\VoyagerBundle\Entity\Place;

class ImportLegacyCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
            ))
            ->setName('voyager:import-legacy')
        ;
    }

    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When the target directory does not exist
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $em = $this->getContainer()->get('doctrine.orm.entity_manager');
        $voyageRepo = $em->getRepository('DTLVoyagerBundle:Voyage');
        $tourRepo = $em->getRepository('DTLVoyagerBundle:Tour');
        $placeRepo = $em->getRepository('DTLVoyagerBundle:Place');

        $pdo = new \PDO('mysql:host=localhost;dbname=travelblog', 'root', '');
        $res = $pdo->query('SELECT * FROM journey');

        if ($tour = $tourRepo->findByTitle('2010 - France')) {
            $this->writeln('Tour already exists');
            return;
        } else {
            $tour = new Tour;
            $tour->setTitle('2010 - France');
            $em->persist($tour);
        }

        while ($row = $res->fetch()) {
            $voyage = new Voyage;
            $voyage->setTour($tour);

            $descParts = explode('-', trim($row['description']));
            if (count($descParts) == 2) {
                $depart = trim(utf8_encode($descParts[0]));
                $arrive = trim(utf8_encode($descParts[1]));
                $output->writeln(sprintf('<info>From "%s" to "%s"</info>', $depart, $arrive));
            } else {
                $output->writeln('Description does not contain 2 points, discarding');
                continue;
            }

            if (!$place = $placeRepo->findByName($depart)) {
                $place = new Place;
                $place->setName($depart);
                $em->persist($place);
            }
            $voyage->setDepart($place);
            if (!$place = $placeRepo->findByName($arrive)) {
                $place = new Place;
                $place->setName($arrive);
                $em->persist($place);
            }
            $voyage->setArrive($place);

            $meters = $row['distance'] * 1609.34;
            $voyage->setDistance($meters);
            $voyage->setTime($row['time'] * 60);
            $voyage->setMaxSpeed($row['max_speed'] * 1609.34);
            $voyage->setDate(new \DateTime($row['date']));
            $voyage->setLog($row['comment']);
            $em->persist($voyage);
        }

        $em->flush();
    }
}

