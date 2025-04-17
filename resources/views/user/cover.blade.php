<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Droid Builders Club - PLI Cover</title>
  </head>
  <body>
    <h2>Droid Builders Club - PLI Cover</h2>
    <hr />
    <table border=1 cellpadding=8>
      <tr><th align=left>Member:</th><td align=right>{{$user->forename}} {{ $user->surname}}</td></tr>
      <tr><th align=left>Contact:</th><td align=right>{{$user->email}}</td></tr>
      <tr><th align=left>PLI Starts:</th><td align=right>{{$user->pli_date}}</td></tr>
      <tr><th align=left>PLI Ends:</th><td align=right>{{ gmdate("Y-m-d", strtotime($user->pli_date." +1 year"))}}</td></tr>
    </table>
    <p>
      This document certifies that {{$user->forename}} {{ $user->surname}} has had their Astromech Droid checked by an officer of
the Droid Builders Club, that it meets the requirements to be covered by the club PLI, and that
said member has paid their subscription to the club.
  </p>
  <p>
    The Cover is provided by Self Assured Underwriting Agencies Limited.
  </p>
  <table border=1 cellpadding=8>
    <tr><th align=left>Policy Number: </th><td align=left>SALSALIA/S338723/BB012/25</td></tr>
    <tr><th align=left>Wording: </th><td align=left>Liability Insurance Policy (SAUA Associations & Clubs PLPW1220)</td></tr>
    <tr><th align=left>People Covered: </th><td align=left>Members of a club who attend shows to show their droids.</td></tr>
    <tr><th align=left>Public Liability: </th><td align=left>GBP 2,000,000 any one Occurrence, defence costs and expenses in addition</td></tr>
    <tr><th align=left>Property Liability: </th><td align=left>GBP 2,000,000 any one Occurrence and in the aggregate, defence costs and expenses in addition</td></tr>
    <tr><th align=left>Excess: </th><td align=left>Property Damage GBP 250 each and every Occurrence</td></tr>
  </table>
  <h4>Contacts:</h4>
  <table border=1 cellpadding=8>
    <tr><th align=left>Chairman</th><td align=left>Lee Towersey <lee@artoo-detoo.co.uk></td></tr>
    <tr><th align=left>Admin</th><td align=left>admin@droidbuilders.uk</td></tr>
  </table>
  </body>
</html>
