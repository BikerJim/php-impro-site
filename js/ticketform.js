// JavaScript Document
function el_windowopenform (date) {
	window.open('https://docs.google.com/forms/d/1jrEwIXaG7YL9TYI-y9VFtkzOut0uy52am8X4ttQIsf0/viewform?entry.1839852768=' + date + '&entry.1226550965&entry.340680070&entry.1176492980&entry.478837227=Please+add+me+to+the+easylaughs+mailing+list!', "ticketwindow", 'height=685,width=620,scrollbars=1,screenx=100,screeny=80,left=100,top=80');
}

function el_windowopen (date) {
	window.open('reserve3.php?date=' + date, "ticketwindow", 'height=645,width=520 scrollbars=yes screenx=100 screeny=80 left=100 top=80');
}

function el_windowopen1show (date) {
	window.open('reserve3.php?date=' + date + '&Special=1show', "ticketwindow", 'height=645,width=520 scrollbars=yes screenx=100 screeny=80 left=100 top=80');
}

function el_windowopen2shows (date) {
	window.open('reserve3.php?date=' + date + '&Special=930', "ticketwindow", 'height=645,width=520 scrollbars=yes screenx=100 screeny=80 left=100 top=80');
}

function el_windowopen3 (date) {
	el_windowopen(date);
}

function el_windowopen_old (date, time, price, both) {
	window.open('reserve.php?date=' + date + '&time=' + time + '&price=' + price + "&both=" + both, "ticketwindow", 'height=620,width=520 scrollbars=yes screenx=100 screeny=100 left=100 top=100');
}

function el_windowopen_veryold (date, time, price, both) {
// both means show option for both shows

var generator=window.open('','name','height=500,width=600 scrollbars=yes screenx=100 screeny=100 left=100 top=100');
  
  generator.document.write('<html><head><title>Reserve easylaughs tickets here</title>');
  generator.document.write('<link rel="stylesheet" href="http://easylaughs.nl/popupstyle.css">');
  generator.document.write('</head><body style="padding: 20px;">');
  generator.document.write('<div style="text-align:right;"><img src="http://easylaughs.nl/images/easyLogo-white.gif" alt="easylaughs logo" style="padding-bottom:10px;" width="280"></div>');

//  generator.document.write('<p>THIS PART OF THE SITE IS NOT FUNCTIONAL AT THE MOMENT. SORRY FOR THE INCONVENIENCE</p>');

  generator.document.write('<p class="el-bg-text">To make your reservation for <b>', date, '</b> at <b>', time, '</b>, fill out this form.</p>');

  generator.document.write('<form METHOD="POST"ACTION="http://www.easylaughs.nl/themes/easyLaughs-blue/nonPN/formmail/el-formmail.php">');

  generator.document.write('<input type="hidden" name="date_show" value="', date,'">');
  generator.document.write('<input type="hidden" name="time_show" value="', time,'">');
  generator.document.write('<input type="hidden" name="price_tickets" value="', price, '">');
  generator.document.write('<input type="hidden" name="subject" value="Ticket reservation online for ',date,' at ', time,'">');

  generator.document.write('<p><table width="100%" border="0" cellpadding="0" cellspacing="4">');

  generator.document.write('<tr><td class="el-bg-text">Number of tickets (price per ticket: &euro;', price, '):</td><td>');
  generator.document.write('<select name="number_of_tickets" ONCHANGE="calcnumber=this.value;"><option value="1">1<option value="2">2<option value="3">3<option value="4">4<option value="5">5<option value="6">6<option value="7">7<option value="8">8<option value="9">9<option value="10">10</select></td></tr>');

// this bit modified so that it caters for the value no longer being 1 for YES, but the price :
if (both > 0 && both != price)  {
  if (both==1) both=12;
  generator.document.write('<tr><td class="el-bg-text">Do you want to reserve for both shows at a discounted price of &euro;', both, ' for both?');
  generator.document.write('</span></td><td>');
  generator.document.write('<select name="Tickets_for_both_shows"><option value="yes">yes, both shows<option value="no">no, just this show</select></td></tr>');
} else {
  generator.document.write('<input type="hidden" name="Tickets_for_both_shows" value="no"></td></tr>');
}


  generator.document.write('<tr><td class="el-bg-text">Make the reservation under this name:</td><td><input type="text" name="reservation under_name" size="30"></td></tr>');
  generator.document.write('<tr><td class="el-bg-text">Confirmation email can be sent to:</td><td ><input type="text" name="email" size="30"></td></tr>');

//  generator.document.write('<tr><td><br>Where did you hear about us?</td><td><br><input type="text" name="which_PR" value="website/online agenda/paper agenda/flyer/other?" size="50"></td></tr></table>');
  generator.document.write('<tr><td class="el-bg-text"><br>Where did you hear about us?</td><td><br><select name="which_PR"><option value="no_choice">- make your choice here -<option value="flyer_poster">Flyer/poster<option value="Paper_agenda">Paper agenda<option value="Online_agenda">Online agenda<option value="weblink">Link on the web<option value="Google">Web Search (Google, Yahoo, etc)<option value="tru_friends">Friends<option value="Other">Other</select></td></tr>');

//  generator.document.write('<tr><td>More details:</td><td><br><select name="Paper_details"><option value="no_choice">- make your choice here -<option value="het_parool">Het Parool<option value="ams_week">Amsterdam Weekly<option value="uitkrant">Uitkrant<option value="nl20">NL20<option value="MUG">MUG<option value="ams_times">Amsterdam Times<option value="roundabout">Roundabout<option value="Other">Other</select></td></tr>');

  generator.document.write('</table>');


  generator.document.write('<p class="el-bg-text">Anything you want to add?<br/><textarea name="comments" rows="3" cols="50"></textarea></div>');

  generator.document.write('<p class="el-bg-text"><input type="submit" value="Make my reservation">');

  generator.document.write('</form><p class="el-bg-text"><a href="javascript:self.close()">Close</a> this window without making a reservation.');
  generator.document.write('<br />For problems or large bookings, please email <a href="mailto:info@easylaughs.nl">info@easylaughs.nl</a></p>');
  generator.document.write('</body></html>');
  generator.document.close();

}
