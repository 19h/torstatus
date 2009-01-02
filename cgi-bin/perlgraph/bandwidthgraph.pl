#!/usr/bin/perl
#
# plot.pl for TorStatus
# Copyright (c) Kasimir Gabert 2009
#
#    This program is free software: you can redistribute it and/or modify
#    it under the terms of the GNU General Public License as published by
#    the Free Software Foundation, either version 3 of the License, or
#    (at your option) any later version.
#
#    This program is distributed in the hope that it will be useful,
#    but WITHOUT ANY WARRANTY; without even the implied warranty of
#    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#    GNU General Public License for more details.
#
#    You should have received a copy of the GNU General Public License
#    along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
# The Tor(TM) trademark and Tor Onion Logo are trademarks of The Tor Project. 
#
# Required Perl packages:
#  * CGI from CPAN to communicate easily with requests from the web server
#  * RRDs to create the graphs
#

use CGI;
use RRDs;

my $cgi = new CGI;

# Flush the buffers so RRDs will output
$| = 1;

# Determine the bandwidth file, name, and time period
my $fp = $cgi->param('fp');
my $name = $cgi->param('name');
my $time = $cgi->param('time');

# Ensure that there is nothing weird in the fingerprint
if ((length $fp) != 40 || $fp =~ /[^[A-Z0-9]/)
{
	print "Content-type: text/html\n\n";
	print "Unknown input.";
	exit;
}
# Make sure that the date is an allowed one
unless ($time eq "day" || $time eq "week" || $time eq "month" || $time eq "3months" || $time eq "year")
{
	print "Content-type: text/html\n\n";
	print "Unknown time period.";
	exit;
}

# Get the bwfile to create the graphs from
my $bwfile = "../../bandwidthhistory/$fp.rrd";

# Declare the common graph arguments
my @graphargs = (
	"--lower-limit=0",
	"--end=now",
	"--height=130",
	"DEF:read=$bwfile:read:AVERAGE",
	"DEF:write=$bwfile:write:AVERAGE",
	"--color=BACK#FFFFFF",
	"--color=FRAME#FFF368",
	"--color=SHADEA#FFF368",
	"--color=SHADEB#FFF368",
	"--color=FONT#0000BF",
	"--color=ARROW#000000",
	"AREA:read#0000BF:Read History",
	"LINE2:write#FFF368:Write History",
	"--vertical-label=Bandwidth (KBps)",
);

my @timeargs = ();

# Determine the time period
if ($time eq "day")
{
	push @timeargs,
	"--title=Past Day's Bandwidth for $name",
	"--start=end-1d";
}
elsif ($time eq "week")
{
	push @timeargs,
	"--title=Past Week's Bandwidth for $name",
	"--start=end-1w";
}
elsif ($time eq "month")
{
	push @timeargs,
	"--title=Past Month's Bandwidth for $name",
	"--start=end-1m";
}
elsif ($time eq "3months")
{
	push @timeargs,
	"--title=Past Three Month's Bandwidth for $name",
	"--start=end-3m";
}
elsif ($time eq "year")
{
	push @timeargs,
	"--title=Past Year's Bandwidth for $name",
	"--start=end-1y";
}


# Output the graph
print "Content-type: image/png\n\n";
RRDs::graph(
	"-",
	@timeargs,
	@graphargs
);

