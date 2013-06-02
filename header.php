<?php include('config.php');

include("include/login_sessions.php");
if($logged_in) {
	$login_link = "<a href=\"settings.php\"><img src=\"images/settings.png\" /></a> <a href=\"javascript:void(0)\" onclick=\"logout()\" id=\"login_link\">LOG OUT</a>";
}
else {
	$login_link = "<a href=\"javascript:void(0)\" onclick=\"show_login()\" id=\"login_link\">LOG IN</a>";
}
?>
<div class="clearfix">
	<div class="main_header">
		<a href="index.php"><span class="header"><?php echo $header;?></span><br />
		<span class="header_sub"><?php echo $header_sub;?></span></a>
	</div>
	<div class="regions"><span style="font-weight: bold; text-style: italic">Reporting for</span><br/>
		<a href="http://www.nationstates.net?region=Democratic Socialist Assembly" target="_blank">Democratic Socialist Assembly</a><br/>
		<a href="http://www.nationstates.net?region=Social Liberal Union" target="_blank">Social Liberal Union</a><br/>
		<a href="http://www.nationstates.net?region=United Peoples Front for Socialism" target="_blank">United Peoples Front for Socialism</a><br/>
		<a href="http://www.nationstates.net?region=Communist International League" target="_blank">Communist International League</a>
	</div>
</div>
<div id="header_nav_div" class="clearfix">
	<nav class="header_nav">
		<ul>
			<li><a href="newslist.php">Latest News</a></li>
			<li><a href="newslist.php?orderby=interesting">Most Interesting</a></li>
			<li><a href="archive.php">Search Archive</a></li>
			<li><a href="submit.php">Submit an Article</a></li>
		</ul>
	</nav>
	
	<div id="login">
		<? echo $login_link; ?>
	</div>
</div>
