<?php

use yii\db\Migration;

class m251201_000003_add_slug_to_barbershop extends Migration
{
    public function safeUp()
    {
        $this->addColumn('{{%barbershop}}', 'slug', $this->string(180)->null()->unique());

        // Generate slugs for existing rows
        $rows = (new \yii\db\Query())->from('{{%barbershop}}')->all();
        foreach ($rows as $row) {
            $base = $this->slugify($row['name'] ?: ('barbershop-' . $row['id']));
            $slug = $base;
            $i = 1;
            while ((new \yii\db\Query())->from('{{%barbershop}}')->where(['slug' => $slug])->exists()) {
                $slug = $base . '-' . $i++;
            }
            $this->update('{{%barbershop}}', ['slug' => $slug], ['id' => $row['id']]);
        }
    }

    public function safeDown()
    {
        $this->dropColumn('{{%barbershop}}', 'slug');
    }

    private function slugify($text)
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = strtolower($text);
        $text = preg_replace('~[^-a-z0-9]+~', '', $text);
        return $text ?: 'barbershop';
    }
}
