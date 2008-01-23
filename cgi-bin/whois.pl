#!/usr/bin/perl
#
# AUTHOR: Kasimir Gabert
#
#    This program is free software; you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation; either version 2 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program; if not, write to the Free Software
#    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
#

use CGI qw/:standard/;

my $ip = param('ip');
print header;
unless ($ip) {
	print "No ip address entered.\n";
	exit; 
}

if ($ip !~ /^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/)
{
	print "Bad IP.\n";
	exit;
}

# Form the interface head and tail
my $head =<<ENDHEAD;
<br/><br/>

<table width='70%' cellspacing='2' cellpadding='2' border='0' align='center'>

<tr>

<td class='PT'><br/><a href='/index.php'>Tor Network Status</a> -- WHOIS Query<br/><br/></td>
</tr>

</table>

<br/><br/>

<table width='70%' cellspacing='2' cellpadding='2' border='0' align='center'>
<tr>
<td class='TDBLACK'>
	
	<table cellspacing='2' cellpadding='2' border='0' align='center' width='100%'>
	<tr>
ENDHEAD
$head .= "<td class='THN'>WHOIS Query For $ip</td>";
$head .=<<ENDHEAD;
	</tr>

	<tr>
	<td class='TRSB'>
ENDHEAD

my $tail =<<ENDTAIL;
</td></tr></table></td></tr></table><br/><br/>
<table width='70%' cellspacing='2' cellpadding='2' border='0' align='center'>
<tr>
<td class='TRC'><b>
ENDTAIL
$tail .= `php ../web/config.php printthefooter`;
$tail .= '</b></td></tr></table>';

# Submit the whois query, it looks like it works
print start_html(
		-title=>'WHOIS lookup',
		-style=>{'src'=>'/css/main.css'},
		-class=>'BOD'),
	$head,
	pre(`whois $ip`),
	$tail,
	end_html;

