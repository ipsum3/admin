<?php

namespace Ipsum\Admin\Concerns;

trait Sortable
{

    protected static function bootSortable()
    {

        self::saving(function(self $objet)
        {
            if (!$objet->exists) {

                // On récupère le dernier order
                $objet->order = self::filtreSortable($objet)->count() + 1;

            }
        });

        self::deleted(function(self $objet)
        {
            self::updateOrder($objet);
        });
    }



    static public function updateOrder($objet, $exclude_id = null)
    {
        $query = self::select(['id', 'order'] + self::clesEtrangeres())->filtreSortable($objet);
        if ($exclude_id !== null) {
            $query->where('id', '!=', $exclude_id);
        }
        $objets = $query->orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        $datas = [];
        foreach ($objets as $objet) {
            $datas[implode('-', self::clesEtrangeres())][] = $objet;
        }

        foreach ($datas as $data) {
            $order = 1;
            foreach ($data as $objet) {
                $objet->order = $order;
                $objet->save();
                $order++;
            }
        }
    }


    protected static function clesEtrangeres()
    {
        return [];
    }


    public function scopeFiltreSortable($query, $objet)
    {
        foreach (self::clesEtrangeres() as $cle) {
            $query->where($cle, $objet->{$cle});
        }
    }

}
