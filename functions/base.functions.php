<?php
// This function get the company name from an ID
include_once("validation.functions.php");
include_once("system.log.functions.php");
include_once("system.alerts.php");
include_once("check.permission.php");
include_once("alerts.show.php");
include_once("country.codes.php");
require_once("core_security_functions_inc.php");
include_once("message.functions.php");


//Uncomment when not in development mode
include("developer.toolkit.inc.php");


function pb_get_identikey_from_object_id($object_id,$object_type) {

    global $db;
    if ($object_type=="dta") {
        $table_name="dta_registry";
    } else if ($object_type=="assessment") {
        $table_name="assessment_registry";
    } else if ($object_type=="assessment_section") { //including option to delete Section
        $table_name="assessment_section";
    } else if ($object_type=="assessment_question") {
        $table_name="assessment_question";
    } else {
        return false;
    }

    $query="select identikey from $table_name where object_id='$object_id'";
    $statement = $db->prepare($query);

    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

        return $row['identikey'];
    }




}


function pb_get_object_id_from_id($table,$id) {
    // This is used in conjunction with LastID, it returns the object ID for a given ID

    global $db;

    $statement = $db->prepare("select object_id from $table where id = :id");
    $statement->bindParam(':id', $id);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

        return $row['object_id'];
    }



}


// Takes a mysql timestamp and formats it nicely
function pb_format_date($date) {
    return	date("d F Y",strtotime($date));
}

// Outputs a list of items related to an identikey, eg all the assessments for that identikey, uysed to be build select form fields

function pb_uni_list_items($item_type,$identikey) {
    global $db;
    $query="SELECT * from $item_type where identikey='$identikey'";

    $statement = $db->prepare($query);
    $statement->execute();
    $x=0;
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $object_id[$x][0]=$row['object_id'];
        $object_id[$x][1]=$row['title'];
        ++$x;

    }

    $arr[]=$object_id;

    return $arr;
}



// This item will return the title using object_id for any item (specify table using item_type);

function pb_uni_select_item($item_type,$object_id) {
    global $db;
    $query="SELECT title from $item_type where object_id='$object_id' limit 1";

    $statement = $db->prepare($query);
    $statement->execute();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){

        $title=$row['title'];
    }
    return $title;


}

// This function will connect a table and return the specified column value

function pb_uni_check($database_table,$database_column,$id) {
    global $db;
    $query="select $database_column from $database_table where object_id='$id'";

    $statement = $db->prepare($query);
    $statement->execute();

    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        $database_column_value=$row[$database_column];
    }

    return $database_column_value;

}


// This function returns a company name from identikey
function pb_getCompanyNameIdentikey($identikey) {

    global $db;

    $statement = $db->prepare("select company_name from company where company_identikey = :identikey");
    $statement->bindParam(':identikey', $identikey);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        return $row['company_name'];
    }

}

function pb_build_breadcrumbs($breadcrumbs) {

    if ($breadcrumbs) {
        while (list($key, $value) = each($breadcrumbs)) {
            if ($value) {
                echo "<li><a href='$value'>$key</a><i class='fa fa-angle-right'></i></li>";
            } else {
                echo "<li><span>$key</span></li>";
            }
        }
    }


}

function pb_getCompanyName($id) {
// No longer used

    global $db;
    $statement = $db->prepare("select company_name from company where id = :id");
    $statement->bindParam(':id', $id);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        return $row['company_name'];
    }

}

// This gets a companys name from session (identikey)
function pb_getCompanyNamefromSession() {

    global $db;
    $identikey=$_SESSION['s_identikey'];

    if (!$identikey) {
        echo "Security Violation: Invalid 21 Code";
        exit;

    }
    $statement = $db->prepare("select company_name from company where company_identikey = :identikey");
    $statement->bindParam(':identikey', $identikey);
    $statement->execute();
    while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
        return $row['company_name'];
    }

}

function pb_getUserModules($user) {

    global $db;
    $statement = $db->prepare("select * from access_users where userid = :user");
    $statement->bindParam(':user', $user);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    return $row;


}

function pb_resultsPagination($query,$limit,$start,$pid,$mode="") {

    global $s_current_page;

    if ($mode=="ext") {
        global $ext_db;
        $db=$ext_db;
    } else {
        global $db;
    }

    ?>
    <nav>
    <ul class="pagination">
    <?php

    $rows = $db->query($query)->fetchColumn();
    //calculate total page number for the given table in the database

    $total=ceil($rows/$limit);
    //echo "<pre>$rows</pre>";
    //echo "<pre>$limit</pre>";
    //echo "<pre>$total</pre>";
    //only shows pagination if there is more than 1 page
    if ($total > 1) {
        if (strpos($s_current_page, "pid") === false) {
            if(strpos($s_current_page,"?")){
                $s_current_page = $s_current_page . "&pid=1" ; 
            } else {
                $s_current_page = $s_current_page . "?pid=1"; 
            }
        }

        if ($pid > 1) {
            //Go to previous page to show previous 10 items. If its in page 1 then it is inactive
            $hold = str_replace("pid=" . $pid, "pid=" . ($pid - 1), $s_current_page);

            //echo "<a href='$hold' class='button'>PREVIOUS</a>";

            echo "<li class='page-item'><a class='page-link' href='$hold'><i class='fa fa-angle-left'></i></a></li>";

        } else {

            $hold = str_replace("pid=" . $pid, "pid=" . ($pid - 1), $s_current_page);

            //    echo "<a href='$hold' class='button'>PREVIOUS</a>";
            echo "<li class='page-item disabled'><a class='page-link' href=''><i class='fa fa-angle-left'></i></a></li>";

        }


        //show all the page link with page number. When click on these numbers go to particular page.
        for ($i = 1; $i <= $total; $i++) {

            if ($i == $pid) {
                //  echo "<li class='current'>".$i."</li>";

                echo "<li class='page-item active'><a class='page-link' href='$hold'> " . $i . " </a></li>";

            } else {
                $hold = str_replace("pid=" . $pid, "pid=" . $i, $s_current_page);
                //echo "<li><a href='$hold'>".$i."</a></li>";
                echo "<li class='page-item'><a class='page-link' href='$hold'>$i</a></li>";
            }
        }

        if ($pid != $total) {
            ////Go to previous page to show next 10 items.
            $hold = str_replace("pid=" . $pid, "pid=" . ($pid + 1), $s_current_page);

            //  echo "<a href='$hold' class='button'>NEXT</a>";
            echo "<li class='page-item'><a class='page-link' href='$hold'><i class='fa fa-angle-right'></i></a></li>";
        }

        ?>
        </ul>
        </nav>



        <?php
    }
}



function pb_list_countries() {

    $countries = array
    (
        'AF' => 'Afghanistan',
        'AX' => 'Aland Islands',
        'AL' => 'Albania',
        'DZ' => 'Algeria',
        'AS' => 'American Samoa',
        'AD' => 'Andorra',
        'AO' => 'Angola',
        'AI' => 'Anguilla',
        'AQ' => 'Antarctica',
        'AG' => 'Antigua And Barbuda',
        'AR' => 'Argentina',
        'AM' => 'Armenia',
        'AW' => 'Aruba',
        'AU' => 'Australia',
        'AT' => 'Austria',
        'AZ' => 'Azerbaijan',
        'BS' => 'Bahamas',
        'BH' => 'Bahrain',
        'BD' => 'Bangladesh',
        'BB' => 'Barbados',
        'BY' => 'Belarus',
        'BE' => 'Belgium',
        'BZ' => 'Belize',
        'BJ' => 'Benin',
        'BM' => 'Bermuda',
        'BT' => 'Bhutan',
        'BO' => 'Bolivia',
        'BA' => 'Bosnia And Herzegovina',
        'BW' => 'Botswana',
        'BV' => 'Bouvet Island',
        'BR' => 'Brazil',
        'IO' => 'British Indian Ocean Territory',
        'BN' => 'Brunei Darussalam',
        'BG' => 'Bulgaria',
        'BF' => 'Burkina Faso',
        'BI' => 'Burundi',
        'KH' => 'Cambodia',
        'CM' => 'Cameroon',
        'CA' => 'Canada',
        'CV' => 'Cape Verde',
        'KY' => 'Cayman Islands',
        'CF' => 'Central African Republic',
        'TD' => 'Chad',
        'CL' => 'Chile',
        'CN' => 'China',
        'CX' => 'Christmas Island',
        'CC' => 'Cocos (Keeling) Islands',
        'CO' => 'Colombia',
        'KM' => 'Comoros',
        'CG' => 'Congo',
        'CD' => 'Congo, Democratic Republic',
        'CK' => 'Cook Islands',
        'CR' => 'Costa Rica',
        'CI' => 'Cote D\'Ivoire',
        'HR' => 'Croatia',
        'CU' => 'Cuba',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'DJ' => 'Djibouti',
        'DM' => 'Dominica',
        'DO' => 'Dominican Republic',
        'EC' => 'Ecuador',
        'EG' => 'Egypt',
        'SV' => 'El Salvador',
        'GQ' => 'Equatorial Guinea',
        'ER' => 'Eritrea',
        'EE' => 'Estonia',
        'ET' => 'Ethiopia',
        'FK' => 'Falkland Islands (Malvinas)',
        'FO' => 'Faroe Islands',
        'FJ' => 'Fiji',
        'FI' => 'Finland',
        'FR' => 'France',
        'GF' => 'French Guiana',
        'PF' => 'French Polynesia',
        'TF' => 'French Southern Territories',
        'GA' => 'Gabon',
        'GM' => 'Gambia',
        'GE' => 'Georgia',
        'DE' => 'Germany',
        'GH' => 'Ghana',
        'GI' => 'Gibraltar',
        'GR' => 'Greece',
        'GL' => 'Greenland',
        'GD' => 'Grenada',
        'GP' => 'Guadeloupe',
        'GU' => 'Guam',
        'GT' => 'Guatemala',
        'GG' => 'Guernsey',
        'GN' => 'Guinea',
        'GW' => 'Guinea-Bissau',
        'GY' => 'Guyana',
        'HT' => 'Haiti',
        'HM' => 'Heard Island & Mcdonald Islands',
        'VA' => 'Holy See (Vatican City State)',
        'HN' => 'Honduras',
        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
        'IS' => 'Iceland',
        'IN' => 'India',
        'ID' => 'Indonesia',
        'IR' => 'Iran, Islamic Republic Of',
        'IQ' => 'Iraq',
        'IE' => 'Ireland',
        'IM' => 'Isle Of Man',
        'IL' => 'Israel',
        'IT' => 'Italy',
        'JM' => 'Jamaica',
        'JP' => 'Japan',
        'JE' => 'Jersey',
        'JO' => 'Jordan',
        'KZ' => 'Kazakhstan',
        'KE' => 'Kenya',
        'KI' => 'Kiribati',
        'KR' => 'Korea',
        'KW' => 'Kuwait',
        'KG' => 'Kyrgyzstan',
        'LA' => 'Lao People\'s Democratic Republic',
        'LV' => 'Latvia',
        'LB' => 'Lebanon',
        'LS' => 'Lesotho',
        'LR' => 'Liberia',
        'LY' => 'Libyan Arab Jamahiriya',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
        'MO' => 'Macao',
        'MK' => 'Macedonia',
        'MG' => 'Madagascar',
        'MW' => 'Malawi',
        'MY' => 'Malaysia',
        'MV' => 'Maldives',
        'ML' => 'Mali',
        'MT' => 'Malta',
        'MH' => 'Marshall Islands',
        'MQ' => 'Martinique',
        'MR' => 'Mauritania',
        'MU' => 'Mauritius',
        'YT' => 'Mayotte',
        'MX' => 'Mexico',
        'FM' => 'Micronesia, Federated States Of',
        'MD' => 'Moldova',
        'MC' => 'Monaco',
        'MN' => 'Mongolia',
        'ME' => 'Montenegro',
        'MS' => 'Montserrat',
        'MA' => 'Morocco',
        'MZ' => 'Mozambique',
        'MM' => 'Myanmar',
        'NA' => 'Namibia',
        'NR' => 'Nauru',
        'NP' => 'Nepal',
        'NL' => 'Netherlands',
        'AN' => 'Netherlands Antilles',
        'NC' => 'New Caledonia',
        'NZ' => 'New Zealand',
        'NI' => 'Nicaragua',
        'NE' => 'Niger',
        'NG' => 'Nigeria',
        'NU' => 'Niue',
        'NF' => 'Norfolk Island',
        'MP' => 'Northern Mariana Islands',
        'NO' => 'Norway',
        'OM' => 'Oman',
        'PK' => 'Pakistan',
        'PW' => 'Palau',
        'PS' => 'Palestinian Territory, Occupied',
        'PA' => 'Panama',
        'PG' => 'Papua New Guinea',
        'PY' => 'Paraguay',
        'PE' => 'Peru',
        'PH' => 'Philippines',
        'PN' => 'Pitcairn',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'PR' => 'Puerto Rico',
        'QA' => 'Qatar',
        'RE' => 'Reunion',
        'RO' => 'Romania',
        'RU' => 'Russian Federation',
        'RW' => 'Rwanda',
        'BL' => 'Saint Barthelemy',
        'SH' => 'Saint Helena',
        'KN' => 'Saint Kitts And Nevis',
        'LC' => 'Saint Lucia',
        'MF' => 'Saint Martin',
        'PM' => 'Saint Pierre And Miquelon',
        'VC' => 'Saint Vincent And Grenadines',
        'WS' => 'Samoa',
        'SM' => 'San Marino',
        'ST' => 'Sao Tome And Principe',
        'SA' => 'Saudi Arabia',
        'SN' => 'Senegal',
        'RS' => 'Serbia',
        'SC' => 'Seychelles',
        'SL' => 'Sierra Leone',
        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'SB' => 'Solomon Islands',
        'SO' => 'Somalia',
        'ZA' => 'South Africa',
        'GS' => 'South Georgia And Sandwich Isl.',
        'ES' => 'Spain',
        'LK' => 'Sri Lanka',
        'SD' => 'Sudan',
        'SR' => 'Suriname',
        'SJ' => 'Svalbard And Jan Mayen',
        'SZ' => 'Swaziland',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
        'SY' => 'Syrian Arab Republic',
        'TW' => 'Taiwan',
        'TJ' => 'Tajikistan',
        'TZ' => 'Tanzania',
        'TH' => 'Thailand',
        'TL' => 'Timor-Leste',
        'TG' => 'Togo',
        'TK' => 'Tokelau',
        'TO' => 'Tonga',
        'TT' => 'Trinidad And Tobago',
        'TN' => 'Tunisia',
        'TR' => 'Turkey',
        'TM' => 'Turkmenistan',
        'TC' => 'Turks And Caicos Islands',
        'TV' => 'Tuvalu',
        'UG' => 'Uganda',
        'UA' => 'Ukraine',
        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
        'US' => 'United States',
        'UM' => 'United States Outlying Islands',
        'UY' => 'Uruguay',
        'UZ' => 'Uzbekistan',
        'VU' => 'Vanuatu',
        'VE' => 'Venezuela',
        'VN' => 'Viet Nam',
        'VG' => 'Virgin Islands, British',
        'VI' => 'Virgin Islands, U.S.',
        'WF' => 'Wallis And Futuna',
        'EH' => 'Western Sahara',
        'YE' => 'Yemen',
        'ZM' => 'Zambia',
        'ZW' => 'Zimbabwe',
    );

    return $countries;

}
?>
