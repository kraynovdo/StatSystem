<?php
    function start_NAVIG() {
        $navig_arr = array(
            'code' => 'main'
        );
        return $navig_arr;
    }
    function start_index(){
        $result = array();
        $result['navigation'] = start_NAVIG();
        return $result;
    }