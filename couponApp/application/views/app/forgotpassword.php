<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>

  <meta content=text/html; charset=utf-8 http-equiv=Content-Type />
            <title>Feedback</title>
            <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600' rel='stylesheet' type='text/css'>
            </head>
            <body>
            <table style="font-family: 'Open Sans', sans-serif;margin:auto;" width=40% border=0 bgcolor=#fff>
            <tr>
            <th width=20px></th>
            <th width=20px  style='padding-top:30px;padding-bottom:30px;'></th>
            <th width=20px></th>
            </tr>
            <tr>
            <td width=20px></td>
            <td bgcolor=#fff style="border-radius:10px;padding:20px;border: 2px solid #eee;">
            <table width=100%;>
            <tr>
            <th style=font-size:20px; font-weight:bolder; text-align:right;padding-bottom:10px;border-bottom:solid 1px #ddd;> Hello <?php echo $data['fname']; ?></th>
            </tr>

            <tr>
            <td style=font-size:16px;>
            <p style="text-align:center"><img src="<?php echo base_url("public/img/logo.jpg");?>"></p>
            <p> You have requested a password retrieval for your user account at Pendulum Points. To complete the process, click the link below.</p>
            <p> This link is valid for 30 Minutes.</p>
            <p><a href=
            <?php echo base_url('api/Auth/newpassword?id=').$data['bId']; ?> >Change Password</a></p>
            </td>
            </tr>
            <tr>
            <td style=text-align:center; padding:20px;>
            <h2 style=margin-top:50px; font-size:29px;>Best Regards</h2>
            <h4 style=margin:0; font-weight:100;>Pendulum Points Customer Support Team</h4>

            </td>
            </tr>
            </table>
            </td>
            <td width=20px></td>
            </tr>
            <tr>
            <td width=20px></td>
            <td style='text-align:center; color:#fff; padding:10px;'> Copyright © Pendulum Points All Rights Reserved</td>
            <td width=20px></td>
            </tr>
            </table>
</body>
</html>