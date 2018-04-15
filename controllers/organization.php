<?php
    function organization_info($dbConnect, $id) {
        return common_getrecord($dbConnect, '
            SELECT
                id, name, `desc`, logo, phone, email, address
            FROM
                organization
            WHERE
                id = :id
        ', array ('id' => $id));
    }

    function organization_edit($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $result = array(
                'answer' => array()
            );
            require_once($_SERVER['DOCUMENT_ROOT'] . $CONSTPath . '/controllers/admin.php');

            $result['navigation'] = admin_navig();

            $result['answer']['org'] = organization_info($dbConnect, $_GET['org']);

            return $result;
        }
        else {
            return 'ERROR-403';
        }
    }

    function organization_update($dbConnect, $CONSTPath) {
        if ($_SESSION['userType'] == 3) {
            $data = common_getrecord($dbConnect, '
                SELECT
                  logo
                FROM
                  organization
                WHERE id = :id', array('id' => $_POST['org']));

            if (count($data)) {
                $oldLogo = $data['logo'];
            }

            $logo = common_loadFile('logo', $CONSTPath);
            if ($logo) {
                if ($oldLogo) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $CONSTPath  . '/upload/' . $oldLogo);
                }
            }
            else {
                $logo = $oldLogo;
            }

            common_query($dbConnect, '
                UPDATE
                  organization
                SET
                  name = :name,
                  `desc` = :desc,
                  logo = :logo,
                  phone = :phone,
                  email = :email,
                  address = :address
                WHERE
                  id = :id
            ', array(
                'id' => $_POST['org'],
                'name' => $_POST['name'],
                'desc' => $_POST['desc'],
                'logo' => $logo,
                'phone' => $_POST['phone'],
                'email' => $_POST['email'],
                'address' => $_POST['address']
            ));

            return array(
                'page' => '/?r=' . $_POST['ret'] . '&comp='.$_POST['comp']
            );
        }
        else {
            return 'ERROR-403';
        }
    }