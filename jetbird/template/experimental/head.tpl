{*
	This file is part of Jetbird.

    Jetbird is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    Jetbird is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with Jetbird.  If not, see <http://www.gnu.org/licenses/>.
*}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<title>Jetbird Preview</title>
	<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
	<script src="{$template_dir}/js/jquery-1.2.6.js" type="text/javascript"></script>
	<script src="{$template_dir}/js/common.js" type="text/javascript"></script>
	<link type="text/css" rel="stylesheet" media="screen" href="{$template_dir}/css/style.css" />
	<link href="./?feed" rel="alternate" type="application/rss+xml" title="Jetbird RSS Feed" />
	{if $smarty.const.SVN_REVISION ==! false}<!--
		This file is served to you by Jetbird revision {$smarty.const.SVN_REVISION}	-->
{/if}
</head>

<body>
