<?php

use Illuminate\Support\Facades\Http;

function getPriorityText($value): string
{
    $priority_options = json_decode(config('generic.DAK_PRIORITY_TYPE'), true);
    $daak_priority_text = "";
    if (isset($priority_options[intval($value)]) && intval($value) > 0) {
        $daak_priority_text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon-exclamation-square mr-2"></i> ' . $priority_options[intval($value)] . '</div>';
    }
    return $daak_priority_text;
}

function getSecurityText($value): string
{
    $security_options = json_decode(config('generic.DAK_SECRECY_TYPE'), true);
    $icon = "";

    if ($security_options[intval($value)] == "অতি গোপনীয়") {
        $icon = "fad fa-shield";
    } else if ($security_options[intval($value)] == "বিশেষ গোপনীয়") {
        $icon = "fad fa-shield-alt";
    } else if ($security_options[intval($value)] == "গোপনীয়") {
        $icon = "far fa-shield-alt";
    } else if ($security_options[intval($value)] == "সীমিত") {
        $icon = "fad fa-badge-sheriff";
    }
    $daak_security_text = "";
    if (isset($security_options[intval($value)]) && intval($value) > 0) {
        $daak_security_text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon-lifebuoy' . $icon . ' mr-2"></i> ' . $security_options[intval($value)] . '</div>';
    }
    return $daak_security_text;
}

function getAttentionTypeText($value): string
{
    $text = "";
    if (intval($value) == 0) {
        $text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon2-copy mr-2"></i>' . __("CC ") . '</div>';
    } else if (intval($value) == 2) {
        $text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon2-copy mr-2"></i>' . __('') . '</div>';
    } else {
        $text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon2-copy mr-2"></i> ' . __('Recipient ') .
            '</div>';
    }
    return $text;
}

function getApplicationOriginText($value): string
{
    $text = "";
    if (strtoupper($value) != 'NOTHI') {
        $text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon-lifebuoy mr-2"></i> ' . strtoupper($value) . '</div>';
    }
    return $text;
}

function getDakOriginText($value): string
{
    $text = "";
    if (intval($value) == 1) {
        $text = '<div class="ml-3  d-flex align-items-center"><i class="flaticon-upload-1 mr-2"></i> ' . __("পত্রজারি") . '</div>';
    } else {
        $text = ''; //'<div class="ml-3  d-flex align-items-center"><i class="flaticon-upload-1 mr-2"></i> ' . __("আপলোডকৃত ডাক") . '</div>';
    }
    return $text;
}

function getDakTypeText($value): string
{
    if ($value == config('generic.DAK_NAGORIK')) {
        $daak_type_text = '<div class="ml-3  d-flex align-items-center"><i class="fa fa-user mr-1"></i>' . __('নাগরিক') . '</div>';
    } else {
        $daak_type_text = ''; //'<div class="ml-3  d-flex align-items-center"><i class="fa fa-building mr-1"></i>' . __('দাপ্তরিক') . '</div>';
    }
    return $daak_type_text;
}

function base64_url_encode($val): string
{
    return strtr(base64_encode($val), '+/=', '-_,');
}

function base64_url_decode($val): string
{
    return base64_decode(strtr($val, '-_,', '+/='));
}

function isJson($string): bool
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function json_encode_unicode($string)
{
    return json_encode($string, JSON_UNESCAPED_UNICODE);
}

function getLoginTokenParams(): array
{
    return [
        'device_id' => 'did',
        'device_type' => 'dt',
        'username' => 'un',
        'employee_record_id' => 'eri',
        'user_id' => 'ui',
        'designations' => 'map',
    ];
}

function responseFormat($status = 'error', $data = '', $options = []): array
{
    $response = [''];
    if (!empty($status)) {
        if ($status == 'success') {
            $response = [
                'status' => $status,
                'data' => $data
            ];
        } elseif ($status == 'error') {
            $response = [
                'status' => $status,
                'message' => $data
            ];
            if (!empty($options) && !empty($options['details'])) {
                $response['details'] = $options['details'];
            }
            if (!empty($options) && !empty($options['reason'])) {
                $response['reason'] = $options['reason'];
            }
        }
        if (!empty($options) && !empty($options['code'])) {
            $response['code'] = $options['code'];
        }
    }
    return $response;
}

function isSuccessResponse($response): bool
{
    if (!empty($response)) {
        if (isset($response['status']) && $response['status'] == 'success') {
            return true;
        } elseif (isset($response['status']) && $response['status'] == 'error') {
            return false;
        }
    }
    return false;
}

function singleDataToArr($data): array
{
    return is_array($data) ? $data : [$data];
}

function getBrowser(): array
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version = "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    } elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    } elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    } elseif (preg_match('/Firefox/i', $u_agent)) {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    } elseif (preg_match('/OPR/i', $u_agent)) {
        $bname = 'Opera';
        $ub = "Opera";
    } elseif (preg_match('/Chrome/i', $u_agent)) {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    } elseif (preg_match('/Safari/i', $u_agent)) {
        $bname = 'Apple Safari';
        $ub = "Safari";
    } elseif (preg_match('/Netscape/i', $u_agent)) {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
            $version = $matches['version'][0];
        } else {
            $version = $matches['version'][1];
        }
    } else {
        $version = $matches['version'][0];
    }

    // check if we have a number
    if ($version == null || $version == "") {
        $version = "?";
    }

    return array(
        'userAgent' => $u_agent,
        'name' => $bname,
        'version' => $version,
        'platform' => $platform,
        'pattern' => $pattern
    );
}

function getIP(): string
{
    $ip = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function enTobn($value)
{
    $bn = array("১", "২", "৩", "৪", "৫", "৬", "৭", "৮", "৯", "০");
    $en = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");

    return str_replace($en, $bn, $value);
}

if (!function_exists('dateEnToBn')) {
    function dateEnToBn($value)
    {
        $currentDate = date("d/m/Y h:i A", strtotime($value));
        $engDATE = array('1', '2', '3', '4', '5', '6', '7', '8', '9', '0', 'January', 'February', 'March', 'April',
            'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December', 'Saturday', 'Sunday',
            'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'AM', 'PM');
        $bangDATE = array('১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯', '০', 'জানুয়ারী', 'ফেব্রুয়ারী', 'মার্চ', 'এপ্রিল', 'মে',
            'জুন', 'জুলাই', 'আগস্ট', 'সেপ্টেম্বর', 'অক্টোবর', 'নভেম্বর', 'ডিসেম্বর', 'শনিবার', 'রবিবার', 'সোমবার', 'মঙ্গলবার', '
বুধবার', 'বৃহস্পতিবার', 'শুক্রবার', 'পূর্বাহ্ণ', 'অপরাহ্ন'
        );
        $convertedDATE = str_replace($engDATE, $bangDATE, $currentDate);
        return $convertedDATE;
    }
}

function bnToen($value)
{
    // dd($value);
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    return $output = str_replace($bn_digits, range(0, 9), $value);
}

function digit_replace($value)
{
    $bn_digits = array('০', '১', '২', '৩', '৪', '৫', '৬', '৭', '৮', '৯');
    $en_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');

    if (in_array($value, $en_digits)) {
        return $value;
    } else {
        return $output = str_replace($bn_digits, range(0, 9), $value);
    }

}

function get_file_type($file_path): string
{
    switch (strtolower(pathinfo($file_path, PATHINFO_EXTENSION))) {
        case 'jpeg':
        case 'jpg':
            return 'image/jpeg';
        case 'png':
            return 'image/png';
        case 'gif':
            return 'image/gif';
        case 'bmp':
            return 'image/bmp';
        case 'pdf':
            return 'application/pdf';
        case 'doc':
            return 'application/msword';
        case 'docx':
            return 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
        case 'xls':
            return 'application/vnd.ms-excel';
        case 'xlsx':
            return 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';
        case 'ppt':
            return 'application/vnd.ms-powerpoint';
        case 'pptx':
            return 'application/vnd.openxmlformats-officedocument.presentationml.presentation';
        default:
            return 'application/octet-stream';
    }
}

function generateRandomString($length = 8): string
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}


if (!function_exists('generateRandomNum')) {
    function generateRandomNum($length = 4): string
    {
        $generator = "1357902468";
        $result = "";
        for ($i = 1; $i <= $length; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }
}

if (!function_exists('loadTree')) {
    function loadTree($results, $tree_children, $control = false)
    {
        $tree_child = explode('->', $tree_children);
        ?>
        <ul><?php
        foreach ($results as $key => $result) { // bivag
            if (isset($tree_children) && $result[$tree_child[0]]) {
                ?>
                <li>
                    <?php if ($control) { ?>
                    <b style="font-weight: 500 !important;">
                        <?php } ?>
                        <a href="javascript:;" class="mr-3"
                           data-id="<?php echo $result->id ?>"><?php echo $result->name_bng ?></a>
                        <?php if ($control) { ?>
                            <a href="javascript:;" onclick="Edit(<?= $result->id ?>)"><span
                                    class="mr-1 fas fa-edit"></span></a>
                            <a href="javascript:;" onclick="addNew(<?= $result->id ?>);"><span
                                    class="mr-1 fas fa-plus"></span></a>
                            <a href="javascript:;" onclick="Delete(<?= $result->id ?>);"><span
                                    class="fas fa-trash"></span></a>
                        <?php } ?>
                        <?php if ($control) { ?>
                    </b>
                <?php } ?>
                    <ul>
                        <?php
                        loadTreeLi($result, $tree_child, 0, $control);
                        ?>
                    </ul>
                </li>
                <?php
            } else {
                ?>
                <li data-jstree=''>
                    <?php if ($control) { ?>
                    <b style="font-weight: 500 !important;">
                        <?php } ?>
                        <a href="javascript:;" class="mr-3"
                           data-id="<?php echo $result->id ?>"><?php echo $result->name_bng ?></a>
                        <?php if ($control) { ?>
                            <a href="javascript:;" onclick="Edit(<?= $result->id ?>)"><span
                                    class="mr-1 fas fa-edit"></span></a>
                            <a href="javascript:;" onclick="addNew(<?= $result->id ?>);"><span
                                    class="mr-1 fas fa-plus"></span></a>
                            <a href="javascript:;" onclick="Delete(<?= $result->id ?>);"><span
                                    class="fas fa-trash"></span></a>
                        <?php } ?>
                        <?php if ($control) { ?>
                    </b>
                <?php } ?>
                </li>
                <?php
            }
        }
        ?>
        </ul><?php
    }
}

if (!function_exists('loadTreeLi')) {
    function loadTreeLi($results, $tree_child, $recurring_position = 0, $control = false)
    {
        if (isset($tree_child[$recurring_position]) && $results[$tree_child[$recurring_position]]) {
            foreach ($results[$tree_child[$recurring_position]] as $key => $result) {
                $new_recurring_position = $recurring_position;
                $new_recurring_position++;
                if (isset($tree_child[$new_recurring_position]) && $result[$tree_child[$new_recurring_position]]) {
                    ?>
                    <li>
                        <?php if ($control) { ?>
                        <b style="font-weight: 500 !important;">
                            <?php } ?>
                            <a href="javascript:;" class="mr-3"
                               data-id="<?php echo $result->id ?>"><?php echo $result->name_bng ?></a>
                            <?php if ($control) { ?>
                                <a href="javascript:;" onclick="Edit(<?= $result->id ?>)"><span
                                        class="mr-1 fas fa-edit"></span></a>
                                <a href="javascript:;" onclick="addNew(<?= $result->id ?>);"><span
                                        class="mr-1 fas fa-plus"></span></a>
                                <a href="javascript:;" onclick="Delete(<?= $result->id ?>);"><span
                                        class="fas fa-trash"></span></a>
                            <?php } ?>
                            <?php if ($control) { ?>
                        </b>
                    <?php } ?>
                        <ul><?php
                            loadTreeLi($result, $tree_child, $new_recurring_position, $control);
                            ?>
                        </ul>
                    </li>
                    <?php
                } else {
                    ?>
                    <li data-jstree=''>

                        <?php if ($control) { ?>
                        <b style="font-weight: 500 !important;">
                            <?php } ?>
                            <a href="javascript:;" class="mr-3"
                               data-id="<?php echo $result->id ?>"><?php echo $result->name_bng ?></a>
                            <?php if ($control) { ?>
                                <a href="javascript:;" onclick="Edit(<?= $result->id ?>)"><span
                                        class="mr-1 fas fa-edit"></span></a>
                                <a href="javascript:;" onclick="addNew(<?= $result->id ?>);"><span
                                        class="mr-1 fas fa-plus"></span></a>
                                <a href="javascript:;" onclick="Delete(<?= $result->id ?>);"><span
                                        class="fas fa-trash"></span></a>
                            <?php } ?>
                            <?php if ($control) { ?>
                        </b>
                    <?php } ?>
                    </li>
                    <?php
                }
            }
        }
    }
}

if (!function_exists('loadTreeMultiple')) {
    function loadTreeMultiple($results, $tree_children, $plus_button = false, $opened_node = [])
    {
        ?>
        <ul><?php
        foreach ($results as $key => $result) { // bivag
            loadTreeMultipleLi($result, $tree_children, $plus_button, $opened_node);
        }
        ?></ul><?php
    }
}

if (!function_exists('loadTreeMultipleLi')) {
    function loadTreeMultipleLi($results, $tree_child, $plus_button = false, $opened_node = [])
    {

        if (isset($tree_child)) {
            $plus_button_part = [0, 0];
            if ($plus_button) {
                $plus_button_part = explode(':', $plus_button);
            }
            $tree_child_part = explode(':', $tree_child);
            $unit_node = "unit_" . $results->origin_id . "_" . $results->id;
            $designation_node = "designation_" . $results->origin_id . "_" . $results->id;
            $branch_node = "branch_" . $results->origin_id . "_" . $results->id;

            $unit_jstree_option = '';
            $designation_jstree_option = '{ "icon" : "fa fa-users"';

            $branch_jstree_option = '{ "icon" : "fa fa-home"';

            if (in_array($unit_node, $opened_node)) {
                $unit_jstree_option = '{"opened":true}';
            }

            if (in_array($designation_node, $opened_node)) {
                $designation_jstree_option .= ',"opened":true';
            }

            if (in_array($branch_node, $opened_node)) {
                $branch_jstree_option .= ',"opened":true';
            }

            $designation_jstree_option .= '}';
            $branch_jstree_option .= '}';
            ?>
            <li data-jstree='<?= $unit_jstree_option ?>'>
                <a href="javascript:;" data-rel="<?= $unit_node ?>" data-origin-id="<?php echo $results->origin_id ?>"
                   data-id="<?php echo $results->id ?>"><?php echo $results->name_bng ?></a>
                <ul>
                    <li data-jstree='<?= $designation_jstree_option ?>'>
                        <a href="javascript:;" data-rel="<?= $designation_node ?>"><?php echo 'পদবি' ?></a>
                        <ul>
                            <?php
                            if (isset($tree_child_part[1]) && $results[$tree_child_part[1]]) {
                                // dd($results[$tree_child_part[1]]);
                                if ($plus_button_part[1] == 1) {
                                    ?>
                                    <li data-jstree='{"icon":"fa fa-plus-circle"}'>
                                        <a href="javascript:;" data-type="title"
                                           data-unit-id="<?php echo $results->id; ?>">নতুন যোগ করুন </a>
                                    </li>
                                    <?php
                                }
                                foreach ($results[$tree_child_part[1]] as $key => $result) {
                                    $dataJsTree = '{ "icon" : "fa fa-user"}';
                                    if ($tree_child_part[1] == 'originOrganograms') {
                                        $is_exists = $result->getExistsInOfficeUnitOrganograms($results['office_id']);
                                        if ($is_exists) {
                                            $dataJsTree = '{ "icon" : "fa fa-user", "disabled": "true" }';
                                        }
                                    } ?>
                                    <li data-jstree='<?= $dataJsTree ?>' class="podobi">
                                        <?php
                                        if ($tree_child_part[1] == 'originOrganograms') {
                                            if ($is_exists) {
                                                ?>
                                                <span style="color: #0abb87 !important;" href="javascript:;"
                                                      data-type="title" data-id="<?php echo $result->id ?>"
                                                      data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php
                                                    echo $result->name_bng;
                                                    ?></span>
                                                <?php
                                            } else { ?>
                                                <a href="javascript:;" data-type="title"
                                                   data-id="<?php echo $result->id ?>"
                                                   data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php
                                                    echo $result->name_bng;
                                                    ?></a>
                                                <?php
                                            }
                                        } else { ?>
                                            <a href="javascript:;" data-type="title" data-id="<?php echo $result->id ?>"
                                               data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php
                                                echo $result->name_bng;
                                                ?></a>
                                            <?php
                                        }
                                        ?>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li data-jstree='<?= $branch_jstree_option ?>'>
                        <a href="javascript:;" data-rel="<?= $branch_node ?>"><?php echo 'শাখা' ?></a>
                        <ul>
                            <?php
                            if (isset($tree_child_part[0]) && $results[$tree_child_part[0]]) {
                                foreach ($results[$tree_child_part[0]] as $key => $result) {
                                    loadTreeMultipleLi($result, $tree_child, $plus_button, $opened_node);
                                }
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php
        }
    }
}

if (!function_exists('NidVerify')) {
    function NidVerify($dob, $nid)
    {

        $response = Http::get('http://esb.beta.doptor.gov.bd:8280/nid/information?dob=' . $dob . '&nid=' . $nid);
        // dd($response->json());
        if ($response['operationResult']['success'] == false) {
            return false;
        } else {
            return $response;
        }
    }
}

if (!function_exists('loadMenuForRole')) {
    function loadMenuForRole($parentMenus, $control = false)
    {
        foreach ($parentMenus as $value) {
            echo '<div class="col-md-12 pl-0 text-capitalize">'; ?>
            <label>
                <input name="menus[]"
                       type="checkbox"
                       value="<?= $value->id ?> "
                       class="parent_menu"
                       id="parent_<?= $value->id ?> "> <span class="pl-2"><?= $value->menu_name ?></span>
            </label>
            <?php
            if (!$value->children->isEmpty()) {
                loadMenuChild($value);
            }
            echo '</div>';
        }
    }
}

if (!function_exists('loadMenuChild')) {
    function loadMenuChild($value)
    { ?>
        <?php
        foreach ($value->children as $child) {
            echo '        <div class="col-md-12 pl-4 text-capitalize">';
            if ($child->children->isEmpty()) { ?>

                <label><input name="menus[]" type="checkbox"
                              onclick="makeParentChecked(event)"
                              value="<?= $child->id ?> " class="child_menu"
                              data-parent="parent_<?= $value->id ?> "
                              id="child_<?= $child->id ?> "><span class="pl-2"><?= $child->menu_name ?></span>
                </label>
                <br/>
                <?php
            } else { ?>
                <label><input name="menus[]" type="checkbox"
                              onclick="makeParentChecked(event)"
                              value="<?= $child->id ?> " class="child_menu"
                              data-parent="parent_<?= $value->id ?> "
                              id="child_<?= $child->id ?>"><span class="pl-2"><?= $child->menu_name ?></span>
                </label>
                <br/>
                <?php
                loadMenuChild($child);
            }
            echo '</div>';
        }
    }
}

if (!function_exists('loadNavigationMenu')) {
    function loadNavigationMenu($parentMenus, $control = false)
    {
        foreach ($parentMenus as $value) { ?>

            <li class="kt-menu__item  kt-menu__item--submenu"
                aria-haspopup="true" data-ktmenu-submenu-toggle="hover">
                <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
		        	<span class="kt-menu__link-icon">
		        		<i class="<?= $value->menu_icon ?>"></i>
		        	</span>
                    <span class="kt-menu__link-text"> <?= $value->menu_name ?> </span>

                    <i class="kt-menu__ver-arrow la la-angle-right"></i>
                </a>
                <?php
                if (!$value->children->isEmpty()) {
                    loadNavigationMenuSingle($value);
                } ?>
            </li>
            <?php
        }
    }
}

if (!function_exists('loadNavigationMenuSingle')) {
    function loadNavigationMenuSingle($value)
    {
        echo '<div class="kt-menu__submenu "><span class="kt-menu__arrow"></span>
                    <ul class="kt-menu__subnav">';
        foreach ($value->children as $child) {
            if ($child->children->isEmpty()) { ?>
                <li class="kt-menu__item <?php if (request()->is(['' . $child->menu_link . ''])) echo 'kt-menu__item--active' ?>"
                    aria-haspopup="true">
                    <a href="<?= url('' . $child->menu_link . '') ?>" class="kt-menu__link ">
                        <!--<i class="kt-menu__link-bullet kt-menu__link-bullet--line"><span></span></i>-->
                        <span class="kt-menu__link-icon">
                            <i class="<?= $child->menu_icon ?>"></i>
                        </span>
                        <span class="kt-menu__link-text"><?= $child->menu_name ?></span>
                    </a>
                </li>
                <?php
            } else {
                ?>
                <li class="kt-menu__item kt-menu__item--submenu" aria-haspopup="true"
                    data-ktmenu-submenu-toggle="hover">
                    <a href="javascript:;" class="kt-menu__link kt-menu__toggle">
                        <!--<i class="kt-menu__link-bullet kt-menu__link-bullet--dot"> <span></span></i>-->
                        <span class="kt-menu__link-icon">
                            <i class="<?= $child->menu_icon ?>"></i>
                        </span>
                        <span class="kt-menu__link-text">
                        <?= $child->menu_name ?>
                        </span><i class="kt-menu__ver-arrow la la-angle-right"></i>
                    </a>

                    <?php loadNavigationMenuSingle($child); ?>
                </li>
                <?php
            }
        }
        echo '</ul> </div>';
    }
}

if (!function_exists('loadOfficeOriginUnitOrganoTree')) {
    function loadOfficeOriginUnitOrganoTree($results, $tree_children, $plus_button = false)
    {
        ?>
        <ul><?php
        $counter = 1;
        foreach ($results as $key => $result) {
            $counter++;
            loadOfficeOriginUnitOrganoTreeLi($result, $tree_children, $counter, $plus_button);
        }
        ?></ul><?php
    }
}

if (!function_exists('loadOfficeOriginUnitOrganoTreeLi')) {
    function loadOfficeOriginUnitOrganoTreeLi($results, $tree_child, $node_counter, $plus_button = false)
    {
        if (isset($tree_child)) {
            $plus_button_part = [0, 0];
            if ($plus_button) {
                $plus_button_part = explode(':', $plus_button);
            }
            $tree_child_part = explode(':', $tree_child);
            ?>
            <li data-jstree='{"icon":"fa fa-home"}' id="kathamo_<?= $results->id ?>">
                <a href="javascript:;" data-id="<?php echo $results->id ?>"><?php echo $results->name_bng ?></a>
                <ul id="top_node_ul_counter_<?= $results->id ?>">
                    <li data-jstree='{ "icon" : "fa fa-users" }' id="podobi_node_<?= $results->id ?>">
                        <a href="javascript:;" data-id=""><?php echo 'পদবি' ?></a>
                        <ul id="second_node_ul_counter_<?= $node_counter ?>">
                            <?php
                            if (isset($tree_child_part[1]) && $results[$tree_child_part[1]]) {
                                foreach ($results[$tree_child_part[1]] as $key => $podobi) {
                                    ?>
                                    <li data-jstree='{ "icon" : "fa fa-user" }'
                                        id="main_node_counter_<?= $podobi->id ?>"
                                        class="podobi">
                                        <span onclick="return false;"
                                              data-type="title"
                                              data-id="<?php echo $podobi->id ?>"
                                              data-parentchild="<?php echo $podobi->id . '|' .
                                                  $podobi->office_origin_unit_id ?>"
                                              data-unitid="<?php echo $podobi->office_origin_unit_id ?>"
                                        >
                                            <?php echo $podobi->name_bng ?>
                                        </span>
                                        <span onclick="editOfficeOriginUnitOrganogram(event)"
                                              data-type="title"
                                              data-id="<?php echo $podobi->id ?>"
                                              data-unitid="<?php echo $podobi->office_origin_unit_id ?>"
                                              data-parentchild="<?php echo $podobi->id . '|'
                                                  . $podobi->office_origin_unit_id ?>" class="ml-2 fa fa-edit">
                                        </span>
                                        <span onclick="deleteOfficeOriginUnitOrganogram(event)"
                                              data-type="delete"
                                              data-id="<?php echo $podobi->id ?>"
                                              data-unitid="<?php echo $podobi->office_origin_unit_id ?>"
                                              data-parentchild="<?php echo $podobi->id . '|' .
                                                  $podobi->office_origin_unit_id ?>" class="ml-2 fa fa-trash-alt">
                                        </span>
                                    </li>
                                    <?php
                                }
//                                if ($plus_button_part[1] == 1) {
                                ?>
                                <li id="add_designation_to_orgin_unit_<?= $results->id ?>"
                                    data-jstree='{"icon":"fa fa-plus-circle"}'>
                                    <a href="javascript:;" data-type="title"
                                       data-unit-id="<?php echo $results->id; ?>">নতুন যোগ করুন </a>
                                </li>
                                <?php
//                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li id="shakha_node_<?= $results->id ?>" data-jstree='{"icon":"fa fa-home"}'>
                        <a href="javascript:;" data-id=""><?php echo 'শাখা' ?></a>
                        <ul>
                            <?php
                            if (isset($tree_child_part[0]) && $results[$tree_child_part[0]]) {
                                foreach ($results[$tree_child_part[0]] as $key => $result) {
                                    loadOfficeOriginUnitOrganoTreeLi($result, $tree_child, $plus_button);
                                }
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php
        }
    }
}

if (!function_exists('loadOrganogramTreeOnlyViewMultiple')) {
    function loadOrganogramTreeOnlyViewMultiple($results, $tree_children, $plus_button = false)
    {
        ?>
        <ul><?php
        foreach ($results as $key => $result) { // bivag
            loadOrganogramTreeOnlyViewMultipleLi($result, $tree_children, $plus_button);
        }
        ?></ul><?php
    }
}

if (!function_exists('loadOrganogramTreeOnlyViewMultipleLi')) {
    function loadOrganogramTreeOnlyViewMultipleLi($results, $tree_child, $plus_button = false)
    {

        if (isset($tree_child)) {
            $plus_button_part = [0, 0];
            if ($plus_button) {
                $plus_button_part = explode(':', $plus_button);
            }
            $tree_child_part = explode(':', $tree_child);
            // dd($tree_child_part);
            ?>
            <li>
                <a href="javascript:;" data-id="<?php echo $results->id ?>"><?php echo $results->name_bng ?></a>
                <ul>
                    <li data-jstree='{ "icon" : "fa fa-users" }'>
                        <a href="javascript:;" data-id=""><?php echo 'পদবি' ?></a>
                        <ul>
                            <?php
                            if (isset($tree_child_part[1]) && $results[$tree_child_part[1]]) {
                                // dd($results[$tree_child_part[1]]);
                                if ($plus_button_part[1] == 1) {
                                    ?>
                                    <li data-jstree='{"icon":"fa fa-plus-circle"}'>
                                        <a href="javascript:;" data-type="title"
                                           data-unit-id="<?php echo $results->id; ?>">নতুন যোগ করুন </a>
                                    </li>
                                    <?php
                                }
                                foreach ($results[$tree_child_part[1]] as $key => $result) {
                                    ?>
                                    <li data-jstree='{ "icon" : "fa fa-user" }' class="podobi">
                                        <a href="javascript:;" data-type="title" data-id="<?php echo $result->id ?>"
                                           data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php echo $result->name_bng ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </li>
                    <li data-jstree='{ "icon" : "fa fa-home" }'>
                        <a href="javascript:;" data-id=""><?php echo 'শাখা' ?></a>
                        <ul>
                            <?php
                            if (isset($tree_child_part[0]) && $results[$tree_child_part[0]]) {
                                foreach ($results[$tree_child_part[0]] as $key => $result) {
                                    loadOrganogramTreeOnlyViewMultipleLi($result, $tree_child, $plus_button);
                                }
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </li>
            <?php
        }
    }
}

if (!function_exists('loadBase64Image')) {
    function loadBase64Image($image_string)
    {
        $base64_starter = 'data:image';
        if (!\Str::containsAll($image_string, [$base64_starter])) {
            $image = explode(';', $image_string);
            $image_ext = $image[0];
            $image_txt = $image[1];
            return $base64_starter . '/' . $image_ext . ';base64,' . $image_txt;
        } else {
            return $image_string;
        }
    }
}
if (!function_exists('loadOfficeWiseUnitOrganogramTree')) {
    function loadOfficeWiseUnitOrganogramTree($results)
    {
        ?>
        <ul>
            <?php
            foreach ($results as $key => $result) {
                ?>
                <li>
                    <a href="javascript:;" data_type="unit" data_unit_origin_id="<?php echo $result->origin_id ?>"
                       data_unit_id="<?php echo $result->id ?>">
                        <?php echo $result->name_bng ?>
                    </a>
                    <?php
                    loadOfficeWiseUnitOrganogramTreeLi($result);
                    ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
}

if (!function_exists('loadOfficeWiseUnitOrganogramTreeLi')) {
    function loadOfficeWiseUnitOrganogramTreeLi($result)
    {
        ?>
        <ul>
            <?php
            foreach ($result['active_organograms'] as $key => $organogram) {
                ?>
                <li data-jstree='{ "icon" : "fa fa-user" }' class="podobi">
                    <a href="javascript:;" data_unit_id="<?php echo $result->id ?>" data_type="designation"
                       data_designation_id="<?php echo $organogram->id ?>">
                        <?php echo $organogram->name_bng ?>
                    </a>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }

    ?>
    <?php
}

if (!function_exists('loadOfficeOriginUnitTreeHelper')) {
    function loadOfficeOriginUnitTreeHelper($results, $office_id = null, $control = false)
    {
        ?>
        <ul>
            <?php
            foreach ($results as $key => $result) {
                $dataJsTree = '{ "icon" : "fa fa-home"}';
                if ($office_id) {
                    $is_exists = $result->getExistsInOfficeUnit($office_id) > 0;
                    if ($is_exists) {
                        $dataJsTree = '{ "icon" : "fa fa-home", "disabled": "true" }';
                    }
                }
                ?>
                <li data-jstree='<?= $dataJsTree ?>'>
                    <a href="javascript:;" data-type="origin_unit" data-id="<?php echo $result->id ?>">
                        <?php echo $result->name_bng ?>
                    </a>
                    <?php
                    if ($result['child'])
                        loadOfficeOriginUnitTreeLiHelper($result['child'], $office_id, $control);
                    ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }
}


if (!function_exists('loadOfficeOriginUnitTreeLiHelper')) {
    function loadOfficeOriginUnitTreeLiHelper($results, $office_id = null, $control = false)
    {
        ?>
        <ul>
            <?php
            foreach ($results as $key => $result) {
                $dataJsTree = '{ "icon" : "fa fa-home"}';
                if ($office_id) {
                    $is_exists = $result->getExistsInOfficeUnit($office_id) > 0;
                    if ($is_exists) {
                        $dataJsTree = '{ "icon" : "fa fa-home", "disabled": "true" }';
                    }
                }
                ?>
                <li data-jstree='<?= $dataJsTree ?>'>
                    <a href="javascript:;" data-type="origin_unit" data-id="<?php echo $result->id ?>">
                        <?php echo $result->name_bng ?>
                    </a>
                    <?php
                    if ($result['child'])
                        loadOfficeOriginUnitTreeLiHelper($result['child'], $control);
                    ?>
                </li>
                <?php
            }
            ?>
        </ul>
        <?php
    }

    ?>
    <?php
}

function expand_spreadsheet($sheet, $spreadsheet)
{
    // Dynamically spread every column of a spreadsheet
    // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth('30');
    // $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
    $columnIndex = 'A';
    foreach ($sheet->getColumnIterator($columnIndex) as $column) {
        $columnIndex = $column->getColumnIndex();
        $maxWidth = 0;
        foreach ($column->getCellIterator() as $cell) {
            $text = $cell->getValue();
            $width = mb_strlen($text, 'UTF-8');
            $maxWidth = max($maxWidth, $width);
        }
        $spreadsheet->getActiveSheet()->getColumnDimension($columnIndex)->setWidth($maxWidth + 1);
    }
}

if (!function_exists('loadOriginOrganogramTreeForBuilder')) {
    function loadOriginOrganogramTreeForBuilder($results)
    {
        ?>
        <ul><?php
        foreach ($results as $key => $result) {
            loadOriginOrganogramTreeForBuilderLi($result);
        }
        ?></ul><?php
    }
}

if (!function_exists('loadOriginOrganogramTreeForBuilderLi')) {
    function loadOriginOrganogramTreeForBuilderLi($results)
    {

        $plus_button_part = [0, 0];
        $unit_node = "unit_" . $results->origin_id . "_" . $results->id;
        $designation_node = "designation_" . $results->origin_id . "_" . $results->id;
        $branch_node = "branch_" . $results->origin_id . "_" . $results->id;

        $unit_jstree_option = '';
        $designation_jstree_option = '{ "icon" : "fa fa-users"';

        $branch_jstree_option = '{ "icon" : "fa fa-home"';

        $tree_child_part[1] = 'originOrganograms';
        $designation_jstree_option .= '}';
        $branch_jstree_option .= '}';
        ?>
        <li data-jstree='<?= $unit_jstree_option ?>'>
            <a href="javascript:;" data-rel="<?= $unit_node ?>" data-origin-id="<?php echo $results->origin_id ?>"
               data-id="<?php echo $results->id ?>"><?php echo $results->name_bng ?></a>
            <ul>
                <li data-jstree='<?= $designation_jstree_option ?>'>
                    <a href="javascript:;" data-rel="<?= $designation_node ?>"><?php echo 'পদবি' ?></a>
                    <ul>
                        <?php
                        if (isset($tree_child_part[1]) && $results[$tree_child_part[1]]) {
                            // dd($results[$tree_child_part[1]]);
                            if ($plus_button_part[1] == 1) {
                                ?>
                                <li data-jstree='{"icon":"fa fa-plus-circle"}'>
                                    <a href="javascript:;" data-type="title"
                                       data-unit-id="<?php echo $results->id; ?>">নতুন যোগ করুন </a>
                                </li>
                                <?php
                            }
                            foreach ($results[$tree_child_part[1]] as $key => $result) {
                                $dataJsTree = '{ "icon" : "fa fa-user"}';
                                if ($tree_child_part[1] == 'originOrganograms') {
                                    $is_exists = false;
                                    if ($is_exists) {
                                        $dataJsTree = '{ "icon" : "fa fa-user", "disabled": "true" }';
                                    }
                                } ?>
                                <li data-jstree='<?= $dataJsTree ?>' class="podobi">
                                    <?php
                                    if ($tree_child_part[1] == 'originOrganograms') {
                                        if ($is_exists) {
                                            ?>
                                            <span style="color: #0abb87 !important;" href="javascript:;"
                                                  data-type="title" data-id="<?php echo $result->id ?>"
                                                  data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php
                                                echo $result->name_bng;
                                                ?></span>
                                            <?php
                                        } else { ?>
                                            <a href="javascript:;" data-type="title"
                                               data-id="<?php echo $result->id ?>"
                                               data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php
                                                echo $result->name_bng;
                                                ?></a>
                                            <?php
                                        }
                                    } else { ?>
                                        <a href="javascript:;" data-type="title" data-id="<?php echo $result->id ?>"
                                           data-parent-child="<?php echo $result->id . '|' . $result->office_origin_unit_id ?>"><?php
                                            echo $result->name_bng;
                                            ?></a>
                                        <?php
                                    }
                                    ?>
                                </li>
                                <?php
                            }
                        }
                        ?>
                    </ul>
                </li>
                <li data-jstree='<?= $branch_jstree_option ?>'>
                    <a href="javascript:;" data-rel="<?= $branch_node ?>"><?php echo 'শাখা' ?></a>
                    <ul>
                        <?php
                        if (isset($tree_child_part[0]) && $results[$tree_child_part[0]]) {
                            foreach ($results[$tree_child_part[0]] as $key => $result) {
                                loadOriginOrganogramTreeForBuilderLi($result);
                            }
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </li>
        <?php
    }
}

function removeLeadingChar($string, $char = '')
{
    return ltrim($string, $char);
}

function removeLeadingChars($string, $char = [])
{
    foreach ($char as $c) {
        $string = removeLeadingChar($string, $c);
    }
    return $string;
}

function removeTrailingChar($string, $char = '')
{
    return rtrim($string, $char);
}

function removeTrailingChars($string, $char = [])
{
    foreach ($char as $c) {
        $string = removeTrailingChar($string, $c);
    }
    return $string;
}
