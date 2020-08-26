<?php

namespace Anteris\Autotask\Generator;

use Anteris\Autotask\Generator\DataTransferObject\EndpointDataTransferObject;
use Anteris\Autotask\Generator\Helper\Str;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

/**
 * Handles the generating of classes used across multiple domains. Examples
 * include Http clients and Page entities.
 */
class SupportGenerator extends AbstractFileWriter
{
    /**
     * Makes client files and support files.
     * 
     * @author Aidan Casey <aidan.casey@anteris.com>
     */
    public function make(): void
    {
        $this->makeClient();
        $this->makeSupport();
    }

    /**
     * Iterates through a directory looking for *Service.php classes and
     * creates a client based on the results.
     * 
     * @author Aidan Casey <aidan.casey@anteris.com>
     */
    public function makeClient(): void
    {
        /**
         * Step 1. Find service files
         */
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($this->outputDirectory)
        );

        $services = [];

        foreach ($files as $filename => $fileDetails) {
            $filename = pathinfo($filename, PATHINFO_FILENAME);
            if (substr($filename, -strlen('Service')) === 'Service') {
                $name = substr($filename, 0, -strlen('Service'));
                $services[] = new EndpointDataTransferObject([
                    'plural'    => Str::pluralStudly($name),
                    'singular'  => Str::singular($name),
                ]);
            }
        }

        /**
         * Step 2. Write the client files
         */
        $this->writeTemplate('Package/Client.php.twig', 'Client.php', [
            'services' => $services
        ]);

        // $this->writeTemplate('ClientTest.twig', 'ClientTest.php', [
        //     'services' => $services
        // ]);
        // $this->writeTemplate('AbstractTest.twig', 'AbstractTest.php');

        $this->writeTemplate('Package/HttpClient.php.twig', 'HttpClient.php');
    }

    /**
     * Makes classes that belong in /Support
     * 
     * @author Aidan Casey <aidan.casey@anteris.com>
     */
    public function makeSupport(): void
    {
        $this->setSubDirectory('Support/EntityFields');
        $this->writeTemplate(
            'Package/Support/EntityFields/EntityFieldEntity.php.twig',
            'EntityFieldEntity.php'
        );
        $this->writeTemplate(
            'Package/Support/EntityFields/EntityFieldCollection.php.twig',
            'EntityFieldCollection.php'
        );

        $this->setSubDirectory('Support/EntityInformation');
        $this->writeTemplate(
            'Package/Support/EntityInformation/EntityInformationEntity.php.twig',
            'EntityInformationEntity.php'
        );

        $this->setSubDirectory('Support/EntityUserDefinedFields');
        $this->writeTemplate(
            'Package/Support/EntityUserDefinedFields/EntityUserDefinedFieldEntity.php.twig',
            'EntityUserDefinedFieldEntity.php'
        );
        $this->writeTemplate(
            'Package/Support/EntityUserDefinedFields/EntityUserDefinedFieldCollection.php.twig',
            'EntityUserDefinedFieldCollection.php'
        );

        $this->setSubDirectory('Support/Pagination');
        $this->writeTemplate(
            'Package/Support/Pagination/PageEntity.php.twig',
            'PageEntity.php'
        );

        $this->setSubDirectory('Support/UserDefinedFields');
        $this->writeTemplate(
            'Package/Support/UserDefinedFields/UserDefinedFieldEntity.php.twig',
            'UserDefinedFieldEntity.php'
        );

        // Reset the sub-directory for other methods.
        $this->setSubDirectory('');
    }
}
