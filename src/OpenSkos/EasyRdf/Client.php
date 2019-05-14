<?php

namespace App\OpenSkos\EasyRdf;

use EasyRdf_Sparql_Client;

class Client extends EasyRdf_Sparql_Client
{
    /**
    * Deletes the resource and inserts it with the new data.
    * @param string $uri The resource id
    * @param Graph|string $data The insert data
    */
    public function replace($uri, $data)
    {
    $query = 'DELETE WHERE {<' . $uri . '> ?predicate ?object};';
    $query .= PHP_EOL;
    $query .= 'INSERT DATA {' . $this->convertToTriples($data) . '}';

    $this->update($query);
    }
}
