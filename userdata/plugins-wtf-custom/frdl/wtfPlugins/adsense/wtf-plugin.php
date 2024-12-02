<?php
/**
 * Plugin Name: Adsense ads.txt 
 * Description: Shows the adsense text. Plug this plugin for adsense-enabled tenants into 
 *              userdata/plugins-wtf-custom/frdl/wtfPlugins/adsense/wtf-plugin.php
 * Version: 0.0.1
 * Author: WEID Consortium
 * Author URI: https://weid.info
 * License: MIT
 */
namespace Frdlweb\OIDplus\Adsense\plugin;

	use ViaThinkSoft\OIDplus\Core\OIDplus;
	use ViaThinkSoft\OIDplus\Core\OIDplusConfig;

function handle404_for_adstxt(string $request){ 
	global $oidplus_handle_404_handled_return_value;
	
	$adstxtBaseUri = '/ads.txt'; 	
	 
	if (explode('?',$request)[0]=== $adstxtBaseUri
	    && !empty(OIDplus::config()->getValue('FRDLWEB_ADSENSE_TXT_CONTENT', ''))
	   ) {
		$oidplus_handle_404_handled_return_value = true;
		while(ob_get_level())ob_end_clean();
		header('Content-Type: text/plain');
		echo OIDplus::config()->getValue('FRDLWEB_ADSENSE_TXT_CONTENT');
		flush();
		 die();
	}//base uri match
	
}//handle404_for_adstxt
	


	
function init(bool $html = true){
			OIDplus::config()->prepareConfigKey('FRDLWEB_ADSENSE_TXT_CONTENT',
											'Contents of the ads.txt you want to show in your domain root. Info: https://support.google.com/adsense/answer/12171612',        
												"", 
												OIDplusConfig::PROTECTION_EDITABLE,
												function ($value) {
		  
			  
		});		
}

//you can use autowiring as from container->invoker->call( \callable | closure(autowired arguments), [parameters]) !!!
return (function(){	
	add_action(	'frdl_wtf_init',	__NAMESPACE__.'\init',	0, null);	   
	add_action(	'oidplus_handle404',	__NAMESPACE__.'\handle404_for_adstxt',	0, null);	
});
