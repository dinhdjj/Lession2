<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Pagination;

class Category extends Model
{
    public static function table(): string
    {
        return 'categories';
    }

    public static function paginateWithDeepChildrenAndSearch(int $page = 1, int $perPage = 2, string $search = ''): Pagination
    {
        $search = '%'.$search.'%';
        $offset = ($page - 1) * $perPage;

        $mixedCategories = static::select(
            'WHERE name LIKE ? LIMIT '.$perPage.' OFFSET '.$offset,
            [$search]
        );

        $parents = array_filter($mixedCategories, fn ($category) => $category->parent_id === null);

        /**
         * Find all parents for below lost children and join them to $parents
         */
        $lostChildren = array_filter($mixedCategories, fn ($category) => $category->parent_id !== null);
        $findParent = function ($lostChildren, $findParent) use (&$parents) {
            foreach ($lostChildren as $key => $lostChild) {
                if ($lostChild->parent_id === null) {
                    $parents[] = $lostChild;
                    unset($lostChildren[$key]);

                    continue;
                }

                foreach ($parents as $parent) {
                    if ($parent->id === $lostChild->parent_id) {
                        unset($lostChildren[$key]);
                        break;
                    }
                }
            }

            if (empty($lostChildren)) {
                return;
            }

            $newLostChildren = static::select(
                'WHERE id IN ('.implode(',', array_map(fn ($category) => $category->parent_id, $lostChildren)).')'
            );

            return $findParent($newLostChildren, $findParent);
        };
        $findParent($lostChildren, $findParent);

        /**
         * Load all children relationships for each parent
         */
        $loadChild = function ($categories, $loadChild) {
            if (empty($categories)) {
                return;
            }

            $ids = array_map(fn ($category) => $category->id, $categories);
            $children = static::select('WHERE parent_id IN ('.implode(',', $ids).')');

            foreach ($categories as $category) {
                $category->setRelation('children', array_filter($children, fn ($child) => $child->parent_id === $category->id));
            }

            return $loadChild($children, $loadChild);
        };
        $loadChild($parents, $loadChild);

        return new Pagination($parents, $page, $perPage, static::count('WHERE name LIKE ?', [$search]));
    }
}
