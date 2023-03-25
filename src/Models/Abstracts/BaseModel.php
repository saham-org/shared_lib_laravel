<?php

namespace SahamLibs\Models\Abstracts;

use SahamLibs\Mongodb\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Collection;
use SahamLibs\Traits\Trackable;
use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    use Trackable;
    protected $connection = 'mongodb';
    protected $dateFormat = 'Y-m-d H:i:s';
    protected $guarded    = [];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m-d H:i:s');
    }

    /**
     * @return array<string>
     */
    protected function TableCols(): mixed
    {
        $table = $this->getTable();

        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    public static function rawQueryWithPagination(array $aggr): Paginator
    {
        $total = (int) self::raw(static function ($collection) use ($aggr) {
            $aggr = array_merge($aggr, [
                ['$count' => 'count'],
            ]);

            return $collection->aggregate($aggr);
        })->first()?->toArray()['count'] ?? 0;

        $currentPage = Paginator::resolveCurrentPage();
        $perPage     = (int) (request()->per_page && request()->per_page <= $total ? request()->per_page : $total);

        if ($perPage === 0) {
            $perPage = 1;
        }

        $results = self::raw(static function ($collection) use ($aggr, $perPage, $currentPage) {
            $aggr = array_merge($aggr, [
                ['$skip' => ($currentPage - 1) * $perPage],
                ['$limit' => $perPage],
            ]);

            return $collection->aggregate($aggr);
        });

        $resultsCollection = new Collection($results->all());
        $r                = new Paginator($resultsCollection, $total, $perPage, $currentPage);

        return $r->setPath(request()->url())->withQueryString();
    }
}
