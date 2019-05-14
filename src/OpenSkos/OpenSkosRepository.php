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
        //return $this->resource->;
    }

    /**
     * @return OpenSkosResource[]
     */
    /*
    function all() : array ;
    */


}
