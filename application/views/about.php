<?php defined('BASEPATH') OR exit; ?>
<div class="row content">
	<div class="auxpages">
		<h1>About</h1>
		<p></p>
		<h2>Summary</h2>
		<p>WardRep is a collaboration project of Open Data &quot;hacktivists&quot; from four 
		regional community groups in Ontario, Canada:
		<a href="http://openhalton.ca" target="_blank">OpenHalton</a>,
		<a href="http://openhamilton.ca" target="_blank">OpenHamilton</a>,&nbsp;
		<a href="http://twitter.com/OpenGuelph" target="_blank">OpenGuelph</a> and
		<a href="http://www.opendatalondon.ca/" target="_blank">OpenDataLondon</a>.</p>
		<p>WardRep gives citizens a way to easily find out which ward they live 
		in, who their city councilors are &amp; how to contact them. </p>
		<p></p>
		<h2>Background</h2>
		<p>Many of our cities provide only the most basic ward maps &amp; councilor/mayor 
		data as separate information; navigating through maps &amp; various sections 
		of city websites to figure out which ward you live in, and who your councilors 
		are is not very intuitive. This and other experiences that citizens have 
		with government data could be dramatically improved, by citizens, with very 
		little additional cost for the government - if only the data were made open 
		to everyone as &quot;open data&quot;</p>
		<p>WardRep is just one example of what is possible with Open Data. </p>
		<p>Of course, we had to be creative in building WardRep without the actual 
		data made open (only one of the cities we reached out to gave us their ward 
		boundary data, saving hours of developer effort - <strong>THANK YOU</strong>!).
		</p>
		<ul>
			<li><strong>Ward Boundaries</strong>: almost all map data has been re-drawn 
			by hand into a digital map format (KML) from printed or .PDF maps from 
			the cities&#39; websites. This allowed us to use a dynamic map versus the 
			traditional &quot;image-only&quot; maps of wards </li>
			<li><strong>Mayor &amp; Council Information</strong>: captured from respectful 
			cities&#39; town hall, council and mayor website pages into a simple CSV 
			file format. This data was &quot;mashed up&quot; with the map data in by joining 
			Ward Maps with the Council data </li>
			<li><strong>WardRep Data</strong>: The was loaded into a
			<a href="http://www.microsoft.com/windowsazure/">Windows Azure </a>cloud-based 
			open source catalogue for Open Data (<strong><a href="http://datadotgc.cloudapp.net/">OGDI</a></strong>), 
			which powers <a href="http://datadotgc.ca">DataDOTgc.ca</a> (an all-Canadian 
			grassroots catalogue). This makes all of the data easy to access by 
			developers using Open Standard APIs (REST, Json, etc) </li>
			<li><strong>WardRep Web</strong>: Powered by PHP built on top of CodeIgniter 
			framework and running on Windows Server &amp; IIS, the web app pulls the 
			data from <a href="http://datadotgc.cloudapp.net/">OGDI/DataDOTgc.ca</a> 
			using simple APIs and mashes it up on the fly. </li>
			<li><strong>WardRep Mobile</strong>: The same datasets and APIs power 
			both web and also mobile versions of WardRep. To-date, an iPhone version 
			is under way and a free Windows Phone 7 app is finished &amp; will be soon 
			available in the app marketplace. </li>
		</ul>
		<p>WardRep originated as an
		<a href="http://openhalton.ca/projects" target="_blank">OpenHalton.ca project</a> 
		kicked off at the
		<a href="http://ohoghackathon.eventbrite.com/" target="_blank">Open Data 
		Hackathon Day</a> with generous sponsorship and technology contribution 
		from <strong>Microsoft Canada </strong>&amp;
		<a href="http://port25.ca" target="_blank"><strong>Port25.ca</strong></a></p>
		<p>In one day WardRep went from an idea to a proof-of-concept application 
		for mobile &amp; web because of the effort of the following individuals at the 
		hackathon:</p>
		<table border="0" cellpadding="4" cellspacing="10" width="80%">
			<tr>
				<td valign="top" width="200">Nik Garkusha <br />
				<a href="http://OpenHalton.ca" target="_blank">http://OpenHalton.ca</a>
				<br />
				Twitter: <a href="http://twitter.com/nik_g" target="_blank">@Nik_G</a>
				</td>
				<td valign="top" width="200">Aaron McGowan <br />
				<a href="http://www.amcgowan.ca" target="_blank">http://www.amcgowan.ca</a>
				<br />
				Twitter: <a href="http://twitter.com/amcgowanca" target="_blank">
				@amcgowanca</a> </td>
			</tr>
			<tr>
				<td valign="top" width="200">Mark Arteaga <br />
				<a href="http://redbitdev.com" target="_blank">http://redbitdev.com</a>
				<br />
				Twitter:
				<a href="http://twitter.com/markarteaga" target="_blank">@markarteaga</a>
				</td>
				<td valign="top" width="200">Mike Druiven <br />
				<a href="http://chatt.hdsb.ca/~druivenm/" target="_blank">http://chatt.hdsb.ca/~druivenm/</a>
				<br />
				Twitter: <a href="http://twitter.com/mdruiven" target="_blank">@mdruiven</a></td>
			</tr>
			<tr>
				<td valign="top" width="200">Cory Fowler <br />
				Web: <a href="http://blog.syntaxc4.net/" target="_blank">http://blog.syntaxc4.net/</a>
				<br />
				Twitter:
				<a href="http://www.twitter.com/SyntaxC4" target="_blank">@SyntaxC4</a>
				</td>
				<td valign="top" width="200">Alan Lukachko <br />
				<a href="http://softwarestrategies.ca/" target="_blank">http://softwarestrategies.ca/</a>
				<br />
				Twitter:
				<a href="http://twitter.com/alanlukachko" target="_blank">@alanlukachko</a>
				</td>
			</tr>
			<tr>
				<td valign="top" width="200">Ricardo Covo <br />
				<a href="http://ricardocovo.wordpress.com" target="_blank">http://ricardocovo.wordpress.com</a>
				<br />
				Twitter:
				<a href="http://twitter.com/ricardocovo" target="_blank">@ricardocovo</a>
				</td>
				<td valign="top" width="200">Jeff Verkoeyen <br />
				<a href="http://jeffverkoeyen.com" target="_blank">http://jeffverkoeyen.com</a>
				<br />
				Twitter:
				<a href="http://twitter.com/featherless" target="_blank">@featherless</a>
				</td>
			</tr>
			<tr>
				<td valign="top" width="200">Tony Wallace <br />
				<a href="http://heuristicmedia.com" target="_blank">http://heuristicmedia.com</a>
				<br />
				Twitter:
				<a href="http://twitter.com/heuristicmedia" target="_blank">@heuristicmedia</a>
				</td>
				<td valign="top" width="200">Nathan Vexler <br />
				Twitter:
				<a href="http://twitter.com/cartoon_nate" target="_blank">@cartoon_nate</a>
				</td>
			</tr>
			<tr>
				<td valign="top" width="200">Jenna Hoffman <br />
				<a href="http://port25.ca" target="_blank">http://port25.ca</a>
				<br />
				Twitter: <a href="http://twitter.com/jennahoff" target="_blank">
				@jennahoff</a> </td>
				<td valign="top" width="200">&nbsp;</td>
			</tr>
		</table>
		<p>Over the 3+ months that followed the team worked on scraping and adding 
		city data from Milton, Guelph, London and Hamilton. </p>
		<p>Special thanks to Mike Druiven who digitized the entire ward map of Milton, 
		ON, Joey Coleman and <a href="http://openhamilton.ca" target="_blank">OpenHamilton</a> 
		for providing a digital map of Hamilton and Aaron McGowan for WardRep Web 
		and Mark Arteaga and <a href="http://redbitdev.com" target="_blank">RedBit 
		Dev</a> for WardRep Windows Phone 7.</p>
		<h4>WardRep Source Code is available as Open Source on GitHub:
		<a href="http://github.com/openlab/wardrep">http://github.com/openlab/wardrep</a></h4>
		<p></p>
	</div>
</div>
