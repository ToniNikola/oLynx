<?php

namespace App\Helpers;

use App\Category;
use App\Stages;

class CategoryHelper {
    public static function getList()
    {
        $category = Category::all();
        $category_list = null;
        foreach ($category as $c)
        {
            $category_list[$c->code] = $c->name;
        }

        return $category_list;
    }
    public static function formatStageCategory($id)
    {
        $stage = Stages::where('event_id', $id)->first();

        $stageCategory = null;
        $stage_array = null;
        if (is_object($stage))
        {


            $stages[] = explode('-', $stage->stage1);
            $stages[] = explode('-', $stage->stage2);
            $stages[] = explode('-', $stage->stage3);
            $stages[] = explode('-', $stage->stage4);
            $stages[] = explode('-', $stage->stage5);
            $stages[] = explode('-', $stage->stage6);
            $stages[] = explode('-', $stage->stage7);
            $stages[] = explode('-', $stage->stage8);
            $stages[] = explode('-', $stage->stage9);
            $stages[] = explode('-', $stage->stage10);

            $i = 0;
            while (10 > $i)
            {
                $num[$i] = array_filter($stages[$i]);
                $i ++;
            }
            $stageCategory = array_filter($num);


            for ($i = 0; count($stageCategory) > $i; $i ++)
            {

                $stage_array[] = array_combine($stageCategory[$i], $stageCategory[$i]);
            }


            return $stage_array;
        }

        return $stage_array;
    }
}