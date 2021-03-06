<?php

	// determine IP
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		$myIP = $_SERVER['HTTP_CLIENT_IP'];
	}
	else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$myIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
	}
	else{
		$myIP = $_SERVER['REMOTE_ADDR'];
	}

	$enableAdminIP = $_POST['enableAdminIP'];
	$adminIPs = $_POST['adminIPs'];
	$allowedAccess = false;
	if($enableAdminIP==1){
		$allowedIPs = explode(",",$adminIPs);
		for($i=0;$i<count($allowedIPs);$i++){
			$thisIP = trim($allowedIPs[$i]);
			if (strpos($myIP, $thisIP) !== false) {
				$allowedAccess = true;
			}
		}
	}
	else{
		$allowedAccess = true;
	}

	if(!$allowedAccess){
		die("Cannot save the setup because you enabled the IP check and the current IP is not included, this would lock you out of the template and you would not be able to change this. If you want to enable the admin IP check, you need to make sure the current IP is included.");
	}

	session_start();
	if($_SESSION['user']!="admin"){
		echo "Unauthorized access.";
		die();
	}

	foreach(glob('../lang/*.*') as $file) {
		$langArr [] = substr($file,-6,2);
	}

	if($_POST['adminPasswordNew']!==""){
		$adminPassword = $_POST['adminPasswordNew'];
	}
	else{
		$adminPassword = $_POST['adminPassword'];
	}

	$updatePassword = $_POST['updatePassword'];

	// SQL
	$mySQLHost = $_POST['mySQLHost'];
	$mySQLUser = $_POST['mySQLUser'];
	$mySQLPassword = $_POST['mySQLPassword'];
	$mySQLName = $_POST['mySQLName'];

	// paths
	$path = $_POST['templatePath'];
	$pageURL = $_POST['pageURL'];

	$templateVersion = $_POST['templateVersion'];
	$versionName = $_POST['versionName'];

	// location
	$stationLat = $_POST['stationLat'];
	if(!is_numeric($stationLat)){
		die("Please check your latitude! It must be a number between -90 and +90 corresponding to the degrees latitude of your location.");
	}
	$stationLon = $_POST['stationLon'];
	if(!is_numeric($stationLon)){
		die("Please check your longitude! It must be a number between -180 and +180 corresponding to the degrees longitude of your location.");
	}
	$stationCountry = strtolower($_POST['stationCountry']);
	$stationLocation = formatText($_POST['stationLocation']);
	$stationTZ = $_POST['stationTZ'];

	// language
	$lang = $_POST['lang'];
	if($lang==""){
		$lang = "us";
	}
	for($i=0;$i<count($langArr);$i++){
		$langAvailable [] = '"'.$langArr[$i].'"';
	}

	// METAR
	$stationMETAR = $_POST['stationMETAR'];

	// Info
	$pageName = formatText($_POST['pageName']);
	$pageAuthor = formatText($_POST['pageAuthor']);
	$pageDesc = formatText($_POST['pageDesc']);
	$stationModel = formatText($_POST['stationModel']);
	$stationIcon = $_POST['stationIcon'];
	$customStation = formatText($_POST['customStation']);

	$solarSensor = $_POST['solarSensor'];
		if($solarSensor=="1"){
			$solarSensor = "true";
		}
		else{
			$solarSensor = "false";
		}

	// Appearance
	$design = $_POST['design'];
	$design2 = $_POST['design2'];
	$designFont = $_POST['designFont'];
	$designFont2 = $_POST['designFont2'];
	$gradient = $_POST['gradient'];
		if($gradient=="1"){
			$gradient = "true";
		}
		else{
			$gradient = "false";
		}

	// Units
	$dataTempUnits = $_POST['dataTempUnits'];
	$dataWindUnits = $_POST['dataWindUnits'];
	$dataPressUnits = $_POST['dataPressUnits'];
	$dataRainUnits = $_POST['dataRainUnits'];
	$displayTempUnits = $_POST['displayTempUnits'];
	$displayWindUnits = $_POST['displayWindUnits'];
	$displayPressUnits = $_POST['displayPressUnits'];
	$displayRainUnits = $_POST['displayRainUnits'];
	$displayCloudbaseUnits = $_POST['displayCloudbaseUnits'];
	$displayVisibilityUnits = $_POST['displayVisibilityUnits'];

	// Limits
	$limitTempMin = $_POST['limitTempMin'];
	if(!is_numeric($limitTempMin)){
		die("Please check your minimum temperature limit, it must be a valid number.");
	}
	$limitTempMax = $_POST['limitTempMax'];
	if(!is_numeric($limitTempMax)){
		die("Please check your maximum temperature limit, it must be a valid number.");
	}
	$limitHumidityMin = $_POST['limitHumidityMin'];
	if(!is_numeric($limitHumidityMin)){
		die("Please check your minimum humidity limit, it must be a valid number.");
	}
	$limitHumidityMax = $_POST['limitHumidityMax'];
	if(!is_numeric($limitHumidityMax)){
		die("Please check your maximum humidity limit, it must be a valid number.");
	}
	$limitPressureMin = $_POST['limitPressureMin'];
	if(!is_numeric($limitPressureMin)){
		die("Please check your minimum pressure limit, it must be a valid number.");
	}
	$limitPressureMax = $_POST['limitPressureMax'];
	if(!is_numeric($limitPressureMax)){
		die("Please check your maximum pressure limit, it must be a valid number.");
	}
	$limitRainMin = $_POST['limitRainMin'];
	if(!is_numeric($limitRainMin)){
		die("Please check your minimum precipitation limit, it must be a valid number.");
	}
	$limitRainMax = $_POST['limitRainMax'];
	if(!is_numeric($limitRainMax)){
		die("Please check your maximum precipitation limit, it must be a valid number.");
	}
	$limitRainRateMin = $_POST['limitRainRateMin'];
	if(!is_numeric($limitRainRateMin)){
		die("Please check your minimum rain rate limit, it must be a valid number.");
	}
	$limitRainRateMax = $_POST['limitRainRateMax'];
	if(!is_numeric($limitRainRateMax)){
		die("Please check your maximum rain rate limit, it must be a valid number.");
	}
	$limitWindMin = $_POST['limitWindMin'];
	if(!is_numeric($limitWindMin)){
		die("Please check your minimum wind speed limit, it must be a valid number.");
	}
	$limitWindMax = $_POST['limitWindMax'];
	if(!is_numeric($limitWindMax)){
		die("Please check your maximum wind speed limit, it must be a valid number.");
	}
	$limitBearingMin = $_POST['limitBearingMin'];
	if(!is_numeric($limitBearingMin)){
		die("Please check your minimum wind direction limit, it must be a valid number.");
	}
	$limitBearingMax = $_POST['limitBearingMax'];
	if(!is_numeric($limitBearingMax)){
		die("Please check your maximum wind direction limit, it must be a valid number.");
	}
	$limitSolarMin = $_POST['limitSolarMin'];
	if(!is_numeric($limitSolarMin)){
		die("Please check your minimum solar radiation limit, it must be a valid number.");
	}
	$limitSolarMax = $_POST['limitSolarMax'];
	if(!is_numeric($limitSolarMax)){
		die("Please check your maximum solar radiation temperature limit, it must be a valid number.");
	}

	if($dataPressUnits=="inhg" && $limitPressMin>50){
		die("Double check your pressure. You specified your pressure units as inHg, in which case you must set the pressure limits accordingly. Pressure values for inHg usually range around 25 to 35.");
	}
	if($dataPressUnits=="inhg" && $limitPressMax>50){
		die("Double check your pressure. You specified your pressure units as inHg, in which case you must set the pressure limits accordingly. Pressure values for inHg usually range around 25 to 35.");
	}

	// Formats
	$dateFormat = $_POST['dateFormat'];
	$timeFormat = $_POST['timeFormat'];
	$dateTimeFormat = $_POST['dateTimeFormat'];
	$prefferedDate = $_POST['prefferedDate'];
	$prefferedTime = $_POST['prefferedTime'];
	$firstWeekday = $_POST['firstWeekday'];
	$graphTimeFormat = $_POST['graphTimeFormat'];
	$graphDateFormat = $_POST['graphDateFormat'];

	$climateID = $_POST['climateID'];
	if(!is_numeric($climateID)){
		die("Please check your climateID, it must be a valid number.");
	}

	// Customization
	if($_POST['userCustomColor']=="on"){
		$userCustomColor = "true";
	}
	else{
		$userCustomColor = "false";
	}
	if($_POST['userCustomFont']=="on"){
		$userCustomFont = "true";
	}
	else{
		$userCustomFont = "false";
	}
	if($_POST['userCustomUnits']=="on"){
		$userCustomUnits = "true";
	}
	else{
		$userCustomUnits = "false";
	}
	if($_POST['userCustomLang']=="on"){
		$userCustomLang = "true";
	}
	else{
		$userCustomLang = "false";
	}

	$bannerID = $_POST['bannerID'];

	$paypalButtonCode = $_POST['paypalButtonCode'];
		if($paypalButtonCode == ""){
			$paypalButton = "false";
			$paypalButtonCode = "";
		}
		else{
			$paypalButton = "true";
		}

	// Services
	$wuStationID = $_POST['wuStationID'];
		if($wuStationID == ""){
			$wuIcon = "false";
			$wuStationID == "";
		}
		else{
			$wuIcon = "true";
		}
	$awekasID = $_POST['awekasID'];
		if($awekasID == ""){
			$awekasIcon = "false";
			$awekasID == "";
		}
		else{
			$awekasIcon = "true";
		}
	$cwopID = $_POST['cwopID'];
		if($cwopID == ""){
			$cwopIcon = "false";
			$cwopID == "";
		}
		else{
			$cwopIcon = "true";
		}
	$weathercloudID = $_POST['weathercloudID'];
		if($weathercloudID == ""){
			$weathercloudIcon = "false";
			$weathercloudID == "";
		}
		else{
			$weathercloudIcon = "true";
		}
	$WOWMetofficeID = $_POST['WOWMetofficeID'];
		if($WOWMetofficeID == ""){
			$WOWMetofficeIcon = "false";
			$WOWMetofficeID == "";
		}
		else{
			$WOWMetofficeIcon = "true";
		}
	$pwsID = $_POST['pwsID'];
		if($pwsID == ""){
			$pwsIcon = "false";
			$pwsID == "";
		}
		else{
			$pwsIcon = "true";
		}
	$aerisID = $_POST['aerisID'];
	$aerisSecret = $_POST['aerisSecret'];
	$aerisCacheTime = $_POST['aerisCacheTime'];
	$WWOApiKey = $_POST['WWOApiKey'];
	$WWOLocation = $_POST['WWOLocation'];
	$WWOCacheTime = $_POST['WWOCacheTime'];

	// Gauge Limits
	$tempGaugeMax = $_POST['tempGaugeMax'];
	if(!is_numeric($climateID)){
		die("Please check your maximum temperature gauge limit, it has to be a valid number.");
	}
	$tempGaugeMin = $_POST['tempGaugeMin'];
	if(!is_numeric($climateID)){
		die("Please check your minimum temperature gauge limit, it has to be a valid number.");
	}
	$pressureGaugeMax = $_POST['pressureGaugeMax'];
	if(!is_numeric($climateID)){
		die("Please check your maximum pressure gauge limit, it has to be a valid number.");
	}
	$pressureGaugeMin = $_POST['pressureGaugeMin'];
	if(!is_numeric($climateID)){
		die("Please check your minimum pressure gauge limit, it has to be a valid number.");
	}
	$windGaugeMax = $_POST['windGaugeMax'];
	if(!is_numeric($climateID)){
		die("Please check your maximum wind speed gauge limit, it has to be a valid number.");
	}
	$windGaugeMin = $_POST['windGaugeMin'];
	if(!is_numeric($climateID)){
		die("Please check your minimum wind speed gauge limit, it has to be a valid number.");
	}
	$gustGaugeMax = $_POST['gustGaugeMax'];
	if(!is_numeric($climateID)){
		die("Please check your maximum wind gust gauge limit, it has to be a valid number.");
	}
	$gustGaugeMin = $_POST['gustGaugeMin'];
	if(!is_numeric($climateID)){
		die("Please check your minimum wind gust gauge limit, it has to be a valid number.");
	}
	$rainGaugeMax = $_POST['rainGaugeMax'];
	if(!is_numeric($climateID)){
		die("Please check your maximum precipitation gauge limit, it has to be a valid number.");
	}
	$rainGaugeMin = $_POST['rainGaugeMin'];
	if(!is_numeric($climateID)){
		die("Please check your minimum precipitation gauge limit, it has to be a valid number.");
	}
	$solarGaugeMax = $_POST['solarGaugeMax'];
	if(!is_numeric($climateID)){
		die("Please check your maximum solar radiation gauge limit, it has to be a valid number.");
	}
	$solarGaugeMin = $_POST['solarGaugeMin'];
	if(!is_numeric($climateID)){
		die("Please check your minimum solar radiation gauge limit, it has to be a valid number.");
	}

	$defaultGraphInterval = $_POST['defaultGraphInterval'];
	$defaultGraphParameter = $_POST['defaultGraphParameter'];

	$GAcode = $_POST['GAcode'];
		if($GAcode == ""){
			$googleAnalytics = "false";
			$GAcode == "";
		}
		else{
			$googleAnalytics = "true";
		}

	$customBgColor1 = $_POST['customBgColor1'];
	$customBgColor2 = $_POST['customBgColor2'];
	$customBgColor3 = $_POST['customBgColor3'];
	$customBgColor4 = $_POST['customBgColor4'];
	$customBgType = $_POST['customBgType'];
	$customBgImg = $_POST['customBgImg'];

	$customMaxWidth = $_POST['customMaxWidth'];

	$customBlockRadius = $_POST['customBlockRadius'];
		$customBlockRadius = str_replace(" ","",$customBlockRadius);
	$customBlockBevel = $_POST['customBlockBevel'];
		$customBlockBevel = str_replace(" ","",$customBlockBevel);
	$customBlockBorderWidth = $_POST['customBlockBorderWidth'];
		$customBlockBorderWidth = str_replace(" ","",$customBlockBorderWidth);

	$customHeadingShadow = $_POST['customHeadingShadow'];
	$customBodyTextShadow = $_POST['customBodyTextShadow'];
	$headerLeftImg = $_POST['headerLeftImg'];
	$customHeaderLeftImg = $_POST['customHeaderLeftImg'];
	$headerImg = $_POST['headerImg'];
	$customHeaderImg = $_POST['customHeaderImg'];
	$headerSubtitleSelect = $_POST['headerSubtitleSelect'];
	$headerSubtitleText = formatText($_POST['headerSubtitleText']);
	$headerTitleSelect = $_POST['headerTitleSelect'];
	$headerTitleText = formatText($_POST['headerTitleText']);
	$menuType = $_POST['menuType'];
	$menuSpeed = $_POST['menuSpeed'];
	$customGlobalFontSize = $_POST['customGlobalFontSize'];
	$customGraphFontSize = $_POST['customGraphFontSize'];
	$customFooterDisplay = $_POST['customFooterDisplay'];
	$customFooterText = formatText($_POST['customFooterText']);

	// added version 7
	$stationWarnings = $_POST['stationWarnings'];
	$stationWarningsInterval = $_POST['stationWarningsInterval'];
		if($stationWarnings=="1"){
			$stationWarnings = "true";
		}
		else{
			$stationWarnings = "false";
		}
	$warningHighT = $_POST['warningHighT'];
	$warningLowT = $_POST['warningLowT'];
	$warningHighW = $_POST['warningHighW'];
	$warningHighR = $_POST['warningHighR'];
	$warningHighS = $_POST['warningHighS'];

	// added version 8

	$googleMapsAPIKey = formatText($_POST['googleMapsAPIKey']);
	$alertActive = $_POST['alertActive'];
		if($alertActive=="1"){
			$alertActive = "true";
		}
		else{
			$alertActive = "false";
		}
	$minimumAlertInterval = $_POST['minimumAlertInterval'];
	$alertEmail = $_POST['alertEmail'];

	$redirectMobiles = $_POST['redirectMobiles'];
		if($redirectMobiles=="1"){
			$redirectMobiles = "true";
		}
		else{
			$redirectMobiles = "false";
		}
	$redirectTablets = $_POST['redirectTablets'];
		if($redirectTablets=="1"){
			$redirectTablets = "true";
		}
		else{
			$redirectTablets = "false";
		}
	$maxWidthMobile = $_POST['maxWidthMobile'];
	if(!is_numeric($maxWidthMobile)){
		die("Please check the redirection widths, it must be a valid number in pixels.");
	}
	$minWidthDesktop = $_POST['minWidthDesktop'];
	if(!is_numeric($minWidthDesktop)){
		die("Please check the redirection widths, it must be a valid number in pixels.");
	}

	$stationElevation = $_POST['stationElevation'];
	if(!is_numeric($stationElevation)){
		die("Please check your station elevation, it must be a valid number.");
	}
	$stationElevationUnits = $_POST['stationElevationUnits'];


	// added version 10
	$mobileHeaderImg = $_POST['mobileHeaderImg'];
	$customPageSearch = $_POST['customPageSearch'];
		if($customPageSearch=="1"){
			$customPageSearch = "true";
		}
		else{
			$customPageSearch = "false";
		}
	$searchCode = $_POST['searchCode'];
	$headerConditions = $_POST['headerConditions'];
		if($headerConditions=="1"){
			$headerConditions = "true";
		}
		else{
			$headerConditions = "false";
		}
	$headerConditionsInterval = $_POST['headerConditionsInterval'];
	$fIOKey = $_POST['fIOKey'];
	$fIOLanguage = $_POST['fIOLanguage'];

	// added version 13
	$stationState = $_POST['stationState'];
	$hideAdminEntrance = $_POST['hideAdminEntrance'];
		if($hideAdminEntrance=="1"){
			$hideAdminEntrance = "true";
		}
		else{
			$hideAdminEntrance = "false";
		}
	$hideHelpOpener = $_POST['hideHelpOpener'];
		if($hideHelpOpener=="1"){
			$hideHelpOpener = "true";
		}
		else{
			$hideHelpOpener = "false";
		}
	$hideMultipleBlockBorder = $_POST['hideMultipleBlockBorder'];
		if($hideMultipleBlockBorder=="1"){
			$hideMultipleBlockBorder = "true";
		}
		else{
			$hideMultipleBlockBorder = "false";
		}
	$highlightMenuHover = $_POST['highlightMenuHover'];
		if($highlightMenuHover=="1"){
			$highlightMenuHover = "true";
		}
		else{
			$highlightMenuHover = "false";
		}
	$flatDesignDesktop = $_POST['flatDesignDesktop'];
		if($flatDesignDesktop=="1"){
			$flatDesignDesktop = "true";
		}
		else{
			$flatDesignDesktop = "false";
		}
	$flatDesignMobile = $_POST['flatDesignMobile'];
		if($flatDesignMobile=="1"){
			$flatDesignMobile = "true";
		}
		else{
			$flatDesignMobile = "false";
		}
	$blockMaximizeDesktop = $_POST['blockMaximizeDesktop'];
		if($blockMaximizeDesktop=="1"){
			$blockMaximizeDesktop = "true";
		}
		else{
			$blockMaximizeDesktop = "false";
		}
	$blockMaximizeMobile = $_POST['blockMaximizeMobile'];
		if($blockMaximizeMobile=="1"){
			$blockMaximizeMobile = "true";
		}
		else{
			$blockMaximizeMobile = "false";
		}
	$blockExportDesktop = $_POST['blockExportDesktop'];
		if($blockExportDesktop=="1"){
			$blockExportDesktop = "true";
		}
		else{
			$blockExportDesktop = "false";
		}
	$blockExportMobile = $_POST['blockExportMobile'];
		if($blockExportMobile=="1"){
			$blockExportMobile = "true";
		}
		else{
			$blockExportMobile = "false";
		}

	$flagIconShape = $_POST['flagIconShape'];
	$defaultPaperSize = $_POST['defaultPaperSize'];

	$templateUpdateCheck = $_POST['templateUpdateCheck'];
		if($templateUpdateCheck=="1"){
			$templateUpdateCheck = "true";
		}
		else{
			$templateUpdateCheck = "false";
		}

	$titleSmallCaps = $_POST['titleSmallCaps'];
		if($titleSmallCaps=="1"){
			$titleSmallCaps = "true";
		}
		else{
			$titleSmallCaps = "false";
		}
	
	$titleBoldText = $_POST['titleBoldText'];
		if($titleBoldText=="1"){
			$titleBoldText = "true";
		}
		else{
			$titleBoldText = "false";
		}
	
	$subtitleSmallCaps = $_POST['subtitleSmallCaps'];
		if($subtitleSmallCaps=="1"){
			$subtitleSmallCaps = "true";
		}
		else{
			$subtitleSmallCaps = "false";
		}

	$subtitleBoldText = $_POST['subtitleBoldText'];
		if($subtitleBoldText=="1"){
			$subtitleBoldText = "true";
		}
		else{
			$subtitleBoldText = "false";
		}
	
	$menuLinksUpper = $_POST['menuLinksUpper'];
		if($menuLinksUpper=="1"){
			$menuLinksUpper = "true";
		}
		else{
			$menuLinksUpper = "false";
		}

	$addSharer = $_POST['addSharer'];
		if($addSharer=="1"){
			$addSharer = "true";
		}
		else{
			$addSharer = "false";
		}
	
	$moreLinkHighlight = $_POST['moreLinkHighlight'];
		if($moreLinkHighlight=="1"){
			$moreLinkHighlight = "true";
		}
		else{
			$moreLinkHighlight = "false";
		}

	$footerSeasonImages = $_POST['footerSeasonImages'];
		if($footerSeasonImages=="1"){
			$footerSeasonImages = "true";
		}
		else{
			$footerSeasonImages = "false";
		}

	$footerSeasonImagesType = $_POST['footerSeasonImagesType'];

	$enableAdminIP = $_POST['enableAdminIP'];
		if($enableAdminIP=="1"){
			$enableAdminIP = "true";
		}
		else{
			$enableAdminIP = "false";
		}
	$adminIPs = $_POST['adminIPs'];
	$apiRRCalculation = $_POST['apiRRCalculation'];
	$showFooterStationStatus = $_POST['showFooterStationStatus'];
		if($showFooterStationStatus=="1"){
			$showFooterStationStatus = "true";
		}
		else{
			$showFooterStationStatus = "false";
		}
	
	// version 16
	$areaNormalsTUnits = $_POST['areaNormalsTUnits'];
	$areaNormalsT = $_POST['areaNormalsT'];

	$areaNormalsRUnits = $_POST['areaNormalsRUnits'];
	$areaNormalsR = $_POST['areaNormalsR'];

	$enableKeyboard = $_POST['enableKeyboard'];
		if($enableKeyboard=="1"){
			$enableKeyboard = "true";
		}
		else{
			$enableKeyboard = "false";
		}

	$multiplierT = $_POST['multiplierT'];
	if(!is_numeric($multiplierT)){
		$multiplierT = 0;
	}
	$multiplierR = $_POST['multiplierR'];
	if(!is_numeric($multiplierR)){
		$multiplierR = 1;
	}
	$multiplierW = $_POST['multiplierW'];
	if(!is_numeric($multiplierW)){
		$multiplierW = 1;
	}
	$multiplierP = $_POST['multiplierP'];
	if(!is_numeric($multiplierP)){
		$multiplierP = 0;
	}

	// version 17
	$mobileHomepageType = $_POST['mobileHomepageType'];

	#################################################################################################################
	#################################################################################################################

	function formatText($text){ // make sure there are no apostrophes, which would cause errors in config
		$text = str_replace("'","\'",$text);
		return($text);
	}

	// Create file
	$string = "<?php".PHP_EOL;

	$string .=" // Meteotemplate Configuration File".PHP_EOL;

	$string .= PHP_EOL;
	$string .= PHP_EOL;

	$string .= "error_reporting(0);".PHP_EOL;

	$string .= "if(isset(\$_GET['errors'])) { error_reporting(E_ALL); ini_set('display_errors', 'On'); }".PHP_EOL;

	$string .= PHP_EOL;
	$string .= PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$templateVersion = ".$templateVersion.";".PHP_EOL;
	$string .= "\$versionName = '".$versionName."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$dbName = '".$mySQLName."';".PHP_EOL;
	$string .= "\$con = mysqli_connect('$mySQLHost','$mySQLUser','$mySQLPassword',\$dbName);".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$lang = '".$lang."';".PHP_EOL;
	$string .= "\$langAvailable = array(".implode(",",$langAvailable).");".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$path = '".$path."';".PHP_EOL;
	$string .= "\$pageURL = '".$pageURL."';".PHP_EOL;
	$string .= "\$baseURL = dirname(__FILE__).\"/\";".PHP_EOL;

	$string .= "\$adminPassword = '".$adminPassword."';".PHP_EOL;
	$string .= "\$updatePassword = '".$updatePassword."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$displayTempUnits = '".$displayTempUnits."';".PHP_EOL;
	$string .= "\$displayRainUnits = '".$displayRainUnits."';".PHP_EOL;
	$string .= "\$displayWindUnits = '".$displayWindUnits."';".PHP_EOL;
	$string .= "\$displayPressUnits = '".$displayPressUnits."';".PHP_EOL;
	$string .= "\$displayCloudbaseUnits = '".$displayCloudbaseUnits."';".PHP_EOL;
	$string .= "\$displayVisibilityUnits = '".$displayVisibilityUnits."';".PHP_EOL;
	$string .= "\$dataTempUnits = '".$dataTempUnits."';".PHP_EOL;
	$string .= "\$dataRainUnits = '".$dataRainUnits."';".PHP_EOL;
	$string .= "\$dataWindUnits = '".$dataWindUnits."';".PHP_EOL;
	$string .= "\$dataPressUnits = '".$dataPressUnits."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$limitTempMin = ".$limitTempMin.";".PHP_EOL;
	$string .= "\$limitTempMax = ".$limitTempMax.";".PHP_EOL;
	$string .= "\$limitHumidityMin = ".$limitHumidityMin.";".PHP_EOL;
	$string .= "\$limitHumidityMax = ".$limitHumidityMax.";".PHP_EOL;
	$string .= "\$limitPressureMin = ".$limitPressureMin.";".PHP_EOL;
	$string .= "\$limitPressureMax = ".$limitPressureMax.";".PHP_EOL;
	$string .= "\$limitRainMin = ".$limitRainMin.";".PHP_EOL;
	$string .= "\$limitRainMax = ".$limitRainMax.";".PHP_EOL;
	$string .= "\$limitRainRateMin = ".$limitRainRateMin.";".PHP_EOL;
	$string .= "\$limitRainRateMax = ".$limitRainRateMax.";".PHP_EOL;
	$string .= "\$limitBearingMin = ".$limitBearingMin.";".PHP_EOL;
	$string .= "\$limitBearingMax = ".$limitBearingMax.";".PHP_EOL;
	$string .= "\$limitWindMin = ".$limitWindMin.";".PHP_EOL;
	$string .= "\$limitWindMax = ".$limitWindMax.";".PHP_EOL;
	$string .= "\$limitSolarMin = ".$limitSolarMin.";".PHP_EOL;
	$string .= "\$limitSolarMax = ".$limitSolarMax.";".PHP_EOL;

	$string .= "\$multiplierT = ".$multiplierT.";".PHP_EOL;
	$string .= "\$multiplierR = ".$multiplierR.";".PHP_EOL;
	$string .= "\$multiplierW = ".$multiplierW.";".PHP_EOL;
	$string .= "\$multiplierP = ".$multiplierP.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$stationLat = ".$stationLat.";".PHP_EOL;
	$string .= "\$stationLon = ".$stationLon.";".PHP_EOL;
	$string .= "\$stationCountry = '".$stationCountry."';".PHP_EOL;
	$string .= "\$stationLocation = '".$stationLocation."';".PHP_EOL;
	$string .= "\$stationState = '".$stationState."';".PHP_EOL;
	$string .= "\$stationTZ = '".$stationTZ."';".PHP_EOL;
	$string .= "\$stationMETAR = '".$stationMETAR."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$pageAuthor = '".$pageAuthor."';".PHP_EOL;
	$string .= "\$pageName = '".$pageName."';".PHP_EOL;
	$string .= "\$pageDesc = '".$pageDesc."';".PHP_EOL;
	$string .= "\$stationModel = '".$stationModel."';".PHP_EOL;
	$string .= "\$stationIcon = '".$stationIcon."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$design = '".$design."';".PHP_EOL;
	$string .= "\$design2 = '".$design2."';".PHP_EOL;
	$string .= "\$designFont = '".$designFont."';".PHP_EOL;
	$string .= "\$designFont2 = '".$designFont2."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$gradient = ".$gradient.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$solarSensor = ".$solarSensor.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$dateFormat = '".$dateFormat."';".PHP_EOL;
	$string .= "\$timeFormat = '".$timeFormat."';".PHP_EOL;
	$string .= "\$dateTimeFormat = '".$dateTimeFormat."';".PHP_EOL;
	$string .= "\$prefferedDate = '".$prefferedDate."';".PHP_EOL;
	$string .= "\$prefferedTime = '".$prefferedTime."';".PHP_EOL;
	$string .= "\$firstWeekday = ".$firstWeekday.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$graphTimeFormat = '".$graphTimeFormat."';".PHP_EOL;
	$string .= "\$graphDateFormat = '".$graphDateFormat."';".PHP_EOL;
	$string .= "\$defaultPaperSize = '".$defaultPaperSize."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$bannerID = '".$bannerID."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$climateID = '".$climateID."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$areaNormalsTUnits = '".$areaNormalsTUnits."';".PHP_EOL;
	$string .= "\$areaNormalsT = '".$areaNormalsT."';".PHP_EOL;
	$string .= "\$areaNormalsRUnits = '".$areaNormalsRUnits."';".PHP_EOL;
	$string .= "\$areaNormalsR = '".$areaNormalsR."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$userCustomColor = ".$userCustomColor.";".PHP_EOL;
	$string .= "\$userCustomFont = ".$userCustomFont.";".PHP_EOL;
	$string .= "\$userCustomUnits = ".$userCustomUnits.";".PHP_EOL;
	$string .= "\$userCustomLang = ".$userCustomLang.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$paypalButton = ".$paypalButton.";".PHP_EOL;
	$string .= "\$paypalButtonCode = '".$paypalButtonCode."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$wuIcon = ".$wuIcon.";".PHP_EOL;
	$string .= "\$wuStationID = '".$wuStationID."';".PHP_EOL;
	$string .= "\$awekasIcon = ".$awekasIcon.";".PHP_EOL;
	$string .= "\$awekasID = '".$awekasID."';".PHP_EOL;
	$string .= "\$cwopIcon = ".$cwopIcon.";".PHP_EOL;
	$string .= "\$cwopID = '".$cwopID."';".PHP_EOL;
	$string .= "\$weathercloudIcon = ".$weathercloudIcon.";".PHP_EOL;
	$string .= "\$weathercloudID = '".$weathercloudID."';".PHP_EOL;
	$string .= "\$WOWMetofficeIcon = ".$WOWMetofficeIcon.";".PHP_EOL;
	$string .= "\$WOWMetofficeID = '".$WOWMetofficeID."';".PHP_EOL;
	$string .= "\$pwsIcon = ".$pwsIcon.";".PHP_EOL;
	$string .= "\$pwsID = '".$pwsID."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$tempGaugeMin = ".$tempGaugeMin.";".PHP_EOL;
	$string .= "\$tempGaugeMax = ".$tempGaugeMax.";".PHP_EOL;
	$string .= "\$pressureGaugeMin = ".$pressureGaugeMin.";".PHP_EOL;
	$string .= "\$pressureGaugeMax = ".$pressureGaugeMax.";".PHP_EOL;
	$string .= "\$windGaugeMin = ".$windGaugeMin.";".PHP_EOL;
	$string .= "\$gustGaugeMin = ".$gustGaugeMin.";".PHP_EOL;
	$string .= "\$windGaugeMax = ".$windGaugeMax.";".PHP_EOL;
	$string .= "\$gustGaugeMax = ".$gustGaugeMax.";".PHP_EOL;
	$string .= "\$rainGaugeMin = ".$rainGaugeMin.";".PHP_EOL;
	$string .= "\$rainGaugeMax = ".$rainGaugeMax.";".PHP_EOL;
	$string .= "\$solarGaugeMin = ".$solarGaugeMin.";".PHP_EOL;
	$string .= "\$solarGaugeMax = ".$solarGaugeMax.";".PHP_EOL;
	$string .= "\$apiRRCalculation = '".$apiRRCalculation."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$defaultGraphInterval = '".$defaultGraphInterval."';".PHP_EOL;
	$string .= "\$defaultGraphParameter = '".$defaultGraphParameter."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$fIOKey = '".$fIOKey."';".PHP_EOL;
	$string .= "\$fIOLanguage = '".$fIOLanguage."';".PHP_EOL;
	$string .= "\$WWOApiKey = '".$WWOApiKey."';".PHP_EOL;
	$string .= "\$WWOLocation = '".$WWOLocation."';".PHP_EOL;
	$string .= "\$WWOCacheTime = '".$WWOCacheTime."';".PHP_EOL;
	$string .= "\$aerisID = '".$aerisID."';".PHP_EOL;
	$string .= "\$aerisSecret = '".$aerisSecret."';".PHP_EOL;
	$string .= "\$aerisCacheTime = '".$aerisCacheTime."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$googleAnalytics = ".$googleAnalytics.";".PHP_EOL;
	$string .= "\$GAcode = '".$GAcode."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$enableAdminIP = ".$enableAdminIP.";".PHP_EOL;
	$string .= "\$adminIPs = '".$adminIPs."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$customBgColor1 = '".$customBgColor1."';".PHP_EOL;
	$string .= "\$customBgColor2 = '".$customBgColor2."';".PHP_EOL;
	$string .= "\$customBgColor3 = '".$customBgColor3."';".PHP_EOL;
	$string .= "\$customBgColor4 = '".$customBgColor4."';".PHP_EOL;
	$string .= "\$customBgType = '".$customBgType."';".PHP_EOL;
	$string .= "\$customBgImg = '".$customBgImg."';".PHP_EOL;
	$string .= "\$customMaxWidth = '".$customMaxWidth."';".PHP_EOL;
	$string .= "\$customBlockRadius = '".$customBlockRadius."';".PHP_EOL;
	$string .= "\$customBlockBevel = '".$customBlockBevel."';".PHP_EOL;
	$string .= "\$customBlockBorderWidth = '".$customBlockBorderWidth."';".PHP_EOL;
	$string .= "\$customHeadingShadow = '".$customHeadingShadow."';".PHP_EOL;
	$string .= "\$customBodyTextShadow = '".$customBodyTextShadow."';".PHP_EOL;
	$string .= "\$headerLeftImg = '".$headerLeftImg."';".PHP_EOL;
	$string .= "\$flagIconShape = '".$flagIconShape."';".PHP_EOL;
	$string .= "\$customHeaderLeftImg = '".$customHeaderLeftImg."';".PHP_EOL;
	$string .= "\$mobileHeaderImg = '".$mobileHeaderImg."';".PHP_EOL;
	$string .= "\$headerImg = '".$headerImg."';".PHP_EOL;
	$string .= "\$customHeaderImg = '".$customHeaderImg."';".PHP_EOL;
	$string .= "\$headerSubtitleSelect = '".$headerSubtitleSelect."';".PHP_EOL;
	$string .= "\$headerSubtitleText = '".$headerSubtitleText."';".PHP_EOL;
	$string .= "\$headerTitleSelect = '".$headerTitleSelect."';".PHP_EOL;
	$string .= "\$headerTitleText = '".$headerTitleText."';".PHP_EOL;
	$string .= "\$menuType = '".$menuType."';".PHP_EOL;
	$string .= "\$menuSpeed = '".$menuSpeed."';".PHP_EOL;
	$string .= "\$highlightMenuHover = ".$highlightMenuHover.";".PHP_EOL;
	$string .= "\$customGlobalFontSize = '".$customGlobalFontSize."';".PHP_EOL;
	$string .= "\$customGraphFontSize = '".$customGraphFontSize."';".PHP_EOL;
	$string .= "\$customFooterDisplay = '".$customFooterDisplay."';".PHP_EOL;
	$string .= "\$customFooterText = '".$customFooterText."';".PHP_EOL;
	$string .= "\$headerConditions = ".$headerConditions.";".PHP_EOL;
	$string .= "\$headerConditionsInterval = ".$headerConditionsInterval.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$hideAdminEntrance = ".$hideAdminEntrance.";".PHP_EOL;
	$string .= "\$hideHelpOpener = ".$hideHelpOpener.";".PHP_EOL;
	$string .= "\$hideMultipleBlockBorder = ".$hideMultipleBlockBorder.";".PHP_EOL;
	$string .= "\$flatDesignDesktop = ".$flatDesignDesktop.";".PHP_EOL;
	$string .= "\$flatDesignMobile = ".$flatDesignMobile.";".PHP_EOL;
	$string .= "\$blockMaximizeDesktop = ".$blockMaximizeDesktop.";".PHP_EOL;
	$string .= "\$blockMaximizeMobile = ".$blockMaximizeMobile.";".PHP_EOL;
	$string .= "\$blockExportDesktop = ".$blockExportDesktop.";".PHP_EOL;
	$string .= "\$blockExportMobile = ".$blockExportMobile.";".PHP_EOL;
	

	$string .= PHP_EOL;
	$string .= "\$stationWarnings = ".$stationWarnings.";".PHP_EOL;
	$string .= "\$stationWarningsInterval = '".$stationWarningsInterval."';".PHP_EOL;
	$string .= "\$warningHighT = '".$warningHighT."';".PHP_EOL;
	$string .= "\$warningLowT = '".$warningLowT."';".PHP_EOL;
	$string .= "\$warningHighW = '".$warningHighW."';".PHP_EOL;
	$string .= "\$warningHighR = '".$warningHighR."';".PHP_EOL;
	$string .= "\$warningHighS = '".$warningHighS."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$googleMapsAPIKey = '".$googleMapsAPIKey."';".PHP_EOL;
	$string .= "\$alertActive = ".$alertActive.";".PHP_EOL;
	$string .= "\$minimumAlertInterval = ".$minimumAlertInterval.";".PHP_EOL;
	$string .= "\$alertEmail = '".$alertEmail."';".PHP_EOL;
	$string .= "\$customPageSearch = ".$customPageSearch.";".PHP_EOL;
	$string .= "\$searchCode = '".$searchCode."';".PHP_EOL;
	$string .= "\$addSharer = ".$addSharer.";".PHP_EOL;
	$string .= "\$enableKeyboard = ".$enableKeyboard.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$redirectMobiles = ".$redirectMobiles.";".PHP_EOL;
	$string .= "\$redirectTablets = ".$redirectTablets.";".PHP_EOL;
	$string .= "\$maxWidthMobile = ".$maxWidthMobile.";".PHP_EOL;
	$string .= "\$minWidthDesktop = ".$minWidthDesktop.";".PHP_EOL;
	$string .= "\$mobileHomepageType = '".$mobileHomepageType."';".PHP_EOL;
	

	$string .= PHP_EOL;
	$string .= "\$stationElevation = ".$stationElevation.";".PHP_EOL;
	$string .= "\$stationElevationUnits = '".$stationElevationUnits."';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$templateUpdateCheck = ".$templateUpdateCheck.";".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$meteotemplateURL = 'http://www.meteotemplate.com';".PHP_EOL;

	$string .= PHP_EOL;
	$string .= "\$titleSmallCaps = ".$titleSmallCaps.";".PHP_EOL;
	$string .= "\$titleBoldText = ".$titleBoldText.";".PHP_EOL;
	$string .= "\$subtitleSmallCaps = ".$subtitleSmallCaps.";".PHP_EOL;
	$string .= "\$subtitleBoldText = ".$subtitleBoldText.";".PHP_EOL;
	$string .= "\$menuLinksUpper = ".$menuLinksUpper.";".PHP_EOL;
	$string .= "\$moreLinkHighlight = ".$moreLinkHighlight.";".PHP_EOL;
	$string .= "\$footerSeasonImages = ".$footerSeasonImages.";".PHP_EOL;
	$string .= "\$footerSeasonImagesType = '".$footerSeasonImagesType."';".PHP_EOL;
	$string .= "\$showFooterStationStatus = ".$showFooterStationStatus.";".PHP_EOL;
	

	$string .= PHP_EOL;
	$string .= PHP_EOL;
	$string .= PHP_EOL;
	$string .= '$cookie_name = "weatherTemplate";'.PHP_EOL;
	$string .= 'if(!isset($_COOKIE[$cookie_name])) {}'.PHP_EOL;
	$string .= 'else {'.PHP_EOL;
	$string .= '	if(!isset($doNotLoadCookie)){'.PHP_EOL;
	$string .= '		$rawCookie = $_COOKIE[$cookie_name];'.PHP_EOL;
	$string .= '		$cookieValues = explode(";",$rawCookie);'.PHP_EOL;
	$string .= '		if($userCustomColor){'.PHP_EOL;
	$string .= '			$design = $cookieValues[0];'.PHP_EOL;
	$string .= '			$design2 = $cookieValues[1];'.PHP_EOL;
	$string .= '		}'.PHP_EOL;
	$string .= '		if($userCustomUnits){'.PHP_EOL;
	$string .= '			$displayTempUnits = $cookieValues[2];'.PHP_EOL;
	$string .= '			$displayRainUnits = $cookieValues[3];'.PHP_EOL;
	$string .= '			$displayWindUnits = $cookieValues[4];'.PHP_EOL;
	$string .= '			$displayPressUnits = $cookieValues[5];'.PHP_EOL;
	$string .= '			$displayCloudbaseUnits = $cookieValues[6];'.PHP_EOL;
	$string .= '			$displayVisibilityUnits = $cookieValues[7];'.PHP_EOL;
	$string .= '		}'.PHP_EOL;
	$string .= '		if($userCustomFont){'.PHP_EOL;
	$string .= '			$designFont = $cookieValues[8];'.PHP_EOL;
	$string .= '			$designFont2 = $cookieValues[9];'.PHP_EOL;
	$string .= '		}'.PHP_EOL;
	$string .= '		if($userCustomLang){'.PHP_EOL;
	$string .= '			$lang = $cookieValues[10];'.PHP_EOL;
	$string .= '		}'.PHP_EOL;
	$string .= '	}'.PHP_EOL;
	$string .= '}'.PHP_EOL;
	$string .= '$climateUnitsTemp = $displayTempUnits;'.PHP_EOL;
	$string .= '$climateUnitsRain = $displayRainUnits;'.PHP_EOL;
	$string .= '$climateUnitsElevation = $displayCloudbaseUnits;'.PHP_EOL;
	$string .= PHP_EOL;
	$string .= 'date_default_timezone_set($stationTZ);'.PHP_EOL;
	$string .= '$now = new DateTime();'.PHP_EOL;
	$string .= '$mins = $now->getOffset() / 60;'.PHP_EOL;
	$string .= '$sgn = ($mins < 0 ? -1 : 1);'.PHP_EOL;
	$string .= '$mins = abs($mins);'.PHP_EOL;
	$string .= '$hrs = floor($mins / 60);'.PHP_EOL;
	$string .= '$mins -= $hrs * 60;'.PHP_EOL;
	$string .= '$offset = sprintf("%+d:%02d", $hrs*$sgn, $mins);'.PHP_EOL;
	$string .= 'mysqli_query($con,"SET time_zone=\'$offset\'");'.PHP_EOL;
	$string .= PHP_EOL;


	$string .= "?>".PHP_EOL;

	if(file_exists("../config.php")){
		unlink("../config.php");
	}
	file_put_contents("../config.php",$string);
	chmod("../config.php",0777);

	// check file exists

	if(!file_exists("../config.php")){
		echo "<script>alert('Config file could not be created! Check that permissions for the template root folder are set correctly to write files in there!');close();</script>";
	}
	else{
		print "<script>alert('Config created/updated.');close();</script>";
	}
?>
