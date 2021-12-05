<?php

/**
 * Zend Framework
 * 
 * compatible Doctrine 2
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   GamePortal
 * @package    GamePortal_Doctrine
 * @subpackage GamePortal_Doctrine_Auth_Adapter
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: $
 */

/**
 * php 5.5 password hash api 
 */
require_once 'GamePortal/Auth/PasswordHash.php';


class GamePortal_Doctrine_Auth_Adapter implements Zend_Auth_Adapter_Interface {

    /**
     * Doctrine entity manager
     *
     * @var Doctrine\ORM\EntityManager
     */
    protected $_em = null;

    /**
     * $_entityName - the entity name to check
     *
     * @var string
     */
    protected $_entityName = null;
    
    /**
     * $_entityAlias - the entity alias for queries
     *
     * @var string
     */
    protected $_entityAlias = null;

    /**
     * $_identityColumn - the column to use as the identity
     *
     * @var string
     */
    protected $_identityColumn = null;

    /**
     * $_credentialColumns - columns to be used as the credentials
     *
     * @var string
     */
    protected $_credentialColumn = null;

    /**
     * $_identity - Identity value
     *
     * @var string
     */
    protected $_identity = null;

    /**
     * $_credential - Credential values
     *
     * @var string
     */
    protected $_credential = null;

    /**
     * $_authenticateResultInfo
     *
     * @var array
     */
    protected $_authenticateResultInfo = null;

    /**
     * $_resultRow - Results of database authentication query
     *
     * @var array
     */
    protected $_resultRow = null;

    /**
     * __construct() - Sets configuration options
     *
     * @param  string                     $entityName
     * @param  string                     $entityAlias                        
     * @param  string                     $identityColumn
     * @param  string                     $credentialColumn
     * @param  Doctrine\ORM\EntityManager $em      
     * @return void
     */
    public function __construct($entityName, $entityAlias, $identityColumn, $credentialColumn, $em = NULL) {
        
        $this->_entityName = $entityName;
        $this->_entityAlias = $entityAlias;
        
        if (null !== $em) {
            $this->setEntityManager($em);
        }else{
            $this->getEntityManager();
        }        

        if (null !== $identityColumn) {
            $this->setIdentityColumn($identityColumn);
        }

        if (null !== $credentialColumn) {
            $this->setCredentialColumn($credentialColumn);
        }
    }

    /**
     * setEntityManager() - set the doctrine entity manager
     *
     * @param  Doctrine\ORM\EntityManager $em
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setEntityManager(Doctrine\ORM\EntityManager $em) {
        $this->_em = $em;
        return $this;
    }

    /**
     * getEntityManager() - get the doctrine entity manager
     * 
     * @return Doctrine\ORM\EntityManager|null
     */
    protected function getEntityManager() {
        if (null === $this->_em) {

            $this->_em = \Zend_Registry::get('doctrine')->getEntityManager();
        }

        return $this->_em;
    }

    /**
     * setEntityName() - set the entity name to be used in the select query
     *
     * @param  string $entityName
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setEntityName($entityName) {
        $this->_entityName = $entityName;
        return $this;
    }
    
     /**
     * setEntityAlias() - set the entity alias to be used in the query
     *
     * @param  string $entityAlias
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setEntityAlias($entityAlias) {
        $this->_entityAlias = $entityAlias;
        return $this;
    }

    /**
     * setIdentityColumn() - set the column name to be used as the identity column
     *
     * @param  string $identityColumn
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setIdentityColumn($identityColumn) {
        $this->_identityColumn = $identityColumn;
        return $this;
    }

    /**
     * setCredentialColumn() - set the column name to be used as the credential column
     *
     * @param  string $credentialColumn
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setCredentialColumn($credentialColumn) {
        $this->_credentialColumn = $credentialColumn;
        return $this;
    }

    /**
     * setIdentity() - set the value to be used as the identity
     *
     * @param  string $value
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setIdentity($value) {
        $this->_identity = $value;
        return $this;
    }

    /**
     * setCredential() - set the credential value to be used.
     * 
     *
     * @param  string $credential    
     * @return GamePortal_Doctrine_Auth_Adapter Provides a fluent interface
     */
    public function setCredential($credential) {      
        
        $this->_credential = $credential;
        return $this;
    }

    /**
     * getResultRowObject() - Returns the result row as a stdClass object
     *
     * @param  string|array $returnColumns
     * @param  string|array $omitColumns
     * @return stdClass|boolean
     */
    public function getResultRowObject($returnColumns = null, $omitColumns = null) {
        if (!$this->_resultRow) {
            return false;
        }

        $returnObject = new stdClass();

        if (null !== $returnColumns) {

            $availableColumns = array_keys($this->_resultRow);
            foreach ((array) $returnColumns as $returnColumn) {
                if (in_array($returnColumn, $availableColumns)) {
                    $returnObject->{$returnColumn} = $this->_resultRow[$returnColumn];
                }
            }
            return $returnObject;
        } elseif (null !== $omitColumns) {

            $omitColumns = (array) $omitColumns;
            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                if (!in_array($resultColumn, $omitColumns)) {
                    $returnObject->{$resultColumn} = $resultValue;
                }
            }
            return $returnObject;
        } else {

            foreach ($this->_resultRow as $resultColumn => $resultValue) {
                $returnObject->{$resultColumn} = $resultValue;
            }
            return $returnObject;
        }
    }

    /**
     * authenticate() - defined by Zend_Auth_Adapter_Interface.  This method is called to 
     * attempt an authentication.  Previous to this call, this adapter would have already
     * been configured with all necessary information to successfully connect to a database
     * table and attempt to find a record matching the provided identity.
     *
     * @throws Zend_Auth_Adapter_Exception if answering the authentication query is impossible
     * @return Zend_Auth_Result
     */
    public function authenticate() {
        $this->_authenticateSetup();
        $resultIdentities = $this->_authenticateIdentity();

        if (($authResult = $this->_authenticateValidateResultset($resultIdentities)) instanceof Zend_Auth_Result) {
            return $authResult;
        }

        $authResult = $this->_authenticateValidateResult(array_shift($resultIdentities));
        return $authResult;
    }

    /**
     * _authenticateSetup() - This method abstracts the steps involved with making sure
     * that this adapter was indeed setup properly with all required peices of information.
     *
     * @throws Zend_Auth_Adapter_Exception - in the event that setup was not done properly
     * @return true
     */
    protected function _authenticateSetup() {
        $exception = null;

        if ($this->_entityName == '') {
            $exception = 'An entity must be supplied for the GamePortal_Doctrine_Auth_Adapter authentication adapter.';
        } elseif ($this->_identityColumn == '') {
            $exception = 'An identity column must be supplied for the GamePortal_Doctrine_Auth_Adapter authentication adapter.';
        } elseif ($this->_credentialColumn == '') {
            $exception = 'A credential column must be supplied for the GamePortal_Doctrine_Auth_Adapter authentication adapter.';
        } elseif ($this->_identity == '') {
            $exception = 'A value for the identity was not provided prior to authentication with GamePortal_Doctrine_Auth_Adapter.';
        } elseif ($this->_credential === null) {
            $exception = 'A credential value was not provided prior to authentication with GamePortal_Doctrine_Auth_Adapter.';
        }

        if (null !== $exception) {
            /**
             * @see Zend_Auth_Adapter_Exception
             */
            require_once 'Zend/Auth/Adapter/Exception.php';
            throw new Zend_Auth_Adapter_Exception($exception);
        }

        $this->_authenticateResultInfo = array(
            'code' => Zend_Auth_Result::FAILURE,
            'identity' => $this->_identity,
            'messages' => array()
        );

        return true;
    }

    /**
     * _authenticateIdentity() - This method checks if the identity exists in the db
     * and returns the result.      
     * 
     * @return array $resultIdentities
     */
    protected function _authenticateIdentity() {
        $query = $this->_em->createQueryBuilder()
                  ->select($this->_entityAlias)
                  ->from($this->_entityName, $this->_entityAlias)
                  ->Where($this->_entityAlias.'.'.$this->_identityColumn.' = :identity')
                  ->setParameter('identity', $this->_identity);                  
        
        \Zend_Registry::get('logger')->log($query->getQuery()->getArrayResult(),\Zend_Log::INFO);
        
        $resultIdentities = $query->getQuery()->getArrayResult();

        return $resultIdentities;
    }

    /**
     * _authenticateValidateResultSet() - This method attempts to make certain that only one
     * record was returned in the result set
     *
     * @param array $resultIdentities
     * @return true|Zend_Auth_Result
     */
    protected function _authenticateValidateResultSet(array $resultIdentities) {

        if (count($resultIdentities) < 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
            $this->_authenticateResultInfo['messages'][] = 'A record with the supplied identity could not be found.';
            return $this->_authenticateCreateAuthResult();
        } elseif (count($resultIdentities) > 1) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS;
            $this->_authenticateResultInfo['messages'][] = 'More than one record matches the supplied identity.';
            return $this->_authenticateCreateAuthResult();
        }

        return true;
    }

    /**
     * _authenticateValidateResult() - This method attempts to validate that the record in the 
     * result set is indeed a record that matched the identity and credential provided to this adapter.
     *
     * @param array $resultIdentity
     * @return Zend_Auth_Result
     */
    protected function _authenticateValidateResult($resultIdentity) {        
        
        if (!password_verify($this->_credential, $resultIdentity[$this->_credentialColumn])) {
            $this->_authenticateResultInfo['code'] = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
            $this->_authenticateResultInfo['messages'][] = 'Supplied credential is invalid.';
            return $this->_authenticateCreateAuthResult();
        }
        
        $this->_resultRow = $resultIdentity;

        $this->_authenticateResultInfo['code'] = Zend_Auth_Result::SUCCESS;
        $this->_authenticateResultInfo['messages'][] = 'Authentication successful.';
        return $this->_authenticateCreateAuthResult();
    }

    /**
     * _authenticateCreateAuthResult() - This method creates a Zend_Auth_Result object
     * from the information that has been collected during the authenticate() attempt.
     *
     * @return Zend_Auth_Result
     */
    protected function _authenticateCreateAuthResult() {
        return new Zend_Auth_Result(
                $this->_authenticateResultInfo['code'], $this->_authenticateResultInfo['identity'], $this->_authenticateResultInfo['messages']
        );
    }

}
