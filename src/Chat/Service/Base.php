<?php
declare(strict_types=1);
namespace Chat\Service;

use PDO;
use DateTime;
use DateInterval;
use Exception;
use Chat\Generic\Constants;
#[Chat\Service\Base]
class Base
{
    /**
     * Sets the PDO instance
     */
    public function getConnection()
    {
        return Connection::getInstance();
    }
    /**
     * assembles final SQL SELECT statement
     *
     * @param array $sql
     * @param array $opts
     * @return string $sql
     */
    public function buildSelect(array $sql, array $opts = []) : string
    {
        if (empty($sql['table'])) throw new Exception(Constants::ERR_SQL_FROM);
        $sql = $this->expandSql($sql, $opts);
        $str = 'SELECT ';
        $str .= (isset($sql['cols'])) ? $sql['cols'] . ' ' : '* ';
        $str .= 'FROM ' . $sql['table'] . ' ';
        if (!empty($sql['where']))
            $str .= 'WHERE ' . implode(' ', $sql['where']) . ' ';
        $str .= (!empty($sql['order']))  ? 'ORDER BY ' . $sql['order'] . ' '        : '';
        $str .= (!empty($sql['limit']))  ? 'LIMIT '    . (int) $sql['limit'] . ' '  : '';
        $str .= (!empty($sql['offset'])) ? 'OFFSET '   . (int) $sql['offset'] . ' ' : '';
        return trim(str_replace('  ', ' ', $str));
    }
    /**
     * expands SQL from $opts
     *
     * @param array $sql
     * @param array $opts
     * @return array $sql
     */
    public function expandSql(array $sql, array $opts) : array
    {
        if (!empty($opts['limit'])) {
            $sql['limit'] = (int) $opts['limit'];
        } else {
            $sql['limit'] = Constants::DEFAULT_LIMIT;
        }
        if (!empty($opts['offset'])) {
            $sql['offset'] = (int) $opts['offset'];
        }
        if (!empty($opts['days'])) {
            $today = new DateTime();
            $today->add(new DateInterval('P' . (int) $opts['days'] . 'D'));
            $sql['where'][] = "AND created >= '" . $today->format(Constants::DATE_FORMAT) . "'";
        }
        return $sql;
    }
    /**
     * executes prepared statement
     *
     * @param array $data
     * @param array $sql
     * @param array $opts [optional]
     * @return array|false $result
     */
    public function do_exec(array $data, array $sql, array $opts = []) : array|false
    {
        $result  = FALSE;
        $connect = $this->getConnection();
        $sql_str = $this->buildSelect($sql, $opts);
        $stmt    = $connect->prepare($sql_str);
        if (!empty($stmt)) {
            $stmt->execute($data);
            // NOTE: if the default limit of 20 is raised,
            //       might need to change this into a generator instead
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result;
    }
}
