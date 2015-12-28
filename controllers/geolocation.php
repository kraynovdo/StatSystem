<?php
    function geolocation_cities($dbConnect, $CONSTPath) {
        $search = $_GET['search'] ? '&q=' . $_GET['search'] : '';
        $country = $_GET['country_id'] ? $_GET['country_id'] : 1; //пока по умолчанию Россия;region_id
        $region = $_GET['region_id'];
        $result = common_request('http://api.vk.com/method/database.getCities?v=5.5&need_all=0&country_id='.$country.'&region_id='.$region.$search);
        $items = $result['response']['items'];
        return $items;
    }

    function geolocation_regions($dbConnect, $CONSTPath) {
        $search = $_GET['search'];
        $country = $_GET['country_id'] ? $_GET['country_id'] : 1;
        $filter = '';
        $params = array();

        if ($search) {
            $filter .= ' AND name LIKE :search';
            $params['search'] = $search.'%';
        }

        $filter .= ' AND geo_country = :country';
        $params['country'] = $country;


        $ds = common_getlist($dbConnect, '
        SELECT
          id, name AS title, code
        FROM
          geo_region
        WHERE TRUE ' . $filter . ' ORDER BY name
        ', $params);
        return $ds;
    }

    function geolocation_countries($dbConnect, $CONSTPath) {
        $search = $_GET['search'];

        if ($search) {
            $filter = ' AND name LIKE :search';
            $params = array(
                'search' => $search.'%'
            );
        }
        else {
            $filter = ' AND main = 1';
            $params = array();
        }

        $ds = common_getlist($dbConnect, '
        SELECT
          id, name AS title, name_en AS title_en
        FROM
          geo_country
        WHERE TRUE ' . $filter . ' ORDER BY name
        ', $params);
        return $ds;
    }


    function geolocation_addRegion($dbConnect, $id, $title) {
        $queryresult = $dbConnect->prepare('
                        SELECT
                          1
                        FROM
                          geo_region
                        WHERE
                          id = :id
                        LIMIT 1');
        $queryresult->execute(array(
            'id' => $id
        ));
        $data = $queryresult->fetchAll();
        if (!count($data)) {
            $queryresult = $dbConnect->prepare('
                        INSERT INTO
                          geo_region
                        VALUES (:id, :title) ');
            $queryresult->execute(array(
                'id' => $id,
                'title' => $title
            ));
        }
    }

    function geolocation_addCity($dbConnect, $id, $title) {
        $queryresult = $dbConnect->prepare('
                            SELECT
                              1
                            FROM
                              geo_city
                            WHERE
                              id = :id
                            LIMIT 1');
        $queryresult->execute(array(
            'id' => $id
        ));
        $data = $queryresult->fetchAll();
        if (!count($data)) {
            $queryresult = $dbConnect->prepare('
                            INSERT INTO
                              geo_city
                            VALUES (:id, :title) ');
            $queryresult->execute(array(
                'id' => $id,
                'title' => $title
            ));
        }
    }