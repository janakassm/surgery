<?php

//	EzAuth v 0.6
//	This software is open source, HOWEVER it may not be modified and resold without permission from BizWidgets.
//	Hand Crafted using CodeIgniter by Daniel Errante
//	daniel@bizwidgets.biz
//	http://bizwidgets.biz/
	
/*
	EzAuth is used to manage a database of users on your website. You can protect certain pages of your website, giving users access keys to the different portions of your website. Users can also have administrator access and universal keys to gain access to any section on your domain. You can also define custom key definitions outside of EzAuth that integrate with EzAuth.
	
**** NOTE:

In order to create a very secure password storage system, you can create a register_date for each user, which will be unique for each user and invisible to website visitors, and use that as the salt for passwords.
*/


class Ezauth_model extends CI_Model {

var $userTable = 'ez_users';
var $authTable = 'ez_auth';
var $accessKeysTable = 'ez_access_keys';

//	user defined:
var $program				= 	'default';			//	program name (for example, ezsell, ezstore, user-defined program)
var $protected_pages 		= 	array();			//	pages to protect along with access level

var $roles = array('user', 'guest');



//	other user defined variables:
var $cookie_expire			=	'86500';			//	when to expire cookies
var	$cookie_domain			=	'';					//	cookie domain

//ezauth defined:
var $user		 			=	array();	//	user info in database

	
	public function __construct()
    {
        parent::__construct();
		$ci = get_instance();
		$ci->load->helper('cookie');
		//session auth
		if ($this->session->userdata('ez_user')) {
			$this->user = $this->session->userdata('ez_user');
		}
		
	}
	
	//	v 0.2
	//	auto-login is not very secure, as if anyone can get access to the cookie in the client's browser they will be able to login with their identity. it is used for convenience.
	//	do not use auto-login if you are dealing with personal information that visitors will not want anyone to see.
	//	this is also a threat to people using public computers. allow the user to choose to save login data or not.
	//	to enhance security, enable cookie encryption and set a very unique encryption key
	//	also, encourage strong passwords
	
	function auto_login() {
		if (empty($this->user)) {
			$cookie_hash = get_cookie('ezauth_user_info', TRUE);
			if (!empty($cookie_hash)) $result = $this->login(null, null, true, $cookie_hash);
			if (!empty($result)) if ($result['authorize'] == true) return true;
			
		}
	}
	
	//	v 0.2
	function logout($redirect = '', $drop_cookie = true) {
		$this->session->sess_destroy();
		if ($drop_cookie == true) $this->drop_userinfo();
		if (!empty($redirect)) redirect($redirect);
	}
	
	//	v 0.3
	//establish user session if login information correct
	//can call login() and use default POST username and POST password or use parameters login('username here', 'password here');
	//new in 0.6 - can login from cookie hash
	function login($un = null, $pw = null, $give_new_key = false, $cookie_hash = '', $get_all_user_info = true) {
		$this->userTable = $this->userTable;
		$this->authTable = $this->authTable;
		$this->accessKeysTable = $this->accessKeysTable;
		$un = (empty($un)) ? $this->input->post('username') : $un;
		$pw = (empty($pw)) ? $this->input->post('password') : $pw;
		
	 	if ($get_all_user_info == false) {
			$this->db->select($this->userTable.'.id');
		} else {
			$this->db->select($this->userTable.'.id as id, '.$this->userTable.'.*, '.$this->authTable.'.activation_code');
		}
		if (empty($cookie_hash)) {
			$this->db->join($this->authTable, $this->authTable.'.user_id = '.$this->userTable.'.id');
			$query = $this->db->get_where($this->userTable, array('lower(username)' => strtolower($un), 'password' => $this->_add_salt($pw)));
		} else {
			$this->db->join($this->userTable, $this->authTable.'.user_id = '.$this->userTable.'.id', 'left');
			$query = $this->db->get_where($this->authTable, array('cookie_hash' => $cookie_hash));
		}
		
		if ($query->num_rows() > 0) {
			$userdata = $query->row();
			
			
			if($userdata->suspended)
			{
				return array('authorize' => false, 'error' => 'User suspended. Please contact admin for further inqueries.');
			}
			//	check to see if user's account has been activated
			$v_code = md5(md5($userdata->username).md5($userdata->email).md5($userdata->register_date));
			if ($userdata->activation_code != $v_code) return array('authorize' => false, 'error' => 'Account not active.', 'code'	=>	'not_active');
			
			$this->db->select('program, access');
			$query2 = $this->db->get_where($this->accessKeysTable, array('user_id' => $userdata->id));
			$userdata2 = $query2->result();
			$ez = $userdata;
			
			foreach ($userdata2 as $id => $accesskey) {
				$prg = $accesskey->program;
				$ez->access_keys->$prg = $accesskey->access;
			
			}
			
			$this_prg = $this->program;
			$this_key = (!empty($ez->access_keys->$this_prg)) ? $ez->access_keys->$this_prg : '';

			//	if user does not have a key to specific program, but already has a membership at this site
			//	if give_new_key is set to true, give the user a new key for new program
			if (empty($this_key) && $give_new_key == true) {
				$this->new_access_key($ez->id, $this_prg, 'user');
				$ez->access_keys->$this_prg = 'user';
			}
			
			
			/* old way of checking for active key
			if (!array_key_exists($this_key, $this->roles)) return array('authorize' => false, 'error' => 'Invalid access key for this program!', 'code'	=>	'nosuchkey');
			*/
			
			//	unset activation code
			unset($ez->activation_code);
			
			$this->update_session($ez);
			
			
			
			return array('authorize' => true);
		} else {
			return array('authorize' => false, 'error' => 'Invalid username/password combination!');
		}
	}
	
	//	v 0.1
	/*
		give user another access key for specific region on website
	*/
	function new_access_key($user_id, $program, $access = 'user') {
		$this->accessKeysTable = $this->accessKeysTable;
		$inp = array(
			'user_id'	=>	$user_id,
			'program'	=>	$program,
			'access'	=>	$access,
		);
		
		$this->db->insert($this->accessKeysTable, $inp);
	}
	
	//	v 0.1
	/*
		update session data with user user data
	*/
	function update_session($ez_array) {
		$ez['ez_user'] = $ez_array;
		$this->session->set_userdata($ez);
		$this->user = $ez_array;
		
	}
	
	//	v 0.2
	//authorize current user for page specified
	//returns 'yes' or 'no' with error message
	function authorize($page, $give_new_key = false) {
		$pp = $this->protected_pages;
		$auth_ok = array('authorize' => true);
		$auth_not_ok = array('authorize' => false, 'error' => 'Invalid user name/password for this program.');
		$prg = $this->program;
		
		//	get user access keys
		//	check for universal key for program first, if no universal key, get program key
		
		$program_key = (!empty($this->user)) ? (!empty($this->user->access_keys->all)) ? $this->user->access_keys->all : ((!empty($this->user->access_keys->$prg)) ? $this->user->access_keys->$prg : '') : '';
		
		//echo 'program key: ' . $program_key;
		
		if (!empty($this->user)) {
			if (empty($program_key) && $give_new_key == true) {
				$this->new_access_key($this->user->id, $prg, 'user');
			
				$this->user->access_keys->$prg = 'user';
				$program_key = 'user';
				
				// 	update session with new information
				$new_user = $this->user;
				$this->update_session($new_user);
			}
		}
		//var_dump($this->user->suspended);
		//	if page not protected, return authorize = true
		// 	else check to see that user has correct key for page
		if (!array_key_exists($page, $pp)) {
			if (!array_key_exists('all', $pp)) {
				return $auth_ok;
			} else {
				if ($program_key == 'user' || $program_key == 'admin') return $auth_ok; else return $auth_not_ok;
			}
			
		} else {
			if ($pp[$page] == 'anyone') {
				return $auth_ok;
			} else {
				if ($program_key == '') return $auth_not_ok;
				
				switch ($pp[$page]) {
					case 'user':
						if ($program_key == 'user' || $program_key == 'admin')  return $auth_ok;
					break;
					case 'admin':
						if ($program_key == 'admin') return $auth_ok;
					break;
				}
			}
		}
		return $auth_not_ok;
	}
	
	//	v 0.4
	//new in 0.6: activation keys are generated by user information and a timestamp, and are only enabled after a user verifies their e-mail address
	//this can be overridden by setting verify to false
	function register($inp, $verify = true, $remember_user = false, $login_after_register = true) {
		
		if (empty($inp[$this->userTable]->email) && $verify == true) return array('reg_ok' => 'no', 'error' => 'E-mail required for e-mail validation.');
		
		
		//	check for existing username
		/*$this->db->where('trim(lower(username))', $inp[$this->userTable]['username']);
		$query = $this->db->get($this->userTable);
		if ($query->num_rows() > 0) return array('reg_ok' => 'no', 'error' => 'Username already exists.');*/
	
		//check for existing e-mail if e-mail needs validation
		if ($verify) {
			$this->db->select($this->userTable.'.id as id, '.$this->authTable.'.activation_code, '.$this->userTable.'.username, '.$this->userTable.'.email, '.$this->userTable.'.register_date');
			$this->db->join($this->authTable, $this->authTable.'.user_id = '.$this->userTable.'.id', 'left');
			$this->db->where('trim(lower(email))', $inp[$this->userTable]->email);
			$query = $this->db->get($this->userTable);
			if ($query->num_rows() > 0) {
				$user = $query->row();
				$v_code = md5(md5($user->username).md5($user->email).md5($user->register_date));
				//	if ($v_code == $user->activation_code) {}
				return array('reg_ok' => 'no', 'error' => 'E-mail address is already in use.');
			}
		}
		
		//	insert into ez_users table
		$tmpUsertable = clone $inp[$this->userTable];
		unset($tmpUsertable->password);
		$this->db->insert($this->userTable,$tmpUsertable);
		$user_id = $this->db->insert_id();
		
		//	make very unique cookie hash for auto-login
		$salt = microtime();
		$cookie_hash = $this->_add_salt($inp[$this->userTable]->username.$user_id.$inp[$this->userTable]->password.$inp[$this->userTable]->email, $salt);
		
		//	insert into $this->authTable table
		$inp3 = array(
			'user_id'		=>	$user_id,
			'password'		=>	$this->_add_salt($inp[$this->userTable]->password),
			'cookie_hash'	=>	$cookie_hash
		);
		
		//	for e-mail verification
		//	if verification is true, set to random code, if not, set to pre-determined code that will be used for authentication when logging in
		if ($verify == true) {
			$v_code = md5(md5(microtime()).md5($this->random_string()));	//	temporary access code that will be sent to e-mail for verification
			$md5_vcode = $this->_add_salt($v_code);
			$inp3['activation_code'] = $md5_vcode;
		} else {
			$inp3['activation_code'] = md5(md5($inp[$this->userTable]->username).md5($inp[$this->userTable]->email).md5($inp[$this->userTable]->register_date));
			$v_code = $inp3['activation_code'];
		}
		
		
		$this->db->insert($this->authTable, $inp3);
			
		$keys_ins = 'insert into '.$this->accessKeysTable.' (user_id, program, access) values';
		$max = count($inp[$this->accessKeysTable]);
		$i=0;
	
		foreach ($inp[$this->accessKeysTable] as $obj) {
			$program = $obj['program'];
			$access = $obj['access'];
			$i++;
		
			$keys_ins .= ' (\''.$user_id.'\', \''.$program.'\', \''.$access.'\')';
			if ($i != $max) $keys_ins .= ',';
			
			//	for login after register process
			$new_access_keys->$program = $access;
		}
		$this->db->query($keys_ins);
		
		//	remember user to autologin next time site is visited
		if ($remember_user) {
			//	set cookie with very unique cookie hash
			$cookie = array(
			                   'name'   => 'user_info',
			                   'value'  => $cookie_hash,
			                   'expire' => $this->cookie_expire,
			                   'domain' => $this->cookie_domain,
			                   'path'   => '/',
			                   'prefix' => 'ezauth_'
			);
			set_cookie($cookie);
		}
		
		//	login user after registration
		if ($login_after_register == true && $verify == false) {
			$this->login(null, null, false, $cookie_hash);
		}
		
		return array('reg_ok' => 'yes', 'code' => $v_code, 'user_id' => $user_id);
		
	}
	
	//	v 0.3
	/*
	when user clicks link in e-mail, database will change user authorization_code to a md5 hash that will be matched on login
	** new login after verification setting, GIVE NEW KEY IS SET TO FALSE SO A KEY MUST BE ALREADY SET FOR CURRENT PROGRAM IF AUTO-LOGIN IS SET TO TRUE
	*/
	function verify_email($code, $login_after_verify = false) {
		$code = trim($code);
		if (empty($code)) return false;
		$salty_code = $this->_add_salt($code);
		//	get data for upadting tables and auto-login if desired
		$this->db->select($this->userTable.'.id, '.$this->userTable.'.username, '.$this->userTable.'.email, '.$this->userTable.'.register_date, '.$this->authTable.'.cookie_hash');
		$this->db->join($this->userTable, $this->userTable.'.id = '.$this->authTable.'.user_id', 'left');
		$query = $this->db->get_where($this->authTable, array('activation_code' => $salty_code));
		if ($query->num_rows() == 1) {
			$user = $query->row();
			
			$v_code = md5(md5($user->username).md5($user->email).md5($user->register_date));
			
			//	update $this->authTable table with new hash code
			$this->db->where('activation_code', $salty_code);
			$this->db->update($this->authTable, array('activation_code' => $v_code));
			
			if ($login_after_verify)
				return $this->login(null, null, false, $user->cookie_hash);		//	login by cookie hash
			else
				return true;
		} else {
			return false;
		}
	}
	
	
	//	v 0.2
	// used for generating random authorization codes and temporary passwords
	function random_string($length = 32) {
		//$length = 32;
	    // Generate random 32 character string
	    $string = md5(microtime());

	    // Position Limiting
	    $highest_startpoint = 32-$length;

	    // Take a random starting point in the randomly
	    // Generated String, not going any higher then $highest_startpoint
	    $randomString = substr($string,rand(0,$highest_startpoint),$length);

	    return $randomString;

	}
	

	//forgot pw: 2 steps
	
	//	v 0.1
	//step 1 adds reset code for user to be e-mailed to user to verify e-mail.
	function get_reset_code($user_id) {
		if (empty($user_id)) return false;
		
		$reset_code = $this->_add_salt($this->random_string());
		
			$this->db->where('user_id', $user_id);
			$this->db->update($this->authTable, array('reset_code' => $reset_code));
			
			$this->db->select('email,username');
			$query = $this->db->get_where($this->userTable, array('id' => $user_id));
			$eml = $query->row();
			$email = $eml->email;
                        $uname = $eml->username;
			return array('reset_code' => $reset_code, 'email' => $email,'username'=>$uname);
	}
	
	
	//	v 0.1
	//step 2 confirms e-mail address and sets temporary password that can be e-mailed to user.
	function reset_password($code) {
		if (empty($code)) return false;
		
		//	get user email to send new pw
		
		$this->db->select($this->userTable.'.email, '.$this->userTable.'.username');
		$this->db->join($this->userTable, $this->userTable.'.id = '.$this->authTable.'.user_id', 'left');
		$query = $this->db->get_where($this->authTable, array('reset_code' => $code));
		$result = $query->row();
		if (empty($result)) return false;
		
		$email = $result->email;
		$un = $result->username;
		
		$temp_pw = $this->random_string(8);
		$md5pw = $this->_add_salt($temp_pw);
		$this->db->where('reset_code', $code);
		$this->db->update($this->authTable, array('password' => $md5pw, 'reset_code' => ''));
		
		return array('temp_pw' => $temp_pw, 'username' => $un, 'email' => $email);
	}
	
	//	v 0.2
	function _add_salt($pw, $salt = 'shakeit') {
		$md5_string = '';
		if (is_array($pw)) {
			foreach ($pw as $word) {
				$md5_string .= md5($word);
			}
		} else {
			$md5_string = $pw;
		}
		return md5(md5($salt) . md5($md5_string));
	}
	
	//	v 0.3
	function change_pw($user_id, $old_pw, $new_pw) {
		$this->db->where('user_id', $user_id);
		$this->db->where('password', $this->_add_salt($old_pw));
		$this->db->update($this->authTable, array('password' => $this->_add_salt($new_pw)));
		return $this->db->affected_rows();
	}
	
	//	v 0.5
	//	gets user id from email address or username and activation status
	//	new in 0.6 - check if activated user option
	function get_userid($username = '', $email = '') {
		if (empty($username) && empty($email)) return false;
		$un_added = false;
		if (!empty($username)) {
			$this->db->where('username', $username);
			$un_added = true;
		}
		if (!empty($email))
			if ($un_added) $this->db->or_where('email', $email); else $this->db->where('email', $email);
			
		$this->db->select($this->userTable.'.id as id, '.$this->authTable.'.activation_code, '.$this->userTable.'.username, '.$this->userTable.'.email, '.$this->userTable.'.register_date');
		
		//	check if active user
		$this->db->join($this->authTable, $this->userTable.'.id = '.$this->authTable.'.user_id', 'left');

		$query = $this->db->get($this->userTable);
		
		$userdata = $query->row();
		if(empty($userdata)) return false;
		
		//	active user or not
		$v_code = md5(md5($userdata->username).md5($userdata->email).md5($userdata->register_date));
				
		$active = ($userdata->activation_code == $v_code) ? true : false;
		
		if (!empty($userdata)) $user = array('user_id' => $userdata->id, 'active' => $active); else $user = false;
		
		return $user;
	}
	
	//	functions to remember user when loggin in
	
	//	v 0.3
	//	if you use functions that remember the user, you must have CodeIgniter's cookie helper enabled!!!!
	//	remember to enable cookie encryption and set a very unique encryption KEY
	
	function remember_user($user = null, $reset_cookie = false) {
		$user = (empty($user)) ? $this->user : $user;
		if (empty($user)) return false;
		
		$this->db->select($this->userTable.'.id as id, '.$this->userTable.'.*, '.$this->authTable.'.cookie_hash, '.$this->authTable.'.password');
		$this->db->join($this->userTable, $this->userTable.'.id = '.$this->authTable.'.user_id', 'left');
		$this->db->limit(1);
		$query = $this->db->get_where($this->authTable, array('user_id' => $user->id));
		$db_user = $query->row();
		
		//	stopping point if no user found
		if (empty($db_user)) return false;
		
		//	no cookie hash found, so make new one and save
		//	or if reset cookie is specified
		if (empty($db_user->cookie_hash) || $reset_cookie == true) {
			//	make very unique cookie hash for auto-login
			$salt = microtime();
			$db_user->cookie_hash = $this->_add_salt($db_user->username.$db_user->id.$db_user->password.$db_user->email, $salt);
			$this->db->where('user_id', $db_user->id);
			$this->db->limit(1);
			$this->db->update($this->authTable, array('cookie_hash' => $db_user->cookie_hash));
		}
		
		//	set cookie with very unique cookie hash
		$cookie = array(
		                   'name'   => 'user_info',
		                   'value'  => $db_user->cookie_hash,
		                   'expire' => $this->cookie_expire,
		                   'domain' => $this->cookie_domain,
		                   'path'   => '/',
		                   'prefix' => 'ezauth_'
		);
		set_cookie($cookie);
		
		return true;
	}
	
	//	v 0.2
	//	gets all user info in ez_users table based on hash saved in cookie
	//	runs cookie through XSS filter
	function fetch_userinfo() {
		$cookie_hash = get_cookie('ezauth_user_info', TRUE);
		
		if (empty($cookie_hash)) return false;
		
		$this->db->select($this->userTable.'.*');
		$this->db->join($this->userTable, $this->userTable.'.id = '.$this->authTable.'.user_id', 'left');
		$query = $this->db->get_where($this->authTable, array('cookie_hash' => $cookie_hash));
		return $query->row();
	}
	
	//	v 0.2
	function drop_userinfo() {
		delete_cookie('ezauth_user_info');
	}
	
	//	v 0.1
	//	cleans up pending registrations that have not been verified after x days (default is 30)
	function cleanup_pending_registrations($days = '30') {
		
		$query = 'DELETE '.$this->userTable.'.*, '.$this->authTable.'.*, '.$this->accessKeysTable.'.* FROM '.$this->userTable.'., $this->authTable, '.$this->accessKeysTable.' WHERE '.$this->userTable.'.register_date < date_sub(now(), interval ".$days." day) AND '.$this->userTable.'.id = '.$this->authTable.'.user_id AND '.$this->accessKeysTable.'.user_id = '.$this->userTable.'.id AND '.$this->authTable.'.activation_code != md5(concat(md5('.$this->userTable.'.username), md5('.$this->userTable.'.email), md5('.$this->userTable.'.register_date)))';
		$query = $this->db->query($query);
		return $this->db->affected_rows();
	}
	
}
	
?>