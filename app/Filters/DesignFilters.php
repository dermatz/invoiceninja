<?php
/**
 * Invoice Ninja (https://invoiceninja.com).
 *
 * @link https://github.com/invoiceninja/invoiceninja source repository
 *
 * @copyright Copyright (c) 2022. Invoice Ninja LLC (https://invoiceninja.com)
 *
 * @license https://www.elastic.co/licensing/elastic-license
 */

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

/**
 * DesignFilters.
 */
class DesignFilters extends QueryFilters
{
    /**
     * Filter based on search text.
     *
     * @param string query filter
     * @return Builder
     * 
     * @deprecated
     */
    public function filter(string $filter = ''): Builder
    {
        if (strlen($filter) == 0) {
            return $this->builder;
        }

        return  $this->builder->where(function ($query) use ($filter) {
            $query->where('designs.name', 'like', '%'.$filter.'%');
        });
    }

    /**
     * Sorts the list based on $sort.
     *
     * @param string sort formatted as column|asc
     * 
     * @return Builder
     */
    public function sort(string $sort): Builder
    {
        $sort_col = explode('|', $sort);

        if(is_array($sort_col))
            return $this->builder->orderBy($sort_col[0], $sort_col[1]);

        return $this->builder;
    }

    /**
     * Filters the query by the users company ID.
     *
     * @return Illuminate\Database\Query\Builder
     */
    public function entityFilter(): Builder
    {
        //return $this->builder->whereCompanyId(auth()->user()->company()->id);
        return $this->builder->where('company_id', auth()->user()->company()->id)->orWhere('company_id', null)->orderBy('id','asc');
    }
}