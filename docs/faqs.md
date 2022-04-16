## FAQs

#### What email notifications are sent?

For now, the email notifications are only for backups.

[👨‍💻Coming soon] The recipient configured in `notify_email` will be notified when the following scenarios occur:
* When the server disk space is 80% filled
* When the server memory is at 80% utilization
* When nginx or fastcgi is down
* When there is a new wordpress version

#### How to restore backups?

The backups emailed to you are database backups. The extended tarball backups with the uploads folder are available on the server.

* Lookup on how to restore a MySQL/MariaDB database.
* The files in `wp-content/uploads` folder are not part of the email backups. These would most likely be large to be sent over email. Please ensure to enable disk backups on your cloud provider.

As much as I would love to improve backups and backup restoration, I am also limited by time.

#### Why not use Kubernetes, Docker, etc?

This project is designed to be budget-friendly. I wanted to setup something small for my family and my hobby projects.

#### How to update Wordpress version?

[Coming soon 👨‍💻] The plan is to notify you via email about new wordpress versions for any sites that are outdated.
