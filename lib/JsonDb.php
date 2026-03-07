<?php
class JsonDb
{
    private $dir;

    public function __construct()
    {
        $this->dir = DATA_DIR;
        if (!is_dir($this->dir)) {
            mkdir($this->dir, 0755, true);
        }
    }

    private function path($entity)
    {
        return $this->dir . '/' . $entity . '.json';
    }

    private function read($entity)
    {
        $path = $this->path($entity);
        if (!file_exists($path)) {
            return [];
        }
        $json = file_get_contents($path);
        $data = json_decode($json, true);
        return is_array($data) ? $data : [];
    }

    private function write($entity, $data)
    {
        $path = $this->path($entity);
        file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX);
    }

    public function getAll($entity)
    {
        return $this->read($entity);
    }

    public function getById($entity, $id)
    {
        $data = $this->read($entity);
        foreach ($data as $row) {
            if (isset($row['id']) && (string)$row['id'] === (string)$id) {
                return $row;
            }
        }
        return null;
    }

    public function getWhere($entity, $key, $value)
    {
        $data = $this->read($entity);
        $out = [];
        foreach ($data as $row) {
            if (isset($row[$key]) && $row[$key] == $value) {
                $out[] = $row;
            }
        }
        return $out;
    }

    public function getFirstWhere($entity, $key, $value)
    {
        $data = $this->getWhere($entity, $key, $value);
        return $data ? $data[0] : null;
    }

    public function nextId($entity)
    {
        $data = $this->read($entity);
        $max = 0;
        foreach ($data as $row) {
            if (isset($row['id']) && (int)$row['id'] > $max) {
                $max = (int)$row['id'];
            }
        }
        return $max + 1;
    }

    public function insert($entity, $row)
    {
        $data = $this->read($entity);
        if (!isset($row['id'])) {
            $row['id'] = $this->nextId($entity);
        }
        $data[] = $row;
        $this->write($entity, $data);
        return $row['id'];
    }

    public function update($entity, $id, $row)
    {
        $data = $this->read($entity);
        foreach ($data as $i => $item) {
            if (isset($item['id']) && (string)$item['id'] === (string)$id) {
                $data[$i] = array_merge($item, $row);
                $data[$i]['id'] = $item['id'];
                $this->write($entity, $data);
                return true;
            }
        }
        return false;
    }

    public function delete($entity, $id)
    {
        $data = $this->read($entity);
        $out = [];
        foreach ($data as $item) {
            if (!isset($item['id']) || (string)$item['id'] !== (string)$id) {
                $out[] = $item;
            }
        }
        if (count($out) < count($data)) {
            $this->write($entity, $out);
            return true;
        }
        return false;
    }
}
