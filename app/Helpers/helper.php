<?php

/* Active Sidebar */
function getActiveClass($routes = [],$is_default=0)
{
    $class = '';
    if(in_array(\Route::currentRouteName(), $routes)){
        $class = "active";
        if($is_default == 1){
            $class = "hover show";
        }elseif($is_default == 2){
            $class = "menu-active-bg";
        }
    }
    return $class;
}

?>