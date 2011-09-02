<?php

namespace DTL\VoyagerBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use DTL\VoyagerBundle\Document\Media;
use Symfony\Component\Finder\Finder;
use Imagine\Gd\Imagine;
use Imagine\Image\Box;
use Symfony\Component\HttpKernel\Util\Filesystem;

class ImportMediaCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setDefinition(array(
            ))
            ->setName('voyager:import-media')
            ->addArgument('path', null, 'Media path')
            ->addArgument('output', null, 'Thumbnail output path');
        ;
    }

    /**
     * @see Command
     *
     * @throws \InvalidArgumentException When the target directory does not exist
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $exts = array('JPG');
        $dm = $this->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $repo = $dm->getRepository('DTLVoyagerBundle:Media');
        $fs = new Filesystem;

        $path = $input->getArgument('path');
        $outputPath = $input->getArgument('output');

        $finder = Finder::create()->files();
        foreach ($exts as $ext) {
            $finder->name('*.'.$ext);
        }
        $files = $finder->in($path);

        foreach ($files as $i => $file) {
            $fname = md5_file($file).'.JPG';
            if (!$media = $repo->findOneByFilename($fname)) {
                $media = new Media;
                $media->setFilename($fname);
            }

            $meta = exif_read_data($file);
            $output->writeln(print_r($meta, true));
            array_walk_recursive($meta, function (&$v, &$k) {
                if (is_string($v)) {
                    $v = utf8_encode($v);
                }
            });
            $media->setFilename($fname);
            $date = new \DateTime($meta['DateTimeOriginal']);
            $media->setDate($date);
            $media->setMeta($meta);
            $dm->persist($media);
            $output->writeln(' => '.$file.' '.$date->format('c'));


            $path = $outputPath."/thumb/".$fname;
            if (!file_exists($path)) {
                // generate thumbnail
                $imagine = new Imagine;
                $image = $imagine->open($file);
                $thumb = $image->thumbnail( new Box(100, 100));
                $fs->mkdir($outputPath.'/thumb');
                $thumb->save($path);
            }
        }

        $dm->flush();
    }
}
