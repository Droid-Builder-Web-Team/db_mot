<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>UK R2D2 Builders Club - PLI Cover</title>
  </head>
  <body>
    <table class="table table-bordered">
      <tr><th>Member:</th><td>{{$user->forename}} {{ $user->surname}}</td></tr>
      <tr><th>Contact:</th><td>{{$user->email}}</td></tr>
      <tr><th>PLI Starts:</th><td>{{$user->pli_date}}</td></tr>
      <tr><th>PLI Ends:</th><td>{{ gmdate("Y-m-d", strtotime($user->pli_date." +1 year"))}}</td></tr>
    </table>
    <p>
      This document certifies that {{$user->forename}} {{ $user->surname}} has had their Astromech Droid checked by an officer of
the UK R2D2 Builders Club, that it meets the requirements to be covered by the club PLI, and that
said member has paid their subscription to the club.
  </p>
  <p>
    The Cover is provided by Self Assured Underwriting Agencies Limited.
  </p>
  <table>
    <tr><th>Policy Number: </th><td>SALSALIA/S143387/0120/19</td></tr>
    <tr><th>Wording: </th><td>Liability Insurance Policy (SAUA Associations & Clubs PLPW0119)</td></tr>
    <tr><th>People Covered: </th><td>Members of a club who attend shows to show their droids.</td></tr>
    <tr><th>Public Liability: </th><td>GBP 2,000,000 any one Occurrence, defence costs and expenses in addition</td></tr>
    <tr><th>Property Liability: </th><td>GBP 2,000,000 any one Occurrence and in the aggregate, defence costs and expenses in addition</td></tr>
  </table>
  Contacts:
  <table>
    <tr><th>Chairman</th><td>Lee Towersey <lee@artoo-detoo.co.uk></td></tr>
  </table>
  </body>
</html>
