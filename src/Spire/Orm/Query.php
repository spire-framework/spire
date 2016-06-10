<?php
namespace Spire\Database;

use Spire\Exception\Exception;

class Query
{

    /**
     * @var string The table name.
     */
    protected $table = '';

    /**
     * @var string The built SQL.
     */
    protected $sql = '';

    /**
     * @var array The query INSERT clause.
     */
    protected $insert = [];

    /**
     * @var array The query SELECT clause.
     */
    protected $select = [];

    /**
     * @var array The query WHERE clause.
     */
    protected $where = [];

    /**
     * @var array The query ORDER BY clause.
     */

    /**
     * @var \Spire\Database\Statement The query statement.
     */
    protected $stmt;

    /**
     * @var mixed The query result.
     */
    protected $result;

    /**
     * @var array Valid query methods.
     */
    private $methods = [
        'create',
        'read',
        'update',
        'delete',
        'describe'
    ];

    /**
     * Constructor.
     *
     * @param  string  $table  The table name we're working with in this query.
     * @return void
     */
    public function __construct(string $table = '')
    {
        $this->table = $table;
    }

    /**
     * Sets the INSERT clause.
     *
     * @param  array  $data  The data to insert.
     * @return \Spire\Database\Query
     */
    public function insert(array $data)
    {
        $this->insert = array_merge($this->insert, $data);

        return $this;
    }

    /**
     * Sets the SELECT clause.
     *
     * @param  array  $fields  The fields to select.
     * @return \Spire\Database\Query
     */
    public function select(array $fields)
    {
        $this->select = array_merge($this->select, $fields);

        return $this;
    }

    /**
     * Sets the WHERE clause.
     *
     * @param  string $column    The name of the column.
     * @param  string $operator  The clause operator.
     * @param  mixed  $value     The value to check against the column.
     * @return \Spire\Database\Query
     */
    public function where(string $column, string $operator = '=', $value): Query
    {
        array_push($this->where, compact('column', 'operator', 'value'));

        return $this;
    }

    /**
     * Sets the ORDER BY clause.
     *
     * @param  string  $column     The column to order by.
     * @param  string  $direction  The order direction.
     * @return \Spire\Database\Query
     */
    public function orderBy(string $column, string $direction = 'asc'): Query
    {
        array_push($this->orderBy, compact('column', 'direction'));

        return $this;
    }

    /**
     * Runs the query
     *
     * @param  string  $method  The query method.
     * @return \Spire\Database\Query
     */
    public function run(string $method = 'read'): Query
    {
        // Normalize the method.
        $method = strtolower($method);

        // Ensure this is a valid query method.
        if (!in_array($method, $this->methods))
        {
            throw new Exception(sprintf('Invalid query method: %s', $method));
        }

        // Ensure the SQL is cleared.
        $this->sql = '';

        // The builder methods we run depends on the query method.
        switch ($method)
        {
            case 'read':
                $this->sql .= Builder::select($this->select);
                $this->sql .= Builder::from($this->table);
                $this->sql .= Builder::where($this->where);
                break;
            case 'create':
                $this->sql .= Build::insert($this->table, $this->insert);
                break;
            case 'describe':
                $this->sql .= Build::describe($this->table);
                break;
        }

        // Instantiate the statement.
        $this->stmt = new Statement($this->sql);

        // Bind WHERE values.
        foreach ($this->where as $where)
        {
            $this->stmt->bind(':' . $where['column'], $where['value']);
        }

        // Do we need to bind INSERT values.
        if ($method === 'create')
        {
            foreach ($this->insert as $key => $value)
            {
                $this->stmt->bind(':' . $key, $value);
            }
        }

        // Execute the statement.
        $this->result = $this->stmt->execute();

        // Return object.
        return $this;
    }

    /**
     * Fetches all query results.
     *
     * @return array
     */
    public function all(): array
    {
        // Execute the query.
        $this->run('read');

        // Fetch results.
        return $this->stmt->all();
    }

    /**
     * Fetches column information on the table.
     *
     * @return array
     */
    public function describe(): array
    {
        if ($this->run('describe'))
        {
            return $this->stmt->all();
        }
        else
        {
            return [];
        }
    }

    /**
     * Select a table to query.
     *
     * @param  string  $table  The table to query.
     * @return \Spire\Database\Query
     */
    public static function table(string $table)
    {
        $class = get_called_class();
        return new $class($table);
    }

}
