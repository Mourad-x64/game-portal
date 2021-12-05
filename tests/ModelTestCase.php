<?php

/**
 * Description of ModelTestCase
 *
 * 
 */
class ModelTestCase extends PHPUnit_Framework_TestCase {

    /**
     *
     * @var Bisna\Doctrine\Container
     */
    protected $doctrineContainer;
    /**
     *
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;


    /**
     * 
     * @return \Doctrine\ORM\Tools\SchemaTool
     */
    protected function schemaTool() {        
        $tool = new \Doctrine\ORM\Tools\SchemaTool($this->em);       
        return $tool;
    }    

    public function setUp() {        
        global $application;
        $application->bootstrap();
        $this->doctrineContainer = Zend_Registry::get('doctrine');        
        $this->em = $this->doctrineContainer->getEntityManager();

        $tool = $this->schemaTool();
        $tool->dropSchema($this->em->getMetadataFactory()->getAllMetadata());
        $tool->createSchema($this->em->getMetadataFactory()->getAllMetadata());

        parent::setUp();
    }

    public function tearDown() {        
        //$this->schemaTool()->dropSchema($this->em->getMetadataFactory()->getAllMetadata());
        $this->em->getConnection()->close();
        parent::tearDown();
    }

}
