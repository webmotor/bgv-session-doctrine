<?php

namespace BgvSessionDoctrine\SaveHandler;

use Zend\Session\SaveHandler;

/**
 * Class DoctrineORM.
 * DoctrineORM session save handler.
 * @package BgvSessionDoctrine\SaveHandle
 * @author Georgy Bazhukov <gosha@bugov.net>
 */
class DoctrineORM implements SaveHandlerInterface
{
    /**
     * Session Save Path
     * @var string
     */
    protected $sessionSavePath;

    /**
     * Session Name
     * @var string
     */
    protected $sessionName;

    /**
     * Lifetime
     * @var int
     */
    protected $lifetime;

    /**
     * DoctrineORM entity's name
     * @var string
     */
    protected $entityName = '\BgvSessionDoctrine\Entity\Session';

    /**
     * DoctrineORM repository's name
     * @var string
     */
    protected $repositoryName = '\BgvSessionDoctrine\Repository\SessionRepository';

    /**
     * Options
     * @var array
     */
    protected $options;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * Constructor
     */
    public function __construct()
    {
        // \WmRegistry\ServiceLocator - just service locator like \ServiceLocatorFactory\ServiceLocatorFactory
        $this->em = \WmRegistry\ServiceLocator::getInstance()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * Open Session
     * @param  string $savePath
     * @param  string $name
     * @return bool
     */
    public function open($savePath, $name)
    {
        $this->sessionSavePath = $savePath;
        $this->sessionName = $name;
        $this->lifetime = ini_get('session.gc_maxlifetime');
        return true;
    }

    /**
     * Close session
     * @return bool
     */
    public function close()
    {
        return true;
    }

    /**
     * Read session data
     * @param string $id
     * @return string
     */
    public function read($id)
    {
        $session = $this->em->getRepository($this->repositoryName)
            ->findOneBy(array('id' => $id, 'name' => $this->sessionName));

        if (!is_null($session)) {
            if ($session->getModified() + $session->getLifetime() > time()) {
                return $session->getData();
            }
            $this->destroy($id);
        }
        return '';
    }

    /**
     * Write session data
     * @param string $id
     * @param string $data
     * @return bool
     */
    public function write($id, $data)
    {
        $session = $this->em->getRepository($this->repositoryName)
            ->findOneBy(array('id' => $id, 'name' => $this->sessionName));

        if (is_null($session)) {
            $session = new $this->entityName;
            $session->setId($id);
            $session->setName($this->sessionName);
        }

        $session->setModify(time());
        $session->setData((string) $data);
        $session->setLifetime($this->lifetime);

        $this->em->persist($session);
        $this->em->flush();

        return true;
    }

    /**
     * Destroy session
     * @param  string $id
     * @return bool
     */
    public function destroy($id)
    {
        $session = $this->em->getRepository($this->repositoryName)
            ->findOneBy(array('id' => $id, 'name' => $this->sessionName));

        if (!is_null($session)) {
            $this->em->remove($session);
            $this->em->flush();
        }
        return true;
    }

    /**
     * Garbage Collection
     * @param int $maxlifetime
     * @return true
     */
    public function gc($maxlifetime)
    {
        $dql = sprintf("DELETE %s AS session WHERE session.modified + session.lifetime < :time", $this->entityName);
        $this->em->createQuery($dql) ->setParameter('time', time())->execute();
        return true;
    }
}