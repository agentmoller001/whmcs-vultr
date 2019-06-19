<?php

namespace MGModule\vultr\mgLibs\MySQL;

use MGModule\vultr as main;


/**
 * MySQL Results Class
 */
class Result
{
	/**
	 * Use PDO for Connection
	 *
	 * @var boolean
	 */
	static private $usePDO = false;
	/**
	 *
	 * @var PDOStatement
	 */
	private $result;

	/**
	 * Constructor
	 *
	 * @param PDOStatement $result
	 * @param int $id
	 */
	function __construct($result, $id = null)
	{

		if (is_a($result, 'PDOStatement'))
		{
			self::$usePDO = true;
		}

		$this->result = $result;
		$this->id = $id;
	}

	/**
	 * Fetch All Records
	 *
	 * @return array
	 */
	function fetchAll()
	{
		if (self::$usePDO)
		{
			return $this->result->fetchAll(\PDO::FETCH_ASSOC);
		}
		else
		{
			$result = array();
			while ($row = $this->fetch())
			{
				$result[] = $row;
			}
			return $result;
		}
	}

	/**
	 * Fetch one record
	 *
	 * @return array
	 */
	function fetch()
	{
		if (self::$usePDO)
		{
			return $this->result->fetch(\PDO::FETCH_ASSOC);
		}
		else
		{
			return mysql_fetch_assoc($this->result);
		}
	}

	/**
	 * Fetch One Column From First Record
	 *
	 * @param string $name
	 * @return array
	 */
	function fetchColumn($name = null)
	{
		if (self::$usePDO)
		{
			$data = $this->result->fetch(\PDO::FETCH_BOTH);
		}
		else
		{
			if ($name)
			{
				$data = mysql_fetch_assoc($this->result);
			}
			else
			{
				$data = mysql_fetch_array($this->result);
			}
		}

		if ($name)
		{
			return $data[$name];
		}
		else
		{
			return $data[0];
		}
	}

	/**
	 * Get ID Last Inserted Record
	 *
	 * @return int
	 */
	function getID()
	{
		return $this->id;
	}
}