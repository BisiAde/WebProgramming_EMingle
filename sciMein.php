<?php
ob_start();//https://stackoverflow.com/a/9709170
session_start();

$debug = false;

/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
*/

include('services.php');

validatePost();

authenticateUser();
// MyauthenticateUser2();




if( $GLOBALS['debug'] === false )
{
	monitorURL();
}

parsePost();

function authenticateUser()
{
	if( isset($_SESSION['authenticationFlag']) === false )
	{
		$userDetails = array();
		$shouldRedirectFlag = false;

		if( isset($_POST["email"]) === false || isset($_POST["password"]) === false )
		{
			$_SESSION['index.php.msg'] = 'Please login';
			$shouldRedirectFlag = true;
		}
		else
		{
			if( strlen(trim($_POST["email"])) === 0 || strlen(trim($_POST["password"])) === 0 )
			{
				$_SESSION['index.php.msg'] = 'Please login';
				$shouldRedirectFlag = true;
			}
			else
			{
				$userDetails = login( $_POST['email'], $_POST['password'] );
				if( count($userDetails) === 0 )
				{
					$_SESSION['index.php.msg'] = 'Incorrect email or password';
					$shouldRedirectFlag = true;
				}
			}
		}


		if( $shouldRedirectFlag === true )
		{	
			$newLocation = 'index.php';

			if( isset($_GET['channel']) )
			{
				$newLocation = $newLocation . '?channel=' . $_GET['channel'];
				if( isset($_GET['post']) )
				{
					$newLocation .= '&post=' . $_GET['post'];
				}

				if( isset($_GET['page']) )
				{
					$newLocation .= '&page=' . $_GET['page'];
				}
			}

			header('Location: ' . $newLocation);
			exit;
		}
		else
		{	
			if( is2FAUser($userDetails['user_id']) && validate2FAChallenge($userDetails['user_id'], $_POST['security_code']) == false )
			{
				
				$randStr = getKRandStr(4);
				//consider not sending email too often
				sendEmail($_POST["email"], 'Security code: ' . $randStr . ' expires in 10mins', 'CS Slack Security code');
				
				setTwoFactor(
					$userDetails['user_id'],
					1,
					$randStr
				);
				$_SESSION['curPost'] = $_POST;

				header('Location: 2FA.php');
				exit;
			}

			$_SESSION['config'] = array(
					'history_size' => 10,
					'paginationSize' => 10,
				);

			$_SESSION['authenticationFlag'] = $userDetails;
			$_SESSION['authenticationFlag']['email'] = $_POST["email"];
			unset($_SESSION['index.php.msg']);
		}
	}
}



function MyauthenticateUser2()
{
	if( isset($_SESSION['authenticationFlag']) === false )
	{
		$userDetails = array();
		$shouldRedirectFlag = false;

	if( isset($_POST["code"]) === false || isset($_POST["password"]) === false)
		{
			$_SESSION['index.php.msg'] = 'Please off either password is false or code';
			$shouldRedirectFlag = true;
		} 
		else
		{
		if( strlen(trim($_POST["code"])) === 0 ||  strlen(trim($_POST["password"])) === 0 )
			{
				$_SESSION['index.php.msg'] = 'Please if I reason you, Post code is 0';
				$shouldRedirectFlag = true;
			}
			else
			{
				$userDetails = login2( $_POST['code'], $_POST['password'] ); 
				if( count($userDetails) === 0 )
				{
					$_SESSION['index.php.msg'] = 'Incorrect code or password';
					$shouldRedirectFlag = true;
				}
			}
		}


		if( $shouldRedirectFlag === true )
		{	
			$newLocation = 'index.php';

			if( isset($_GET['channel']) )
			{
				$newLocation = $newLocation . '?channel=' . $_GET['channel'];
				if( isset($_GET['post']) )
				{
					$newLocation .= '&post=' . $_GET['post'];
				}

				if( isset($_GET['page']) )
				{
					$newLocation .= '&page=' . $_GET['page'];
				}
			}

			header('Location: ' . $newLocation);
			exit;
		}
		else
		{	
			if( is2FAUser($userDetails['user_id']) && validate2FAChallenge($userDetails['user_id'], $_POST['security_code']) == false )
			{
				
				$randStr = getKRandStr(4);
				//consider not sending email too often
				sendEmail($_POST["email"], 'Security code: ' . $randStr . ' expires in 10mins', 'CS Slack Security code');
				
				setTwoFactor(
					$userDetails['user_id'],
					1,
					$randStr
				);
				$_SESSION['curPost'] = $_POST;

				header('Location: 2FA.php');
				exit;
			}

			$_SESSION['config'] = array(
					'history_size' => 10,
					'paginationSize' => 10,
				);

			$_SESSION['authenticationFlag'] = $userDetails;
			$_SESSION['authenticationFlag']['password'] = $_POST["password"];
			unset($_SESSION['index.php.msg']);
		}
	}
}


function monitorURL()
{
	$shouldRedirectFlag = false;
	$newLocation = $_SERVER['REQUEST_URI'];

	//review - start
	/*if( isset($_GET['channel']) === false )
	{
		$shouldRedirectFlag = true;
		$newLocation .= '?channel=general';
	}*/
	//review - end

	if( isset($_GET['page']) === false )
	{
		$shouldRedirectFlag = true;
		$newLocation .= '&page=1';
	}

	if( $shouldRedirectFlag == true )
	{
		header('Location: ' . $newLocation);	
		//exit;
	}
}

function parsePost()
{
	if( isset($_POST) === false )
	{
		return;
	}

	if( $GLOBALS['debug'] === true )
	{
		//var_dump( $_POST );
		//var_dump( $_FILES );
		//return;
	}

	if( isset($_POST['channel_state']) )
	{
		if( $_POST['channel_state'] != 'ACTIVE' )
		{
			return;
		}
	}

	$user_id = $_SESSION['authenticationFlag']['user_id'];
	$fname = $_SESSION['authenticationFlag']['fname'];
	$lname = $_SESSION['authenticationFlag']['lname'];
	// $code = $_SESSION['authenticationFlag']['code'];

	
	if( isset($_POST['delete']) ) 
	{
		//delete
		if( $_SESSION['authenticationFlag']['role_type'] == 'ADMIN' )
		{
			$post_id = $_POST['post_id'];	
			if( isset($_POST['post_img_id']) )
			{
				unlink($_POST['post_img_id']);
			}
			deletePost($post_id, $_POST['post_user_id']);
		}
	}
	else if( isset($_POST['post']) )
	{
		$content = trim($_POST['post']);
		
		//image upload - start
		$imgLinks = array();
		if( $_FILES )
		{	
			if( strlen($_FILES['mkfile']['name']) != 0 )
			{
				
				#this is an image
				$uploadfile = './postImgs/' . getKRandStr(10) . '.jpg';
				if( uploadImage($_FILES, 'image', $uploadfile) == 'go' )
				{
					array_push($imgLinks, $uploadfile);
				}
			}
			
			if( strlen($_FILES['mkfile-gen']['name']) != 0 )
			{
				//this is a generic upload file or image
				$type = explode('/', $_FILES['mkfile-gen']['type'])[0];
				$exn = explode('.', $_FILES['mkfile-gen']['name']);
				$filename = $exn[0];
				$optImg = '';
				
				if( count($exn) > 1 )
				{
					$exn = $exn[1];
				}
				else
				{
					$exn = 'exn';
				}

				if( $exn == 'php' )
				{
					$exn = 'txt';
				}

				$uploadfile = './postImgs/' . getKRandStr(10) . '.' . $exn;
				
				if( $type == 'image' )
				{
					$optImg = "<img alt='file thumbnail' class='postIcon' src='$uploadfile'>";
				}

				if( uploadImage($_FILES, $type, $uploadfile, 'mkfile-gen') == 'go' )
				{
					$content = addDownloadLinkToPost($content, $filename, $uploadfile, $optImg);
				}
			}
		}

		$imgLinks = array_merge( 
			$imgLinks,
			getImgLinksFromText($content)
		);
		$content = addImgLinksToPost($content, $imgLinks);
		//image upload - end

		if( strlen($content) !== 0 )
		{	
			//post at a channel
			$channel_id = $_POST['channel_id'];
			$parent_id = -1;

			if( isset($_POST['post_id']) )
			{
				//this is a reply
				$parent_id = $_POST['post_id'];
			}

			if( isset($_POST['pre_tag']) )
			{
				$content = '<pre>' . $content . '</pre>';
			}

			$extra = array(
				'pair_user_id' => $_POST['pair_user_id']
			);

			post($user_id, $fname, $lname, $channel_id, $parent_id, $content, $extra);
			focusOnPost( $_POST['post_id'] );
		}
		else if( isset($_POST['reaction']) )
		{
			$post_id = $_POST['post_id'];
			$user_id = $_POST['user_id'];
			$reaction_type_id = -1;
			
			//consider review (tight coupling) - start
			foreach ($_POST as $key => $value) 
			{
				if( strpos($key, 'reaction-') !== false )
				{
					$reaction_type_id = explode('reaction-', $key);
					$reaction_type_id = $reaction_type_id[1];
				}
			}
			//consider review (tight coupling) - end

			if( $reaction_type_id !== -1 )
			{
				postReaction($reaction_type_id, $post_id, $user_id, $fname, $lname);
			}

			focusOnPost($post_id);
		}
	}
}

function focusOnPost($post_id)
{
	//set URL to current post replied
	if( isset($_GET['post']) === false )
	{
		//does not have &post= in URL
		if( strlen($post_id) != 0 )
		{
			$post_id = '&post=' . $post_id;
		}

		$newLocation = $_SERVER['REQUEST_URI'] . $post_id;
	}
	else
	{
		//has &post= in URL, but update with latest post after removing old id
		$newLocation = str_replace('&post=' . $_GET['post'], '', $_SERVER['REQUEST_URI']);
		$newLocation = $newLocation . '&post=' . $post_id;
	}

	header('Location: ' . $newLocation);
	exit;
}

function getCurChannel()
{
	//attempt to extract channel id from session channel dict using channel supplied from url param
	$channelInfo = array('channelName' => 'general', 'channelId' =>  1, 'post' => -1, 'state' => 'ACTIVE');

	if( isset($_GET['channel']) && isset($_SESSION['channels']) )
	{
		$channels = array_merge( 
			$_SESSION['channels']['pub-memb'], 
			$_SESSION['channels']['priv-memb'],
			$_SESSION['channels']['pub-non-memb']
		);
		
		$channel = genericGetFromArr($channels, $_GET['channel'], 'name');

		if( count($channel) != 0 )
		{
			$channelInfo['channelName'] = $channel['name'];
			$channelInfo['channelId'] = $channel['channel_id'];
			$channelInfo['state'] = $channel['state'];
		}
		else
		{
			//bad channel address, set default
			//header('Location: index.php');
			header('Location: main.php?channel=general&page=1');
			exit;
			
		}
	}

	if( isset($_GET['post']) )
	{
		if( is_numeric($_GET['post']) )
		{
			$channelInfo['post'] = $_GET['post'];	
		}
	}
	
	return $channelInfo;
}

function genericGetFromArr($allChannels, $key, $type='channel_id')
{
	
	for($i = 0; $i < count($allChannels); $i++)
	{
		if( isset($allChannels[$i][$type]) )
		{
			if( $allChannels[$i][$type] == $key )
				return $allChannels[$i];
		}
	}

	return array();
}

function getChannelPartitions($allChannels, $memberChannels)
{
	/*
		Create channel partitions:
		1. public channels user is a member of -- display in channel panel/profiles
		2. private channels user is a member of -- display in channel panel with lock sign logo
		2. public channels user is NOT a member -- display in browse
	*/

	$channelPartition = array();
	$channelPartition['pub-memb'] = array();
	$channelPartition['priv-memb'] = array();
	$channelPartition['pub-non-memb'] = array();

	if( count($allChannels) == 0 )
		return $channelPartition;
	
	$skipChannels = array();
	for($i = 0; $i < count($memberChannels); $i++)
	{
		$channel = genericGetFromArr($allChannels, $memberChannels[$i]['channel_id'], 'channel_id');
		if( count($channel) != 0 )
		{
			array_push($skipChannels, $channel['channel_id']);

			if( $channel['type'] == 'PUBLIC' )
			{
				array_push($channelPartition['pub-memb'], $channel);
			}
			else
			{
				array_push($channelPartition['priv-memb'], $channel);
			}
		}
	}

	for($i = 0; $i < count($allChannels); $i++)
	{
		if( $allChannels[$i]['type'] == 'PUBLIC' )
		{
			if( in_array($allChannels[$i]['channel_id'], $skipChannels) == false )
			{
				array_push($channelPartition['pub-non-memb'], $allChannels[$i]);
			}
		}
	}

	return $channelPartition;
}

function printPagePanel($maxPageSize)
{
	$root = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$page = 1;
	if( isset($_GET['page']) )
	{
		$root = str_replace('&page='.$_GET['page'], '', $root);
		$page = $_GET['page'];
	}

	$pages = pagination($page, $maxPageSize);
	echo '<div style="text-align:center; font-weight: bold; font-size:16px; padding-bottom: 5px;">';
	for($i = 0; $i<count($pages); $i++)
	{
		if( $pages[$i] == -1 )
		{
			echo '<span>...</span>';
		}
		else
		{
			echo '<a href="' . $root . '&page='. $pages[$i] . '">&nbsp;'. $pages[$i] .'&nbsp;</a>&nbsp;';
		}
	}
	echo '</div>';	
}

//credit: https://gist.github.com/kottenator/9d936eb3e4e3c3e02598
function pagination($c, $m) 
{
    $current = $c;
    $last = $m;
    $delta = 2;
    $left = $current - $delta;
    $right = $current + $delta + 1;
    $range = array();
    $rangeWithDots = array();
    $l = -1;

    for ($i = 1; $i <= $last; $i++) 
    {
        if ($i == 1 || $i == $last || $i >= $left && $i < $right) 
        {
            array_push($range, $i);
        }
    }

    for($i = 0; $i<count($range); $i++) 
    {
        if ($l != -1) 
        {
            if ($range[$i] - $l === 2) 
            {
                array_push($rangeWithDots, $l + 1);
            } 
            else if ($range[$i] - $l !== 1) 
            {
            	//-1 is used to mark ...
                array_push($rangeWithDots, -1);
            }
        }
        
        array_push($rangeWithDots, $range[$i]);
        $l = $range[$i];
    }

    return $rangeWithDots;
}

?>
<html>
<head>
	<script src="common.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>

	<link rel="stylesheet" type="text/css" href="style.css">
	<link href="https://fonts.googleapis.com/css?family=Inconsolata|Josefin+Slab" rel="stylesheet">
	 <link href="https://fonts.googleapis.com/css?family=Lato|Noto+Sans+KR|Oxygen" rel="stylesheet">
	<link rel="stylesheet" href="https://unpkg.com/purecss@1.0.0/build/pure-min.css" integrity="sha384-nn4HPE8lTHyVtfCBi5yW9d20FjT8BJwUXyWZT9InLYax14RDjBj46LmSztkmNP9w" crossorigin="anonymous">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
	<link rel="search" type="application/opensearchdescription+xml"
	title="Ievent SearchEngine" href="http://localhost/Ievent/opensearch.xml">
</head>
<body style="margin: 0; height: 100%; overflow: hidden;" onload="main()">

<div id="menuDiv" style="background-color: #0e374e; padding: 10px 0px 10px 0px; border-radius: 0px;">
	<table style="width: 100%;" align="center">
		<tr>

			<td width="20%" style="text-align:center;">
				<a style="color: white; text-decoration: none;" href="main.php?channel=general">Home</a>
				<i class="fas fa-home"></i>
			</td>

			<td width="20%" style="text-align:center;">
				<a style="color: white; text-decoration: none;" href="logout.php">Logout</a>
				<i class="fas fa-sign-in-alt"></i>
			</td>

			<td width="20%" style="text-align:center;">
				<a style="color: white; text-decoration: none;" href="chart_data.php">Analytics</a>
				<i class="fas fa-chart-line"></i>
			</td>

			<td width="20%" style="text-align:center;">
				<?php
					echo '<a style="color: white; text-decoration: none;" href="./profile.php?user=' . $_SESSION['authenticationFlag']['user_id'] . '" >My Profile</a>';
				?>
			</td>

			<td width="20%" style="text-align:center;">
				<a style="color: white; text-decoration: none;" href="help.php">Help</a>
			</td>

		</tr>
	</table>
</div>

<div class="leftmenu">
Channels:
<hr>
<?php
	$channels = genericGetAll('Channel');
	$memberChannels = genericGetAll('Channel_Membership', 'WHERE user_id=' . $_SESSION['authenticationFlag']['user_id']);
	$channelPartition = getChannelPartitions($channels, $memberChannels);

	$channels = array_merge( $channelPartition['pub-memb'], $channelPartition['priv-memb'] );
	echo '<ul style="list-style-type:none;">';//credit: https://stackoverflow.com/a/9709788
		echo '<li><a style="color: inherit; text-decoration: none;" href="./new.php"> + New Channel/Invite</a></li>';
		for( $i = 0; $i<count($channels); $i++ )
		{
			echo '<li>' . getHTMLForChannel( $channels[$i] ) . '</li>';
		}
	
		if( count($channelPartition['pub-non-memb']) != 0 )
		{
			echo '<br><li>Post to Subscribe to these channels:</li>';
			echo '<ul style="list-style-type:none;">';
				for( $i = 0; $i<count($channelPartition['pub-non-memb']); $i++ )
				{
					echo '<li>' . getHTMLForChannel( $channelPartition['pub-non-memb'][$i] ) . '</li>';
				}
			echo '</ul>';
		}
	echo '</ul>';

	$_SESSION['channels'] = array();
	$_SESSION['channels']['pub-memb'] = $channelPartition['pub-memb'];
	$_SESSION['channels']['priv-memb'] = $channelPartition['priv-memb'];
	$_SESSION['channels']['pub-non-memb'] = $channelPartition['pub-non-memb'];

?>
Direct Messages:
<hr>
<?php
	$users = genericGetAll('User', 'WHERE user_id!=' . $_SESSION['authenticationFlag']['user_id'], 'user_id, fname, lname');
	$_SESSION['users'] = $users;

	echo '<ul style="list-style-type:none;">';//credit: https://stackoverflow.com/a/9709788
	for($i = 0; $i<count($users); $i++)
	{
		echo '<li>' . getHTMLForUser( $_SESSION['authenticationFlag'], $users[$i], 'pair_user' ) . '</li>';
	}
	echo '</ul>';
?>
</div>
<br>
<div class="main">	
	<?php
		$msgExtraParams = array();
		$msgExtraParams['page_size'] = $_SESSION['config']['paginationSize'];
		$msgExtraParams['pair_user_id'] = "";//default not a direct msg
		$formPostAddr = '#';

		if( isset($_GET['page']) )
		{
			$msgExtraParams['page'] = $_GET['page'];
			
			if( $msgExtraParams['page'] == $_SESSION['config']['history_size'] && $msgExtraParams['page'] < 47 )
			{
				$_SESSION['config']['history_size'] += 4;
			}
		}
		else
		{	
			$msgExtraParams['page'] = 1;
		}

		printPagePanel( $_SESSION['config']['history_size'] );
		$channelInfo = getCurChannel();
		$reactionTypes = genericGetAll('Reaction_Type');

		$msgExtraParams['reactionTypes'] = $reactionTypes;
		$msgExtraParams['role_type'] = $_SESSION['authenticationFlag']['role_type'];
		$msgExtraParams['state'] = $channelInfo['state'];

		$payload = array(
			'channel_info' => $channelInfo,
			'msg_extra_params' => $msgExtraParams,
			'user_id' => $_SESSION['authenticationFlag']['user_id'],
			'fname' => $_SESSION['authenticationFlag']['fname'],
			'lname' => $_SESSION['authenticationFlag']['lname']
		);
		$payload = htmlspecialchars(json_encode($payload), ENT_QUOTES, 'UTF-8');

		echo '<div onscroll="scrolling(\'' . $payload . '\')" id="infoArea">';
		echo '<div id="msgAreaContainer">';

			if( isset($_GET['channel']) )
			{
				$formPostAddr = 'channel='. $channelInfo['channelName'];
				printChannelMsg(
					$channelInfo,
					$msgExtraParams, 
					$_SESSION['authenticationFlag']['user_id'],
					$_SESSION['authenticationFlag']['fname'],
					$_SESSION['authenticationFlag']['lname']
				);
			}
			else if( isset($_GET['pair_user']) )
			{
				
				$channelInfo['channelId'] = -1;
				$msgExtraParams['pair_user_id'] = $_GET['pair_user'];
				$formPostAddr = 'pair_user=' . $msgExtraParams['pair_user_id'];
				
				$pairUser = explode('.', $msgExtraParams['pair_user_id']);
				if( $pairUser[0] == $_SESSION['authenticationFlag']['user_id'] )
				{
					$pairUser = $pairUser[1];
				}
				else
				{
					$pairUser = $pairUser[0];	
				}
				
				//direct msg
				$user = genericGetFromArr($users, $pairUser, $type='user_id');

				echo '<h3>' 
				. $_SESSION['authenticationFlag']['fname'] 
				. ' ' 
				. $_SESSION['authenticationFlag']['lname'] 
				. ' and ' 
				. $user['fname'] . ' ' . $user['lname']
				. ' (direct messages)'
				. '</h3>';
				
				//echo '<br><br>';
				//echo '<hr class="style13">';
				
				printChannelMsg(
					$channelInfo,
					$msgExtraParams, 
					$_SESSION['authenticationFlag']['user_id'],
					$_SESSION['authenticationFlag']['fname'],
					$_SESSION['authenticationFlag']['lname']
				);
			}

		echo '</div>';
		echo '</div>';

		if( $channelInfo['state'] == 'ACTIVE' )
		{
			echo '<form class="pure-form" enctype="multipart/form-data" action="main.php?' . $formPostAddr . '" method="post">';
			echo '<fieldset>';
			echo '<input type="hidden" name="channel_id" value="' . $channelInfo['channelId'] . '">';
			echo '<input type="hidden" name="pair_user_id" value="' . $msgExtraParams['pair_user_id'] . '">';
			echo '<textarea type="text" size="90%" name="post" placeholder="Enter message here" style="margin-top: 0px; margin-bottom: 0px; width: 380px; height: 35px;"></textarea>';
			echo '<input type="submit" value="post" class="pure-button pure-button-primary">';
			echo '<br><input type="checkbox" name="pre_tag"> Pre-formated';
			
			echo '<input type="hidden" name="MAX_FILE_SIZE" value="5048576">';

			echo '<input type="file" id="upload-photo-main" name="mkfile" style="opacity: 0;position: absolute;z-index: -1;" />';
			echo '<label for="upload-photo-main" style="cursor: pointer;">   &#128247; Upload image (5MB)</label>';

			echo '<input type="file" id="upload-file-main" name="mkfile-gen" style="opacity: 0;position: absolute;z-index: -1;" />';
			echo '<label for="upload-file-main" style="cursor: pointer;">   &#128194; Upload file (5MB)</label>';
			
			echo '</fieldset>';
			echo '</form>';
		}
		else
		{
			echo '<strong>This channel has been archived, if you need it unarchived, please contact the administrator.</strong>';
		}
	?>
</div>


<script type="text/javascript">
	
	function main()
	{	
		console.log('\nmain()');
		preAddExtraDetails();
	}

	function replyCounterClick(post_id)
	{
		post_id = 'post=' + post_id;
		var uriParams = processURL();

		console.log('\nreplyCounterClick(), params:', uriParams);

		if( uriParams.post == undefined )
		{
			window.location.href += '&' + post_id;
		}
		else
		{
			window.location.href = window.location.href.replace('post=' + uriParams.post, post_id);
		}
	}

	function addExtraDetailsToPost(className)
	{
		var msgDivs = document.getElementsByClassName('msgArea');
		for(var i=0; i<msgDivs.length; i++)
		{
			var imgFlag = msgDivs[i].getElementsByClassName(className);
			var formDiv = msgDivs[i].getElementsByClassName('pure-form')[0];
			
			for(var j = 0; j<imgFlag.length; j++ )
			{
				var selector = 'href';
				if( imgFlag[j].nodeName.toLowerCase() == 'img' )
				{
					selector = 'src';
				}

				var link = imgFlag[j][selector].split('/Slack/postImgs/')[1];
				if( link != undefined )
				{
					var hidden = document.createElement('input');
					hidden.type = 'hidden';
					hidden.value = './postImgs/' + link;
					hidden.name = 'post_img_id';
					formDiv.appendChild(hidden);
				}
			}			
		}

		var timestamps = document.getElementsByClassName('timestamp');
		for(var i=0; i<timestamps.length; i++)
		{
			var time = timestamps[i].getAttribute('value');
			timestamps[i].innerText = moment(time).fromNow() + ' (' + time + ')';
		}
	}
	function preAddExtraDetails()
	{
		addExtraDetailsToPost('postImg');
		addExtraDetailsToPost('postIcon');
		addExtraDetailsToPost('postFile');
	}

	function scrollToTop()
	{
		/*page scrolls during file upload, this is a patch*/
		scroll(0,0);
		console.log('\nscrollToTop()');
	}

	function selectiveRefreshSingleMsg(singleOldMsg, newMsgAreaCon)
	{
		for(var i = 0; i<newMsgAreaCon.length; i++)
		{
			if( newMsgAreaCon[i].getAttribute('id') == singleOldMsg.getAttribute('id') )
			{
				//update time is not needed because time of post is fixed
				singleOldMsg.getElementsByClassName('replyInputCounter')[0].value = newMsgAreaCon[i].getElementsByClassName('replyInputCounter')[0].value;
				

				var oldReactionInputs = singleOldMsg.getElementsByClassName('reaction-input');
				var newReactionInputs = newMsgAreaCon[i].getElementsByClassName('reaction-input');
				if( oldReactionInputs.length == newReactionInputs.length )
				{
					for(var j = 0; j<oldReactionInputs.length; j++)
					{
						oldReactionInputs[j].value = newReactionInputs[j].value;
					}
				}
				
				break;
			}
		}
	}

	function refreshMsgArea(oldMsgAreaCon, newMsgAreaCon)
	{
		if( oldMsgAreaCon.length == 0 )
		{
			return;
		}

		var htmlObject = document.createElement('div');
		htmlObject.innerHTML = newMsgAreaCon;	
		newMsgAreaCon = htmlObject.getElementsByClassName('msgArea');
		
		//add new msgs - start
		var newMsgs = [];
		for(var i=0; i<newMsgAreaCon.length; i++)
		{
			var breakFlag = false;
			for(var j=0; j<oldMsgAreaCon.length; j++)
			{
				if( newMsgAreaCon[i].getAttribute('id') == oldMsgAreaCon[j].getAttribute('id') )
				{
					breakFlag = true;
					break;
				}
			}

			if( breakFlag == true )
			{
				//there is a match, so rest will match
				break;
			}
			else
			{
				newMsgs.push( newMsgAreaCon[i] );
			}
		}
		
		for(var i=0; i<newMsgs.length; i++)
		{
			//add new to top
			oldMsgAreaCon[0].parentNode.insertBefore(newMsgs[i], oldMsgAreaCon[0]);
			console.log('skip refreshing new:', newMsgs[i]['id']);
			//remove last from bottom
			oldMsgAreaCon[0].parentNode.removeChild( oldMsgAreaCon[oldMsgAreaCon.length-1] );
		}
		//add new msgs - end

		
		//update old items
		//newMsg.length is where old begins
		for(var i = newMsgs.length; i<oldMsgAreaCon.length; i++)
		{
			selectiveRefreshSingleMsg( oldMsgAreaCon[i], newMsgAreaCon );
		}
	}

	function continuousUpdate_obsolete(payload)
	{
		console.log('\ncontinuousUpdate(), payload:', payload);

		httpPost({'getPost': payload}, './services.php', function(response)
	    {
	    	//console.log(response);
	        response = JSON.parse(response);
	        if( response.response )
	        {	
	        	var oldMsgAreaCon = document.getElementsByClassName('msgArea');
	        	refreshMsgArea(oldMsgAreaCon, response.response);
				preAddExtraDetails();        	

				//to drastic a change
	        	//msgAreaContainer.innerHTML = response.response;
	        }
	    });

		/*
		setTimeout(
			function()
			{ 
				continuousUpdate(payload);
			}
		, 3000);
		*/
		
	}

	function genericMsgAct(activity)
	{
		console.log('\nmouseOverText():', activity);
	}


	function scrolling(payload)
	{
		var uriParams = processURL();
		payload = JSON.parse(payload);

		//update details
		if( uriParams.channel == undefined )
		{
			payload.channel_info.channelId = -1;
		}

		if( uriParams.pair_user )
		{
			payload.msg_extra_params.pair_user_id = uriParams.pair_user;
		}
		
		console.log('scrolling, updating UI');
		httpPost({'getPost': payload}, './services.php', function(response)
	    {
	        response = JSON.parse(response);
	        if( response.response )
	        {	
	        	var oldMsgAreaCon = document.getElementsByClassName('msgArea');
	        	refreshMsgArea(oldMsgAreaCon, response.response);
				preAddExtraDetails();  	
	        }
	    });
	}

</script>

	
	<!-- 
		<?php
		//echo '<script>continuousUpdate(' . json_encode($payload) . ')</script>'; 
		?>
	-->
	
</body>
</html>
