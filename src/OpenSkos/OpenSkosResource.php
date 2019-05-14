<?php declare(strict_types=1);

namespace App\OpenSkos;

use App\OpenSkos\EasyRdf\Client;
use App\Rdf\Triple;

class OpenSkosResource{


    /**
     * @var Client
     */
    private $client;


    /**
     * @var Triple[]
     */
    private $triples = [];

    /**
     * OpenSkosResource constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @return string[]
     */
    public function properties() : array
    {
        $res = [];
        foreach ($this->triples as $triple) {
            $res[$triple->getPredicate()] = $triple->getObject();
        }

        return $res;
    }

    /**
     * @param Triple[] $triples
     */
    public static function fromTriples(array $triples) : self
    {
        $obj = new self();
        $obj->triples = $triples;

        return $obj;
    }
}
