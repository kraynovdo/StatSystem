<?
//OK
    class usercomp extends BaseController {
        function _list($comp=null, $person=null) {
            $where = ' WHERE type IS NULL';
            $params = array();
            if (!$person) {
                $person = $_GET['person'];
            }
            if (!$comp) {
                $comp = $_GET['comp'];
            }
            if ($person) {
                $where .= ' AND person = :person';
                $params['person'] = $person;
            }
            if ($comp) {
                $where .= ' AND competition = :comp';
                $params['comp'] = $comp;
            }

            $dataset = $this->_getlist('
                SELECT UR.id, C.name, C.id as comp, S.yearB, S.yearE, C.link
                FROM usercomp UR LEFT JOIN competition C ON C.id = UR.competition
                LEFT JOIN season S ON S.id = C.season'. $where. ' ORDER BY S.yearB DESC',
            $params);
            return $dataset;
        }
    }
    function usercomp_list($dbConnect, $CONSTPath, $comp=null, $person=null) {
        $result = array();
        $where = ' WHERE type IS NULL';
        $params = array();
        if (!$person) {
            $person = $_GET['person'];
        }
        if (!$comp) {
            $comp = $_GET['comp'];
        }
        if ($person) {
            $where .= ' AND person = :person';
            $params['person'] = $person;
        }
        if ($comp) {
            $where .= ' AND competition = :comp';
            $params['comp'] = $comp;
        }

        $queryresult = $dbConnect->prepare('
            SELECT UR.id, C.name, C.id as comp, S.yearB, S.yearE, C.link
            FROM usercomp UR LEFT JOIN competition C ON C.id = UR.competition
            LEFT JOIN season S ON S.id = C.season'. $where. ' ORDER BY S.yearB DESC');
        $queryresult->execute($params);
        $dataset = $queryresult->fetchAll();

        return $dataset;
    }