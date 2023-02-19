<?php

namespace Core\Models;

use VVF\ErrorHandler\ErrorHandler;
use VVF\Models\Model;

class AppTopModel extends Model
{
    public string $table = 'appTop';

    public function saveInDbCategories(array $categoriesPrepare, string $date): void
    {
        try {
            foreach ($categoriesPrepare as $category => $position) {
                $this->db->query("INSERT INTO `appTop` (`date`, `category`, `position`) VALUES ('$date', '$category', '$position')");
            }
        } catch (ErrorHandler $e) {
            throw new ErrorHandler('Не удалось добавить в топ ' . $e->getMessage());
        }
    }
}