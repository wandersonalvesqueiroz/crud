<?php

include('Connection.php');

class Client extends Connection
{

    private $client;
    private $count;
    private $idClient;

    public function prepareStatement($query, $params)
    {

        $conn = $this->conectDB();

        $this->countParams($params);
        $this->client = $conn->prepare($query);

        if ($this->count > 0) {
            for ($i = 1; $i <= $this->count; $i++) {
                $this->client->bindValue($i, $params[$i - 1]);
            }
        }

        $this->client->execute();

        $this->idClient = $conn->lastInsertId();

    }

    private function countParams($params)
    {
        $this->count = count($params);
    }

    public function insert($table, $cond, $params)
    {
        $this->prepareStatement("INSERT INTO {$table} VALUES ({$cond})", $params);

        return $this->client;
    }

    public function update($table, $set, $cond, $params)
    {
        $this->prepareStatement("UPDATE {$table} SET {$set} WHERE {$cond}", $params);

        return $this->client;
    }

    public function insertPhone($phones, $id = 0)
    {
        if ($id > 0)
            $this->idClient = $id;

        foreach ($phones as $phone) {
            $conn = $this->conectDB();
            $phoneInsert = $conn->prepare("INSERT INTO client_phone(id_client, phone) VALUES (:id_client, :phone)");
            $phoneInsert->bindParam(':id_client', $this->idClient, PDO::PARAM_STR);
            $phoneInsert->bindParam(':phone', $phone, PDO::PARAM_STR);
            $phoneInsert->execute();
        }
    }

    public function select($variables, $table, $cond, $params)
    {
        $this->prepareStatement("SELECT {$variables} FROM {$table} {$cond}", $params);
        return $this->client;
    }

    public function selectPhone($variables, $table, $cond, $params)
    {
        $this->prepareStatement("SELECT {$variables} FROM {$table} {$cond}", $params);
        return $this->client;
    }

    public function delete($table, $cond, $params)
    {
        $this->prepareStatement("DELETE FROM {$table} WHERE {$cond}", $params);
        return $this->client;
    }

    public function mask($val, $mask)
    {
        $maskared = '';
        $k = 0;
        for ($i = 0; $i <= strlen($mask) - 1; $i++) {
            if ($mask[$i] == '#') {
                if (isset($val[$k]))
                    $maskared .= $val[$k++];
            } else {
                if (isset($mask[$i]))
                    $maskared .= $mask[$i];
            }
        }
        return $maskared;
    }

}

