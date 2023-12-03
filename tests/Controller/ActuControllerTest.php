<?php

namespace App\Test\Controller;

use App\Entity\Actu;
use App\Repository\ActuRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ActuControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/actu/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Actu::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Actu index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'actu[title]' => 'Testing',
            'actu[text_content]' => 'Testing',
            'actu[publication_date]' => 'Testing',
            'actu[images]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sweet/food/');

        self::assertSame(1, $this->getRepository()->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Actu();
        $fixture->setTitle('My Title');
        $fixture->setText_content('My Title');
        $fixture->setPublication_date('My Title');
        $fixture->setImages('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Actu');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Actu();
        $fixture->setTitle('Value');
        $fixture->setText_content('Value');
        $fixture->setPublication_date('Value');
        $fixture->setImages('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'actu[title]' => 'Something New',
            'actu[text_content]' => 'Something New',
            'actu[publication_date]' => 'Something New',
            'actu[images]' => 'Something New',
        ]);

        self::assertResponseRedirects('/actu/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getText_content());
        self::assertSame('Something New', $fixture[0]->getPublication_date());
        self::assertSame('Something New', $fixture[0]->getImages());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Actu();
        $fixture->setTitle('Value');
        $fixture->setText_content('Value');
        $fixture->setPublication_date('Value');
        $fixture->setImages('Value');

        $this->manager->remove($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/actu/');
        self::assertSame(0, $this->repository->count([]));
    }
}
