<?php declare(strict_types=1);


namespace App\OpenSkos\Entities;

use App\OpenSkos\EasyRdf\Client;
use App\OpenSkos\Namespaces;

class SparqlResourceManager
{
    /**
     * Execute raw query
     * Retries on timeout, because when jena stays idle for some time, sometimes throws a timeout error.
     *
     * @param string $query
     * @return \EasyRdf\Graph
     * @throws \EasyRdf\Exception
     */
    public function query($query)
    {
        $maxTries = 3;
        $tries = 0;
        $ex = null;
        do {
            try {
                return $this->client->query($query);
            } catch (\EasyRdf\Exception $ex) {
                if (strpos($ex->getMessage(), 'timed out') === false) {
                    throw $ex;
                }
            }
            sleep(30);
            $tries ++;
        } while ($tries < $maxTries && $ex !== null);
        if ($ex !== null) {
            throw $ex;
        }
    }

    /**
     * Fetch all resources matching the query.
     *
     * @param \Asparagus\QueryBuilder|string $query
     * @return ResourceCollection
     */
    public function fetchQuery($query, $rdfType = null)
    {
        if ($query instanceof \Asparagus\QueryBuilder) {
            $query = $query->getSPARQL();
        }

        $result = $this->query($query);
        if (!isset($rdfType)) {
            $rdfType = $this->resourceType;
        }
        return EasyRdf::graphToResourceCollection($result, $rdfType);
    }

    /**
     * Fetches a single resource matching the uri.
     * @param string $uri
     * @return Resource
     * @throws ResourceNotFoundException
     */
    public function fetchByUri($uri, $type = null)
    {
        $resource = new Uri($uri);
        $prefixes = [
            'rdf' => RdfNamespace::NAME_SPACE
        ];
        $serializedURI = (new NTriple)->serialize($resource);
        $qb = new \Asparagus\QueryBuilder($prefixes);
        $query = $qb->describe([$serializedURI, '?object'])
            ->where($serializedURI, '?property', '?object')->filterNotExists('?object', 'rdf:type', '?sometype');

        if (isset($type)) {
            $query = $query->also('?subject', 'rdf:type', "<$type>");
        }

        try {
            $result = $this->fetchQuery($query, $type);
            // @TODO Add resourceType check.
        } catch (\Exception $exp) {
            throw new ResourceNotFoundException("Unable to fetch resource \n" . $exp->getMessage() . " (of $type) \n");
        }
        if (count($result) == 0) {
            throw new ResourceNotFoundException(
                'The requested resource <' . $uri . '> was not found.'
            );
        }
        if (count($result) > 1) {
            throw new \RuntimeException(
                'Something went very wrong. The requested resource <' . $uri . '> was found more than once.'
            );
        }
        return $result[0];
    }



}
