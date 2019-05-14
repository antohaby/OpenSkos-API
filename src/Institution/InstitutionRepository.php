<?php declare(strict_types=1);

namespace App\Institution;

use App\OpenSkos\OpenSkosRepository;
use App\OpenSkos\Namespaces;

class  InstitutionRepository extends OpenSkosRepository{

    private $predicate = Namespaces\OpenSkos::TENANT;

    /**
     * @return Institution[]
     */
    /*
    function all() : array ;
    */



}