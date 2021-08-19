# moodle_tool_messenger
This plugin expands the abilty of administrators to communicate with a large amount of users
at once. 

### Types of messages
Administrators may choose to send an email or display a popup to all users that meet certain
criteria. Popups will be shown the next time the user logs into any site across the moodle instance.

##Settings

`emailspercron` - Emails are sent by the cronjob, the emailspercron settings restricts the number
of emails that are sent during a cronjob instance.
<br><br>
`sendinguserid` - This is the user that will send the emails to the users. It's email address will appear as the sender
<br><br>
`popupcheckcooldown` - The amount of time for each user until the server will check for popups again
<br><br>
`cleanupduration` - Jobs and Popups will automatically be deleted if they are older than this.

##Options for sending messages
`Send to` - Mails and popups will only be send/shown to users having one of the selected roles
in atleast one course.
<br><br>
`Ignore Useres that haven't logged in after` - Emails will only be sent to users that have
logged in after the specified date.
<br><br>
`Show popup till` - Date until the popup will be shown if a user logs in (Popups will only be shown once to users)
<br><br>
`priority` - priority is only relevant for emails. Email jobs with higher priority will send before those with lower,
which is relevant when the amount of emails to be sent exceeds the `cronjoblimit`
<br><br>
`send immediately` - All emails of this job will be sent out with the next cronjob, ignoring the `cronjoblimit`
<br><br>
`type` - wether to send an email, show a popup, or both.
