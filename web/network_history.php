<?php

// See LICENSE for licensing information 

// Start new session
session_start();

// Include configuration settings
include("config.php");

$pageTitle = "Network History";
include("header.php");

?>

<table width='100%' cellspacing='2' cellpadding='2' border='0'>
<tr>

<!-- Running Servers -->
	<td>
		<table class="displayTable" width='100%' cellspacing='0' cellpadding='0' align='center'>
		<tr>
			<td class="HRN">Running Servers</td>
		</tr>
		<tr>
			<td class='TRSCN'>
			<br/>
			<table class="bwhistory">
		        <tr>
		        	<td>
		                <img src="history/running_6h.png"; alt="Running Servers in the last 6 Hours"/>
		                </td>
		                <td>
		        	<img src="history/running_1d.png"; alt="Running Servers in the last 24 Hours"/>
				</td>
		        </tr>
		        <tr>
		         	<td>
				<img src="history/running_1w.png"; alt="Running Servers in the last Week"/>
				</td>
		                <td>
		                <img src="history/running_1m.png"; alt="Running Servers in the last Month"/>
				</td>
		     	</tr>
		        <tr>
		                <td>
				<img src="history/running_3m.png"; alt="Running Servers in the last 3 Months"/>		                
				</td>
		                <td>
				<img src="history/running_1y.png"; alt="Running Servers in the last Year"/>
		                </tr>
			</table>
		</tr>
		</table>
	</td>
</tr>

<!-- Running Exit Servers -->
<tr>
	<td>
                <table class="displayTable" width='100%' cellspacing='0' cellpadding='0' align='center'>
                <tr>
                        <td class="HRN">Running Exit Servers</td>
                </tr>
                <tr>
                        <td class='TRSCN'>
                        <br/>
                        <table class="bwhistory">
                        <tr>
				<td>
				<img src="history/runExit_6h.png"; alt="Running Exit Servers in the last 6 Hours"/>
				</td>
                                <td>
                                <img src="history/runExit_1d.png"; alt="Running Exit Servers in the last 24 Hours"/>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                <img src="history/runExit_1w.png"; alt="Running Exit Servers in the last Week"/>
                                </td> 
			       	<td>
                                <img src="history/runExit_1m.png"; alt="Running Exit Servers in the last Month"/>
                                </td>
                        </tr>   
                        <tr>
                                <td>
                                <img src="history/runExit_3m.png"; alt="Running Exit Servers in the last 3 Months"/>
                                </td>
			       	<td>
                                <img src="history/runExit_1y.png"; alt="Running Exit Servers in the last Year"/>
                                </td>
                        </table>
                </tr>   
                </table>
	</td>
</tr>

<!-- Running Guard Servers -->
<tr>
        <td>
                <table class="displayTable" width='100%' cellspacing='0' cellpadding='0' align='center'>
                <tr>
                        <td class="HRN">Running Guard Servers</td>
                </tr>
                <tr>
                        <td class='TRSCN'>
                        <br/>
                        <table class="bwhistory">
                        <tr>
                                <td>
                                <img src="history/runGuard_6h.png"; alt="Running Guard Servers in the last 6 Hours"/>
                                </td>
                                <td>
                                <img src="history/runGuard_1d.png"; alt="Running Guard Servers in the last 24 Hours"/>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                <img src="history/runGuard_1w.png"; alt="Running Guard Servers in the last Week"/>
                                </td>                         
			        <td>
                                <img src="history/runGuard_1m.png"; alt="Running Guard Servers in the last Month"/>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                <img src="history/runGuard_3m.png"; alt="Running Guard Servers in the last 3 Months"/>
                                </td>
				<td>
                                <img src="history/runGuard_1y.png"; alt="Running Guard Servers in the last Year"/>
                                </td>
                        </table>
                </tr>
                </table>
        </td>
</tr>

<!-- Running Fast Servers -->
<tr>
        <td>
                <table class="displayTable" width='100%' cellspacing='0' cellpadding='0' align='center'>
                <tr>
                        <td class="HRN">Running Fast Servers</td>
                </tr>
                <tr>
                        <td class='TRSCN'>
                        <br/>
                        <table class="bwhistory">
                        <tr>
                                <td>
                                <img src="history/runFast_6h.png"; alt="Running Fast Servers in the last 6 Hours"/>
                                </td>
                                <td>
                                <img src="history/runFast_1d.png"; alt="Running Fast Servers in the last 24 Hours"/>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                <img src="history/runFast_1w.png"; alt="Running Fast Servers in the last Week"/>
                                </td>
                                <td>
                                <img src="history/runFast_1m.png"; alt="Running Fast Servers in the last Month"/>
                                </td>
                        </tr>
                        <tr>
                                <td>
                                <img src="history/runFast_3m.png"; alt="Running Fast Servers in the last 3 Months"/>
                                </td>
                                <td>
                                <img src="history/runFast_1y.png"; alt="Running Fast Servers in the last Year"/>
                                </td>
                        </table>
                </tr>
                </table>
        </td>
</tr>


<!-- Footer -->
		<br/>
		<table width='70%' cellspacing='2' cellpadding='2' border='0' align='center'>
		<tr>	
			<td class='TRC'><?php echo $footerText; ?></td>
		</tr>
		</table>
</body>
</html>
