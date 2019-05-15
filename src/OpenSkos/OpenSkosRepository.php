<?php declare(strict_types=1);

namespace App\OpenSkos;

use App\OpenSkos\Entities\SparqlResourceManager;
use App\OpenSkos\Namespaces;

class  OpenSkosRepository {

    /*
     * @var SparqlResourceManager
     */
    private $resource;


    /**
     * OpenSkosRepository constructor.
     * @param OpenSkosResource $resource
     */
    public function __construct(SparqlResourceManager $resource)
    {
        $this->resource = $resource;
    }

    public function findAll(){
        $object = $this->resource->fetchByUri('<http://tenant/c38d8779-02e7-40d0-bd08-4a60a42b4814>');
        return $object;
        //return $this->resource->;
    }

    /**
     * @return OpenSkosResource[]
     */
    /*
    function all() : array ;
    */


}
