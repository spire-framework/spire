<?php
namespace Spire\Database;

class Builder
{

    /**
     * Builds the INSERT clause.
     *
     * @param  string  $table   Table to insert data into.
     * @param  array   $insert  The fields and values to insert.
     * @return string
     */
    public static function insert(string $table, array $insert): string
    {
        $set    = [];
        $values = [];

        foreach (array_keys($insert) as $column)
        {
            array_push($set, $column);
            array_push($values, ':' . $column);
        }

        return 'INSERT INTO ' . $table . ' (' . implode(', ', $set) . ') VALUES (' . implode(', ', $values) . ') ';
    }

    /**
     * Builds the SELECT clause.
     *
     * @param  array  $fields  The fields to select.
     * @return string
     */
    public static function select(array $fields = []): string
    {
        if (empty($fields))
        {
            return 'SELECT * ';
        }
        else
        {
            return 'SELECT ' . implode(', ', $fields) . ' ';
        }
    }

    /**
     * Builds the FROM clause.
     *
     * @param  string  $table  The name of the table to pull data from.
     * @return string
     */
    public static function from(string $table): string
    {
        return ' FROM ' . $table;
    }

    /**
     * Builds the WHERE clause.
     *
     * @param  array  $where  The where clause options.
     * @return string
     */
    public static function where(array $where = []): string
    {
        // Return nothing if $where is empty.
        if (empty($where))
        {
            return '';
        }
        else
        {
            $clause = ' WHERE ';
            $first  = true;

            foreach ($where as $w)
            {
                $value = ':' . $w['column'];

                if (!$first)
                {
                    $clause .= 'AND ';
                }
                else
                {
                    $clause .= $w['column'] . ' ' . $w['operator'] . ' ' . $value;
                }

                $first = false;
            }
        }

        return $clause;
    }

}
