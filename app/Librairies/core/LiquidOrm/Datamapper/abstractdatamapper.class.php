<?php

declare(strict_types=1);

abstract class AbstractDataMapper implements DataMapperInterface
{
    /**
     * Get Results from select Query
     * =========================================================================================================
     * @param Array $data
     * @return void
     */
    protected function select_result($q, array $data)
    {
        $value = '';
        $type = $this->typeMode($data);
        if (array_key_exists('return_mode', $data) && $data['return_mode'] == 'class') {
            if (array_key_exists('return_type', $data)) {
                switch ($data['return_type']) {
                case 'count':
                    $value = $this->_count;
                break;
                case 'single':
                    $q->setFetchMode(PDO::FETCH_CLASS, $data['class']);
                    $value = $q->fetch(PDO::FETCH_CLASS);
                    //$value = $q->fetch(PDO::FETCH_OBJ);
                break;
                case 'first':
                    $value = current($q->fetchAll($type, $data['class']));
                break;
                default:
                    $value = '';
                break;
            }
            } else {
                $value = $q->fetchAll($type, $data['class']);
            }
        } else {
            if (array_key_exists('return_type', $data)) {
                switch ($data['return_type']) {
                case 'count':
                    $value = $this->_count;
                break;
                case 'single':
                    $value = $q->fetch($type);
                break;
                case 'first':
                    $value = current($q->fetchAll($type));
                break;
                default:
                    $value = '';
                break;
            }
            } else {
                if ($q->rowCount() > 0) {
                    $value = $q->fetchAll($type);
                } else {
                    $value = '';
                }
            }
        }
        return $value;
    }

    /**
     * Get Result type
     * =========================================================================================================
     * @param array $data
     * @return void
     */
    private function typeMode(array $data)
    {
        $type = '';
        if (array_key_exists('return_mode', $data)) {
            switch ($data['return_mode']) {
                case 'object':
                    $type = PDO::FETCH_OBJ;
                break;
                case 'class':
                    $type = PDO::FETCH_CLASS;
                break;
                default:
                    $type = PDO::FETCH_ASSOC;
                break;
            }
        } else {
            $type = PDO::FETCH_ASSOC;
        }
        return $type;
    }
}