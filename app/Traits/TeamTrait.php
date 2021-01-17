<?php
namespace App\Traits;

trait TeamTrait {

    public function addUpperCase($teamCollection)
    {
        // dd($teamCollection);
        // $addUpperCaseKey = function ( $teamItem ){
        //     return $teamItem;
        // };
        // return array_map($addUpperCaseKey, $teamCollection) ;
        
        return $teamCollection->map( function( $item ) {
            $item->newTitle = strtoupper( $item->title );
            return $item;
        } )->toArray();

    }
}
