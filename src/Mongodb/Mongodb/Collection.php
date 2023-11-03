<?php

namespace Saham\SharedLibs\Mongodb;

use MongoDB\BSON\ObjectID;
use MongoDB\Collection as MongoCollection;
use Throwable;

class Collection
{
    /**
     * The connection instance.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * The MongoCollection instance.
     *
     * @var MongoCollection
     */
    protected $collection;

    public function __construct(Connection $connection, MongoCollection $collection)
    {
        $this->connection = $connection;
        $this->collection = $collection;
    }

    /**
     * Handle dynamic method calls.
     *
     * @param string $method
     * @param array  $parameters
     *
     */
    public function __call($method, $parameters): mixed
    {
        $start  = microtime(true);
        $result = call_user_func_array([$this->collection, $method], $parameters);

        // Once we have run the query we will calculate the time that it took to run and
        // then log the query, bindings, and execution time so we will report them on
        // the event that the developer needs them. We'll log time in milliseconds.
        $time = $this->connection->getElapsedTime($start);

        $query = [];

        // Convert the query parameters to a json string.
        array_walk_recursive($parameters, static function (&$item, $key): void {
            if ($item instanceof ObjectID) {
                $item = (string) $item;
            }
        });

        // Convert the query parameters to a json string.
        foreach ($parameters as $parameter) {
            try {
                $query[] = json_encode($parameter);
            } catch (Throwable $e) {
                $query[] = '{...}';
            }
        }

        $queryString = $this->collection->getCollectionName() . '.' . $method . '(' . implode(',', $query) . ')';

        $this->connection->logQuery($queryString, [], $time);

        return $result;
    }
}
