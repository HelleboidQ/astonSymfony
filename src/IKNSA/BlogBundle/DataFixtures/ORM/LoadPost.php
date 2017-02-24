<?php

namespace IKNSA\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use IKNSA\BlogBundle\Entity\Post;

class LoadPost extends AbstractFixture implements OrderedFixtureInterface {

    public function load(ObjectManager $manager) {

        $post = new Post();
        $post->setTitle('Titre 1');
        $post->setSummary('Summary 1');
        $post->setContent('Content 1');
        $post->setCreatedAt(new \Datetime("now"));
        $post->setAuthor($this->getReference('user'));
        $manager->persist($post);

        $post = new Post();
        $post->setTitle('Titre 2');
        $post->setSummary('Summary 2');
        $post->setContent('Content 2');
        $post->setCreatedAt(new \Datetime("now"));
        $post->setAuthor($this->getReference('user'));
        $manager->persist($post);

        $manager->flush();
    }

    public function getOrder() {
        return 2;
    }

}
