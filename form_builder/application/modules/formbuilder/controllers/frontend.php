<?php

/**
 * Intranet
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   CVS: $Id: intranet.php, v2.00 2013-11-30 02:52:40 Softdiscover $
 * @link      http://php-form-builder.zigaform.com/
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/**
 * Estimator intranet class
 *
 * @category  PHP
 * @package   PHP_Form_Builder
 * @author    Softdiscover <info@softdiscover.com>
 * @copyright 2013 Softdiscover
 * @license   http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version   Release: 1.00
 * @link      http://php-form-builder.zigaform.com/
 */
class Frontend extends MX_Controller {

    const VERSION = '1.2';

    private $flag_submitted = 0;
    private $form_response = array();
    private $form_rec_msg_summ = '';

    const PREFIX = 'wprofmr_';

    /**
     * Frontend::__construct()
     * 
     * @return 
     */
    function __construct() {

        parent::__construct();
        $this->load->language_alt(model_settings::$db_config['language']);
        $this->template->set('controller', $this);
        $this->load->model('model_fields');
        $this->load->model('model_forms');
        $this->load->model('model_record');
        $this->load->model('visitor/model_visitor');
        
           /*shortcodes*/
        add_shortcode('uifm_wrap', array(&$this, 'shortcode_uifm_recvar_wrap') );
        add_shortcode('uifm_recvar', array(&$this, 'shortcode_uifm_recvar') );
        add_shortcode('uifm_var', array(&$this, 'shortcode_uifm_form_var') );
        
        //check update
        $this->auth->checkupdate();
    }
    
    
   
    
    /**
     * Frontend::index()
     * Get all fields information by form id
     * 
     * @return array
     */
    public function index() {


        $form_id = ($this->input->get('form')) ? $this->input->get('form') : 0;
        $website = 'cmsest';
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        if (!isset($_COOKIE[$website])) {
            $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
            $hash = hash('crc32', md5($ip . $user_agent));
            setcookie($website, $hash, time() + (60 * 60 * 24 * 30), '/');
        } else {
            $hash = $_COOKIE[$website];
        }
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';


        //visitor data
        /*$data3 = array();
        $data3['vis_uniqueid'] = $hash;
        $data3['vis_user_agent'] = $agent;
        $data3['vis_page'] = $_SERVER['REQUEST_URI'];
        $data3['vis_referer'] = $referer;
        $data3['vis_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->db->set($data3);
        $this->db->insert($this->model_visitor->table);*/

        $data = array();
        if ($form_id == 0) {
            $rdata = $this->model_forms->getFormDefault();
            if (empty($rdata)) {
                $forms = $this->model_forms->getListActiveForms();
                if (!empty($forms)) {
                    foreach ($forms as $value) {
                        $rdata = $this->model_forms->getFormById($value->fmb_id);
                        break 1;
                    }
                }
            }
        } else {
            $rdata = $this->model_forms->getFormById($form_id);
        }

        if (!empty($rdata)) {
            $data = array();
            $data['html_content'] = $rdata->fmb_html;
            $data['forms'] = $this->model_forms->getListActiveForms();

            $data['uniqueid'] = $hash;
            //get data from form
            $form_data = $this->model_forms->getFormById_2($rdata->fmb_id);
            $form_data_onsubm = json_decode($form_data->fmb_data2, true);
                
            $onload_scroll = (isset($form_data_onsubm['main']['onload_scroll'])) ? $form_data_onsubm['main']['onload_scroll'] : '1';
                            
            $preload_noconflict = (isset($form_data_onsubm['main']['preload_noconflict'])) ? $form_data_onsubm['main']['preload_noconflict'] : '1';    
                            
            $temp=array();
            $temp['id_form']=$rdata->fmb_id;
            $temp['site_url']=site_url();
            $temp['base_url']=base_url();
            $temp['onload_scroll']=$onload_scroll;
            $temp['preload_noconflict']=$preload_noconflict;
            $data['script'] = $this->load->view('formbuilder/forms/get_code_widget', $temp, true);

            $message = ($this->input->get('message')) ? $this->input->get('message') : '';
            if (!empty($message)) {
                switch ($message) {
                    case 'ppsuccess';
                        $data['message'] = __('paypal success message', 'FRocket_admin');
                        break;
                    case 'pperror';
                        $data['message'] = __('error found while submitting', 'FRocket_admin');
                        break;
                    case 'offlinesuccess';
                        $data['message'] = __('Offline success', 'FRocket_admin');
                        break;
                    default;
                        break;
                }
            }
        }

        $this->template->loadPartial('frontend/layout', 'frontend/index', $data);
    }

    /**
     * Frontend::getform()
     * Get form by form id
     * 
     * @return array
     */
    public function getform() {

        $form_id = ($this->input->post('id')) ? Uiform_Form_Helper::sanitizeInput($this->input->post('id')) : 0;

        $website = 'uiform';
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        if (!isset($_COOKIE[$website])) {
            $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
            $hash = hash('crc32', md5($ip . $user_agent));
            setcookie($website, $hash, time() + (60 * 60 * 24 * 30), '/');
        } else {
            $hash = $_COOKIE[$website];
        }
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';

        //visitor data
        /*$data3 = array();
        $data3['vis_uniqueid'] = $hash;
        $data3['vis_user_agent'] = $agent;
        $data3['vis_page'] = $_SERVER['REQUEST_URI'];
        $data3['vis_referer'] = $referer;
        $data3['vis_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->db->set($data3);
        $this->db->insert($this->model_visitor->table);*/

        $data = array();

        if (intval($form_id) === 0) {
            return;
        } else {


            $rdata = $this->model_forms->getFormById($form_id);
        }

        $response = array();
        if (!empty($rdata)) {
            $response['html_content'] = Uiform_Form_Helper::encodeHex($rdata->fmb_html);
        }
        $data = array();
        $data['json'] = $response;

        $this->load->view('html_view', $data);
    }
    
    public function get_summaryRecord($id_rec){
         
        
        $form_id = (isset($_POST['form_id'])) ? Uiform_Form_Helper::sanitizeInput($_POST['form_id']) : '';
        
        $name_fields = $this->model_record->getNameField($id_rec);
        $form_rec_data = $this->model_record->getFormDataById($id_rec);
        
        $form_data=json_decode($form_rec_data->fmb_data, true);
               
         $name_fields_check = array();
        foreach ($name_fields as $value) {
            $name_fields_check[$value->fmf_uniqueid] = $value->fieldname;
        }
        $data_record = $this->model_record->getRecordById($id_rec);
        $record_user = json_decode($data_record->fbh_data, true);
        $new_record_user = array();
        foreach ($record_user as $key => $value) {
            if (isset($name_fields_check[$key])) {
                $key = $name_fields_check[$key];
            }
                $new_record_user[] = array('field' => $value['label'], 'value' => $value['input']);
        }
        $data=array();
                
        $data['record_info'] = $new_record_user;
        
        $form_summary=$this->load->view('formbuilder/frontend/form_summary',$data,true);
        return $form_summary;
    }
    
    public function shortcode_uifm_recvar_wrap($atts, $content = null) {
              
        $vars = shortcode_atts( array(
            'id'=>"",
            'atr1'=>'input'
        ), $atts );
        
        $result='';
        
        $output=$this->model_formrecords->getFieldOptRecord($vars['id'].'_'.$vars['atr1'],$this->flag_submitted);
        
                if($output!=''){
                    $result = do_shortcode($content);
                }else{
                   $result = '';
                }
        
         return $result;

    }
    
    public function shortcode_uifm_recvar($atts) {
        
        $vars = shortcode_atts( array(
            'id'=>"",
            'atr1'=>'input'
        ), $atts );
        
        $output=$this->model_record->getFieldOptRecord($vars['id'].'_'.$vars['atr1'],$this->flag_submitted);
        
        if($output!=''){
            return $output;
        }else{
            return '';
        }
    }
    
    
    public function shortcode_uifm_form_var($atts) {
        
        $vars = shortcode_atts( array(
            'atr1'=>"0", //source 0=>fmb_data2; 1=>fmb_data
            'atr2'=>"",
            'atr3'=>"",
            'opt'=>"" //quick option
        ), $atts );
        $output='';
        
        $rec_id=$this->flag_submitted;
        $data=$this->model_record->getFormDataById($rec_id);
        if(!empty($vars['opt'])){
             switch ((string)$vars['opt']) {
                case "rec_summ":
                     $output=$this->form_rec_msg_summ;
                    break;
                case "rec_url_fm":
                     $output= isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
                    
                    break;
                case "form_name":
                    $output=$data->fmb_name;
                    break;
                case "rec_id":
                    $output=$rec_id;
                    break;
                default:
                
            }
        }else{
            
        }
       
        
        //get data from form
                
                
        
        
        if($output!=''){
            return $output;
        }else{
            return '';
        }
    }
    
    
    /**
     * Frontend::ajax_submit_ajaxmode()
     * 
     * @return 
     */
    public function ajax_submit_ajaxmode() {
        $resp = array();
        $resp = $this->process_form();

        if (isset($this->flag_submitted) && intval($this->flag_submitted) > 0) {
            $resp['success'] = (isset($resp['success']))?$resp['success']:0;
            $resp['show_message'] = (isset($resp['show_message'])) ? Uiform_Form_Helper::encodeHex($resp['show_message']) :
                    '<div class="rockfm-alert rockfm-alert-danger"><i class="fa fa-exclamation-triangle"></i> ' . __('Success! your form was submitted', 'frocket_front') . '</div>';
        } else {
            $resp['success'] = 0;
            $resp['show_message'] = '<div class="rockfm-alert rockfm-alert-danger"><i class="fa fa-exclamation-triangle"></i> ' . __('warning! Form was not submitted', 'frocket_front') . '</div>';
        }
        
        $resp['sm_redirect_st'] = $resp['sm_redirect_st'];
        $resp['sm_redirect_url'] = $resp['sm_redirect_url'];
        
        //return data to ajax callback
        header('Content-Type: text/html; charset=UTF-8');
        //return data to ajax callback
        echo json_encode($resp);
        die();
        $data = array();
        $data['json'] = $resp;

        $this->load->view('html_view', $data);
    }

    /**
     * Frontend::ajax_validate_captcha()
     * 
     * @return 
     */
    public function ajax_validate_captcha() {
        $rockfm_code = (isset($_POST['rockfm-code'])) ? Uiform_Form_Helper::sanitizeInput($_POST['rockfm-code']) : '';
        $rockfm_inpcode = (isset($_POST['rockfm-inpcode'])) ? Uiform_Form_Helper::sanitizeInput($_POST['rockfm-inpcode']) : '';
        $resp = array();
        $resp['code'] = $rockfm_code;
        $resp['inpcode'] = $rockfm_inpcode;

        if (!empty($rockfm_code)) {
            $captcha_key = 'Rocketform-' . $_SERVER['HTTP_HOST'];
            $captcha_resp = Uiform_Form_Helper::data_decrypt($rockfm_code, $captcha_key);
            $resp['resp'] = $captcha_resp;
            if ((string) $captcha_resp === (string) ($rockfm_inpcode)) {
                $resp['success'] = true;
            } else {
                $resp['success'] = false;
            }
        } else {
            $resp['success'] = false;
        }

        //return data to ajax callback
        header('Content-Type: text/html; charset=UTF-8');
        echo json_encode($resp);
        die();
    }

    /**
     * Frontend::ajax_refresh_captcha()
     * 
     * @return 
     */
    public function ajax_refresh_captcha() {
        $rkver = (isset($_POST['rkver'])) ? Uiform_Form_Helper::sanitizeInput(trim($_POST['rkver'])) : 0;
        if ($rkver) {
            $rkver = Uiform_Form_Helper::base64url_decode(json_decode($rkver));
            $rkver_arr = json_decode($rkver, true);

            $length = 5;
            $charset = 'abcdefghijklmnpqrstuvwxyz123456789';
            $phrase = '';
            $chars = str_split($charset);

            for ($i = 0; $i < $length; $i++) {
                $phrase .= $chars[array_rand($chars)];
            }
            $captcha_data = array();

            if (isset($rkver_arr['ca_txt_gen'])) {
                $rkver_arr['ca_txt_gen'] = $phrase;
                $captcha_data = $rkver_arr;
            } else {
                $captcha_data['ca_txt_gen'] = $phrase;
            }
            $captcha_options = Uiform_Form_Helper::base64url_encode(json_encode($captcha_data));
            $resp = array();
            $resp['rkver'] = $captcha_options;

            /* generate check code */
            $captcha_key = 'Rocketform-' . $_SERVER['HTTP_HOST'];
            $resp['code'] = Uiform_Form_Helper::data_encrypt($phrase, $captcha_key);

            //return data to ajax callback
            header('Content-Type: text/html; charset=UTF-8');
            echo json_encode($resp);
            die();
        }
    }

    /**
     * Frontend::ajax_check_recaptcha()
     * 
     * @return 
     */
    public function ajax_check_recaptcha() {
        
        modules::run('formbuilder/uifmrecaptcha/front_verify_recaptcha', array());
        
    }

    /**
     * Frontend::process_form()
     * 
     * @return 
     */
    public function process_form() {
        try {
            
             //  upload an image and document options
            $config = array();
            $config['upload_path'] = FCPATH . 'uploads';
            $config['allowed_types'] = 'jpg|png|gif|jpeg|JPG|PNG|GIF|JPEG|pdf|doc|docx|xls|xlsx|zip|rar';
            $config['max_size'] = '2097152'; // 0 = no file size limit
            $config['overwrite'] = false;
            $config['remove_spaces'] = true;
            $this->load->library('upload', $config);
            
            
            $form_id = ($_POST['_rockfm_form_id']) ? Uiform_Form_Helper::sanitizeInput(trim($_POST['_rockfm_form_id'])) : 0;
            $this->current_form_id=$form_id;
                $form_fields = (isset($_POST['uiform_fields']) && $_POST['uiform_fields']) ? array_map(array('Uiform_Form_Helper', 'sanitizeRecursive'), $_POST['uiform_fields']) : array();
                $form_f_tmp = array();
                $form_f_rec_tmp = array();
                 
                $attachment_status=0;
                $attachments = array();  // initialize attachment array 
                //get data from form
                $form_data = $this->model_forms->getFormById_2($form_id);
                $form_data_onsubm = json_decode($form_data->fmb_data2, true);
                $form_data_name = $form_data->fmb_name;
                 
                //process fields
                $message_fields = '';
                $form_errors=array();
                $mail_errors=false;
                
                
                if(!empty($form_fields)){
                    foreach ($form_fields as $key => $value) {
                        $tmp_field_name = $this->model_fields->getFieldNameByUniqueId($key, $form_id);
                        /*for validation only*/
                        switch (intval($tmp_field_name->type)){
                            case 6:
                                /*textbox*/
                            case 28:    
                            case 29:    
                            case 30:    
                                $tmp_fdata= json_decode($tmp_field_name->data,true);
                                if(isset($tmp_fdata['validate']) && isset($tmp_fdata['validate']['typ_val']) && intval($tmp_fdata['validate']['typ_val'])===4){
                                //$mail_replyto=$value;  
                                }
                            break;
                        }

                    /*storing to main array*/
                        
                            switch(intval($tmp_field_name->type)){
                                case 9:
                                    /*checkbox*/
                                case 11:
                                    /*multiselect*/
                                    $tmp_fdata= json_decode($tmp_field_name->data,true);
                                    
                                    $tmp_options = array();
                                    $tmp_field_label=(!empty($tmp_fdata['label']['text']))?$tmp_fdata['label']['text']:$tmp_field_name->fieldname;
                                    $form_f_tmp[$key]['label']=$tmp_field_label;
                                    
                                    /*mail notification*/
                                    $message_fields.='</br>' . $tmp_field_label . ' : </br>';
                                    $message_fields.='<table cellspacing="0" cellpadding="0">';
                                    if (is_array($value)) {
                                        //for records
                                        $tmp_options_rec = array();
                                        foreach ($value as $key2 => $value2) {
                                            $tmp_options_row=array();
                                            $tmp_options_row['label']=isset($tmp_fdata['input2']['options'][$value2]['label'])?$tmp_fdata['input2']['options'][$value2]['label']:'';
                                            $tmp_options_rec[] = $tmp_options_row['label'];
                                        }
                                        $form_f_rec_tmp[$key] = implode('^,^', $tmp_options_rec);
                                        //end for records
                                       
                                        foreach ($value as $key2=>$value2) {
                                            $tmp_options_row=array();
                                            $tmp_options_row['label']=isset($tmp_fdata['input2']['options'][$value2]['label'])?$tmp_fdata['input2']['options'][$value2]['label']:'';
                                             
                                            if(isset($tmp_fdata['input2']['options'][$value2]) && $tmp_fdata['input2']['options'][$value2]){
                                            

                                            /*mail notification*/
                                            $message_fields.='<tr>';
                                                $message_fields.='<td width="20" align="center" valign="top">&bull;</td>';
                                                $message_fields.='<td   align="left" valign="top">' . $tmp_options_row['label'] ;
 

                                                $message_fields.='</td>';
                                                $message_fields.='</tr>';
                                            }

                                            $tmp_options[] = $tmp_options_row;
                                        }
                                    }
                                   
                                    /*saving data to field array*/
                                    $form_f_tmp[$key]['input'] = $tmp_options;
                                     /*mail notification*/
                                    $message_fields.='</table>';
                                    
                                    break;
                               case 8:
                                    /*radiobutton*/      
                               case 10:
                                    /*select*/
                                    
                                    $tmp_fdata= json_decode($tmp_field_name->data,true);
                                    
                                    $tmp_options = array();
                                    $tmp_field_label=(!empty($tmp_fdata['label']['text']))?$tmp_fdata['label']['text']:$tmp_field_name->fieldname;
                                    $form_f_tmp[$key]['label']=$tmp_field_label;
                                    /*mail notification*/
                                    $message_fields.='</br>';
                                    $message_fields.='<table cellspacing="0" cellpadding="0">';
                                    
                                   // foreach ($value as $key2=>$value2) {
                                        $tmp_options_row=array();
                                        $tmp_options_row['label']=isset($tmp_fdata['input2']['options'][$value]['label'])?$tmp_fdata['input2']['options'][$value]['label']:'';
                                        //for records
                                        $form_f_rec_tmp[$key] = $tmp_options_row['label'];
                                        
                                        if(isset($tmp_fdata['input2']['options'][$value])){
                                           
                                           /*mail notification*/
                                           $message_fields.='<tr>';
                                           $message_fields.='<td align="center" valign="top">' . $tmp_field_label.' - '.$tmp_options_row['label'] . '</td>';
                                            $message_fields.='<td width="20" align="center" valign="top"></td>';
                                            $message_fields.='<td   align="left" valign="top">';
                                            
                                           
                                           
                                            $message_fields.='</td>';
                                            $message_fields.='</tr>';
                                        }
                                        
                                        $tmp_options[] = $tmp_options_row;
                                   // }
                                    /*saving data to field array*/
                                    $form_f_tmp[$key]['input'] = $tmp_options;
                                     /*mail notification*/
                                    $message_fields.='</table>';
                                    
                                    break;
                                case 12;
                        /* file input field */
                        case 13;
                            /* image upload */
                            /* file input field */

                            $tmp_fdata = json_decode($tmp_field_name->data, true);
                            $allowedext_default = array('aaaa', 'png', 'doc', 'docx', 'xls', 'xlsx', 'csv', 'txt', 'rtf', 'zip', 'mp3', 'wma', 'wmv', 'mpg', 'flv', 'avi', 'jpg', 'jpeg', 'png', 'gif', 'ods', 'rar', 'ppt', 'tif', 'wav', 'mov', 'psd', 'eps', 'sit', 'sitx', 'cdr', 'ai', 'mp4', 'm4a', 'bmp', 'pps', 'aif', 'pdf');
                            $custom_allowedext = (!empty($tmp_fdata['input16']['extallowed'])) ? array_map('trim', explode(',', $tmp_fdata['input16']['extallowed'])) : $allowedext_default;
                            $custom_maxsize = (!empty($tmp_fdata['input16']['maxsize'])) ? floatval($tmp_fdata['input16']['maxsize']) : 5;
                            $custom_attach_st = (isset($tmp_fdata['input16']['attach_st'])) ? intval($tmp_fdata['input16']['attach_st']) : 0;

                            if (isset($_FILES['uiform_fields']['name'][$key])
                                    && !empty($_FILES['uiform_fields']['name'][$key])) {


                                $fileSize = $_FILES['uiform_fields']['size'][$key];
                                if (floatval($fileSize) > $custom_maxsize * 1024 * 1024) {
                                    $form_errors[]=__('Error! The file exceeds the allowed size of', 'frocket_front').' '.$custom_maxsize.' MB';
                                }
                                /* find attachment max size found */
                                $attachment_status = ($attachment_status < $custom_attach_st) ? $custom_attach_st : $attachment_status;

                                $ext = strtolower(substr($_FILES['uiform_fields']['name'][$key], strrpos($_FILES['uiform_fields']['name'][$key], '.') + 1));
                                if (!in_array($ext, $custom_allowedext)) {
                                    $form_errors[] = __('Error! Type of file is not allowed to upload', 'frocket_front');
                                }
                                if (empty($form_errors)) {
                                    $config['allowed_types'] = implode('|', $allowedext_default);
                                    $config['max_size'] = $custom_maxsize * 1024 * 1024; // 0 = no file size limit
                                    $this->upload->initialize($config);

                                    
                                    $rename = "file_" . md5(uniqid($_FILES['uiform_fields']['name'][$key], true));

                                    $_FILES['uiform_fields']['name'][$key] = $rename . "." . strtolower($ext);

                                      
                                    //attachment
                                    
                                    if (!$this->upload->do_upload2($key)) {
                                        $form_errors[] = __('Error! File not uploaded - '. $this->upload->display_errors('<span>', '</span>'), 'frocket_front');
                                    } else {
                                        $data_upload_files = $this->upload->data();
                                        $image = base_url() . 'uploads/' . $data_upload_files['file_name'];
                                        //getting image uploaed
                                        if(intval($custom_attach_st)===1){
                                            $attachments[] = $data_upload_files['file_path'].$data_upload_files['file_name'];
                                        }
                                        
                                        $form_f_tmp[$key] = $image;
                                        $form_fields[$key] = $image;
                                        
                                         /* mail notification */
                                        $message_fields.='<table cellspacing="0" cellpadding="0">';
                                        $message_fields.='<tr>';
                                        $message_fields.='<td align="center" valign="top">' . $tmp_field_name->fieldname . '</td>';
                                        $message_fields.='<td width="20" align="center" valign="top">:</td>';
                                        $message_fields.='<td  align="left" valign="top"> ' . $form_f_tmp[$key] . '</td>';
                                        $message_fields.='</tr>';
                                        $message_fields.='</table>';
                                        
                                    }
                                    
                                    
                                    
                                   
                                }
                            } else {
                                unset($form_fields[$key]);
                                            $form_f_tmp[$key]['input']='';
                                            $form_f_rec_tmp[$key]='';
                            }
                            break;
                               case 16:
                                    /*slider*/ 
                                case 18:
                                    /*spinner*/    
                                   $tmp_fdata= json_decode($tmp_field_name->data,true);
                                    
                                    $tmp_options = array();
                                    $tmp_field_label=(!empty($tmp_fdata['label']['text']))?$tmp_fdata['label']['text']:$tmp_field_name->fieldname;
                                    $form_f_tmp[$key]['label']=$tmp_field_label;
                                    /*mail notification*/
                                   $message_fields.='</br>';
                                    $message_fields.='<table cellspacing="0" cellpadding="0">';
                                    
                                   // foreach ($value as $key2=>$value2) {
                                        $tmp_options_row=array();
                                        $tmp_options_row['qty']=  floatval($value);
                                           $tmp_options_row['label']=floatval($value);
                                        
                                         
                                           //for records
                                           $form_f_rec_tmp[$key] = $value;
                                           
                                           /*mail notification*/
                                           $message_fields.='<tr>';
                                           $message_fields.='<td align="center" valign="top">' . $tmp_field_label . '</td>';
                                            $message_fields.='<td width="20" align="center" valign="top"></td>';
                                            $message_fields.='<td   align="left" valign="top">';
                                         
                                           
                                            $message_fields.='</td>';
                                            $message_fields.='</tr>';
                                        
                                        
                                        $tmp_options[] = $tmp_options_row;
                                   // }
                                    /*saving data to field array*/
                                    $form_f_tmp[$key]['input'] = $tmp_options;
                                     /*mail notification*/
                                    $message_fields.='</table>';
                                   break;
                               case 40:
                                    /*switch*/
                                    $tmp_fdata= json_decode($tmp_field_name->data,true);
                                    
                                    $tmp_options = array();
                                    $tmp_field_label=(!empty($tmp_fdata['label']['text']))?$tmp_fdata['label']['text']:$tmp_field_name->fieldname;
                                    $form_f_tmp[$key]['label']=$tmp_field_label;
                                    /*mail notification*/
                                    $message_fields.='</br>';
                                    $message_fields.='<table cellspacing="0" cellpadding="0">';
                                    
                                    //foreach ($value as $key2=>$value2) {
                                        $tmp_options_row=array();
                                        $tmp_options_row['label']=$value;
                                        
                                        //for records
                                        $form_f_rec_tmp[$key] = $value;
                                         
                                           /*mail notification*/
                                           $message_fields.='<tr>';
                                           $message_fields.='<td align="center" valign="top">' . $tmp_field_label.' - '.$value. '</td>';
                                            $message_fields.='<td width="20" align="center" valign="top"></td>';
                                            $message_fields.='<td  align="left" valign="top">';
                                            $message_fields.='</td>';
                                            $message_fields.='</tr>';
                                         
                                        $tmp_options[] = $tmp_options_row;
                                    //}
                                    /*saving data to field array*/
                                    $form_f_tmp[$key]['input'] = $tmp_options;
                                     /*mail notification*/
                                    $message_fields.='</table>';
                                   break;    
                                case 41;
                                /*dyn checkbox*/
                                case 42;
                                /*dyn radiobtn*/    
                                        $tmp_fdata= json_decode($tmp_field_name->data,true);
                                        $tmp_options = array();
                                        $tmp_field_label=(!empty($tmp_fdata['label']['text']))?$tmp_fdata['label']['text']:$tmp_field_name->fieldname;
                                        $form_f_tmp[$key]['label']=$tmp_field_label;
                                        /*mail notification*/
                                        $message_fields.='</br>' . $tmp_field_label . ' : </br>';
                                        $message_fields.='<table cellspacing="0" cellpadding="0">';
                                        
                                        //for records
                                        $tmp_options_rec = array();
                                        foreach ($value as $value2) {
                                            $tmp_options_rec[] = $value2;
                                        }
                                        $form_f_rec_tmp[$key] = implode('^,^', $tmp_options_rec);
                                        //end for records
                                        
                                        foreach ($value as $key2=>$value2) {
                                            $tmp_options_row=array();
                                            $tmp_options_row['label']=$tmp_fdata['input17']['options'][$key2]['label'];

                                            if($tmp_fdata['input17']['options'][$key2]){
                                            $tmp_options_row['qty']=  $value2;
                                            /*mail notification*/
                                            $message_fields.='<tr>';
                                                $message_fields.='<td width="20" align="center" valign="top">&bull;</td>';
                                                $message_fields.='<td   align="left" valign="top">' . $tmp_fdata['input17']['options'][$key2]['label'] ;
 
                                                $message_fields.='</td>';
                                                $message_fields.='</tr>';
                                            }

                                            $tmp_options[] = $tmp_options_row;
                                        }
                                        /*saving data to field array*/
                                        $form_f_tmp[$key]['input'] = $tmp_options;
                                        /*mail notification*/
                                        $message_fields.='</table>';
                                        break;
                                default:
                                   
                                     $tmp_fdata= json_decode($tmp_field_name->data,true);
                                     $tmp_field_label=(!empty($tmp_fdata['label']['text']))?$tmp_fdata['label']['text']:$tmp_field_name->fieldname;
                                      $form_f_tmp[$key]['label']=$tmp_field_label;
                                    if (is_array($value)) {
                                      $tmp_options = array();
                                        foreach ($value as $value2) {
                                            $tmp_options[] = $value2;
                                        }
                                        $form_f_tmp[$key]['input'] = implode('^,^', $tmp_options);
                                        //for records
                                        $form_f_rec_tmp[$key] = implode('^,^', $tmp_options);
                                        
                                        /*mail notification*/
                                        $message_fields.='</br>' . $tmp_field_label . ' : </br>';
                                        $message_fields.='<table cellspacing="0" cellpadding="0">';
                                        foreach ($value as $value2) {
                                            $message_fields.='<tr>';
                                            $message_fields.='<td width="20" align="center" valign="top">&bull;</td>';
                                            $message_fields.='<td  align="left" valign="top">' . $value2 . '</td>';
                                            $message_fields.='</tr>';
                                        }
                                        $message_fields.='</table>';  
                                    }else{
                                         $form_f_tmp[$key]['input'] = $value;
                                         //for records
                                         $form_f_rec_tmp[$key] = $value;
                                    
                                        /*mail notification*/
                                        $message_fields.='</br>';
                                        $message_fields.='<table cellspacing="0" cellpadding="0">';
                                            $message_fields.='<tr>';
                                                $message_fields.='<td align="center" valign="top">' . $tmp_field_label . '</td>';
                                                $message_fields.='<td width="20" align="center" valign="top">:</td>';
                                                $message_fields.='<td   align="left" valign="top"> ' . $value . '</td>';
                                            $message_fields.='</tr>';
                                            $message_fields.='</table>';
                                    }
                                    
                                    break;
                            }
                            
                        
                           
                        }

                    }
                   
                if(count($form_errors)>0){
                    $data=array();
                    $data['success']=0;
                    $data['form_errors']=count($form_errors);
                    $tmp_err_msg='<ul>';
                        foreach ($form_errors as $value_er) {
                        $tmp_err_msg.='<li>'.$value_er.'</li>';    
                        }
                        $tmp_err_msg.='</ul>';
                        $tmp_err_msg=Uiform_Form_Helper::assign_alert_container($tmp_err_msg,4);
                    $data['form_error_msg']=$tmp_err_msg;
                    $this->form_response=$data;
                    $data['form_error_msg']=Uiform_Form_Helper::encodeHex($data['form_error_msg']);
                    return $data;
                }
                 
                $this->form_rec_msg_summ = $message_fields;
                
                //ending form process

                //save to form records
                $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
                $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';
                
                 $form_f_rec_tmp=$this->process_DataRecord($form_f_tmp,$form_f_rec_tmp);
                
                $data = array();
                $data['fbh_data'] = json_encode($form_f_tmp);
                $data['fbh_data_rec'] = json_encode($form_f_rec_tmp);
                $data['created_ip'] = $_SERVER['REMOTE_ADDR'];
                $data['form_fmb_id'] = $form_id;
                $data['fbh_data_rec_xml'] = Uiform_Form_Helper::array2xml($form_f_rec_tmp);
                $data['fbh_user_agent'] = $agent;
                $data['fbh_page'] = $_SERVER['REQUEST_URI'];
                $data['fbh_referer'] = $referer;
                
                //generate uniqueid
                if (!isset($_COOKIE["uiform_fbuilder"])) {
                    $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
                    $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
                    $hash = hash('crc32', md5($ip . $user_agent));
                    setcookie("uiform_fbuilder", $hash, time() + (60 * 60 * 24 * 30), '/');
                }else{
                    $hash = $_COOKIE["uiform_fbuilder"];
                }
                
                //$data['vis_uniqueid'] = $hash;
                
                $this->db->set($data);
                $this->db->insert($this->model_record->table);
                
                $idActivate = $this->db->insert_id();
                $json=array();
                $json['status'] = 'created';
                $json['id'] = $idActivate;

                $this->flag_submitted = $idActivate;
                
                
                
                 //preparing mail
                
                $this->load->library('email', emailConfiguration(intval(model_settings::$db_config['type_email'])));
                
                
                $mail_from_email = (isset($form_data_onsubm['onsubm']['mail_from_email'])) ? $form_data_onsubm['onsubm']['mail_from_email'] : '';
                $mail_from_name = (isset($form_data_onsubm['onsubm']['mail_from_name'])) ? $form_data_onsubm['onsubm']['mail_from_name'] : '';
                
                //admin
                //mail template
                $mail_template_msg = (isset($form_data_onsubm['onsubm']['mail_template_msg'])) ? urldecode($form_data_onsubm['onsubm']['mail_template_msg']) : '';
                $mail_template_msg =do_shortcode($mail_template_msg);
                
                $email_recipient = (isset($form_data_onsubm['onsubm']['mail_recipient'])) ? $form_data_onsubm['onsubm']['mail_recipient'] : model_settings::$db_config['admin_mail'];
                $email_cc = (isset($form_data_onsubm['onsubm']['mail_cc'])) ? $form_data_onsubm['onsubm']['mail_cc'] : '';
                $email_bcc = (isset($form_data_onsubm['onsubm']['mail_bcc'])) ? $form_data_onsubm['onsubm']['mail_bcc'] : '';
                $mail_subject = (isset($form_data_onsubm['onsubm']['mail_subject'])) ? $form_data_onsubm['onsubm']['mail_subject'] : __('New form request', 'FRocket_front');
                
                $mail_usr_recipient = (isset($form_data_onsubm['onsubm']['mail_usr_recipient'])) ? $form_data_onsubm['onsubm']['mail_usr_recipient'] : '';
                
                $data_mail=array();
                $data_mail['from_mail']=$mail_from_email;
                $data_mail['from_name']=$mail_from_name;
                $data_mail['message']=$mail_template_msg;
                $data_mail['subject']=$mail_subject;
                $data_mail['attachments']=$attachments;
                $data_mail['to']=$email_recipient;
                $data_mail['cc']=array_map('trim', explode(',',$email_cc));
                $data_mail['bcc']=array_map('trim', explode(',',$email_bcc));
                $data_mail['mail_replyto']=$this->model_record->getFieldOptRecord($mail_usr_recipient.'_input',$idActivate);
                $mail_errors=$this->process_mail($data_mail);
                
                //customer 
                //mail template
                $mail_usr_st = (isset($form_data_onsubm['onsubm']['mail_usr_st'])) ? $form_data_onsubm['onsubm']['mail_usr_st'] : "0";
                if(intval($mail_usr_st)===1){
                    $mail_template_msg = (isset($form_data_onsubm['onsubm']['mail_usr_template_msg'])) ? urldecode($form_data_onsubm['onsubm']['mail_usr_template_msg']) : '';
                    $mail_template_msg =do_shortcode($mail_template_msg);

                    $mail_usr_cc = (isset($form_data_onsubm['onsubm']['mail_usr_cc'])) ? $form_data_onsubm['onsubm']['mail_usr_cc'] : '';
                    $mail_usr_bcc = (isset($form_data_onsubm['onsubm']['mail_usr_bcc'])) ? $form_data_onsubm['onsubm']['mail_usr_bcc'] : '';
                    $mail_usr_subject = (isset($form_data_onsubm['onsubm']['mail_usr_subject'])) ? $form_data_onsubm['onsubm']['mail_usr_subject'] : __('New form request', 'FRocket_front');
                    
                    $mail_usr_pdf_st = (isset($form_data_onsubm['onsubm']['mail_usr_pdf_st'])) ? $form_data_onsubm['onsubm']['mail_usr_pdf_st'] : "0";
                    if (intval($mail_usr_pdf_st) === 1) {
                        
                        $data_mail=array();
                        $mail_template_msg_pdf = (isset($form_data_onsubm['onsubm']['mail_usr_pdf_template_msg'])) ? urldecode($form_data_onsubm['onsubm']['mail_usr_pdf_template_msg']) : '';
                        $mail_template_msg_pdf =do_shortcode($mail_template_msg_pdf);
                        $data_mail['mail_usr_pdf_template_msg']=$mail_template_msg_pdf;
                        $mail_pdf_fn = (isset($form_data_onsubm['onsubm']['mail_usr_pdf_fn'])) ? urldecode($form_data_onsubm['onsubm']['mail_usr_pdf_fn']) : '';
                        $mail_pdf_fn =do_shortcode($mail_pdf_fn);
                        $data_mail['mail_usr_pdf_fn']=$mail_pdf_fn;
                        $data_mail['rec_id']=$idActivate;
                        //$mail_pdf_font = (isset($form_data_onsubm['onsubm']['mail_usr_pdf_font'])) ? urldecode($form_data_onsubm['onsubm']['mail_usr_pdf_font']) : '';
                        //$data_mail['mail_usr_pdf_font']=$mail_pdf_font;
                        //$data_mail['mail_usr_pdf_charset']=(isset($form_data_onsubm['onsubm']['mail_usr_pdf_charset'])) ? $form_data_onsubm['onsubm']['mail_usr_pdf_charset'] : '';
                        $attachments[] = $this->process_custom_pdf($data_mail);
                    }


                $data_mail=array();
                    $data_mail['from_mail']=$mail_from_email;
                    $data_mail['from_name']=$mail_from_name;
                    $data_mail['message']=$mail_template_msg;
                    $data_mail['subject']=$mail_usr_subject;
                    $data_mail['attachments']=$attachments;
                    $data_mail['to']=$this->model_record->getFieldOptRecord($mail_usr_recipient.'_input',$idActivate);
                    $data_mail['cc']=array_map('trim', explode(',',$mail_usr_cc));
                    $data_mail['bcc']=array_map('trim', explode(',',$mail_usr_bcc));
                    $data_mail['mail_replyto']='';
                    $mail_errors=$this->process_mail($data_mail);
                   
                    
                    
                }
                                
                //success message
                
                $tmp_sm_successtext = (isset($form_data_onsubm['onsubm']['sm_successtext'])) ? urldecode($form_data_onsubm['onsubm']['sm_successtext']) : '';
                $tmp_sm_successtext =do_shortcode($tmp_sm_successtext);
                
                //url redirection
                $tmp_sm_redirect_st = (isset($form_data_onsubm['onsubm']['sm_redirect_st'])) ? $form_data_onsubm['onsubm']['sm_redirect_st'] : '0';
                $tmp_sm_redirect_url = (isset($form_data_onsubm['onsubm']['sm_redirect_url'])) ? urldecode($form_data_onsubm['onsubm']['sm_redirect_url']) : '';
                
                
                $data=array();
                $data['success']=1;
                $data['show_message'] = $tmp_sm_successtext;
                $data['sm_redirect_st']=$tmp_sm_redirect_st;
                $data['sm_redirect_url']=$tmp_sm_redirect_url;
                //$data['vis_uniqueid']=$hash;
                $data['form_errors']=0;
                $data['form_id']=$form_id;
                $data['mail_error']=($mail_errors)?1:0;
                $data['fbh_id']=$idActivate;
                $this->form_response=$data;
                return $data;
                
        } catch (Exception $exception) {
            $data=array();
            $data['success']=0;
            $data['form_errors']=count($form_errors);
            $data['error_debug']=__METHOD__ . ' error: ' . $exception->getMessage();
            $data['mail_error']=($mail_errors)?1:0;
            $this->form_response=$data;
            return $data;
        }
        
    }
    
    private function process_custom_pdf($data) {
        
       $output = '';
        $data2=array();
        $data2['rec_id']=$data['rec_id'];
        $data2['content']=$data['mail_usr_pdf_template_msg'];
        $tmp_html = modules::run('formbuilder/frontend/pdf_global_template',$data2);
        $output = generate_pdf($tmp_html, $data['mail_usr_pdf_fn'], false);
                                          
        return $output;
    }
    
    
    public function pdf_show_record() {
         $rec_id=isset($_GET['id']) ? Uiform_Form_Helper::sanitizeInput($_GET['id']) :'';
                                
         if(intval($rec_id)>0){
             ob_start();
        ?>
        <div style="width:600px;margin: 0 100px;">
                    <!-- if p tag is removed, title will dissapear, idk -->
                    <h3><?php echo __('Order summary','FRocket_admin');?></h3>
                  
                   <?php
                   
                   echo modules::run('formbuilder/frontend/get_summaryRecord',$rec_id);
                ?>
                </div>

        <?php
        $content = ob_get_contents();
        ob_end_clean();
        $output = '';
        $data2=array();
        $data2['rec_id']=$rec_id;
        //$data2['pdf_font']=$data['pdf_font'];
        $data2['content']=$content;
        $tmp_html=modules::run('formbuilder/frontend/pdf_global_template',$data2);                      
         generate_pdf($tmp_html,'record_'.$rec_id, true);
        die();
        
         }
    }
    
    public function pdf_global_template($data) {
        
        $rec_id=$data['rec_id'];
        $temp=$this->model_record->getFormDataById($rec_id);
        $form_id=$temp->form_fmb_id;
        
        $form_data = $this->model_forms->getFormById_2($form_id);
        $form_data_onsubm = json_decode($form_data->fmb_data2, true);
        $pdf_charset = (isset($form_data_onsubm['main']['pdf_charset'])) ? $form_data_onsubm['main']['pdf_charset'] : '';
        $pdf_font = (isset($form_data_onsubm['main']['pdf_font'])) ? urldecode($form_data_onsubm['main']['pdf_font']) : '';
        $data2=array();
        $data2['font']=$pdf_font;
        $data2['charset']=$pdf_charset;
        $data2['head_extra']=isset($data['head_extra'])?$data['head_extra']:'';
        $data2['content']=$data['content'];
        $content=$this->load->view('formbuilder/frontend/pdf_global_template',$data2,true);
        return $content; 
   }
    
    private function process_DataRecord($data1,$data2) {
        
        $data3=array();
        
        if(!empty($data1)){
            foreach ($data1 as $key => $value) {
                foreach ($value as $key2 => $value2) {
                    if(is_array($value2)){
                        //index
                        $temp_input=array();
                        $temp_cost=array();
                        $temp_qty=array();
                        
                        foreach ($value2 as $key3 => $value3) {
                            //values
                            foreach ($value3 as $key4 => $value4) {
                                switch ($key4) {
                                        case 'label':
                                           $temp_input[]=$value4;
                                            break;
                                        case 'cost':
                                            $temp_cost[]=$value4;
                                            break;
                                        case 'qty':
                                            $temp_qty[]=$value4;
                                            break;
                                        default:
                                            
                                    }
                                $data3[$key.'_'.$key2.'_'.$key3.'_'.$key4]=$value4;
                                
                            }
                        }
                        
                        if(!empty($temp_input)){
                            $data3[$key.'_input']=implode('^,^', $temp_input);
                        }
                        if(!empty($temp_cost)){
                            $data3[$key.'_cost']=implode('^,^', $temp_cost);
                        }
                        if(!empty($temp_qty)){
                            $data3[$key.'_qty']=implode('^,^', $temp_qty);
                        }
                        
                        
                    }else{
                        $data3[$key.'_'.$key2]=$value2;
                    }
                }
            }
        }
        $data3=array_merge($data3,$data2);
        
        return $data3;
    }
     
    private function process_mail($data) {
        $mail_errors=false;
         $this->email->clear(TRUE);
         $this->email->set_newline("\r\n");
                /*getting admin mail*/
                $data['from_name']  = !empty($data['from_name']) ? $data['from_name'] : model_settings::$db_config['site_title'];
                
                $headers = array();
                $message_format='html';
                $content_type = $message_format == "html" ? "text/html" : "text/plain";
                $headers[] = "MIME-Version: 1.0";
                $headers[] = "Content-type: {$content_type}";
                $headers[] = "charset=utf8";
                $headers[] = "From: \"{$data['from_name']}\" <{$data['from_mail']}>";
                if (!empty($data['mail_replyto']) 
                        && preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/',$data['mail_replyto'])){
                        $mail_replyto_name=substr($data['mail_replyto'], 0, strrpos($data['mail_replyto'], '@'));
                        $headers[] = "Reply-To: \"{$mail_replyto_name}\" <{$data['mail_replyto']}>";
                        $this->email->reply_to($data['mail_replyto']);
                        $data['subject'].=" - ".$data['mail_replyto'];
                }
                //cc
                if (!empty($data['cc'])) {
                    if(is_array($data['cc'])){
                      foreach ($data['cc'] as $value) {
                          if (preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/',$value)){
                              $headers[] = "Cc: {$value}";
                              $this->email->cc($value);
                            }
                        }
                    }
                }
                
                //bcc
                if (!empty($data['bcc'])) {
                    if(is_array($data['bcc'])){
                      foreach ($data['bcc'] as $value) {
                          if (preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/',$value)){
                              $headers[] = "Bcc: {$value}";
                              $this->email->bcc($value);
                            }
                        }
                    }
                }
                 
                $to = $data['to'];
               
                if (preg_match('/^[a-zA-Z0-9._+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/',$to)){
                    
                    $this->email->from($data['from_mail'], $data['from_name']);
                    $this->email->to($to);
                    $this->email->subject($data['subject']);
                    $this->email->set_mailtype("html");
                    $this->email->message($data['message']);
                    
                    
                   if(!empty($data['attachments'])){
                       foreach ($data['attachments'] as $attachment) {
                           $this->email->attach($attachment);
                        }
                       
                    } 

                    if ($this->email->send()) {
                        $mail_errors = false;
                    } else {
                        $mail_errors = true;
                    }
                    if (false && !empty($data['attachments'])) {
                        foreach ($data['attachments'] as $attachment) {
                            @unlink($attachment); // delete files after sending them
                        }
                    }            
                }else{
                   $mail_errors=true; 
                }
                
        
        return $mail_errors;
    }
    
    
    /**
     * Frontend::viewform()
     * 
     * @return 
     */
    public function viewform() {
        $form_id = ($this->input->get('form')) ? Uiform_Form_Helper::sanitizeInput($this->input->get('form')) : 0;
        $lmode = ($this->input->get('lmode')) ? Uiform_Form_Helper::sanitizeInput($this->input->get('lmode')) : '';
                                        
        if ($form_id === 0) {
            return;
        }
        $website = 'uiform';
        $ip = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        if (!isset($_COOKIE[$website])) {
            $user_agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
            $hash = hash('crc32', md5($ip . $user_agent));
            setcookie($website, $hash, time() + (60 * 60 * 24 * 30), '/');
        } else {
            $hash = $_COOKIE[$website];
        }
        $agent = isset($_SERVER["HTTP_USER_AGENT"]) ? $_SERVER["HTTP_USER_AGENT"] : '';
        $referer = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : '';

        //visitor data
        /*$data3 = array();
        $data3['vis_uniqueid'] = $hash;
        $data3['vis_user_agent'] = $agent;
        $data3['vis_page'] = $_SERVER['REQUEST_URI'];
        $data3['vis_referer'] = $referer;
        $data3['vis_ip'] = $_SERVER['REMOTE_ADDR'];
        $this->db->set($data3);
        $this->db->insert($this->model_visitor->table);*/

       

        $rdata = $this->model_forms->getFormById($form_id);
        $data = array();
        $data['uniqueid'] = $hash;
         //get data from form
            $form_data = $this->model_forms->getFormById_2($rdata->fmb_id);
            $form_data_onsubm = json_decode($form_data->fmb_data2, true);
                
            $onload_scroll = (isset($form_data_onsubm['main']['onload_scroll'])) ? $form_data_onsubm['main']['onload_scroll'] : '1';
                            
            $preload_noconflict = (isset($form_data_onsubm['main']['preload_noconflict'])) ? $form_data_onsubm['main']['preload_noconflict'] : '1';    
                            
            $temp=array();
            $temp['id_form']=$rdata->fmb_id;
            $temp['site_url']=site_url();
            $temp['base_url']=base_url();
            $temp['lmode']=$lmode;
            $temp['onload_scroll']=$onload_scroll;
            $temp['preload_noconflict']=$preload_noconflict;
            $data['script'] = $this->load->view('formbuilder/forms/get_code_widget', $temp, true);

        $this->load->view('formbuilder/frontend/viewform', $data);
    }

}
