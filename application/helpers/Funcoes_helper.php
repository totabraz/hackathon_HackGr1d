<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('set_msg')) {
    function set_msg($msg = NULL)
    {
        $ci = &get_instance();
        $ci->session->set_userdata('aviso', $msg);
    }
}
if (!function_exists('get_msg')) {
    function get_msg($destroy = TRUE)
    {
        $ci = &get_instance();
        $retorno = '<div class="row">';
        $retorno .= '<div class="col-xs-12">';
        $retorno .= $ci->session->userdata('aviso');
        $retorno .= '</div>';
        $retorno .= '</div>';
        if ($destroy) $ci->session->unset_userdata('aviso');
        return $retorno;
    }
}

if (!function_exists('getMsgOk')) {
    function getMsgOk($msg = NULL)
    {
        if (isset($msg)) {
            $startOfAlert = '<div class="alert alert-success alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $endOfAlert = '</div>';
            // Erros recebidos pelo envio. -> com os um estilo pré definido estilos
            $return = $startOfAlert . $msg . $endOfAlert;
            return $return;
        }
    }
}


if (!function_exists('getMsgError')) {
    function getMsgError($msg = NULL)
    {
        if (isset($msg)) {
            $startOfAlert = '<div class="alert alert-error alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $endOfAlert = '</div>';
            // Erros recebidos pelo envio. -> com os um estilo pré definido estilos
            $return = $startOfAlert . $msg . $endOfAlert;
            return $return;
        }
    }
}

if (!function_exists('getMsgInfo')) {
    function getMsgInfo($msg = NULL)
    {
        if (isset($msg)) {
            $startOfAlert = '<div class="alert alert-warning alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>';
            $endOfAlert = '</div>';
            // Erros recebidos pelo envio. -> com os um estilo pré definido estilos
            $return = $startOfAlert . $msg . $endOfAlert;
            return $return;
        }
    }
}


if (!function_exists('globalLogout')) {
    function globalLogout($redirect = 'login')
    {
        // Destroy os dados da sessão
        setSessionnOff();
        set_msg(getMsgError('Você saiu do sistema!'));
        // redirect(base_url(), 'refresh');
        redirect($redirect, 'refresh');
    }
}


if (!function_exists('verificaLogin')) {
    function verificaLogin($redirect = 'login')
    {
        $ci = &get_instance();
        if ($ci->session->userdata('logged') != TRUE) {
            set_msg(getMsgOk('Acesso restrito! <br/> Faça login pra continuar.'));
            redirect($redirect, 'refresh');
        }
    }
}


if (!function_exists('verificaLoginAdmin')) {
    function verificaLoginAdmin($redirect = 'login')
    {
        $ci = &get_instance();
        if (($ci->session->userdata('logged') != TRUE) && (
            ($ci->session->userdata('permission_value') !== PERMISSION_CORRETOR) || ($ci->session->userdata('permission_value') !== PERMISSION_ROOT))) {
            set_msg(getMsgOk('Acesso restrito! <br/> Faça login pra continuar.'));
            redirect($redirect, 'refresh');
        }
    }
}


if (!function_exists('config_upload')) {
    function config_upload($path = './uploads', $types = 'pdf|doc|docx|PDF|DOC|DOCX', $size = 10240)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        return $config;
    }
}


if (!function_exists('config_upload_doc')) {
    function config_upload_doc($path = './uploads', $types = 'pdf|doc|docx|PDF|DOC|DOCX', $size = 10240)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        return $config;
    }
}

if (!function_exists('config_upload_img')) {
    function config_upload_img($path = './uploads', $types = 'png|jpg|jpeg|PNG|JPG|JPEG', $size = 10240)
    {
        $config['upload_path'] = $path;
        $config['allowed_types'] = $types;
        $config['max_size'] = $size;
        return $config;
    }
}

if (!function_exists('htmlToText')) {
    function htmlToText($html = NULL)
    {
        return htmlentities($html);
    }
}

if (!function_exists('textToHtml')) {
    function textToHtml($text = NULL)
    {
        return html_entity_decode($text);
    }
}

if (!function_exists('changeDateToDB')) {
    function changeDateToDB($date = NULL)
    {
        if (isset($date)) {
            if (strpos($date, '-') !== false) {
                $date = explode("-", $date);
                if (strlen($date[2]) > strlen($date[0])) $date = $date[2] . '-' . $date[1] . '-' . $date[0];
                else $date = $date[0] . '-' . $date[1] . '-' . $date[2];
            }
            return $date;
        }
    }
}
if (!function_exists('changeDateFromDB')) {
    function changeDateFromDB($date = NULL)
    {
        if (isset($date)) {
            if (strpos($date, '-') !== false) {
                $date = explode("-", $date);
                if (strlen($date[2]) > strlen($date[0])) $date = $date[0] . '-' . $date[1] . '-' . $date[2];
                else $date = $date[2] . '-' . $date[1] . '-' . $date[0];
            }
            return $date;
        }
    }
}

if (!function_exists('shorterText')) {
    function shorterText($text = '', $chars_limit = 10)
    {
        // Check if length is larger than the character limit
        if (strlen($text) > $chars_limit) {
            // If so, cut the string at the character limit
            $new_text = substr($text, 0, $chars_limit);
            // Trim off white space
            $new_text = trim($new_text);
            // Add at end of text ...
            return $new_text . "...";
        }
        // If not just return the text as is
        else {
            return $text;
        }
    }
}

if (!function_exists('removeSpaces')) {
    function removeSpaces($txtInit = '')
    {
        return rtrim(preg_replace('/\s+/', ' ', $word));
    }
}

if (!function_exists('setSessionnOn')) {
    function setSessionnOn($user)
    {
        // Getting  instance of CI
        $ci = &get_instance();
        $ci->load->library('session');
        // Getting  values
        $login = (isset($user->cpf)) ? $user->cpf : '';
        // Setting values
        $ci->session->set_userdata('logged', TRUE);
        $ci->session->set_userdata('cpf', $cpf);
        $ci->session->set_userdata('name', $fist_name);
    }
}

if (!function_exists('setSessionnOff')) {
    function setSessionnOff()
    {
        // Getting  instance of CI
        $ci = &get_instance();
        $ci->load->library('session');
        // UnSetting values
        $ci->session->unset_userdata('logged');
        $ci->session->unset_userdata('name');
        $ci->session->unset_userdata('user_login');
        $ci->session->unset_userdata('user_email');
    }
}

if (!function_exists('printInfoDump')) {
    function printInfoDump($dados, $txt = '')
    {
        echo '<pre>';
        if ($txt != '') {
            echo $txt;
            echo '<br/>';
            echo '<br/>';
        }
        var_dump($dados);
        echo '</pre>';
    }
}

if (!function_exists('printInfo')) {
    function printInfo($dados)
    {
        echo '<pre>';
        prinr_r($dados);
        echo '</pre>';
    }
}

if (!function_exists('AmIRoot')) {
    function AmIRoot()
    {
        $ci = &get_instance();
        $ci->load->library('session');
        return ($ci->session->userdata('permission_value') == PERMISSION_ROOT);
    }
}

if (!function_exists('isRoot')) {
    function isRoot($permission = 0)
    {
        return ($permission == PERMISSION_ROOT);
    }
}

if (!function_exists('getPermissionValue')) {
    function getPermissionValue($permissionLabel  = PERMISSION_CLIENTE)
    {

        switch ($permissionLabel) {
            case LABEL_ROOT:
                $permission = PERMISSION_ROOT;
                break;

            case LABEL_CORRETOR:
                $permission = PERMISSION_CORRETOR;
                break;

            case LABEL_CLIENTE:
                $permission = PERMISSION_CLIENTE;
                break;

            default:
                $permission = PERMISSION_CLIENTE;
                break;
        }
        return $permission;
    }
}



if (!function_exists('getValueStatus')) {
    function getValueStatus($permissionLabel  = LABEL_NAO_SOLICITADO)
    {
        switch ($permissionLabel) {
            case LABEL_ENVIADO:
            return VALUE_ENVIADO;
            break;
            case LABEL_NAO_SOLICITADO:
            return VALUE_NAO_SOLICITADO;
            break;
            case LABEL_SOLICITADO:
            return VALUE_SOLICITADO;
            break;
            case LABEL_CONFIRMADO:
            return VALUE_CONFIRMADO;
            break;
            case LABEL_NEGADO:
            return VALUE_NEGADO;
            break;
            default:
                $permission = VALUE_NAO_SOLICITADO;
                break;
        }
        return $permission;
    }
}

if (!function_exists('removeBasicWords')) {
    function removeBasicWords($word = '')
    { {
            if (isset($word) && !is_array($word)) {
                $word = rtrim(str_replace(' da ',  ' ', $word));
                $word = rtrim(str_replace(' de ',  ' ', $word));
                $word = rtrim(str_replace(' di ',  ' ', $word));
                $word = rtrim(str_replace(' do ',  ' ', $word));
                $word = rtrim(str_replace(' du ',  ' ', $word));
                $word = rtrim(str_replace(' e ',   ' ', $word));
                $word = rtrim(str_replace(' das ', ' ', $word));
                $word = rtrim(str_replace(' des ', ' ', $word));
                $word = rtrim(str_replace(' dis ', ' ', $word));
                $word = rtrim(str_replace(' dos ', ' ', $word));
                $word = rtrim(str_replace(' dus ', ' ', $word));
                $word = rtrim(preg_replace('/\s+/', ' ', $word));
            }
            return $word;
        }
    }


    if (!function_exists('safeInput')) {
        function safeInput($input)
        {
            if (isset($input) && !is_array($input)) {
                $input = rtrim(str_replace("'", '', $input));
                $input = rtrim(str_replace(';', '', $input));
                $input = rtrim(str_replace('"', '', $input));
                $input = rtrim(str_replace("SELECT", '', $input));
                $input = rtrim(preg_replace('/\s+/', '', $input));
            }
            return $input;
        }
    }
}
