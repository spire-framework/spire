<?php
namespace Spire\Database;

class Statement
{

    /**
     * @var object PDO statement.
     */
    protected $stmt;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct(string $sql = '')
    {
        // If we have SQL, prepare the statement.
        if ($sql !== '')
        {
            $this->prepare($sql);
        }
    }

    /**
     * Prepares an SQL statement.
     *
     * @param  string  $sql  The query to prepare.
     * @return void
     */
    public function prepare(string $sql): Statement
    {
        // Prepare the query.
        $this->stmt = Database::conection()->prepare($sql);

        // Return class.
        return $this;
    }

    /**
     * Binds a parameter to a value.
     *
     * @param  mixed  $parameter
     * @param  mixed  $value
     * @param  int    $type
     * @return Statement
     */
    public function bind($parameter, $value, int $type = 0): Statement
    {
        // Detect the value type if one has not already been set.
        if ($type === 0)
        {
            switch (strtolower(gettype($value)))
            {
                case 'integer':
                    $type = PDO::PARAM_INT;
                    break;
                case 'boolean':
                    $type = PDO::PARAM_BOOL;
                    break;
                case 'null':
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        // Bind the value.
        $this->stmt->bindValue($parameter, $value, $type);

        // Return class.
        return $this;
    }

    /**
     * Executes the prepared statement.
     *
     * @return bool
     */
    public function execute(): bool
    {
         return $this->stmt->execute();
    }

}
